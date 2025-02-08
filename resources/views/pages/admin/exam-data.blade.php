@extends('layouts.app-admin')
@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Data Latih</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Data Latih</li>
                </ol>
            </nav>
        </div>
        <!-- Import & Export Buttons -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tindakan</h5>
                    <form action="{{ route('data-latih.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required>
                        <button type="submit" class="btn btn-primary">Import Excel</button>
                    </form>
                    <a href="{{ route('data-latih.export') }}" class="btn btn-success">Export Excel</a>
                </div>
            </div>
        </div>
        <!-- Data Table -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Latih</h5>
                    <table id="dataTable" class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>NIS</th>
                                <th>Asal Daerah</th>
                                <th>Tahun Angkatan</th>
                                <th>Capaian Hadis</th>
                                <th>Capaian Al Qur'an</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $santri)
                            <tr>
                                <td>{{ $santri->nama }}</td>
                                <td>{{ $santri->jenis_kelamin }}</td>
                                <td>{{ $santri->nis }}</td>
                                <td>{{ $santri->asal_daerah }}</td>
                                <td>{{ $santri->tahun_angkatan }}</td>
                                <td>{{ $santri->capaian_hadis }}</td>
                                <td>{{ $santri->capaian_quran }}</td>
                                <td>{{ $santri->status }}</td>
                                <td>
                                    <!-- Aksi buttons -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection