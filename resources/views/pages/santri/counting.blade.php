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

                    <!-- Form POST ke route countingSantri.post -->
                    <form class="row g-3" action="{{ route('countingSantri.post') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <input type="number" class="form-control" placeholder="Tahun Angkatan" name="year"
                                value="{{ old('year') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="Jumlah Al-Qur'an Isi : Max 606"
                                name="alquran" value="{{ old('alquran') }}" max="606" required>
                        </div>
                        <div class="col-md-6">
                            <input type="number" class="form-control" placeholder="Jumlah Al-Hadis Isi : Max 1997"
                                name="alhadis" value="{{ old('alhadis') }}" max="1997" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Hitung & Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>

                {{-- Bagian menampilkan hasil perhitungan terakhir --}}
                @if($latest)
                <div class="card-footer text-center p-4">
                    <h5 class="mb-3 fw-bold">Hasil Terakhir</h5>
                    <!-- Tabel responsif -->
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
                                        {{ number_format($latest->nilai_n, 2) }}%
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th><i class='bx bx-calculator'></i> Hasil</th>
                                <td>
                                    <span
                                        class="badge {{ $latest->status === 'Tercapai' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $latest->status }}
                                    </span>
                                </td>
                            </tr>

                            {{-- Perhitungan detail target keseluruhan --}}
                            @php
                            $start = \Carbon\Carbon::create($latest->tahun_angkatan, 1, 1);
                            $now = \Carbon\Carbon::today();
                            $x = $start->diffInDays($now);
                            $y = $latest->alquran + $latest->alhadis;
                            $targetSpeed = 2603 / 1095;

                            // Hitung nilai kecepatan (nCheck) sebagai persentase
                            $nCheck = 0;
                            if ($y >= 2603) {
                            $nCheck = 100;
                            } elseif ($x > 0) {
                            $userSpeed = $y / $x;
                            $nCheck = ($userSpeed / $targetSpeed) * 100;
                            }

                            // Tentukan status detail untuk target keseluruhan
                            $detailStatus = '';
                            $badgeClass = '';
                            if ($y >= 2603) {
                            $detailStatus = "Sesuai Target (Halaman penuh)";
                            $badgeClass = 'bg-success';
                            } elseif ($x == 0) {
                            $detailStatus = "Data belum berjalan (x=0)";
                            $badgeClass = 'bg-secondary';
                            } else {
                            if ($nCheck < 100) { $shortPages=($x * $targetSpeed) - $y; $shortPages=ceil($shortPages);
                                $detailStatus="Belum Target, kurang isi {$shortPages} halaman" ; $badgeClass='bg-danger'
                                ; } elseif (abs($nCheck - 100) < 0.00001) { $detailStatus="Sesuai Target (100%)" ;
                                $badgeClass='bg-success' ; } elseif ($nCheck> 100) {
                                $detailStatus = "Lebih Target";
                                $badgeClass = 'bg-primary';
                                } else {
                                $detailStatus = "Data tidak valid";
                                $badgeClass = 'bg-secondary';
                                }
                                }

                                // Hitung kekurangan halaman untuk Quran dan Hadis
                                $quranShort = $latest->alquran < 606 ? (606 - $latest->alquran) : 0;
                                    $hadisShort = $latest->alhadis < 1997 ? (1997 - $latest->alhadis) : 0;
                                        $quranStatus = $latest->alquran >= 606 ? 'Khatam' : 'Belum Khatam';
                                        $hadisStatus = $latest->alhadis >= 1997 ? 'Khatam' : 'Belum Khatam';
                                        @endphp

                                        <tr>
                                            <th><i class="bx bx-info-circle"></i> Status Detail</th>
                                            <td>
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $detailStatus }}
                                                </span>
                                            </td>
                                        </tr>

                                        {{-- Kolom tambahan: Status Quran --}}
                                        <tr>
                                            <th><i class="bx bx-book"></i> Status Quran</th>
                                            <td>
                                                @if($quranStatus === 'Khatam')
                                                <span class="badge bg-success">Khatam</span>
                                                @else
                                                <span class="badge bg-warning">
                                                    Belum Khatam, anda kurang {{ $quranShort }} halaman
                                                </span>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Kolom tambahan: Status Hadis --}}
                                        <tr>
                                            <th><i class="bx bx-book-open"></i> Status Hadis</th>
                                            <td>
                                                @if($hadisStatus === 'Khatam')
                                                <span class="badge bg-success">Khatam</span>
                                                @else
                                                <span class="badge bg-warning">
                                                    Belum Khatam, anda kurang {{ $hadisShort }} halaman
                                                </span>
                                                @endif
                                            </td>
                                        </tr>

                        </table>
                    </div>
                </div>

                {{-- Debug (opsional) --}}
                {{--
                <script>
                    alert("DEBUG:\n" +
                          "x = {{ $x }}\n" +
                          "y = {{ $y }}\n" +
                          "n (dari DB) = {{ $latest->nilai_n }}\n" +
                          "nCheck (dari Blade) = {{ number_format($nCheck,2) }}"
                    );
                </script>
                --}}
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