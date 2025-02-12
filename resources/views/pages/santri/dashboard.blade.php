@extends('layouts.app')
<title>Dashboard Santri | SR Klasifikasi</title>
@section('content')
<style>
    .verification-card {
        background-color: #f8f9fa;
        border-left: 5px solid #ffc107;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .verification-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .time-text{
        color:#012970;
    }

    .verification-card .card-icon {
        width: 50px;
        height: 50px;
        background-color: #ffc107;
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }



    .estimation-card {
        background-color: #f8f9fa;
        border-left: 5px solid #8B07FFFF;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .estimation-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .estimation-card .card-icon {
        width: 50px;
        height: 50px;
        background-color: #8B07FFFF;
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .qr-container {
        display: none;
        text-align: center;
        margin-top: 10px;
    }

    .qr-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }
</style>
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Halo <b>{{ $user->name }}</b> 👋</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Santri</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="col-12">
            <div class="card info-card verification-card">
                <div class="card-body">
                    <h5 class="card-title">Munaqosah <span>| Status</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class='bx bx-shield'></i>
                        </div>
                        <div class="ps-3">
                            @if($latestRiwayat)
                            @if($latestRiwayat->munaqosah_status === 'Ditolak')
                            <h6 class="text-danger">Ditolak</h6>
                            @elseif($latestRiwayat->munaqosah_status === 'Terverifikasi')
                            <h6 class="text-success">Terverifikasi</h6>

                            <!-- Tombol Show/Hide QR -->
                            <div class="qr-buttons">
                                <button id="btnShowQR" class="btn btn-primary">
                                    <i class='bx bx-show'></i> Tampilkan QR
                                </button>
                                <button id="btnHideQR" class="btn btn-secondary d-none">
                                    <i class='bx bx-hide'></i> Sembunyikan QR
                                </button>
                            </div>

                            <!-- Tempat Menampilkan QR Code -->
                            <div id="qrContainer" class="qr-container">
                                <div id="qrcode"></div>
                                <a id="downloadQR" class="btn btn-success mt-2 d-none" download="qrcode.pdf">
                                    <i class='bx bxs-file-pdf'></i> Unduh PDF
                                </a>
                            </div>

                            @else
                            <h6 class="text-warning">Belum Diverifikasi</h6>
                            @endif
                            @else
                            <h6>Belum ada data</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card info-card estimation-card">
                <div class="card-body">
                    <h5 class="card-title">Estimasi Lulus</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class='bx bx-calendar-check'></i>
                        </div>
                        <div class="ps-3">
                            @php
                            $totalHalaman = 2780;
                            $halamanDikerjakan = $latestRiwayat ? ($latestRiwayat->alquran + $latestRiwayat->alhadis) : 0;
                            $sisaHalaman = max(0, $totalHalaman - $halamanDikerjakan);
                            $targetPerHari = 2.38;
                            $estimasiHari = ceil($sisaHalaman / $targetPerHari);
                            $estimasiTanggal = now()->addDays($estimasiHari)->format('d-m-Y');
                            @endphp

                            @if($halamanDikerjakan >= $totalHalaman)
                            <h4 class=" fw-bold time-text">Sudah Lulus 🎉</h4>
                            @else
                            <h4 class="fw-bold time-text">
                                {{ $estimasiHari }} Hari Lagi
                            </h4>
                            <p class="text-muted">Perkiraan <b>{{ $estimasiTanggal }}</b></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Kartu Estimasi Lulus -->


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
                <!-- Al Quran Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Al Quran <span>| Last</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bxs-book-reader'></i>
                                </div>
                                <div class="ps-3">
                                    @if($latestRiwayat)
                                    <h6>{{ $latestRiwayat->alquran }} Halaman</h6>
                                    @else
                                    <h6>Belum ada data</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Al Quran Card -->

                <!-- Al Hadis Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Al Hadis <span>| Last</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bx-book-reader'></i>
                                </div>
                                <div class="ps-3">
                                    @if($latestRiwayat)
                                    <h6>{{ $latestRiwayat->alhadis }} Halaman</h6>
                                    @else
                                    <h6>Belum ada data</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Al Hadis Card -->

                <!-- Hasil Klasifikasi Card -->
                <div class="col-xxl-4 col-md-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Hasil Klasifikasi <span>| Last</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class='bx bx-calculator'></i>
                                </div>
                                <div class="ps-3">
                                    @if($latestRiwayat)
                                    @if($latestRiwayat->status === 'Tercapai')
                                    <h6 class="text-success">{{ $latestRiwayat->status }}</h6>
                                    @else
                                    <h6 class="text-danger">{{ $latestRiwayat->status }}</h6>
                                    @endif
                                    @else
                                    <h6>Belum ada data</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Hasil Klasifikasi Card -->

                <!-- Waktu Card -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function generateQRCode() {
        // Menggunakan operator ternary untuk menghindari error jika $latestRiwayat null
        const data = `Nama: {{ $user->name }}
NIS: {{ $user->nis }}
Status: {{ $latestRiwayat ? $latestRiwayat->status : 'Tidak Tersedia' }}
Tanggal: {{ now()->format('d-m-Y') }}`;
        
        let qr = new QRious({
            element: document.createElement('canvas'),
            value: data,
            size: 200
        });

        // Menampilkan QR Code
        document.getElementById('qrcode').innerHTML = '';
        document.getElementById('qrcode').appendChild(qr.canvas);

        // Menampilkan tombol download
        const link = document.getElementById('downloadQR');
        link.classList.remove('d-none');

        // Menambahkan event untuk mengunduh PDF
        link.onclick = function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Menentukan font dan ukuran font
            doc.setFont("helvetica");
            doc.setFontSize(12);

            // Menambahkan judul PDF dengan font tebal
            doc.setFont("helvetica", "bold");
            doc.text("QR Code Munaqosah", 20, 20);

            // Menambahkan teks dengan font normal
            doc.setFont("helvetica", "normal");

            let y = 30; // Posisi Y dimulai dari sini
            doc.text(`Nama: {{ $user->name }}`, 20, y);
            y += 10;
            doc.text(`NIS: {{ $user->nis }}`, 20, y);
            y += 10;
            doc.text(`Status: {{ $latestRiwayat ? $latestRiwayat->status : 'Tidak Tersedia' }}`, 20, y);
            y += 10;
            doc.text(`Tanggal: {{ now()->format('d-m-Y') }}`, 20, y);

            // Memberi jarak antara teks dan QR Code
            y += 20;

            // Menambahkan QR Code ke PDF
            doc.addImage(qr.canvas.toDataURL('image/png'), 'PNG', 20, y, 160, 160);

            // Menyimpan file PDF dengan nama qrcode.pdf
            doc.save("qrcode.pdf");
        };
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let qrContainer = document.getElementById("qrContainer");
        let btnShowQR = document.getElementById("btnShowQR");
        let btnHideQR = document.getElementById("btnHideQR");
        let qrcodeElement = document.getElementById("qrcode");
        let downloadQR = document.getElementById("downloadQR");

        btnShowQR.addEventListener("click", function () {
            generateQRCode();
            qrContainer.style.display = "block";
            btnShowQR.classList.add("d-none");
            btnHideQR.classList.remove("d-none");
        });

        btnHideQR.addEventListener("click", function () {
            qrContainer.style.display = "none";
            btnShowQR.classList.remove("d-none");
            btnHideQR.classList.add("d-none");
        });
    });
</script>
@endsection