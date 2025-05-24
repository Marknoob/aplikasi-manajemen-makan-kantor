<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index()
    {
        return view('menus.index', [
            'menus' => Menu::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function create()
    {
        return view('menus.create', [
            'vendors' => Vendor::all()
        ]);
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'karbohidrat' => 'required|string|max:255',
            'protein' => 'required|string|max:255',
            'sayur' => 'required|string|max:255',
            'buah' => 'required|string|max:255',
            'kategori_bahan_utama' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'harga' => 'required|integer|min:0',
            'terakhir_dipilih' => 'nullable|date',
        ]);

        Menu::create($request->all() + ['is_active' => true]);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'),[
            'vendors' => Vendor::all()
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'karbohidrat' => 'required|string|max:255',
            'protein' => 'required|string|max:255',
            'sayur' => 'required|string|max:255',
            'buah' => 'required|string|max:255',
            'kategori_bahan_utama' => 'required|string|max:255',
            'vendor_id' => 'required|exists:vendors,id',
            'harga' => 'required|integer|min:0',
            'terakhir_dipilih' => 'nullable|date',
        ]);
        $menu->update([
            'nama_menu' => $request->nama_menu,
            'karbohidrat' => $request->karbohidrat,
            'protein' => $request->protein,
            'sayur' => $request->sayur,
            'buah' => $request->buah,
            'kategori_bahan_utama' => $request->kategori_bahan_utama,
            'vendor_id' => $request->vendor_id,
            'harga' => $request->harga,
            'jumlah_vote' => $request->jumlah_vote,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index');
    }
}
