<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
{
    $obats = Obat::with('supplier')->get();
    $suppliers = Supplier::all(); // get all suppliers
    return view('obat.index', compact('obats', 'suppliers')); // Include suppliers in the compact
}

    public function create()
    {
        $suppliers = Supplier::all();
        return view('obat.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NmObat' => 'required',
            'Jenis' => 'required',
            'Satuan' => 'required',
            'HargaBeli' => 'required|numeric',
            'HargaJual' => 'required|numeric',
            'Stok' => 'required|integer',
            'KdSupplier' => 'required|exists:suppliers,KdSupplier'
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat created successfully.');
    }

    public function show(Obat $obat)
    {
        return view('obat.show', compact('obat'));
    }

    public function edit(Obat $obat)
    {
        $suppliers = Supplier::all();
        return view('obat.edit', compact('obat', 'suppliers'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'NmObat' => 'required',
            'Jenis' => 'required',
            'Satuan' => 'required',
            'HargaBeli' => 'required|numeric',
            'HargaJual' => 'required|numeric',
            'Stok' => 'required|integer',
            'KdSupplier' => 'required|exists:suppliers,KdSupplier'
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')
            ->with('success', 'Obat updated successfully');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('success', 'Obat deleted successfully');
    }
}