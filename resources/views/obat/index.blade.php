@extends('layouts.main')

@section('contents')
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
                    <h3>Data Obat</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Obat</h5>
                    <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal"
                        data-bs-target="#modalTambahObat">
                        <i class="bi bi-plus-circle-fill me-2"></i> Tambah Obat
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Kode Obat</th>
                                <th>Nama Obat</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Supplier</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obats as $obat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $obat->NmObat }}</td>
                                <td>{{ $obat->Jenis }}</td>
                                <td>{{ $obat->Satuan }}</td>
                                <td>Rp {{ number_format($obat->HargaBeli, 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($obat->HargaJual, 2, ',', '.') }}</td>
                                <td>{{ $obat->Stok }}</td>
                                <td>{{ $obat->supplier->NmSupplier ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditObat{{ $obat->KdObat }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <div class="modal fade text-left" id="modalEditObat{{ $obat->KdObat }}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalEditObatLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditObatLabel">Edit Obat</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('obat.update', $obat->KdObat) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="NmObat">Nama Obat</label>
                                                            <input type="text" class="form-control" id="NmObat" name="NmObat" value="{{ $obat->NmObat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Jenis">Jenis</label>
                                                            <input type="text" class="form-control" id="Jenis" name="Jenis" value="{{ $obat->Jenis }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Satuan">Satuan</label>
                                                            <input type="text" class="form-control" id="Satuan" name="Satuan" value="{{ $obat->Satuan }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="HargaBeli">Harga Beli</label>
                                                            <input type="number" step="0.01" class="form-control" id="HargaBeli" name="HargaBeli" value="{{ $obat->HargaBeli }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="HargaJual">Harga Jual</label>
                                                            <input type="number" step="0.01" class="form-control" id="HargaJual" name="HargaJual" value="{{ $obat->HargaJual }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Stok">Stok</label>
                                                            <input type="number" class="form-control" id="Stok" name="Stok" value="{{ $obat->Stok }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="KdSupplier">Supplier</label>
                                                            <select class="form-control" id="KdSupplier" name="KdSupplier" required>
                                                                @foreach($suppliers as $supplier)
                                                                <option value="{{ $supplier->KdSupplier }}" {{ $obat->KdSupplier == $supplier->KdSupplier ? 'selected' : '' }}>
                                                                    {{ $supplier->NmSupplier }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('obat.destroy', $obat->KdObat) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade text-left" id="modalTambahObat" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahObatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahObatLabel">Tambah Obat</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('obat.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NmObat">Nama Obat</label>
                            <input type="text" class="form-control" id="NmObat" name="NmObat" required>
                        </div>
                        <div class="form-group">
                            <label for="Jenis">Jenis</label>
                            <input type="text" class="form-control" id="Jenis" name="Jenis" required>
                        </div>
                        <div class="form-group">
                            <label for="Satuan">Satuan</label>
                            <input type="text" class="form-control" id="Satuan" name="Satuan" required>
                        </div>
                        <div class="form-group">
                            <label for="HargaBeli">Harga Beli</label>
                            <input type="number" step="0.01" class="form-control" id="HargaBeli" name="HargaBeli" required>
                        </div>
                        <div class="form-group">
                            <label for="HargaJual">Harga Jual</label>
                            <input type="number" step="0.01" class="form-control" id="HargaJual" name="HargaJual" required>
                        </div>
                        <div class="form-group">
                            <label for="Stok">Stok</label>
                            <input type="number" class="form-control" id="Stok" name="Stok" required>
                        </div>
                        <div class="form-group">
                            <label for="KdSupplier">Supplier</label>
                            <select class="form-control" id="KdSupplier" name="KdSupplier" required>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->KdSupplier }}">{{ $supplier->NmSupplier }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script>
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
    
        function confirmDelete(url) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = '@csrf @method('DELETE')';
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
</div>
@endsection