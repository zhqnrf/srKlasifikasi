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
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center my-3 gap-2">
                        <h5 class="card-title mb-0">Hasil Klasifikasi</h5>

                        <!-- Tombol Export -->
                        <div class="d-flex flex-wrap gap-2">
                            <button id="btnExcel" class="btn btn-success">
                                <i class='bx bx-file'></i> Export Excel
                            </button>
                            <button id="btnCSV" class="btn btn-info text-white">
                                <i class='bx bx-data'></i> Export CSV
                            </button>
                            <button id="btnPDF" class="btn btn-danger">
                                <i class='bx bxs-file-pdf'></i> Export PDF
                            </button>
                        </div>
                    </div>

                    <!-- Filter & Sorting -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <select id="filterColumn" class="form-select w-auto">
                            <option value="">Pilih Kolom</option>
                            <option value="0">Nama</option>
                            <option value="1">Jenis Kelamin</option>
                            <option value="3">Asal Daerah</option>
                            <option value="4">Tahun Angkatan</option>
                            <option value="5">Presentase Hadis</option>
                            <option value="6">Presentase Qur'an</option>
                            <option value="7">Akumulasi Qur'an & Hadis</option>
                            <option value="8">Status Prediksi</option>
                        </select>
                        <input type="text" id="filterInput" class="form-control w-auto ms-2" placeholder="Cari...">

                        <!-- Tombol Sorting -->
                        <button id="sortAsc" class="btn btn-primary">
                            <i class='bx bx-sort-a-z'></i> Ascending
                        </button>
                        <button id="sortDesc" class="btn btn-secondary">
                            <i class='bx bx-sort-z-a'></i> Descending
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead class="custom-thead">
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>NIS</th>
                                    <th>Asal Daerah</th>
                                    <th>Tahun Angkatan</th>
                                    <th>Persentase Hadis</th>
                                    <th>Persentase Qur'an</th>
                                    <th>Akumulasi Qur'an & Hadis</th>
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
                                    <td>
                                        @if ($item->asal_daerah === 'Dalam Provinsi')
                                        Dalam Provinsi
                                        @elseif ($item->asal_daerah === 'Luar Provinsi')
                                        Luar Provinsi
                                        @else
                                        {{ $item->asal_daerah }}
                                        @endif
                                    </td>
                                    <td>{{ $item->tahun_angkatan }}</td>
                                    <td>{{ number_format(($item->alhadis / 2174) * 100, 2) }}%</td>
                                    <td>{{ number_format(($item->alquran / 606) * 100, 2) }}%</td>
                                    <td>{{ number_format(((($item->alhadis / 2174) * 100) + (($item->alquran / 606) *
                                        100)) / 2, 2) }}%</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        @if ($item->predicted_status == 'Tercapai')
                                        <span class="badge bg-success">Tepat</span>
                                        @else
                                        <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
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
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#dataTable').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: false,
            order: [],
            dom: 'Bfrtip',
            buttons: [],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)"
            }
        });

        // Event untuk tombol export
        $('#btnExcel').on('click', function () {
            table.button('.buttons-excel').trigger();
        });

        $('#btnCSV').on('click', function () {
            table.button('.buttons-csv').trigger();
        });

        $('#btnPDF').on('click', function () {
            table.button('.buttons-pdf').trigger();
        });

        // Tambahkan tombol export
        new $.fn.dataTable.Buttons(table, {
            buttons: [
                { extend: 'excelHtml5', className: 'buttons-excel', title: 'Data Klasifikasi' },
                { extend: 'csvHtml5', className: 'buttons-csv', title: 'Data Klasifikasi' },
                { extend: 'pdfHtml5', className: 'buttons-pdf', title: 'Data Klasifikasi' }
            ]
        });

        table.buttons().container().appendTo($('.dataTables_wrapper'));

        // Sorting
        $('#sortAsc').on('click', function () {
            table.order([$('#filterColumn').val(), 'asc']).draw();
        });

        $('#sortDesc').on('click', function () {
            table.order([$('#filterColumn').val(), 'desc']).draw();
        });
    });
</script>

<style>
    .custom-thead {
        background-color: #012970 !important;
        color: white;
    }

    #dataTable tbody tr td {
        background-color: #f8f9fa !important;
        color: #012970;
    }
</style>

@endsection