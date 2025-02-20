@extends('layouts.app')
<title>Profil | SR Klasifikasi</title>
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Profil</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Santri</li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">

            {{-- Tampilkan pesan sukses atau error --}}
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

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
                    <h5 class="card-title">Profil Santri</h5>

                    <form class="row g-3" action="{{ route('profilSantri.update') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="Nama" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <!-- NIS read-only -->
                            <input type="text" class="form-control" placeholder="NIS" name="nis"
                                value="{{ $user->nis }}" readonly style="background-color: #f2f2f2; color: #959595;">
                        </div>

                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-6">
                            <!-- Jenis kelamin read-only -->
                            <input type="text" class="form-control" placeholder="Jenis Kelamin" name="jenis_kelamin"
                                value="{{ $user->jenis_kelamin }}" readonly
                                style="background-color: #f2f2f2; color: #959595;">
                        </div>

                        <div class="col-md-6">
                            <select id="asalDaerah" class="form-select" name="asal_daerah" required>
                                <option value="" disabled>Pilih Asal Daerah...</option>
                                <option value="Dalam Provinsi" {{ $user->asal_daerah == 'Dalam Provinsi' ? 'selected' : ''
                                    }}>Dalam Provinsi</option>
                                <option value="Luar Provinsi" {{ $user->asal_daerah == 'Luar Provinsi' ? 'selected' : ''
                                    }}>Luar
                                    Provinsi</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Password (opsional)"
                                    name="password" id="password">
                                <span class="input-group-text" onclick="togglePassword('password','toggleIcon1')">
                                    <i class="bx bx-hide" id="toggleIcon1"></i>
                                </span>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin ganti password</small>
                        </div>

                        <div class="col-12">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Konfirmasi Password"
                                    name="password_confirmation" id="confirmPassword">
                                <span class="input-group-text"
                                    onclick="togglePassword('confirmPassword','toggleIcon2')">
                                    <i class="bx bx-hide" id="toggleIcon2"></i>
                                </span>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin ganti password</small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function togglePassword(fieldId, iconId) {
        let field = document.getElementById(fieldId);
        let icon = document.getElementById(iconId);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.replace("bx-hide", "bx-show");
        } else {
            field.type = "password";
            icon.classList.replace("bx-show", "bx-hide");
        }
    }
</script>
@endsection