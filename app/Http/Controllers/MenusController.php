<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Vendor;
use App\Models\MenusDetail;
use App\Models\MenusComponent;
use App\Models\MenusCategory;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Menu::with(['category', 'vendor']) // Eager load kategori dan vendor
                ->where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_menu', 'like', '%' . $search . '%')
                // Cari berdasarkan kategori
                ->orWhereHas('category', function ($q2) use ($search) {
                    $q2->where('kategori_bahan_utama', 'like', '%' . $search . '%');
                })
                // Cari berdasarkan vendor
                ->orWhereHas('vendor', function ($q3) use ($search) {
                    $q3->where('nama', 'like', '%' . $search . '%');
                });
            });
        }

        $menus = $query->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('menus.index', compact('menus'));
    }


    public function create()
    {
        $vendors = Vendor::where('is_active', true)->get();
        $categories = MenusCategory::where('is_active', true)->get();

        // Ambil Komponen berdasarkan jenis Karbohidrat, Protein, Sayur, dan Buah
        $karbohidratList = MenusComponent::where('jenis_komponen', 'karbohidrat')
            ->where('is_active', true)
            ->get();
        $proteinList = MenusComponent::where('jenis_komponen', 'protein')
            ->where('is_active', true)
            ->get();
        $sayurList = MenusComponent::where('jenis_komponen', 'sayur')
            ->where('is_active', true)
            ->get();
        $buahList = MenusComponent::where('jenis_komponen', 'buah')
            ->orWhere('jenis_komponen', 'minuman')
            ->where('is_active', true)
            ->get();

        return view('menus.create', compact('vendors', 'categories', 'karbohidratList', 'proteinList', 'sayurList', 'buahList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'kategori_bahan_utama' => 'required|exists:menus_category,id',
            'vendor_id' => 'required|exists:vendors,id',
            'selected_komponen' => 'required|string', // JSON string dari js
        ]);

        $selectedKomponen = json_decode($validated['selected_komponen'], true);


        // Buat menu
        $menu = Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga_menu,
            'category_id' => $request->kategori_bahan_utama,
            'vendor_id' => $request->vendor_id,
            'terakhir_dipilih' => $request->input('terakhir_dipilih'),
            'is_active' => true,
        ]);

        // Simpan ke tabel MenusDetail
        foreach ($selectedKomponen as $item) {
            MenusDetail::create([
                'menu_id' => $menu->id,
                'component_id' => $item['id'],
            ]);
        }

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }


    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $vendors = Vendor::all();
        $categories = MenusCategory::all();

        // Ambil Komponen berdasarkan jenis Karbohidrat, Protein, Sayur, dan Buah
        $karbohidratList = MenusComponent::where('jenis_komponen', 'karbohidrat')
            ->where('is_active', true)
            ->get();
        $proteinList = MenusComponent::where('jenis_komponen', 'protein')
            ->where('is_active', true)
            ->get();
        $sayurList = MenusComponent::where('jenis_komponen', 'sayur')
            ->where('is_active', true)
            ->get();
        $buahList = MenusComponent::where('jenis_komponen', 'buah')
            ->orWhere('jenis_komponen', 'minuman')
            ->where('is_active', true)
            ->get();

        // Ambil menus detail
        $selectedKomponen = MenusDetail::with('component')
            ->where('menu_id', $menu->id)
            ->where('is_active', true)
            ->get();

        // dd($selectedKomponen);

        return view('menus.edit', compact('menu', 'vendors', 'categories', 'karbohidratList', 'proteinList', 'sayurList', 'buahList', 'selectedKomponen'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'kategori_bahan_utama' => 'required|exists:menus_category,id',
            'vendor_id' => 'required|exists:vendors,id',
            'selected_komponen' => 'required|string', // JSON string dari JS
        ]);

        $selectedKomponen = json_decode($validated['selected_komponen'], true);
        $selectedIds = collect($selectedKomponen)->pluck('id')->toArray();

        $menu->update([
            'nama_menu' => $validated['nama_menu'],
            'harga' => $request->harga_menu,
            'category_id' => $validated['kategori_bahan_utama'],
            'vendor_id' => $validated['vendor_id'],
            'terakhir_dipilih' => $request->input('terakhir_dipilih'),
        ]);

        $existingDetails = MenusDetail::where('menu_id', $menu->id)->get();

        // Cek apakah ada komponen yang dihapus
        foreach ($existingDetails as $detail) {
            if (!in_array($detail->component_id, $selectedIds)) {
                $detail->update(['is_active' => false]);
            } else {
                // Jika masih ada di request dan sebelumnya nonaktif, aktifkan lagi
                if (!$detail->is_active) {
                    $detail->update(['is_active' => true]);
                }
            }
        }

        // Tambah detail baru jika belum ada sebelumnya
        foreach ($selectedIds as $componentId) {
            $existing = $existingDetails->firstWhere('component_id', $componentId);
            if (!$existing) {
                MenusDetail::create([
                    'menu_id' => $menu->id,
                    'component_id' => $componentId,
                ]);
            }
        }

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index');
    }
}
