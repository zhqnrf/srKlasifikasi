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
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Jumlah Data Uji</h5>
                    <div class="row g-2">
                        <div class="col-md-10">
                            <form action="{{ route('testData.show') }}" method="GET" class="d-flex gap-2">
                                <select name="percentage" class="form-select">
                                    @foreach(range(5, 100, 5) as $value)
                                    <option value="{{ $value }}" {{ request('percentage')==$value ? 'selected' : '' }}>{{ $value }}%</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bxs-mouse-alt me-1"></i> Terapkan
                                </button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <form action="{{ route('testData.reset') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="bx bx-reset me-1"></i> <br> Reset Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="col-12 justify-content-center text-center">
                    <h2 class="status-title">Pembagian Data</h2>
                </div>
            <div class="row text-white justify-content-center">
                <div class="col-md-6 ">
                            <div class="card card-main bg-info">
                                <i class="bx bxs-bar-chart-alt-2 fs-1  custom-icon text-white"></i>
                                <h3 class="mb-0 text-white fs-4 ">{{ round($testPercentage) }}%</h3>
                                <h6 class="fs-5 fw-bold" style="color: #fff">Data Latih</h6>
                                <small class="fs-8 text-white">Nilai Asli {{ $testPercentage }}%</small>
                            </div>
                        </div>
                        
                        <!-- Precision -->
                        <div class="col-md-6">
                            <div class="card card-main bg-success">
                                <i class="bx bxs-flask fs-1 custom-icon text-white "></i>
                                <h3 class="mb-0 text-white fs-4 ">{{ round($trainPercentage) }}%</h3>
                                <h6 class="fs-5 fw-bold" style="color: #fff">Data Uji</h6>
                                <small class="fs-8 text-white">Nilai Asli {{ $trainPercentage }}%</small>
                            </div>
                        </div>
            </div>
        </div>
<div class="col-12">
    <div class="row justify-content-center text-center mt-4">
        <div class="col-12">
            <h2 class="status-title">Confusion Matrix</h2>
        </div>
    </div>
    <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-main">
                        <i class="bx bx-data custom-icon data-icon"></i>
                        <h3>{{ $totalTestData }}</h3>
                        <h6>Data yang di Uji</h6>
                        <p>Diambil dari {{ request('percentage', 100) }}% data latih</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Akurasi -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-bar-chart-alt-2 custom-icon accuracy-icon"></i>
                    <h3>{{ number_format($accuracy, 2) }}%</h3>
                    <h6>Akurasi Model</h6>
                </div>
            </div>
        
            <!-- Precision -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-target-lock custom-icon data-icon"></i>
                    <h3>{{ number_format($precision, 2) }}%</h3>
                    <h6>Precision</h6>
                </div>
            </div>
        
            <!-- Recall -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-refresh custom-icon data-icon"></i>
                    <h3>{{ number_format($recall, 2) }}%</h3>
                    <h6>Recall</h6>
                </div>
            </div>
        </div>
        
        <!-- Baris Baru untuk TP, FP, FN -->
        <div class="row mt-3">
            <!-- True Positive (TP) -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-check-circle custom-icon tp-icon"></i>
                    <h3>{{ number_format($truePositive) }}</h3>
                    <h6>True Positive (TP)</h6>
                </div>
            </div>
        
            <!-- False Positive (FP) -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-x-circle custom-icon fp-icon"></i>
                    <h3>{{ number_format($falsePositive) }}</h3>
                    <h6>False Positive (FP)</h6>
                </div>
            </div>
        
            <!-- False Negative (FN) -->
            <div class="col-md-4">
                <div class="card card-main">
                    <i class="bx bx-error custom-icon fn-icon"></i>
                    <h3>{{ number_format($falseNegative) }}</h3>
                    <h6>False Negative (FN)</h6>
                </div>
            </div>
        </div>
        </div>
        <style>
            .hover-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
        
            .hover-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }
        </style>


