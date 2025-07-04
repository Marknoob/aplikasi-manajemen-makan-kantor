<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuDeckExpense;
use App\Models\MenuDeckPayment;
use App\Models\MenusDeck;
use App\Models\Menu;
use App\Models\MenusDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $dateNow = Carbon::now();
        $bulan = $dateNow->translatedFormat('F');

        // Ambil total pembayaran bulan ini
        $totalPaymentThisMonth = MenuDeckPayment::whereMonth('tanggal_bayar', $dateNow->month)
            ->sum('jumlah_bayar');

        // Ambil total pembayaran bulan lalu
        $totalPaymentLastMonth = MenuDeckPayment::whereMonth('tanggal_bayar', $dateNow->month-1)
            ->sum('jumlah_bayar');

        // Hitung persentase perubahan
        if ($totalPaymentLastMonth > 0) {
            $expensePercentage = (($totalPaymentThisMonth - $totalPaymentLastMonth) / $totalPaymentLastMonth) * 100;
        }
        if ($totalPaymentLastMonth <= 0 ) {
            $expensePercentage = 100;
        }
        if ($totalPaymentLastMonth <= 0 && $totalPaymentThisMonth <= 0) {
            $expensePercentage = 0;
        }

        // Hitung Menus Deck mana yang belum ada payment, maupun paymentnya belum lunas
        $totalMenusDeckWaitingPayment = MenusDeck::where('status', 1)
            ->where(function ($query) {
                $query->whereDoesntHave('payments')
                    ->orWhereHas('payments', function ($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->groupBy('menu_deck_id')
                            ->havingRaw('SUM(jumlah_bayar) < (
                                SELECT COALESCE(SUM(jumlah_biaya), 0)
                                FROM menu_deck_expenses
                                WHERE menu_deck_expenses.menu_deck_id = menu_deck_payments.menu_deck_id
                            )');
                    });
            })
            ->count();


        // Hitung Menus Deck yang sudah lunas
        $totalMenusDeckLunas = MenusDeck::whereHas('payments')
            ->whereHas('menu')
            ->get()
            ->filter(function ($deck): bool {
                $totalExpense = $deck->expenses->sum('jumlah_biaya');
                $totalPayment = $deck->payments->sum('jumlah_bayar');
                return $totalPayment >= $totalExpense;
            })
            ->count();

        return view('dashboard.index', compact('totalPaymentThisMonth', 'bulan', 'expensePercentage', 'totalMenusDeckWaitingPayment', 'totalMenusDeckLunas'));
    }

    public function pengeluaran(Request $request)
    {
        // Ambil periode dari input (default ke bulan ini jika tidak ada input)
        $periode = $request->input('periode', now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $periode);

        // Ambil ID menu_deck yang memiliki payment
        $menuDeckWithPayments = MenuDeckPayment::distinct()
            ->pluck('menu_deck_id')
            ->toArray();

        // Ambil hanya MenusDeck yang memiliki status 1 dan ada payment-nya
        $menusDeck = MenusDeck::where('status', 1)
            ->whereIn('id', $menuDeckWithPayments)
            ->whereMonth('tanggal_pelaksanaan', $bulan)
            ->whereYear('tanggal_pelaksanaan', $tahun)
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();


        // Tambahkan properti total_biaya ke setiap menusDeck
        foreach ($menusDeck as $deck) {
            $payments = MenuDeckPayment::where('menu_deck_id', $deck->id)
                ->whereMonth('tanggal_bayar', $bulan)
                ->get();

            // Total pembayaran
            $total_pembayaran = 0;
            foreach ($payments as $payment) {
                $total_pembayaran += $payment->jumlah_bayar;
            }
            $deck->total_pembayaran = $total_pembayaran;
        }

        $expenses = MenuDeckPayment::whereMonth('tanggal_bayar', $bulan)->get();

        return view('dashboard.pengeluaran', compact('menusDeck', 'periode', 'expenses'));
    }

    public function pembayaran()
    {
        // Ambil periode dari input (default ke bulan ini jika tidak ada input)
        $periode = request('periode', now()->format('Y-m'));
        [$tahun, $bulan] = explode('-', $periode);

        $menusDeck = MenusDeck::where('status', 1)
            ->whereMonth('tanggal_pelaksanaan', $bulan)
            ->whereYear('tanggal_pelaksanaan', $tahun)
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

        // Tambahkan properti total_biaya ke setiap menusDeck
        foreach ($menusDeck as $deck) {
            $payments = MenuDeckPayment::where('menu_deck_id', $deck->id)->get();
            $expenses = MenuDeckExpense::where('menu_deck_id', $deck->id)->get();

            // Total biaya
            $total_biaya = 0;
            foreach ($expenses as $expense) {
                $total_biaya += $expense->jumlah_biaya;
            }
            $deck->total_tagihan = $total_biaya;

            // Total pembayaran
            $total_pembayaran = 0;
            foreach ($payments as $payment) {
                $total_pembayaran += $payment->jumlah_bayar;
            }
            $deck->total_pembayaran = $total_pembayaran;

            // Sisa tagihan
            $deck->sisa_tagihan = $total_biaya - $total_pembayaran;

            // Status Bayar
            if ($total_pembayaran >= $total_biaya) {
                $deck->status_lunas = "Paid";
            }
            if ($total_pembayaran < $total_biaya) {
                $deck->status_lunas = "Half Paid";
            }
            if ($total_pembayaran == 0) {
                $deck->status_lunas = "Not Paid";
            }
        }
        return view('dashboard.pembayaran', compact('menusDeck'));
    }

    public function cosineSimilarity()
    {
        $idMenu1 = 2;
        $idMenu2 = 4;
        $allMenus = Menu::all();

        $menu1 = Menu::with('details.component')->find($idMenu1);
        $menu2 = Menu::with('details.component')->find($idMenu2);

        $menu1Details = MenusDetail::with('component')
            ->where('menu_id', $idMenu1)
            ->where('is_active', true)
            ->get();

        $menu2Details = MenusDetail::with('component')
            ->where('menu_id', $idMenu2)
            ->where('is_active', true)
            ->get();

        return view('cosine-similarity', compact('allMenus', 'menu1', 'menu2', 'menu1Details', 'menu2Details'));
    }

    public function jaccardSimilarity()
    {
        // Calculate Vizualization
        $idMenu1 = 2; // Target Menu
        $idMenu2 = 4;

        $menu1 = Menu::with('details.component')->find($idMenu1);
        $menu2 = Menu::with('details.component')->find($idMenu2);

        $menu1Details = MenusDetail::with('component')
            ->where('menu_id', $idMenu1)
            ->where('is_active', true)
            ->get();

        $menu2Details = MenusDetail::with('component')
            ->where('menu_id', $idMenu2)
            ->where('is_active', true)
            ->get();


        // Accuracy Calculation
        $allMenus = Menu::with('details.component', 'category')
            ->where('id', '!=', $idMenu1)
            ->get();

        // // Ambil expected menus dengan kategori bahan utama yang sama
        // $expectedMenus = Menu::whereHas('category', function ($query) use ($menu1) {
        //     $query->where('kategori_bahan_utama', $menu1->category->kategori_bahan_utama);
        // })
        //     ->where('id', '!=', $idMenu1)
        //     ->get();

        // return view('jaccard-similarity', compact('menu1', 'menu2', 'menu1Details', 'menu2Details', 'allMenus', 'expectedMenus'));


        // // Langkah 1: Hitung jumlah menu per kategori bahan utama
        // $kategoriCounts = Menu::with('category')
        //     ->where('id', '!=', $idMenu1)
        //     ->get()
        //     ->groupBy(fn($menu) => $menu->category->kategori_bahan_utama)
        //     ->map(fn($group) => $group->count());

        // // Langkah 2: Ambil jumlah terkecil
        // $minCount = $kategoriCounts->min();

        // // Langkah 3: Ambil menu sejumlah minCount dari setiap kategori
        // $balancedMenus = collect();
        // foreach ($kategoriCounts as $kategori => $count) {
        //     $menus = Menu::with('details.component', 'category')
        //         ->whereHas('category', fn($q) => $q->where('kategori_bahan_utama', $kategori))
        //         ->where('id', '!=', $idMenu1)
        //         ->limit($minCount)
        //         ->get();

        //     $balancedMenus = $balancedMenus->merge($menus);
        // }

        // // AllMenus hasil sampling seimbang
        // $allMenus = $balancedMenus;

        // Ambil expected menus dengan kategori bahan utama yang sama
        // $expectedMenus = Menu::whereHas('category', function ($query) use ($menu1) {
        //         $query->where('kategori_bahan_utama', $menu1->category->kategori_bahan_utama);
        //     })
        //     ->where('id', '!=', $idMenu1)
        //     ->get();

        // Ambil expected menus manual
        $expectedMenus = Menu::with('details.component', 'category')
            ->where('id', '!=', $idMenu1)
            ->whereIn('id', [9, 34, 43, 1, 3])
            ->get();

        return view('jaccard-similarity', compact(
            'menu1', 'menu2', 'menu1Details', 'menu2Details', 'allMenus', 'expectedMenus'
        ));
    }
}
