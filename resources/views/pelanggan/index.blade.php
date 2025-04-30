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
                    <h3>Data Pelanggan</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Pelanggan</h5>
                    <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal"
                        data-bs-target="#modalTambahPelanggan">
                        <i class="bi bi-plus-circle-fill me-2"></i> Tambah Pelanggan
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggans as $pelanggan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pelanggan->NmPelanggan }}</td>
                                <td>{{ $pelanggan->Alamat }}</td>
                                <td>{{ $pelanggan->Kota }}</td>
                                <td>{{ $pelanggan->Telpon }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditPelanggan{{ $pelanggan->KdPelanggan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <div class="modal fade text-left" id="modalEditPelanggan{{ $pelanggan->KdPelanggan }}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditPelangganLabel">Edit Pelanggan</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('pelanggan.update', $pelanggan->KdPelanggan) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="NmPelanggan">Nama Pelanggan</label>
                                                            <input type="text" class="form-control" id="NmPelanggan" name="NmPelanggan" value="{{ $pelanggan->NmPelanggan }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Alamat">Alamat</label>
                                                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="{{ $pelanggan->Alamat }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Kota">Kota</label>
                                                            <input type="text" class="form-control" id="Kota" name="Kota" value="{{ $pelanggan->Kota }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Telpon">Telepon</label>
                                                            <input type="text" class="form-control" id="Telpon" name="Telpon" value="{{ $pelanggan->Telpon }}" required>
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

                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('pelanggan.destroy', $pelanggan->KdPelanggan) }}')">
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

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade text-left" id="modalTambahPelanggan" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPelangganLabel">Tambah Pelanggan</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NmPelanggan">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="NmPelanggan" name="NmPelanggan" required>
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