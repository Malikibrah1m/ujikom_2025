<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>Nota</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Diskon</th>
                <th>Total Obat</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualans as $penjualan)
                <tr>
                    <td>{{ $penjualan->Nota }}</td>
                    <td>{{ date('d/m/Y', strtotime($penjualan->TglNota)) }}</td>
                    <td>{{ $penjualan->pelanggan->NmPelanggan }}</td>
                    <td>{{ $penjualan->Diskon }}%</td>
                    <td>{{ $penjualan->details->sum('Jumlah') }}</td>
                    <td>Rp {{ number_format($penjualan->details->sum(function($detail) {
                        return $detail->Jumlah * $detail->obat->HargaJual;
                    }), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
