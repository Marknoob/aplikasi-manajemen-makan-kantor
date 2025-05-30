<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Vendor::where('is_active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                ->orWhere('kontak', 'like', '%' . $search . '%');
            });
        }

        $vendors = $query->orderBy('created_at', 'desc')
                ->paginate(10);

        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendors.create');
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'penilaian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Vendor::create($request->all() + ['is_active' => true]);
        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'penilaian' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        $vendor->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'penilaian' => $request->penilaian,
            'keterangan' => $request->keterangan,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);
        return redirect()->route('vendors.index')->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index');
    }
}
