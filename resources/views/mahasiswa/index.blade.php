@extends('layouts.dashboard')

@section('title', 'Data Mahasiswa')

@section('judul', 'Data Mahasiswa')

@section('content')
    <div class="card shadow-border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addMahasiswaModal">Tambah
                            Mahasiswa</button>
                            
                        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center">
                            @csrf
                            <div class="mb-3 me-3">
                                <label for="file" class="form-label">Pilih file Excel</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".xlsx, .xls">
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Import</button>
                        </form>

                    </div>

                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Tajwid</th>
                                <th>Fashohah</th>
                                <th>Adab</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="280px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->prodi }}</td>
                                    <td>{{ $mahasiswa->angkatan }}</td>
                                    <td>{{ $mahasiswa->jenis_kelamin }}</td>
                                    <td>{{ $mahasiswa->tajwid }}</td>
                                    <td>{{ $mahasiswa->fashohah }}</td>
                                    <td>{{ $mahasiswa->adab }}</td>
                                    <td>{{ $mahasiswa->total }}</td>
                                    <td>{{ $mahasiswa->status }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-info edit-btn"
                                                data-id="{{ $mahasiswa->id }}">Edit</button>
                                            <button class="btn btn-danger delete-btn"
                                                data-id="{{ $mahasiswa->id }}">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Mahasiswa -->
    <div class="modal fade" id="addMahasiswaModal" tabindex="-1" aria-labelledby="addMahasiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMahasiswaModalLabel">Tambah Mahasiswa</h5>

                </div>
                <div class="modal-body">
                    <form id="addMahasiswaForm" action="{{ route('mahasiswa.store') }}" method="POST">
                        @csrf

                        <div class="row d-flex">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" required>
                                </div>
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Prodi</label>
                                    <input type="text" class="form-control" id="prodi" name="prodi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="angkatan" class="form-label">Angkatan</label>
                                    <input type="text" class="form-control" id="angkatan" name="angkatan" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tajwid" class="form-label">Tajwid</label>
                                    <input type="text" class="form-control" id="tajwid" name="tajwid">
                                </div>
                                <div class="mb-3">
                                    <label for="fashohah" class="form-label">Fashohah</label>
                                    <input type="text" class="form-control" id="fashohah" name="fashohah">
                                </div>
                                <div class="mb-3">
                                    <label for="adab" class="form-label">Adab</label>
                                    <input type="text" class="form-control" id="adab" name="adab">
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Mahasiswa -->
    <div class="modal fade" id="editMahasiswaModal" tabindex="-1" aria-labelledby="editMahasiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMahasiswaModalLabel">Edit Mahasiswa</h5>
                </div>
                <div class="modal-body">
                    <form id="editMahasiswaForm" action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row d-flex">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="edit_nim" name="nim" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_prodi" class="form-label">Prodi</label>
                                    <input type="text" class="form-control" id="edit_prodi" name="prodi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_angkatan" class="form-label">Angkatan</label>
                                    <input type="text" class="form-control" id="edit_angkatan" name="angkatan"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_tajwid" class="form-label">Tajwid</label>
                                    <input type="text" class="form-control" id="edit_tajwid" name="tajwid">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_fashohah" class="form-label">Fashohah</label>
                                    <input type="text" class="form-control" id="edit_fashohah" name="fashohah">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_adab" class="form-label">Adab</label>
                                    <input type="text" class="form-control" id="edit_adab" name="adab">
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Edit Mahasiswa
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                fetch(`/mahasiswa/${id}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Mengisi nilai form dengan data yang diambil
                        document.getElementById('edit_nama').value = data.nama;
                        document.getElementById('edit_nim').value = data.nim;
                        document.getElementById('edit_prodi').value = data.prodi;
                        document.getElementById('edit_angkatan').value = data.angkatan;
                        document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin;
                        document.getElementById('edit_tajwid').value = data.tajwid || '';
                        document.getElementById('edit_fashohah').value = data.fashohah || '';
                        document.getElementById('edit_adab').value = data.adab || '';

                        // Set action form untuk update
                        document.getElementById('editMahasiswaForm').action = `/mahasiswa/${id}`;

                        // Tampilkan modal edit
                        let modal = new bootstrap.Modal(document.getElementById('editMahasiswaModal'));
                        modal.show();
                    });
            });
        });

        // Tambah Mahasiswa
        document.querySelector('[data-bs-target="#addMahasiswaModal"]').addEventListener('click', function() {
            let modal = new bootstrap.Modal(document.getElementById('addMahasiswaModal'));
            modal.show();
        });

        // Hapus Mahasiswa
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak dapat mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/mahasiswa/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(() => {
                                Swal.fire(
                                    'Deleted!',
                                    'Mahasiswa telah dihapus.',
                                    'success'
                                );
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus mahasiswa.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>
@endsection
