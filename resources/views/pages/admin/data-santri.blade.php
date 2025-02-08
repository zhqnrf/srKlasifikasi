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
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Santri</th>
                                        <th>NIS</th>
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
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $item->user->name ?? '—' }}</td>
                                        <td>{{ $item->user->nis ?? '—' }}</td>
                                        <td>{{ $item->tahun_angkatan }}</td>
                                        <td>{{ $item->alquran }}</td>
                                        <td>{{ $item->alhadis }}</td>
                                        <td>{{ number_format($item->nilai_n, 2) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if($item->munaqosah_status === 'Sedang di Verifikasi')
                                            <!-- Jika belum ada keputusan, tampilkan tombol Verifikasi, Tolak, dan Delete -->

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
                                            <!-- Jika sudah ada keputusan (verified atau ditolak), tampilkan badge "Selesai" -->
                                            <span class="badge bg-info">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Sertakan SweetAlert2 -->
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
                                           // Buat form secara dinamis untuk melakukan request DELETE
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
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                            <!-- Tambahkan CSS Responsive -->
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                            <!-- Tambahkan JS Responsive -->
                            <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js">
                            </script>

                            <script>
                                $(document).ready(function () {
                                    $('#dataTable').DataTable({
                                        responsive: true, // Aktifkan fitur responsif
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
    </div>
</main>
@endsection