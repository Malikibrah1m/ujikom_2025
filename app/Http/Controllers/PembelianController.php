<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with(['supplier', 'details'])->get();
        $suppliers = Supplier::all();
        $obats = Obat::all();
        
        return view('pembelian.index', compact('pembelians', 'suppliers', 'obats'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $request->validate([
                'Nota' => 'required|unique:pembelians,Nota',
                'TglNota' => 'required|date',
                'KdSupplier' => 'required|exists:suppliers,KdSupplier',
                'Diskon' => 'required|numeric|min:0',
                'obat' => 'required|array|min:1',
                'obat.*.KdObat' => 'required|exists:obats,KdObat',
                'obat.*.Jumlah' => 'required|integer|min:1',
            ]);

            // Create main transaction
            $pembelian = Pembelian::create([
                'Nota' => $request->Nota,
                'TglNota' => $request->TglNota,
                'KdSupplier' => $request->KdSupplier,
                'Diskon' => $request->Diskon,
            ]);

            // Create transaction details
            foreach ($request->obat as $item) {
                $obat = Obat::find($item['KdObat']);
                
                PembelianDetail::create([
                    'Nota' => $pembelian->Nota,
                    'KdObat' => $item['KdObat'],
                    'Jumlah' => $item['Jumlah'],
                ]);

                // Update stock (increase for purchases)
                $obat->Stok += $item['Jumlah'];
                $obat->save();
            }

            DB::commit();

            return redirect()->route('pembelian.index')
                ->with('success', 'Transaksi pembelian berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }

    public function show($nota)
    {
        $pembelian = Pembelian::with(['supplier', 'details.obat'])->findOrFail($nota);
        return view('pembelian.show', compact('pembelian'));
    }

    public function destroy($nota)
    {
        DB::beginTransaction();
        
        try {
            $pembelian = Pembelian::with('details')->findOrFail($nota);
            
            // Restore stock (decrease for purchase deletion)
            foreach ($pembelian->details as $detail) {
                $obat = Obat::find($detail->KdObat);
                $obat->Stok -= $detail->Jumlah;
                $obat->save();
            }
            
            // Delete transaction
            $pembelian->delete();
            
            DB::commit();
            
            return redirect()->route('pembelian.index')
                ->with('success', 'Transaksi berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: '.$e->getMessage());
        }
    }

    public function export()
    {
        $pembelians = Pembelian::with(['supplier', 'details.obat'])->get();
        $pdf = Pdf::loadView('pembelian.export', compact('pembelians'));
        return $pdf->download('laporan_pembelian.pdf');
    }
}