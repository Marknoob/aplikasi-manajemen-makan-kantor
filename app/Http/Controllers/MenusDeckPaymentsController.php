<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuDeckPayment;
use Illuminate\Http\Request;

class MenusDeckPaymentsController extends Controller
{
    public function create(Request $request)
    {
        $menu_deck_id = $request->query('menu_deck_id');
        return view('menus-deck-payments.create', compact('menu_deck_id'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'menu_deck_id' => 'required|exists:menus_deck,id',
            'deskripsi_pembayaran' => 'required|string|max:255',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string|max:255',
            // 'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        MenuDeckPayment::create([
            'menu_deck_id' => $request->menu_deck_id,
            'deskripsi_pembayaran' => $request->deskripsi_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            // 'file_path' => $request->file_path,
        ]);

        return redirect()
            ->route('menus-deck.edit', $request->menu_deck_id)
            ->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit(MenuDeckPayment $menusDeckPayment)
    {
        return view('menus-deck-payments.edit', compact('menusDeckPayment'));
    }

    public function update(Request $request, MenuDeckPayment $menusDeckPayment)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
            'deskripsi_pembayaran' => 'required|string|max:255',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string|max:255',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menusDeckPayment->update([
            'jumlah_bayar' => $request->jumlah_bayar,
            'deskripsi_pembayaran' => $request->deskripsi_pembayaran,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            // 'file_path' => $request->file_path,
        ]);

        return redirect()
            ->route('menus-deck.edit', $menusDeckPayment->menu_deck_id)
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function delete($id, MenuDeckPayment $menuDeckPayment)
    {
        $expense = MenuDeckPayment::findOrFail($id);
        $expense->is_active = false;
        $expense->save();

        return redirect()
            ->route('menus-deck.edit', $menuDeckPayment->menu_deck_id)
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }

}