<div class="container mb-0">
            <!-- Judul -->
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <h2 class="status-title">Probabilitas Kelas</h2>
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
                                    <small>Sejumlah <b> {{ $totalTercapai }} </b> dari {{ $totalTestData }} data</small>
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
                                    <small>Sejumlah <b> {{ $totalTidakTercapai }} </b> dari {{ $totalTestData }}
                                        data</small>
                                </div>
                            </div>
                            <div class="progress mx-auto" style="width: 80%;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ number_format($probStatus['Terlambat'] ?? 0, 2) }}%"
                                    aria-valuenow="{{ number_format($probStatus['Terlambat'] ?? 0, 2) }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container mt-4">
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <h2 class="status-title">Probabilitas Atribut Numerik</h2>
                </div>
            </div>
        
            <div class="row justify-content-center">
                <!-- Probabilitas Capaian Al-Qur'an -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center p-3">
                        <div class="d-flex justify-content-center mb-2">
                            <span class="rounded-circle bg-primary p-3">
                                <i class="fas fa-book-open text-white fs-4"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold text-primary">Capaian Al-Qur'an</h5>
                        <p class="small text-muted fw-bold">Mean</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-5 ">{{ number_format($stats['alquran']['Tercapai']['mean'],
                                    2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-5 text-danger">{{ number_format($stats['alquran']['Tidak Tercapai']['mean'], 2) }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                        <p class="small text-muted fw-bold">Standar Deviasi</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-6 ">{{
                                    number_format($stats['alquran']['Tercapai']['std_dev'], 2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-6 text-danger">{{ number_format($stats['alquran']['Tidak Tercapai']['std_dev'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Probabilitas Capaian Al-Hadis -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center p-3">
                        <div class="d-flex justify-content-center mb-2">
                            <span class="rounded-circle bg-success p-3">
                                <i class="fas fa-scroll text-white fs-4"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold text-success">Capaian Al-Hadis</h5>
                        <p class="small text-muted fw-bold">Mean</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-5 ">{{ number_format($stats['alhadis']['Tercapai']['mean'],
                                    2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-5 text-danger">{{ number_format($stats['alhadis']['Tidak Tercapai']['mean'], 2) }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                        <p class="small text-muted fw-bold">Standar Deviasi</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-6 ">{{
                                    number_format($stats['alhadis']['Tercapai']['std_dev'], 2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-6 text-danger">{{ number_format($stats['alhadis']['Tidak Tercapai']['std_dev'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Probabilitas Tahun Angkatan -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center p-3">
                        <div class="d-flex justify-content-center mb-2">
                            <span class="rounded-circle bg-warning p-3">
                                <i class="fas fa-calendar-alt text-white fs-4"></i>
                            </span>
                        </div>
                        <h5 class="fw-bold text-warning">Tahun Angkatan</h5>
                        <p class="small text-muted fw-bold">Mean</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-5 ">{{
                                    number_format($stats['tahun_angkatan']['Tercapai']['mean'], 2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-5 text-danger">{{
                                    number_format($stats['tahun_angkatan']['Tidak Tercapai']['mean'], 2) }}</p>
                            </div>
                        </div>
                        <hr class="my-2">
                        <p class="small text-muted fw-bold">Standar Deviasi</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="small text-muted mb-1">Tercapai</p>
                                <p class="fw-bold fs-6 ">{{
                                    number_format($stats['tahun_angkatan']['Tercapai']['std_dev'], 2) }}</p>
                            </div>
                            <div>
                                <p class="small text-muted mb-1">Tidak Tercapai</p>
                                <p class="fw-bold fs-6 text-danger">{{
                                    number_format($stats['tahun_angkatan']['Tidak Tercapai']['std_dev'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="container mt-4">
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <h2 class="status-title">Probabilitas Atribut Kategorik</h2>
                </div>
            </div>
            <div class="row">
                <!-- Probabilitas Jenis Kelamin -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0"><i
                                    class="bx bx-universal-access me-2"></i> Jenis
                                Kelamin
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Laki-laki</th>
                                        <th>Perempuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tercapai</td>
                                        <td>{{ number_format($probKelamin['Tercapai']['Laki-laki']['probability'] * 100,
                                            2) }}% ({{ $probKelamin['Tercapai']['Laki-laki']['count'] }}/{{
                                            $totalTercapai }})</td>
                                        <td>{{ number_format($probKelamin['Tercapai']['Perempuan']['probability'] * 100,
                                            2) }}% ({{ $probKelamin['Tercapai']['Perempuan']['count'] }}/{{
                                            $totalTercapai }})</td>
        
                                    </tr>
                                    <tr>
                                        <td>Tidak Tercapai</td>
                                        <td>{{ number_format($probKelamin['Tidak Tercapai']['Laki-laki']['probability']
                                            * 100, 2) }}% ({{ $probKelamin['Tidak Tercapai']['Laki-laki']['count'] }}/{{
                                            $totalTidakTercapai }})</td>
                                        <td>{{ number_format($probKelamin['Tidak Tercapai']['Perempuan']['probability']
                                            * 100, 2) }}% ({{ $probKelamin['Tidak Tercapai']['Perempuan']['count'] }}/{{
                                            $totalTidakTercapai }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <!-- Probabilitas Asal Daerah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0"><i
                                    class="bx bx-buildings me-2"></i> Asal Daerah
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Dalam Provinsi</th>
                                        <th>Luar Provinsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tercapai</td>
                                        <td>{{ number_format($probProvinsi['Tercapai']['Dalam Provinsi']['probability']
                                            * 100, 2) }}% ({{ $probProvinsi['Tercapai']['Dalam Provinsi']['count'] }}/{{
                                            $totalTercapai }})</td>
                                        <td>{{ number_format($probProvinsi['Tercapai']['Luar Provinsi']['probability'] *
                                            100, 2) }}% ({{ $probProvinsi['Tercapai']['Luar Provinsi']['count'] }}/{{
                                            $totalTercapai }})</td>
        
                                    </tr>
                                    <tr>
                                        <td>Tidak Tercapai</td>
                                        <td>{{ number_format($probProvinsi['Tidak Tercapai']['Dalam Provinsi']['probability'] *
                                            100, 2) }}% ({{ $probProvinsi['Tidak Tercapai']['Dalam Provinsi']['count'] }}/{{
                                            $totalTidakTercapai }})</td>
                                        <td>{{ number_format($probProvinsi['Tidak Tercapai']['Luar Provinsi']['probability'] *
                                            100, 2) }}% ({{ $probProvinsi['Tidak Tercapai']['Luar Provinsi']['count'] }}/{{
                                            $totalTidakTercapai }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row justify-content-center text-center mt-4">
                <div class="col-12">
                    <h2 class="status-title">Peluang</h2>
                </div>
            </div>
            <div class="row">
                <!-- Probabilitas Berdasarkan Asal Daerah -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0"><i
                                    class="bx bx-map-pin me-2"></i> Asal Daerah
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Presentase Data</th>
                                        <th>Peluang Tepat Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dalam Provinsi</td>
                                        <td>{{ number_format($probRegion['Dalam Provinsi'] ?? 0, 2) }}%</td>
                                        <td>{{ number_format($peluangRegion['Dalam Provinsi'] ?? 0, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Luar Provinsi</td>
                                        <td>{{ number_format($probRegion['Luar Provinsi'] ?? 0, 2) }}%</td>
                                        <td>{{ number_format($peluangRegion['Luar Provinsi'] ?? 0, 2) }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Probabilitas Berdasarkan Jenis Kelamin -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="align-items-center d-flex fw-bold" style="margin-bottom: 0"><i
                                    class="bx bxs-user-badge me-2"></i> Jenis
                                Kelamin
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Presentase Data</th>
                                        <th>Peluang Tepat Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Laki Laki</td>
                                        <td>{{ number_format($probGender['Laki-laki'] ?? 0, 2) }}%</td>
                                        <td>{{ number_format($peluangGender['Laki-laki'] ?? 0, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Perempuan</td>
                                        <td>{{ number_format($probGender['Perempuan'] ?? 0, 2) }}%</td>
                                        <td>{{ number_format($peluangGender['Perempuan'] ?? 0, 2) }}%</td>
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
                    <h5 class="card-title">Hasil Uji</h5>
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
                                    <td>@if ($item->asal_daerah === 'Dalam Provinsi')
                                        Dalam Provinsi
                                        @elseif ($item->asal_daerah === 'Luar Provinsi')
                                        Luar Provinsi
                                        @else
                                        {{ $item->asal_daerah }}
                                        @endif</td>
                                    <td>{{ $item->tahun_angkatan }}</td>
                                    <td>{{ $item->alhadis }}</td>
                                    <td>{{ $item->alquran }}</td>
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
        const selectElement = document.querySelector("select[name='percentage']");

        selectElement.addEventListener("change", function () {
            const selectedValue = parseInt(this.value);

            if (selectedValue === 100) {
                Swal.fire({
                    icon: "error",
                    title: "Model Tidak Akurat",
                    text: "Model tidak dapat memberikan prediksi yang akurat dengan 100% data uji!",
                });
            } else if (selectedValue > 50) {
                Swal.fire({
                    icon: "warning",
                    title: "Ketepatan Data Rendah",
                    text: "Kemungkinan ketepatan data rendah karena data latih lebih sedikit.",
                });
            }
        });
    });
</script>
@endsection