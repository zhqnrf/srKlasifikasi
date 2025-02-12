@extends('layouts.app-admin')
<title>Data Latih | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Data Latih</h1>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Latih</li>
            </ol>
        </nav>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        </script>
        @endif
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tindakan</h5>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <form action="{{ route('trainData.import') }}" method="POST" enctype="multipart/form-data"
                                class="d-flex gap-2">
                                @csrf
                                <div class="input-group">
                                    <input type="file" name="file" class="form-control" required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bxs-file-import"></i> Import
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('trainData.export') }}"
                                class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-1">
                                <i class="bx bxs-file-export"></i> Export
                            </a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('trainData.reset') }}" method="POST" class="reset-form">
                                @csrf
                                <button type="button"
                                    class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-1 btn-reset">
                                    <i class="bx bx-reset"></i> Reset Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Latih</h5>

                            <div class="table-responsive">
                                <table id="dataTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>NIS</th>
                                            <th>Asal Daerah</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Capaian Hadis</th>
                                            <th>Capaian Al Qur'an</th>
                                            <th>Target</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($santris as $item)
                                        <tr>
                                            <td>{{ $item->nama ?? '—' }}</td>
                                            <td>{{ $item->jenis_kelamin ?? '—' }}</td>
                                            <td>{{ $item->nis ?? '—' }}</td>
                                            <td>
                                                @if ($item->asal_daerah === 'dalamProvinsi')
                                                Dalam Provinsi
                                                @elseif ($item->asal_daerah === 'luarProvinsi')
                                                Luar Provinsi
                                                @else
                                                {{ $item->asal_daerah }}
                                                @endif
                                            </td>
                                            <td>{{ $item->tahun_angkatan }}</td>
                                            <td>
                                                {{ $item->alhadis >= 2174 ? 'Khatam' : 'Belum Khatam' }}
                                            </td>
                                            <td>
                                                {{ $item->alquran >= 606 ? 'Khatam' : 'Belum Khatam' }}
                                            </td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm btn-delete"
                                                    data-id="{{ $item->id }}">
                                                    <i class='bx bxs-trash'></i> Delete
                                                </button>
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

<script>
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data hanya akan dihapus dari halaman ini, tidak dari database utama!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/trainData/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire(
                            'Terhapus!',
                            'Data berhasil dihapus dari tampilan halaman ini.',
                            'success'
                        );
                        location.reload(); // Refresh tabel setelah dihapus
                    },
                    error: function(response) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });

$(document).on('click', '.btn-reset', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data latih akan diambil ulang dari data riwayat!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, reset!'
    }).then((result) => {
        if (result.isConfirmed) {
            var resetUrl = $(".reset-form").attr("action"); // Ambil URL dari form reset
            
            $.ajax({
                url: resetUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire(
                        'Reset Berhasil!',
                        'Data latih telah diambil ulang dari data riwayat.',
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh tabel setelah reset
                    });
                },
                error: function(response) {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat mereset data.',
                        'error'
                    );
                }
            });
        }
    });
});




</script>
@endsection