<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Pembelian</title>
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
    <h2>Laporan Transaksi Pembelian</h2>
    <table>
        <thead>
            <tr>
                <th>Nota</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Diskon</th>
                <th>Total Obat</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pembelian)
                <tr>
                    <td>{{ $pembelian->Nota }}</td>
                    <td>{{ date('d/m/Y', strtotime($pembelian->TglNota)) }}</td>
                    <td>{{ $pembelian->supplier->NmSupplier }}</td>
                    <td>{{ $pembelian->Diskon }}%</td>
                    <td>{{ $pembelian->details->sum('Jumlah') }}</td>
                    <td>Rp {{ number_format($pembelian->details->sum(function($detail) {
                        return $detail->Jumlah * $detail->obat->HargaBeli;
                    }), 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>