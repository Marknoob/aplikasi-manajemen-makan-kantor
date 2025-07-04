<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenusDeck;
use App\Models\Menu;
use App\Models\MenuDeckExpense;
use App\Models\MenuDeckPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MenusDeckController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        // $bulan = 4;
        // $tahun = 2025;
        $bulan = $request->query('bulan', now()->month);
        $tahun = $request->query('tahun', now()->year);
        $periode = sprintf('%04d-%02d', $tahun, $bulan);

        $tanggalAwalBulan = Carbon::createFromDate($tahun, $bulan, 1);
        $tanggalAkhirBulan = $tanggalAwalBulan->copy()->endOfMonth();

        // Cari Senin pertama (bisa dari bulan sebelumnya)
        $tanggalAwal = $tanggalAwalBulan->copy()->startOfWeek(Carbon::MONDAY);
        // Cari Jumat terakhir (bisa sampai bulan berikutnya)
        $tanggalAkhir = $tanggalAkhirBulan->copy()->endOfWeek(Carbon::FRIDAY);

        $weeks = [];
        $currentWeek = [];

        $current = $tanggalAwal->copy();

        $menusDecks = MenusDeck::with('menu.vendor')
            ->whereBetween('tanggal_pelaksanaan', [$tanggalAwal, $tanggalAkhir])
            ->where('is_active', true)
            ->get()
            ->groupBy(function ($menuDeck) {
                return Carbon::parse($menuDeck->tanggal_pelaksanaan)->format('Y-m-d');
            });

        while ($current <= $tanggalAkhir) {
            // Hanya ambil hari kerja (Senin–Jumat)
            if ($current->isWeekday()) {
                $dateFormatted = $current->format('Y-m-d');

                $currentWeek[] = (object) [
                    'date' => $dateFormatted,
                    'in_month' => $current->month == $bulan,
                    'menus_deck' => $menusDecks->get($dateFormatted) ? $menusDecks->get($dateFormatted)->first() : null,
                ];
            }

            // Setiap Jumat, simpan minggu dan reset
            if ($current->isFriday()) {
                // Simpan hanya jika ada minimal 1 hari in_month = true
                $hasInMonth = collect($currentWeek)->contains(fn ($hari) => $hari->in_month === true);

                if ($hasInMonth) {
                    $confirmed = 0;
                    $not_confirmed = 0;

                    foreach ($currentWeek as $day) {
                        if ($day->menus_deck) {
                            if ($day->menus_deck->status == 1) {
                                $confirmed++;
                            } elseif ($day->menus_deck->status == 0) {
                                $not_confirmed++;
                            }
                        }
                    }

                    $weeks[] = (object) [
                        'days' => $currentWeek,
                        'confirmed' => $confirmed,
                        'not_confirmed' => $not_confirmed,
                    ];
                }

                $currentWeek = [];
            }

            $current->addDay();
        }

        return view('menus-deck.index', compact( 'weeks', 'periode', 'tahun', 'bulan'));
    }

    public function create(Request $request)
    {
        $menus = Menu::with('details.component', 'category')
            ->where(function ($query) {
                $query->whereNull('terakhir_dipilih')
                ->orWhere('terakhir_dipilih', '<', Carbon::now()->subDays(30));
            })
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        $tanggal_pelaksanaan = $request->query('tanggal_pelaksanaan');
        return view('menus-deck.create', compact('menus', 'tanggal_pelaksanaan'));
    }

    public function show(MenusDeck $menusDeck)
    {
        return view('menus-deck.show', compact('menusDeck'));
    }

    public function edit(MenusDeck $menusDeck)
    {
        $menus = Menu::whereNull('terakhir_dipilih')
            ->orWhere('id', $menusDeck->menu_id)
            ->where('is_active', true)
            ->get();
        $expenses = MenuDeckExpense::where('menu_deck_id', $menusDeck->id)
            ->where('is_active', true)
            ->get();
        $payments = MenuDeckPayment::where('menu_deck_id', $menusDeck->id)
            ->where('is_active', true)
            ->get();

        if ($expenses != null && $payments != null) {
            $total_biaya = 0;
            foreach ($expenses as $expense) {
                $total_biaya += $expense->jumlah_biaya;
            }

            $total_pembayaran = 0;
            foreach ($payments as $payment) {
                $total_pembayaran += $payment->jumlah_bayar;
            }

            // Status Bayar
            if ($total_pembayaran >= $total_biaya) {
                $menusDeck->status_lunas = "Paid";
            }
            if ($total_pembayaran < $total_biaya) {
                $menusDeck->status_lunas = "Half Paid";
            }
            if ($total_pembayaran == 0) {
                $menusDeck->status_lunas = "Not Paid";
            }
        }
        return view('menus-deck.edit', compact('menusDeck', 'menus', 'total_biaya', 'expenses','payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'total_serve' => 'nullable|numeric|min:1',
            'harga_menu' => 'nullable|numeric|min:0',
            'jumlah_vote' => 'nullable|numeric|min:0',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);

        $harga = Menu::where('id', $request->menu_id)->first()->harga;

        MenusDeck::create([
            'menu_id' => $request->menu_id,
            'total_serve' => $request->total_serve,
            'harga_menu' => $request->harga_menu ?? $harga,
            'jumlah_vote' => $request->jumlah_vote,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
        ]);

        // Update Menu Terakhir Dipilih
        Menu::where('id', $request->menu_id)
            ->update([
                'terakhir_dipilih' => $request->tanggal_pelaksanaan,
            ]);

        return redirect()->route('menus-deck.index')->with('success', 'Menu Deck berhasil ditambahkan.');
    }

    public function update(Request $request, MenusDeck $menusDeck)
    {
        if ($request->status == 0 || $request->status == 1) {
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'total_serve' => 'nullable|numeric|min:1',
                'harga_menu' => 'nullable|numeric|min:0',
                'jumlah_vote' => 'nullable|numeric|min:0',
                'status' => 'required|boolean',
            ]);
        }

        if ($request->status == 0) {
            $menusDeck->update([
                'menu_id' => $request->menu_id,
                'total_serve' => $request->total_serve,
                'harga_menu' => $request->harga_menu,
                'jumlah_vote' => $request->jumlah_vote,
                'status' => $request->status,
            ]);
        }

        // Konfirmasi Menus Deck
        if ($request->status == 1) {
            $menusDeck->update([
                'status' => $request->status,
                'total_serve' => $request->total_serve,
            ]);

            MenuDeckExpense::create([
                'menu_deck_id' => $menusDeck->id,
                'deskripsi_biaya' => "Biaya Pokok",
                'jumlah_biaya' => $request->total_serve * $request->harga_menu,
            ]);

            // Update Menu Terakhir Dipilih
            Menu::where('id', $request->menu_id)
                ->update([
                    'terakhir_dipilih' => $menusDeck->tanggal_pelaksanaan,
                ]);
        }

        if ($request->status == 2) {
            $request->validate([
                'jumlah_vote' => 'required|numeric|min:0',
            ]);
            $menusDeck->update([
                'jumlah_vote' => $request->jumlah_vote,
            ]);
        }

        return redirect()->route('menus-deck.index')->with('success', 'Menu Deck berhasil diperbarui.');
    }
}
