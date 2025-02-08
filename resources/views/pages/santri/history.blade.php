@extends('layouts.app')
<title>Riwayat | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Riwayat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Santri</a></li>
                    <li class="breadcrumb-item active">Riwayat</li>
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
                            <h5 class="card-title">Riwayat Hitung</h5>

                            <!-- Membungkus tabel dengan div.table-responsive -->
                            <div class="table-responsive">
                                <table id="riwayatTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Tahun Angkatan</th>
                                            <th>Al-Qur'an Isi</th>
                                            <th>Al-Hadis Isi</th>
                                            <th>Nilai N</th>
                                            <th>Status</th>
                                            <th>Review</th>
                                            <!-- Kolom Aksi -->
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $item)
                                        <tr>
                                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $item->tahun_angkatan }}</td>
                                            <td>{{ $item->alquran }}</td>
                                            <td>{{ $item->alhadis }}</td>
                                            <td>{{ number_format($item->nilai_n, 2) }}</td>
                                            <td>
                                                @if($item->status === 'Tercapai')
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                                @else
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->munaqosah_status === 'Terverifikasi')
                                                <span class="badge bg-success">{{ $item->munaqosah_status }}</span>
                                                @elseif($item->munaqosah_status === null)
                                                <span class="badge bg-warning">Belum Diverifikasi</span>
                                                @else
                                                <span class="badge bg-info">{{ $item->munaqosah_status }}</span>
                                                @endif
                                            </td>
                                            <!-- Kolom Aksi -->
                                            <!-- Di dalam tabel, ganti tombol Kirim -->
                                            <td>
                                                <!-- Tombol Hapus (tetap) -->
                                                <form action="{{ route('riwayat.destroy', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class='bx bxs-trash'></i> Hapus
                                                    </button>
                                                </form>

                                                <!-- Tombol Kirim hanya muncul di data terakhir -->
                                                @if($loop->first && ($item->munaqosah_status === null ||
                                                $item->munaqosah_status === 'Belum Diverifikasi'))
                                                <button type="button" class="btn btn-primary btn-sm btn-send"
                                                    data-id="{{ $item->id }}">
                                                    <i class='bx bxs-send'></i> Kirim
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End of .table-responsive -->

                            <!-- DataTables CSS & JS beserta extension Responsive -->
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                            <link rel="stylesheet"
                                href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js">
                            </script>
                            <script>
                                $(document).ready(function () {
                                    $('#riwayatTable').DataTable({
                                        responsive: true,
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


<!-- Modal untuk memilih admin -->
<div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="sendForm" method="POST" action="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendModalLabel">Pilih Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_id" class="form-label">Admin</label>
                        <select name="admin_id" id="admin_id" class="form-select" required>
                            <option value="">Pilih Wali Kelas</option>
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" style="color: black">{{ $admin->email }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('click', '.btn-send', function(){
         var id = $(this).data('id');
         // Set action form ke route /santri/riwayat/{id}/send
         $('#sendForm').attr('action', '/santri/riwayat/' + id + '/send');
         // Tampilkan modal
         $('#sendModal').modal('show');
    });
</script>
@endsection