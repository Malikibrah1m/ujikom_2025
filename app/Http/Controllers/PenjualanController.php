<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan', 'details'])->get();
        $pelanggans = Pelanggan::all();
        $obats = Obat::all();

        return view('penjualan.index', compact('penjualans', 'pelanggans', 'obats'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'Nota' => 'required|unique:penjualans,Nota',
                'TglNota' => 'required|date',
                'KdPelanggan' => 'required|exists:pelanggans,KdPelanggan',
                'Diskon' => 'required|numeric|min:0',
                'obat' => 'required|array|min:1',
                'obat.*.KdObat' => 'required|exists:obats,KdObat',
                'obat.*.Jumlah' => 'required|integer|min:1',
            ]);

            // Create main transaction
            $penjualan = Penjualan::create([
                'Nota' => $request->Nota,
                'TglNota' => $request->TglNota,
                'KdPelanggan' => $request->KdPelanggan,
                'Diskon' => $request->Diskon,
            ]);

            // Create transaction details
            foreach ($request->obat as $item) {
                $obat = Obat::find($item['KdObat']);

                PenjualanDetail::create([
                    'Nota' => $penjualan->Nota,
                    'KdObat' => $item['KdObat'],
                    'Jumlah' => $item['Jumlah'],
                ]);

                // Update stock
                $obat->Stok -= $item['Jumlah'];
                $obat->save();
            }

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi penjualan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show($nota)
    {
        $penjualan = Penjualan::with(['pelanggan', 'details.obat'])->findOrFail($nota);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($nota)
    {
        DB::beginTransaction();

        try {
            $penjualan = Penjualan::with('details')->findOrFail($nota);

            // Restore stock
            foreach ($penjualan->details as $detail) {
                $obat = Obat::find($detail->KdObat);
                $obat->Stok += $detail->Jumlah;
                $obat->save();
            }

            // Delete transaction
            $penjualan->delete();

            DB::commit();

            return redirect()->route('penjualan.index')
                ->with('success', 'Transaksi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
    public function exportPdf()
    {
        $penjualans = Penjualan::with(['pelanggan', 'details.obat'])->get();

        $pdf = Pdf::loadView('penjualan.export', compact('penjualans'));

        return $pdf->download('laporan-penjualan.pdf');
    }
}
