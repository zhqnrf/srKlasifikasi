@extends('layouts.app-admin')
<title>Data Klasifikasi | SR Klasifikasi</title>

@section('content')

<main id="main" class="main">
    <div class="row">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Data Klasifikasi</h1>
        </div>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Hasil Klasifikasi</li>
            </ol>
        </nav>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Hasil Klasifikasi</h5>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>NIS</th>
                                    <th>Asal Daerah</th>
                                    <th>Tahun Angkatan</th>
                                    <th>Capaian Hadis</th>
                                    <th>Capaian Al Qur'an</th>
                                    <th>Status Aktual</th>
                                    <th>Status Prediksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classifiedData as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->asal_daerah }}</td>
                                    <td>{{ $item->tahun_angkatan }}</td>
                                    <td>{{ $item->alhadis }}</td>
                                    <td>{{ $item->alquran }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->predicted_status ?? 'Belum Diklasifikasi' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- DataTables & SweetAlert -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: false,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)"
            }
        });
    });
</script>
@endsection