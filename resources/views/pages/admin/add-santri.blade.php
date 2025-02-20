@extends('layouts.app-admin')
<title>Data Santri | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Santri</h1>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Santri</li>
            </ol>
        </nav>

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Santri</h5>
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            {{-- Tabel Data Santri --}}
                            <div class="table-responsive">
                                <table id="addSantriTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Asal Daerah</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($santris as $index => $santri)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $santri->name }}</td>
                                            <td>{{ $santri->email }}</td>
                                            <td>    @if ($santri->asal_daerah === 'dalamProvinsi')
                                                Dalam Provinsi
                                                @elseif ($santri->asal_daerah === 'luarProvinsi')
                                                Luar Provinsi
                                                @else
                                                {{ $santri->asal_daerah }}
                                                @endif</td>
                                            <td>{{ $santri->jenis_kelamin }}</td>
                                            <td>
                                                <!-- Tombol Delete dengan Form -->
                                                <form action="{{ route('santri.delete', $santri->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                        <i class='bx bx-trash'></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- DataTables & SweetAlert2 -->
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
                            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

                            <script>
                                $(document).ready(function () {
                                    $('#addSantriTable').DataTable({
                                        responsive: true,
                                        scrollX: true,
                                        autoWidth: false,
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

                                document.querySelectorAll('.btn-delete').forEach(button => {
                                    button.addEventListener('click', function() {
                                        let form = this.closest('form');

                                        Swal.fire({
                                            title: 'Yakin ingin menghapus Santri ini?',
                                            text: 'Data yang dihapus tidak bisa dikembalikan!',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ya, hapus!',
                                            cancelButtonText: 'Batal',
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        });
                                    });
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection
