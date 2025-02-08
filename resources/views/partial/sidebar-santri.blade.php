<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Menu</li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('dashboardSantri') ? '' : 'collapsed' }}"
                href="{{ route('dashboardSantri') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('countingSantri') ? '' : 'collapsed' }}"
                href="{{ route('countingSantri') }}">
                <i class='bx bxs-calculator'></i>
                <span>Hitung</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('historySantri') ? '' : 'collapsed' }}" href="{{ route('historySantri') }}">
                <i class='bx bx-history'></i>
                <span>Riwayat</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->