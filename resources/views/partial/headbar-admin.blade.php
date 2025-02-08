<!-- ======= Header ======= -->
<link href="{{ asset('img/favicon.png') }}" rel="icon">
<link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

@php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
@endphp

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="{{ asset('img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">SR Klasifikasi</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <i class='bx bxs-user-circle' style="font-size: 40px; color: #0d6efd;"></i>
                    <span class="d-none d-md-block dropdown-toggle ps-2"></span>
                </a><!-- End Profile Image Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <!-- Tampilkan role & email user yang sedang login -->
                        <h6>{{ $user ? ucfirst($user->role) : 'Guest' }}</h6>
                        <span>{{ $user ? $user->email : 'No Email' }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('changePassword') }}">
                            <i class="bi bi-lock"></i>
                            <span>Ubah Password</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->