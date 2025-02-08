@extends('layouts.app-admin')
<title>Data Uji | SR Klasifikasi</title>

@section('content')
<style>
    .card-main {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        padding: 20px;
        text-align: center;
        transition: 0.3s ease-in-out;
    }

    .card-main:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .custom-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    .accuracy-icon {
        color: #007bff;
        /* Biru */
    }

    .data-icon {
        color: #28a745;
        /* Hijau */
    }

    .card-main h3 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #333;
    }

    .card-main h6 {
        font-size: 16px;
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .card-main p {
        font-size: 14px;
        color: #777;
        margin: 0;
    }

    .status-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    .status-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s;
    }

    .status-card:hover {
        transform: scale(1.03);
    }

    .status-card .card-body {
        padding: 2rem;
    }

    .status-card .icon {
        font-size: 3rem;
    }

    .status-card .number {
        font-size: 2.5rem;
        font-weight: bold;
        line-height: 1;
    }

    .status-card .status-label {
        font-size: 1.2rem;
        margin-top: -0.3rem;
    }

    /* Progress bar dengan track berwarna semi-transparan */
    .status-card .progress {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        height: 20px;
    }

    .status-card .progress-bar {
        border-radius: 10px;
        background-color: #fff;
    }
</style>

<main id="main" class="main">
    <div class="row">
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Data Uji</h1>
        </div>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Uji</li>
            </ol>
        </nav>

        <!-- Pilih Persentase Data Uji -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Data</h5>
                    <form action="{{ route('testData.show') }}" method="GET" class="d-flex justify-content-between">
                        <div class="col-md-4">
                            <select name="percentage" class="form-select">
                                <option value="100" {{ request('percentage')==100 ? 'selected' : '' }}>100%</option>
                                <option value="75" {{ request('percentage')==75 ? 'selected' : '' }}>75%</option>
                                <option value="50" {{ request('percentage')==50 ? 'selected' : '' }}>50%</option>
                                <option value="25" {{ request('percentage')==25 ? 'selected' : '' }}>25%</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"> <i class='bx bxs-mouse-alt'></i>
                            Terapkan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-main">
                        <i class="bx bx-bar-chart-alt-2 custom-icon accuracy-icon"></i>
                        <h3>{{ number_format($accuracy, 2) }}%</h3>
                        <h6>Akurasi Model</h6>
                        <p>Total data diuji: {{ $totalTestData }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-main">
                        <i class="bx bx-data custom-icon data-icon"></i>
                        <h3>{{ $totalTestData }}</h3>
                        <h6>Data yang di Uji</h6>
                        <p>Diambil dari {{ request('percentage', 100) }}% data latih</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Judul -->
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <h2 class="status-title">Probabilitas Status</h2>
                </div>
            </div>
            <!-- Kartu Status -->
            <div class="row justify-content-center">
                <!-- Kartu Tepat -->
                <div class="col-md-5">
                    <div class="card status-card bg-success text-white shadow-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <i class="bx bx-check-circle icon me-3"></i>
                                <div class="text-start">
                                    <div class="number">{{ number_format($probStatus['Tepat'] ?? 0, 2) }}%</div>
                                    <div class="status-label">Tepat</div>
                                </div>
                            </div>
                            <div class="progress mx-auto" style="width: 80%;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ number_format($probStatus['Tepat'] ?? 0, 2) }}%"
                                    aria-valuenow="{{ number_format($probStatus['Tepat'] ?? 0, 2) }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kartu Terlambat -->
                <div class="col-md-5">
                    <div class="card status-card bg-danger text-white shadow-lg">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <i class="bx bx-x-circle icon me-3"></i>
                                <div class="text-start">
                                    <div class="number">{{ number_format($probStatus['Terlambat'] ?? 0, 2) }}%</div>
                                    <div class="status-label">Terlambat</div>
                                </div>
                            </div>
                            <div class="progress mx-auto" style="width: 80%;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ number_format($probStatus['Terlambat'] ?? 0, 2) }}%"
                                    aria-valuenow="{{ number_format($probStatus['Terlambat'] ?? 0, 2) }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="container my-5">
            <div class="row">
                <!-- Card Tepat Waktu -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0rem"><i
                                    class="bx bx-map-pin me-2" style="font-size: 30px"></i> Asal
                                Daerah
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Jumlah</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dalam Provinsi</td>
                                        <td>{{ number_format($probRegion['Dalam Provinsi'] ?? 0, 2) }}%</td>

                                    </tr>
                                    <tr>
                                        <td>Luar Provinsi</td>
                                        <td>{{ number_format($probRegion['Luar Provinsi'] ?? 0, 2) }}%</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0rem"><i
                                    class="bx bxs-user-badge me-2" style="font-size: 30px"></i> Jenis
                                Kelamin
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Jumlah</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Laki Laki</td>
                                        <td>{{ number_format($probGender['Laki-laki'] ?? 0, 2) }}%</td>

                                    </tr>
                                    <tr>
                                        <td>Perempuan</td>
                                        <td>{{ number_format($probGender['Perempuan'] ?? 0, 2) }}%</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Klasifikasi -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Hasil Klasifikasi</h5>
                    <div class="table-responsive">
                        <table class="dataTable">
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
                                @foreach ($testData as $item)
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let testData = @json($testData);
        let totalTestData = "{{ $totalTestData }}";
        let accuracy = "{{ number_format($accuracy, 2) }}";
        let probStatus = @json($probStatus);
        let probGender = @json($probGender);
        let probRegion = @json($probRegion);

        alert("DEBUG DATA: \n" + 
              "Total Test Data: " + totalTestData + "\n" +
              "Accuracy: " + accuracy + "%\n" +
              "Prob Status: " + JSON.stringify(probStatus) + "\n" +
              "Prob Gender: " + JSON.stringify(probGender) + "\n" +
              "Prob Region: " + JSON.stringify(probRegion) + "\n");
    });
</script>
@endsection