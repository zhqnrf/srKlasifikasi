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

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Data</h5>

                            <form class="col-12 justify-content-between g-3 d-flex">
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option value="100%">100%</option>
                                        <option value="75">75%</option>
                                        <option value="50">50%</option>
                                        <option value="25">25%%</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"><i class='bx bx-mouse-alt'></i>
                                        Terapkan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-main">
                        <i class="bx bx-bar-chart-alt-2 custom-icon accuracy-icon"></i>
                        <h3>94%</h3>
                        <h6>Akurasi Data</h6>
                        <p>Total data yang di Uji: 31</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-main">
                        <i class="bx bx-data custom-icon data-icon"></i>
                        <h3>32</h3>
                        <h6>Data yang di Uji</h6>
                        <p>Diambil dari 10% data</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Hasil Klasifikasi</h5>
                            <div class="container">
                                <!-- Judul -->
                                <div class="row justify-content-center text-center mb-4">
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
                                                        <div class="number">70%</div>
                                                        <div class="status-label">Tepat</div>
                                                    </div>
                                                </div>
                                                <div class="progress mx-auto" style="width: 80%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 70%"
                                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                        <div class="number">70%</div>
                                                        <div class="status-label">Terlambat</div>
                                                    </div>
                                                </div>
                                                <div class="progress mx-auto" style="width: 80%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 70%"
                                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                <h5 class="align-items-center d-flex fw-bold"
                                                    style="margin-bottom: 0rem"><i class="bx bx-map-pin me-2"
                                                        style="font-size: 30px"></i> Asal
                                                    Daerah
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kategori</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Peluang</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Dalam Provinsi</td>
                                                            <td>xx</td>
                                                            <td>xx</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Luar Provinsi</td>
                                                            <td>xx</td>
                                                            <td>xx</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Terlambat -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header bg-secondary text-white">
                                                <h5 class="align-items-center d-flex fw-bold"
                                                    style="margin-bottom: 0rem"><i class="bx bxs-user-badgeme-2"
                                                        style="font-size: 30px"></i> Jenis
                                                    Kelamin
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Kategori</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Peluang</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Laki Laki</td>
                                                            <td>xx</td>
                                                            <td>xx</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Perempuan</td>
                                                            <td>xx</td>
                                                            <td>xx</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@endsection