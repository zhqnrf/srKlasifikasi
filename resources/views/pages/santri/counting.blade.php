@extends('layouts.app')
<title>Hitung | SR Klasifikasi</title>

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Hitung</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Santri</li>
                <li class="breadcrumb-item active">Hitung</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
            {{-- Pesan sukses --}}
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            {{-- Tampilkan error validasi --}}
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Hitung Status</h5>

                    <!-- Form POST ke route countingSantri.post (ganti sesuai route Anda) -->
                    <form class="row g-3" action="{{ route('countingSantri.post') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <input type="number" class="form-control" placeholder="Tahun Angkatan" name="year"
                                value="{{ old('year') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="Jumlah Al-Qur'an Isi" name="alquran"
                                value="{{ old('alquran') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="Jumlah Al-Hadis Isi" name="alhadis"
                                value="{{ old('alhadis') }}" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Hitung & Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>

                {{-- Bagian menampilkan hasil terakhir --}}
                @if($latest)
                <div class="card-footer text-center p-4">
                    <h5 class="mb-3 fw-bold">Hasil Terakhir</h5>
                    <!-- Membuat tabel responsif -->
                    <div class="table-responsive">
                        <table class="table table-bordered text-start">
                            <tr>
                                <th><i class="bx bx-calendar"></i> Tanggal</th>
                                <td>{{ $latest->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="bx bx-user"></i> Tahun Angkatan</th>
                                <td>{{ $latest->tahun_angkatan }}</td>
                            </tr>
                            <tr>
                                <th><i class="bx bx-book"></i> Jumlah Al-Qur'an Isi</th>
                                <td>{{ $latest->alquran }}</td>
                            </tr>
                            <tr>
                                <th><i class="bx bx-book-open"></i> Jumlah Al-Hadis Isi</th>
                                <td>{{ $latest->alhadis }}</td>
                            </tr>
                            <tr>
                                <th><i class="bx bx-line-chart"></i> Nilai (n)</th>
                                <td>
                                    <strong>
                                        {{-- Tampilkan 2 desimal + simbol persen --}}
                                        {{ number_format($latest->nilai_n, 2) }}%
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th><i class='bx bx-calculator'></i> Hasil</th>
                                <td>
                                    <span class="badge
                                            {{ $latest->status === 'Tercapai' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $latest->status }}
                                    </span>
                                </td>
                            </tr>

                            {{-- Tambahan kolom baru untuk keterangan detail --}}
                            @php
                                $start = \Carbon\Carbon::create($latest->tahun_angkatan, 1, 1);
                                $now   = \Carbon\Carbon::today();
                                $x     = $start->diffInDays($now);
                                $y     = $latest->alquran + $latest->alhadis;
                                $targetSpeed = 2603 / 1095;

                                // nCheck = 0 sebagai default
                                $nCheck = 0;

                                if ($y >= 2603) {
                                    // Sudah pasti 'Sesuai Target'
                                    $nCheck = 100;
                                } elseif ($x > 0) {
                                    $userSpeed = $y / $x;
                                    $nCheck    = ($userSpeed / $targetSpeed) * 100;
                                }

                                // Tentukan status detail
                                $detailStatus = '';
                                $badgeClass   = '';

                                // 1) Kalau y >= 2603: Sudah penuh => "Sesuai Target"
                                if ($y >= 2603) {
                                    $detailStatus = "Sesuai Target (Halaman penuh)";
                                    $badgeClass   = 'bg-success';
                                }
                                // 2) Kalau x=0 dan y<2603
                                elseif ($x == 0) {
                                    $detailStatus = "Data belum berjalan (x=0)";
                                    $badgeClass   = 'bg-secondary';
                                }
                                else {
                                    // 3) Kalau x>0, cek nCheck
                                    if ($nCheck < 100) {
                                        // Hitung kekurangan
                                        $shortPages = ($x * $targetSpeed) - $y;
                                        $shortPages = ceil($shortPages); 
                                        $detailStatus = "Belum Target, kurang isi {$shortPages} halaman";
                                        $badgeClass   = 'bg-danger';
                                    } elseif (abs($nCheck - 100) < 0.00001) {
                                        // pas 100%
                                        $detailStatus = "Sesuai Target (100%)";
                                        $badgeClass   = 'bg-success';
                                    } elseif ($nCheck > 100) {
                                        $detailStatus = "Lebih Target";
                                        $badgeClass   = 'bg-primary';
                                    } else {
                                        $detailStatus = "Data tidak valid";
                                        $badgeClass   = 'bg-secondary';
                                    }
                                }
                            @endphp

                            <tr>
                                <th><i class="bx bx-info-circle"></i> Status Detail</th>
                                <td>
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $detailStatus }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Debug (opsional) --}}
                {{-- <script>
                    alert("DEBUG:\n" +
                            "x = {{ $x }}\n" +
                            "y = {{ $y }}\n" +
                            "n (dari DB) = {{ $latest->nilai_n }}\n" +
                            "nCheck (dari Blade) = {{ number_format($nCheck,2) }}"
                        );
                </script> --}}
                @else
                <div class="card-footer text-center p-4">
                    <h5 class="fw-bold text-muted">Belum ada perhitungan</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
