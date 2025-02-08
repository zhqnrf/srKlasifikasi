<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Menu</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('dashboardAdmin') ? '' : 'collapsed' }}"
                href="{{ route('dashboardAdmin') }}">
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

        <li class="nav-item">
            <a class="nav-link {{ Route::is('santri.add') ? '' : 'collapsed' }}" href="{{ route('santri.add') }}">
                <i class='bx bx-child'></i>
                <span>Kelola Santri</span>
            </a>
        </li>

        <li class="nav-heading">Klasifikasi</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('examData') ? '' : 'collapsed' }}" href="{{ route('examData') }}">
                <i class='bx bx-data'></i>
                <span>Data Latih</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('trainData') ? '' : 'collapsed' }}" href="{{ route('trainData') }}">
                <i class='bx bx-test-tube'></i>
                <span>Data Uji</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('classificationResult') ? '' : 'collapsed' }}"
                href="{{ route('classificationResult') }}">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span>Hasil Klasifikasi</span>
            </a>
        </li>


    </ul>

</aside>