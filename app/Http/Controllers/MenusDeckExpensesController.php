<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuDeckExpense;
use Illuminate\Http\Request;

class MenusDeckExpensesController extends Controller
{
    public function create(Request $request)
    {
        $menu_deck_id = $request->query('menu_deck_id');
        return view('menus-deck-expenses.create', compact('menu_deck_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_deck_id' => 'required|exists:menus_deck,id',
            'deskripsi_biaya' => 'required|string|max:255',
            'jumlah_biaya' => 'required|numeric|min:0',
        ]);

        MenuDeckExpense::create([
            'menu_deck_id' => $request->menu_deck_id,
            'deskripsi_biaya' => $request->deskripsi_biaya,
            'jumlah_biaya' => $request->jumlah_biaya,
        ]);

        return redirect()
            ->route('menus-deck.edit', $request->menu_deck_id)
            ->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function edit(MenuDeckExpense $menusDeckExpense)
    {
        return view('menus-deck-expenses.edit', compact('menusDeckExpense'));
    }

    public function update(Request $request, MenuDeckExpense $menusDeckExpense)
    {
        $request->validate([
            'deskripsi_biaya' => 'required|string|max:255',
            'jumlah_biaya' => 'required|numeric|min:0',
        ]);

        $menusDeckExpense->update([
            'deskripsi_biaya' => $request->deskripsi_biaya,
            'jumlah_biaya' => $request->jumlah_biaya,
        ]);

        return redirect()
            ->route('menus-deck.edit', $menusDeckExpense->menu_deck_id)
            ->with('success', 'Biaya berhasil diperbarui.');
    }

    public function delete($id, MenuDeckExpense $menusDeckExpense)
    {
        $expense = MenuDeckExpense::findOrFail($id);
        $expense->is_active = false;
        $expense->save();

        return redirect()
            ->route('menus-deck.edit', $menusDeckExpense->menu_deck_id)
            ->with('success', 'Biaya berhasil diperbarui.');
    }

}
