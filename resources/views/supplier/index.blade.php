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
                    <h3>Data Supplier</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Supplier</h5>
                    <!-- Tombol Tambah Supplier -->
                    <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSupplier">
                        <i class="bi bi-plus-circle-fill me-2"></i> Tambah Supplier
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Kode Supplier</th>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->NmSupplier }}</td>
                                <td>{{ $supplier->Alamat }}</td>
                                <td>{{ $supplier->Kota }}</td>
                                <td>{{ $supplier->Telpon }}</td>
                                <td>
                                    <!-- Tombol Edit Supplier -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditSupplier{{ $supplier->KdSupplier }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <!-- Modal Edit Supplier -->
                                    <div class="modal fade text-left" id="modalEditSupplier{{ $supplier->KdSupplier }}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalEditSupplierLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditSupplierLabel">Edit Supplier</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('supplier.update', $supplier->KdSupplier) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="NmSupplier">Nama Supplier</label>
                                                            <input type="text" class="form-control" id="NmSupplier" name="NmSupplier" value="{{ $supplier->NmSupplier }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Alamat">Alamat</label>
                                                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ $supplier->Alamat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Kota">Kota</label>
                                                            <input type="text" class="form-control" id="Kota" name="Kota" value="{{ $supplier->Kota }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Telpon">Telepon</label>
                                                            <input type="text" class="form-control" id="Telpon" name="Telpon" value="{{ $supplier->Telpon }}" required>
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

                                    <!-- Tombol Hapus Supplier -->
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('supplier.destroy', $supplier->KdSupplier) }}')">
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

    <!-- Modal Tambah Supplier -->
    <div class="modal fade text-left" id="modalTambahSupplier" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahSupplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahSupplierLabel">Tambah Supplier</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NmSupplier">Nama Supplier</label>
                            <input type="text" class="form-control" id="NmSupplier" name="NmSupplier" required>
                        </div>
                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <input type="text" class="form-control" id="Alamat" name="Alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="Kota">Kota</label>
                            <input type="text" class="form-control" id="Kota" name="Kota" required>
                        </div>
                        <div class="form-group">
                            <label for="Telpon">Telepon</label>
                            <input type="text" class="form-control" id="Telpon" name="Telpon" required>
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