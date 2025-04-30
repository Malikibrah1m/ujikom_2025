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
                    <h3>Transaksi Penjualan</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Transaksi</h3>
        </div>
        <form id="addPenjualanForm" method="POST" action="{{ route('penjualan.store') }}">
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
                    <label for="KdPelanggan">Pelanggan</label>
                    <select class="form-control" id="KdPelanggan" name="KdPelanggan" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->KdPelanggan }}">{{ $pelanggan->NmPelanggan }}</option>
                        @endforeach
                    </select>
                    @error('KdPelanggan') <span class="text-danger">{{ $message }}</span> @enderror
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
                                <th>Harga Jual</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control obat-select" name="obat[0][KdObat]" onchange="updateHarga(this)" required>
                                        <option value="">Pilih Obat</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->KdObat }}" data-harga="{{ $obat->HargaJual }}" data-stok="{{ $obat->Stok }}">{{ $obat->NmObat }} (Stok: {{ $obat->Stok }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control harga-jual" name="obat[0][HargaJual]" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control jumlah" name="obat[0][Jumlah]" min="1" oninput="updateSubtotal(this)" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control subtotal" name="obat[0][Subtotal]" readonly>
                                </td>
                                {{-- <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td> --}}
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
            <h3 class="card-title">Daftar Transaksi Penjualan</h3>
        </div>
        <a href="{{ route('penjualan.export') }}" class="btn btn-success mb-3" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <div class="card-body">
            <table id="penjualan-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Diskon</th>
                        <th>Total Obat</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
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
                        <td>
                            <a href="{{ route('penjualan.show', $penjualan->Nota) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <form action="{{ route('penjualan.destroy', $penjualan->Nota) }}" method="POST" style="display: inline-block;">
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
            let stok = $(select).find(':selected').data('stok') || 0;
            let row = $(select).closest('tr');
            row.find('.harga-jual').val(harga);
            row.find('.jumlah').attr('max', stok);
            updateSubtotal(row.find('.jumlah')[0]);
        }
    
        function updateSubtotal(input) {
            let row = $(input).closest('tr');
            let harga = parseFloat(row.find('.harga-jual').val()) || 0;
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
                                    <option value="{{ $obat->KdObat }}" data-harga="{{ $obat->HargaJual }}" data-stok="{{ $obat->Stok }}">{{ $obat->NmObat }} (Stok: {{ $obat->Stok }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control harga-jual" name="obat[${rowIndex}][HargaJual]" readonly>
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
            $('#penjualan-table').DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    @endsection
</div>

{{-- @stop --}}