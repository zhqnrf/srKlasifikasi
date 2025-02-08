<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Menu</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('dashboardAdmin') ? '' : 'collapsed' }}" href="{{ route('dashboardAdmin') }}">
            <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('dataMunaqosah') ? '' : 'collapsed' }}" href="{{ route('dataMunaqosah') }}">
                <i class='bx bxs-data'></i>
                <span>Munaqosah Santri</span>
            </a>
        </li>

        <li class="nav-heading">Kelola</li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('admin.add') ? '' : 'collapsed' }}" href="{{ route('admin.add') }}">
                <i class='bx bx-user-plus'></i>
                <span>Kelola Admin</span>
            </a>
        </li>

    </ul>

</aside>