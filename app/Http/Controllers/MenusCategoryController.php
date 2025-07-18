<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenusCategory;
use Illuminate\Http\Request;

class MenusCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = MenusCategory::where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kategori_bahan_utama', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        $menusCategories = $query->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('menus-category.index', compact('menusCategories'));
    }

    public function create(Request $request)
    {
        return view('menus-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_bahan_utama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        MenusCategory::create([
            'kategori_bahan_utama' => $request->kategori_bahan_utama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Kategori Menu berhasil ditambahkan.');
    }

    public function edit(MenusCategory $menusCategory)
    {
        return view('menus-category.edit', compact('menusCategory'));
    }

    public function update(Request $request, MenusCategory $menusCategory)
    {
        $request->validate([
            'kategori_bahan_utama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $menusCategory->update([
            'kategori_bahan_utama' => $request->kategori_bahan_utama,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Kategori Menu berhasil diperbarui.');
    }
}
