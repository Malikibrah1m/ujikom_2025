@extends('layouts.main')

@section('content')
@include('layouts.sidebar')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Transaksi Pembelian</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Transaksi</h3>
        </div>
        <form id="addPembelianForm" method="POST" action="{{ route('pembelian.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="Nota">Nota</label>
                    <input type="text" class="form-control" id="Nota" name="Nota" placeholder="Masukkan nomor nota" required>
                    @error('Nota') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="TglNota">Tanggal Nota</label>
                    <input type="date" class="form-control" id="TglNota" name="TglNota" required>
                    @error('TglNota') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="KdSupplier">Supplier</label>
                    <select class="form-control" id="KdSupplier" name="KdSupplier" required>
                        <option value="">Pilih Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->KdSupplier }}">{{ $supplier->NmSupplier }}</option>
                        @endforeach
                    </select>
                    @error('KdSupplier') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="Diskon">Diskon (%)</label>
                    <input type="number" class="form-control" id="Diskon" name="Diskon" placeholder="Masukkan diskon" min="0" max="100" value="0" required>
                    @error('Diskon') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Obat</label>
                    <table class="table table-bordered" id="obatTable">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Harga Beli</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control obat-select" name="obat[0][KdObat]" onchange="updateHarga(this)" required>
                                        <option value="">Pilih Obat</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->KdObat }}" data-harga="{{ $obat->HargaBeli }}">{{ $obat->NmObat }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control harga-beli" name="obat[0][HargaBeli]" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control jumlah" name="obat[0][Jumlah]" min="1" oninput="updateSubtotal(this)" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control subtotal" name="obat[0][Subtotal]" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm" id="addRow">
                        <i class="fas fa-plus"></i> Tambah Obat
                    </button>
                </div>
                <div class="form-group">
                    <label for="Total">Total</label>
                    <input type="number" class="form-control" id="Total" name="Total" readonly>
                </div>
                <div class="form-group">
                    <label for="GrandTotal">Grand Total (Setelah Diskon)</label>
                    <input type="number" class="form-control" id="GrandTotal" name="GrandTotal" readonly>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Jual</button>
            </div>
        </form>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi Pembelian</h3>
        </div>
        <a href="{{ route('pembelian.export') }}" class="btn btn-success mb-3" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <div class="card-body">
            <table id="pembelian-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Diskon</th>
                        <th>Total Obat</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
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
                        <td>
                            <a href="{{ route('pembelian.show', $pembelian->Nota) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <form action="{{ route('pembelian.destroy', $pembelian->Nota) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>                                                              
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    @section('js')
    <script>
        function updateHarga(select) {
            let harga = $(select).find(':selected').data('harga') || 0;
            let row = $(select).closest('tr');
            row.find('.harga-beli').val(harga);
            updateSubtotal(row.find('.jumlah')[0]);
        }
    
        function updateSubtotal(input) {
            let row = $(input).closest('tr');
            let harga = parseFloat(row.find('.harga-beli').val()) || 0;
            let jumlah = parseInt($(input).val()) || 0;
            let subtotal = harga * jumlah;
            row.find('.subtotal').val(subtotal);
            calculateTotal();
        }
    
        function calculateTotal() {
            let total = 0;
            $('.subtotal').each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $('#Total').val(total);
            calculateGrandTotal();
        }
    
        function calculateGrandTotal() {
            let total = parseFloat($('#Total').val()) || 0;
            let diskon = parseFloat($('#Diskon').val()) || 0;
            let grandTotal = total - (total * (diskon / 100));
            $('#GrandTotal').val(grandTotal);
        }
    
        $(document).ready(function () {
            let rowIndex = 1;
    
            // Tambah baris obat
            $('#addRow').on('click', function () {
                let newRow = `
                    <tr>
                        <td>
                            <select class="form-control obat-select" name="obat[${rowIndex}][KdObat]" onchange="updateHarga(this)" required>
                                <option value="">Pilih Obat</option>
                                @foreach($obats as $obat)
                                    <option value="{{ $obat->KdObat }}" data-harga="{{ $obat->HargaBeli }}">{{ $obat->NmObat }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control harga-beli" name="obat[${rowIndex}][HargaBeli]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control jumlah" name="obat[${rowIndex}][Jumlah]" min="1" oninput="updateSubtotal(this)" required>
                        </td>
                        <td>
                            <input type="number" class="form-control subtotal" name="obat[${rowIndex}][Subtotal]" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#obatTable tbody').append(newRow);
                rowIndex++;
            });
    
            // Hapus baris obat
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                calculateTotal();
            });
    
            // Hitung total dan grand total saat diskon diubah
            $('#Diskon').on('input', function () {
                calculateGrandTotal();
            });
    
            // Initialize DataTable
            $('#pembelian-table').DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    @endsection
</div>
