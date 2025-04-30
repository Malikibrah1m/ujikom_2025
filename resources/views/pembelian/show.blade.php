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
                                <td>{{ $pembelian->Nota }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ date('d/m/Y', strtotime($pembelian->TglNota)) }}</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $pembelian->supplier->NmSupplier }}</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td>{{ $pembelian->Diskon }}%</td>
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
                            <th>Harga Beli</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian->details as $detail)
                            <tr>
                                <td>{{ $detail->obat->NmObat }}</td>
                                <td>Rp {{ number_format($detail->obat->HargaBeli, 0, ',', '.') }}</td>
                                <td>{{ $detail->Jumlah }}</td>
                                <td>Rp {{ number_format($detail->Jumlah * $detail->obat->HargaBeli, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total Sebelum Diskon</th>
                            <th>Rp
                                {{ number_format(
                                    $pembelian->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaBeli;
                                    }),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">Diskon ({{ $pembelian->Diskon }}%)</th>
                            <th>Rp
                                {{ number_format(
                                    $pembelian->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaBeli;
                                    }) *
                                        ($pembelian->Diskon / 100),
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
                                    $pembelian->details->sum(function ($detail) {
                                        return $detail->Jumlah * $detail->obat->HargaBeli;
                                    }) *
                                        (1 - $pembelian->Diskon / 100),
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
                <a href="{{ route('pembelian.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
