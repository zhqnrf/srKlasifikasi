@extends('layouts.app-admin')
<title>Data Munaqosah | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Munaqosah</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Munaqosah Santri</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Munaqosah Santri</h5>

                            <!-- Tabel Riwayat -->
                        <!-- Tabel Riwayat -->
                        <table id="dataTable" class="table">
                            <thead>
                                <tr>
                                    <th>Nama Santri</th>
                                    <th>Tanggal</th>
                                    <th>Tahun Angkatan</th>
                                    <th>Al-Qur'an Isi</th>
                                    <th>Al-Hadis Isi</th>
                                    <th>Nilai N</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $item)
                                <tr>
                                    <!-- Asumsikan Anda punya relasi ke Tabel User untuk nama, jenkel, asal -->
                                    <td>{{ $item->user->name ?? '—' }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->tahun_angkatan }}</td>
                                    <td>{{ $item->alquran }}</td>
                                    <td>{{ $item->alhadis }}</td>
                                    <td>{{ number_format($item->nilai_n, 2) }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <!-- misal admin bisa verifikasi, dsb. -->
                                        <a href="#" class="btn btn-success btn-sm">
                                            <i class='bx bxs-check-circle'></i> Verifikasi
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                            <!-- DataTables CSS & JS -->
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('#dataTable').DataTable({
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
@endsection