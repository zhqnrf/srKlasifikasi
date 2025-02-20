@extends('layouts.app-none')
@section('title', 'Register | SR Klasifikasi')
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
                            <h5 class="card-title text-center pb-0 fs-4">Daftar</h5>
                            <p class="text-center small">Daftarkan Akun Anda (Santri)</p>
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

                        <form class="row g-3 needs-validation" action="{{ route('register.post') }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="col-12">
                                <label for="nameSantri" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" id="nameSantri" required>
                                <div class="invalid-feedback">Masukkan Nama Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="NISSantri" class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" id="NISSantri" required>
                                <div class="invalid-feedback">Masukkan NIS Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="emailSantri" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="emailSantri" required>
                                <div class="invalid-feedback">Masukkan Email Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="passwordSantri" class="form-label">Password</label>
                                <div class="input-group">
                                <input type="password" name="password" class="form-control" id="passwordSantri"
                                    required>
                                    <span class="input-group-text toggle-password" data-target="passwordSantri">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">Masukkan Password Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="confirmPasswordSantri" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" class="form-control"
                                        id="confirmPasswordSantri" required>
                                    <span class="input-group-text toggle-password" data-target="confirmPasswordSantri">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                                <div class="invalid-feedback">Masukkan Konfirmasi Password Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" id="jenisKelamin" required>
                                    <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <div class="invalid-feedback">Pilih Jenis Kelamin Anda</div>
                            </div>

                            <div class="col-12">
                                <label for="asalDaerah" class="form-label">Asal Daerah</label>
                                <select class="form-select" name="asal_daerah" id="asalDaerah" required>
                                    <option value="" selected disabled>Pilih Asal Daerah</option>
                                    <option value="Dalam Provinsi">Dalam Provinsi</option>
                                    <option value="Luar Provinsi">Luar Provinsi</option>
                                </select>
                                <div class="invalid-feedback">Pilih Asal Daerah Anda</div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit" id="btnRegister" disabled>Daftar</button>
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                <p class="small mb-0">
                                    Sudah Punya Akun? <a href="{{ route('login') }}">Masuk Akun</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nisInput = document.getElementById("NISSantri");
        const btnRegister = document.getElementById("btnRegister");

        nisInput.addEventListener("input", function() {
            let nisValue = this.value.trim();

            if (nisValue.length > 0 && !/^([IA])/i.test(nisValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Valid',
                    confirmButtonColor: '#d33'
                });

                this.value = "";  // Kosongkan input NIS
                btnRegister.disabled = true;  // Nonaktifkan tombol daftar
            } else {
                btnRegister.disabled = false;  // Aktifkan tombol daftar jika valid
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        // Show/Hide Password
        document.querySelectorAll(".toggle-password").forEach(button => {
            button.addEventListener("click", function () {
                let targetId = this.getAttribute("data-target");
                let input = document.getElementById(targetId);
                let icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bx-hide");
                    icon.classList.add("bx-show");
                } else {
                    input.type = "password";
                    icon.classList.remove("bx-show");
                    icon.classList.add("bx-hide");
                }
            });
        });

        // Validasi Konfirmasi Password dengan SweetAlert
        document.getElementById("registerForm").addEventListener("submit", function (event) {
            let password = document.getElementById("passwordSantri").value;
            let confirmPassword = document.getElementById("confirmPasswordSantri").value;

            if (password !== confirmPassword) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Konfirmasi password tidak cocok!',
                });
            }
        });
    });
</script>

<style>
    .toggle-password {
        cursor: pointer;
    }
</style>

@endsection