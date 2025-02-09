@extends('layouts.app-admin')
<title>Dashboard Admin | SR Klasifikasi</title>
@section('content')
<style>
    #dataTable thead th {
        color: #012970 !important;
    }

    #dataTable tbody tr td {
        color: #16356BFF;
    }
</style>
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Halo <b>{{ ucwords(auth()->user()->role) }}</b> 👋</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        <!-- Statistik Jumlah Santri dan Tepat Waktu -->
        <div class="col-12 dashboard">
            <div class="row">
                <div class="col-xxl-12 col-md-12">
                    <div class="row">
                        <!-- Card Tanggal -->
                        <div class="col-md-6">
                            <div class="card info-card date-card shadow-lg"
                                style="background-color: #f8f9fa; border-left: 5px solid #007bff;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-bold">Tanggal Hari Ini</h5>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div
                                            class="card-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center p-3">
                                            <i class='bx bx-calendar text-white' style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="current-date" class="fw-semibold " style="color: #012970">Loading...
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Waktu -->
                        <div class="col-md-6">
                            <div class="card info-card time-card shadow-lg"
                                style="background-color: #f8f9fa; border-left: 5px solid #28a745;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success fw-bold">Waktu Saat Ini</h5>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div
                                            class="card-icon rounded-circle bg-success text-white d-flex align-items-center justify-content-center p-3">
                                            <i class='bx bx-time text-white' style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="current-time" class="fw-semibold " style="color: #012970">Loading...
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Santri <span>| Jumlah</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bx-universal-access'></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalSantri }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-md-6 mb-3">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Tepat Waktu <span>| Jumlah</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bx-child'></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{ $totalTepatWaktu }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Klasifikasi Berdasarkan Tahun Angkatan -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Klasifikasi Total</h5>
                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                        tooltip: { trigger: 'item' },
                                        legend: { top: '5%', left: 'center' },
                                        series: [{
                                            name: 'Klasifikasi',
                                            type: 'pie',
                                            radius: ['40%', '70%'],
                                            data: [
                                                { value: {{ $totalTepatWaktu }}, name: 'Tepat Waktu' },
                                                { value: {{ $totalSantri - $totalTepatWaktu }}, name: 'Terlambat' },
                                            ]
                                        }]
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <!-- Tabel Statistik Klasifikasi Berdasarkan Tahun Angkatan -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Klasifikasi Tahun Angkatan</h5>
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-striped">
                                    <thead class="custom-thead">
                                        <tr>
                                            <th>Tahun Angkatan</th>
                                            <th>Jumlah Santri</th>
                                            <th>Tepat Waktu</th>
                                            <th>Terlambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahunAngkatanTable as $tahun)
                                        <tr>
                                            <td>{{ $tahun->tahun_angkatan }}</td>
                                            <td>{{ $tahun->total }}</td>
                                            <td>{{ $tahun->tepat }}</td>
                                            <td>{{ $tahun->total - $tahun->tepat }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Jenis Kelamin -->
                <div class="col-xxl-6 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Jenis Kelamin</h5>
                            <div id="jenisKelamin"></div>
                        </div>
                    </div>

                </div>

                <!-- Grafik Asal Daerah -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Asal Daerah</h5>
                            <div id="asalDaerah"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('current-date').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('current-time').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let tahunAngkatan = {!! json_encode($tahunAngkatan) !!}; 

        // Grafik Jenis Kelamin
        new ApexCharts(document.querySelector("#jenisKelamin"), {
            series: [
                { name: 'Laki-laki', data: {!! json_encode($genderData->pluck('laki')->toArray()) !!} },
                { name: 'Perempuan', data: {!! json_encode($genderData->pluck('perempuan')->toArray()) !!} }
            ],
                chart: { height: 350, type: 'area', toolbar: { show: false } },
            colors: ['#007bff', '#28a745'], 
            xaxis: { 
                categories: tahunAngkatan,
                labels: { 
                
                    rotate: -45,
                },
                axisBorder: { show: true, color: '#000' }
            }
        }).render();

        // Grafik Asal Daerah
        new ApexCharts(document.querySelector("#asalDaerah"), {
            series: [
                { name: 'Dalam Provinsi', data: {!! json_encode($regionData->pluck('dalam')->toArray()) !!} },
                { name: 'Luar Provinsi', data: {!! json_encode($regionData->pluck('luar')->toArray()) !!} }
            ],
    chart: { height: 350, type: 'area', toolbar: { show: false } },
            colors: ['#dc3545', '#6f42c1'],
            xaxis: { 
                categories: tahunAngkatan,
                labels: { 
                
                    rotate: -45,
                },
                axisBorder: { show: true, color: '#000' }
            }
        }).render();
    });
</script>
<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- Tambahkan CSS Responsive -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

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
@endsection