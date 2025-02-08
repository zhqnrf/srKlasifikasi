@extends('layouts.app-admin')

<title>Dashboard Santri | SR Klasifikasi</title>
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ubah Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active">Ubah</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
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
                    <h5 class="card-title">Ubah Password</h5>
                    <form class="row g-3" action="{{ route('changePassword.post') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Password Baru" name="password"
                                    id="password" required>
                                <span class="input-group-text" onclick="togglePassword('password','toggleIcon1')">
                                    <i class="bx bx-hide" id="toggleIcon1"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Konfirmasi Password Baru"
                                    name="password_confirmation" id="confirmPassword" required>
                                <span class="input-group-text"
                                    onclick="togglePassword('confirmPassword','toggleIcon2')">
                                    <i class="bx bx-hide" id="toggleIcon2"></i>
                                </span>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
        var field = document.getElementById(fieldId);
        var icon = document.getElementById(iconId);
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