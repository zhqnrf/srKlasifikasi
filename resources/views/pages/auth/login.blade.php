@extends('layouts.app-none')
@section('title', 'Login | SR Klasifikasi')
@section('content')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                <div class="d-flex justify-content-center py-2">
                    <a href="#" class="d-flex align-items-center w-auto">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height: 100px">
                    </a>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Masuk</h5>
                            <p class="text-center small">Hallo, Selamat Datang Kembali</p>
                        </div>

                        {{-- Tampilkan error jika ada --}}
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form class="row g-3 needs-validation" action="{{ route('login.post') }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="col-12">
                                <label for="emailUser" class="form-label">Email</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="email" class="form-control" id="emailUser" required>
                                    <div class="invalid-feedback">Masukkan Email Anda</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="passwordUser" class="form-label">Password</label>
                                <div class="input-group has-validation">
                                    <input type="password" name="password" class="form-control" id="passwordUser"
                                        required>
                                    <!-- Tombol toggle untuk show/hide password -->
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    <div class="invalid-feedback">Masukkan Password Anda</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Masuk</button>
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                <p class="small mb-0">
                                    Belum Punya Akun? <a href="{{ route('register') }}">Buat Akun</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Script untuk toggle show/hide password -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('passwordUser');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        }
    });
</script>
@endsection