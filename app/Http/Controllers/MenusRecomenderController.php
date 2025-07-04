<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenusDeck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenusRecomenderController extends Controller
{
    public function index(Request $request){
        Carbon::setLocale('id');

        // $bulan = 4;
        // $tahun = 2025;
        $bulan = $request->query('bulan', now()->month);
        $tahun = $request->query('tahun', now()->year);
        $periode = sprintf('%04d-%02d', $tahun, $bulan);
        $bulanTahun = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

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

        $weeksCount = count($weeks);

        $menus = Menu::with('vendor:id,id,nama', 'category:id,kategori_bahan_utama')
            ->where(function ($query) {
                $query->whereNull('terakhir_dipilih')
                    ->orWhere('terakhir_dipilih', '<', Carbon::now()->subDays(30));
            })
            ->leftJoin('menus_deck', 'menus.id', '=', 'menus_deck.menu_id')
            ->select(
                'menus.id',
                'menus.nama_menu',
                'menus.vendor_id',
                'menus.category_id',
                'menus.harga',
                // Get menu berdasarkan vote
                DB::raw('SUM(CASE WHEN menus_deck.total_serve IS NOT NULL THEN menus_deck.total_serve ELSE 0 END) as total_serve'),
                DB::raw('SUM(CASE WHEN menus_deck.jumlah_vote IS NOT NULL THEN menus_deck.jumlah_vote ELSE 0 END) as jumlah_vote'),
                DB::raw('CASE
                            WHEN SUM(CASE WHEN menus_deck.total_serve IS NOT NULL THEN menus_deck.total_serve ELSE 0 END) > 0
                            THEN ROUND(SUM(CASE WHEN menus_deck.jumlah_vote IS NOT NULL THEN menus_deck.jumlah_vote ELSE 0 END) * 100.0 / SUM(CASE WHEN menus_deck.total_serve IS NOT NULL THEN menus_deck.total_serve ELSE 0 END), 2)
                            ELSE 0
                        END as vote_percentage')
            )
            ->groupBy('menus.id', 'menus.nama_menu', 'menus.vendor_id', 'menus.category_id', 'menus.harga')
            ->orderByDesc('vote_percentage') // Urutkan berdasarkan persentase vote terbanyak
            ->get();
        // dd($menus);

        return view('menus-recommender.index', compact('weeks', 'bulanTahun', 'tahun', 'bulan', 'periode', 'weeksCount', 'menus'));
    }

    public function store(Request $request)
    {
        $data = json_decode($request->input('menus_data'), true);

        foreach ($data as $menu) {
            MenusDeck::create([
                'menu_id' => $menu['menu_id'],
                'harga_menu' => $menu['harga_menu'],
                'tanggal_pelaksanaan' => $menu['tanggal_pelaksanaan'],
            ]);
        }

        // Update menus terakhir dipilih
        foreach ($data as $menu) {
            Menu::where('id', $menu['menu_id'])->update([
                'terakhir_dipilih' => $menu['tanggal_pelaksanaan'],
            ]);
        }

        return redirect()->back()->with('success', 'Menu berhasil disimpan.');
    }
}
