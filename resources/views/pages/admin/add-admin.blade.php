@extends('layouts.app-admin')
<title>Tambah Admin | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Tambah Admin</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAdminModal">Tambah
                Admin</button>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Admin</h5>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                            {{-- Tabel Admin --}}
                            <table id="addAdminTable" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $index => $admin)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $admin->email }}</td>
                                <td>
                                    <form action="{{ route('admin.delete', $admin->id) }}" method="POST" id="deleteForm{{ $admin->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete({{ $admin->id }})">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </td>
                                
                                <script>
                                    function confirmDelete(adminId) {
                                        Swal.fire({
                                            title: 'Yakin ingin menghapus admin ini?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, hapus!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('deleteForm' + adminId).submit();
                                            }
                                        });
                                    }
                                </script>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- DataTables CSS & JS (bisa diletakkan di layout umum juga) -->
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                            <!-- SweetAlert2 CSS & JS -->
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('#addAdminTable').DataTable({
                                        "language": {
                                            "search": "Cari:",
                                            "lengthMenu": "Tampilkan _MENU_ data",
                                            "zeroRecords": "Tidak ada data yang cocok",
                                            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                            "infoEmpty": "Tidak ada data tersedia",
                                            "infoFiltered": "(disaring dari _MAX_ total data)"
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="tambahAdminModal" tabindex="-1" aria-labelledby="tambahAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAdminModalLabel">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <span class="input-group-text" onclick="togglePassword('password', this)">
                                <i class='bx bx-hide'></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword"
                                required>
                            <span class="input-group-text" onclick="togglePassword('confirmPassword', this)">
                                <i class='bx bx-hide'></i>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, el) {
    let passwordInput = document.getElementById(fieldId);
    let icon = el.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
}
</script>

@endsection