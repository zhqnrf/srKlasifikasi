@extends('layouts.app-admin')
<title>Dashboard Admin | SR Klasifikasi</title>
@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Halo <b>{{ ucwords($user->role) }}</b> 👋</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <div class="col-12 dashboard">
            <div class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
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
@endsection