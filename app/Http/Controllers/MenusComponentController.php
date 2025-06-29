<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenusComponent;
use Illuminate\Http\Request;

class MenusComponentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = MenusComponent::where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_komponen', 'like', '%' . $search . '%')
                ->orWhere('jenis_komponen', 'like', '%' . $search . '%');
            });
        }

        $menusComponents = $query->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('menus-component.index', compact('menusComponents'));
    }

    public function create(Request $request)
    {
        return view('menus-component.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'jenis_komponen' => 'required|string|max:255',
        ]);

        MenusComponent::create([
            'nama_komponen' => $request->nama_komponen,
            'jenis_komponen' => $request->jenis_komponen,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Komponen Menu berhasil ditambahkan.');
    }

    public function edit(MenusComponent $menusComponent)
    {
        return view('menus-component.edit', compact('menusComponent'));
    }

    public function update(Request $request, MenusComponent $menusComponent)
    {
        $request->validate([
            'nama_komponen' => 'required|string|max:255',
            'jenis_komponen' => 'required|string|max:255',
        ]);

        $menusComponent->update([
            'nama_komponen' => $request->nama_komponen,
            'jenis_komponen' => $request->jenis_komponen,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Komponen Menu berhasil diperbarui.');
    }
}
