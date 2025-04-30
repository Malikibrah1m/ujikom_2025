@extends('layouts.main')

@section('content')
    <div id="main">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Transaksi</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>No. Nota</th>
                                <td>{{ $penjualan->Nota }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ date('d/m/Y', strtotime($penjualan->TglNota)) }}</td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>{{ $penjualan->pelanggan->NmPelanggan }}</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td>{{ $penjualan->Diskon }}%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Daftar Obat</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->details as $detail)
                            <tr>
                                <td>{{ $detail->obat->NmObat }}</td>
                                <td>Rp {{ number_format($detail->obat->HargaJual, 0, ',', '.') }}</td>
                                <td>{{ $detail->Jumlah }}</td>
                                <td>Rp {{ number_format($detail->Jumlah * $detail->obat->HargaJual, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total Sebelum Diskon</th>
                            <th>Rp
                                {{ number_format(
                                    $penjualan->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaJual;
                                    }),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">Diskon ({{ $penjualan->Diskon }}%)</th>
                            <th>Rp
                                {{ number_format(
                                    $penjualan->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaJual;
                                    }) *
                                        ($penjualan->Diskon / 100),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">Grand Total</th>
                            <th>Rp
                                {{ number_format(
                                    $penjualan->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaJual;
                                    }) *
                                        (1 - $penjualan->Diskon / 100),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('penjualan.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
