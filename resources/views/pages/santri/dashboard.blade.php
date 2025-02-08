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
    
    .verification-card .card-icon {
    width: 50px;
    height: 50px;
    background-color: #ffc107;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    .text-success, .text-danger {
    font-size: 1.3rem;
    font-weight: bold;
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

        <!-- Munaqosah Card -->
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
                            <button class="btn btn-primary mt-2" onclick="generateQRCode()">Tampilkan QR</button>
                            <div id="qrcode" class="mt-3"></div>
                            <a id="downloadQR" class="btn btn-success mt-2 d-none" download="qrcode.pdf">Unduh PDF</a>
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
        <!-- End Munaqosah Card -->

        <div class="col-12 dashboard">
            <div class="row">
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
@endsection