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
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <h5 class="card-title mb-0">Munaqosah Santri</h5>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <select id="filterColumn" class="form-select w-auto">
                                        <option value="">Filter</option>
                                        <option value="0">Nama Santri</option>
                                        <option value="4">Tahun Angkatan</option>
                                        <option value="5">Al Qur'an Isi</option>
                                        <option value="5">Al Hadis Isi</option>
                                        <option value="6">Presentase Qur'an</option>
                                    </select>

                                    <button id="sortAsc" class="btn btn-primary">
                                        <i class='bx bx-sort-a-z'></i> Ascending
                                    </button>
                                    <button id="sortDesc" class="btn btn-secondary">
                                        <i class='bx bx-sort-z-a'></i> Descending
                                    </button>
                                    <button id="btnExcel" class="btn btn-success">
                                        <i class='bx bx-file'></i> Export Excel
                                    </button>
                                </div>
                            </div>

                            <!-- Tabel Riwayat -->
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-striped table-bordered">
                                    <thead class="custom-thead">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Santri</th>
                                            <th>NIS</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Al-Qur'an Isi</th>
                                            <th>Persentase Qur'an</th>
                                            <th>Al-Hadis Isi</th>
                                            <th>Persentase Hadis</th>
                                            <th>Nilai N</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->user->name ?? '—' }}</td>
                                            <td>{{ $item->user->nis ?? '—' }}</td>
                                            <td>{{ $item->tahun_angkatan }}</td>
                                            <td>{{ $item->alquran }}</td>
                                            <td>{{ number_format(($item->alquran / 606) * 100, 2) }}%</td>
                                            <td>{{ $item->alhadis }}</td>
                                            <td>{{ number_format(($item->alhadis / 1997) * 100, 2) }}%</td>
                                            <td>{{ number_format($item->nilai_n, 2) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if($item->munaqosah_status === 'Sedang di Verifikasi')
                                                <!-- Tombol Verifikasi -->
                                                <form action="{{ route('munaqosah.verify', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-success btn-sm">
                                                        <i class='bx bxs-check-circle'></i> Verifikasi
                                                    </button>
                                                </form>

                                                <!-- Tombol Tolak -->
                                                <form action="{{ route('munaqosah.reject', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-warning btn-sm">
                                                        <i class='bx bxs-x-circle'></i> Tolak
                                                    </button>
                                                </form>

                                                <!-- Tombol Delete dengan SweetAlert -->
                                                <button class="mb-1 btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class='bx bxs-trash'></i> Delete
                                                </button>
                                                @else
                                                <span class="badge bg-info">Selesai</span>
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
                <div class="col-lg-6">

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <h5 class="card-title mb-0">Munaqosah Astra</h5>
                                <button id="btnExcelAstra" class="btn btn-success">
                                    <i class='bx bx-file'></i> Export Excel
                                </button>
                            </div>

                            <!-- Tabel Riwayat -->
                            <div class="table-responsive">
                                <table id="dataTableAstra" class="table table-striped table-bordered">
                                    <thead class="custom-thead">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Santri</th>
                                            <th>NIS</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Al-Qur'an Isi</th>
                                            <th>Persentase Qur'an</th>
                                            <th>Al-Hadis Isi</th>
                                            <th>Persentase Hadis</th>
                                            <th>Nilai N</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $item)
                                        @if(str_starts_with($item->user->nis, 'A'))
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->user->name ?? '—' }}</td>
                                            <td>{{ $item->user->nis ?? '—' }}</td>
                                            <td>{{ $item->tahun_angkatan }}</td>
                                            <td>{{ $item->alquran }}</td>
                                            <td>{{ number_format(($item->alquran / 606) * 100, 2) }}%</td>
                                            <td>{{ $item->alhadis }}</td>
                                            <td>{{ number_format(($item->alhadis / 1997) * 100, 2) }}%</td>
                                            <td>{{ number_format($item->nilai_n, 2) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if($item->munaqosah_status === 'Sedang di Verifikasi')
                                                <!-- Tombol Verifikasi -->
                                                <form action="{{ route('munaqosah.verify', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-success btn-sm">
                                                        <i class='bx bxs-check-circle'></i> Verifikasi
                                                    </button>
                                                </form>

                                                <!-- Tombol Tolak -->
                                                <form action="{{ route('munaqosah.reject', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-warning btn-sm">
                                                        <i class='bx bxs-x-circle'></i> Tolak
                                                    </button>
                                                </form>

                                                <!-- Tombol Delete dengan SweetAlert -->
                                                <button class="mb-1 btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class='bx bxs-trash'></i> Delete
                                                </button>
                                                @else
                                                <span class="badge bg-info">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <h5 class="card-title mb-0">Munaqosah Astri</h5>
                                <button id="btnExcelAstri" class="btn btn-success">
                                    <i class='bx bx-file'></i> Export Excel
                                </button>
                            </div>

                            <!-- Tabel Riwayat -->
                            <div class="table-responsive">
                                <table id="dataTableAstri" class="table table-striped table-bordered">
                                    <thead class="custom-thead">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Santri</th>
                                            <th>NIS</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Al-Qur'an Isi</th>
                                            <th>Persentase Qur'an</th>
                                            <th>Al-Hadis Isi</th>
                                            <th>Persentase Hadis</th>
                                            <th>Nilai N</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $item)
                                        @if(str_starts_with($item->user->nis, 'I'))
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->user->name ?? '—' }}</td>
                                            <td>{{ $item->user->nis ?? '—' }}</td>
                                            <td>{{ $item->tahun_angkatan }}</td>
                                            <td>{{ $item->alquran }}</td>
                                            <td>{{ number_format(($item->alquran / 606) * 100, 2) }}%</td>
                                            <td>{{ $item->alhadis }}</td>
                                            <td>{{ number_format(($item->alhadis / 1997) * 100, 2) }}%</td>
                                            <td>{{ number_format($item->nilai_n, 2) }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if($item->munaqosah_status === 'Sedang di Verifikasi')
                                                <!-- Tombol Verifikasi -->
                                                <form action="{{ route('munaqosah.verify', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-success btn-sm">
                                                        <i class='bx bxs-check-circle'></i> Verifikasi
                                                    </button>
                                                </form>

                                                <!-- Tombol Tolak -->
                                                <form action="{{ route('munaqosah.reject', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="mb-1 btn btn-warning btn-sm">
                                                        <i class='bx bxs-x-circle'></i> Tolak
                                                    </button>
                                                </form>

                                                <!-- Tombol Delete dengan SweetAlert -->
                                                <button class="mb-1 btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class='bx bxs-trash'></i> Delete
                                                </button>
                                                @else
                                                <span class="badge bg-info">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '.btn-delete', function(e){
                                       e.preventDefault();
                                       var id = $(this).data('id');
                                       Swal.fire({
                                           title: 'Apakah Anda yakin?',
                                           text: "Data akan dihapus permanen!",
                                           icon: 'warning',
                                           showCancelButton: true,
                                           confirmButtonColor: '#3085d6',
                                           cancelButtonColor: '#d33',
                                           confirmButtonText: 'Ya, hapus!'
                                       }).then((result) => {
                                           if (result.isConfirmed) {
                                               var form = $('<form>', {
                                                   'method': 'POST',
                                                   'action': '/admin/munaqosah/' + id
                                               });
                                               var token = '{{ csrf_token() }}';
                                               var hiddenInput = $('<input>', {
                                                   'name': '_token',
                                                   'value': token,
                                                   'type': 'hidden'
                                               });
                                               var hiddenMethod = $('<input>', {
                                                   'name': '_method',
                                                   'value': 'DELETE',
                                                   'type': 'hidden'
                                               });
                                               form.append(hiddenInput, hiddenMethod).appendTo('body').submit();
                                           }
                                       })
                                    });
    </script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function () {
                                        var table = $('#dataTableAstri, #dataTableAstra, #dataTable').DataTable({
                                            responsive: true,
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
                                        $('#btnExcelAstra').on('click', function () {
                                            table.button('.buttons-excel').trigger();
                                        });
                                        $('#btnExcelAstri').on('click', function () {
                                            table.button('.buttons-excel').trigger();
                                            });
                                        $('#btnExcel').on('click', function () {
                                                    table.button('.buttons-excel').trigger();
                                                    });    
                                        // Tambahkan tombol export
                                        new $.fn.dataTable.Buttons(table, {
                                            buttons: [
                                                {
                                                    extend: 'excelHtml5',
                                                    text: 'Export ke Excel',
                                                    className: 'buttons-excel',
                                                    title: 'Data Munaqosah'
                                                }
                                            ]
                                        });
    
                                        table.buttons().container().appendTo($('.dataTables_wrapper'));
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
</main>
@endsection