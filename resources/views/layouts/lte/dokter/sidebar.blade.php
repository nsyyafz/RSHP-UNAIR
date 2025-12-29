<!--begin::Sidebar Dokter-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('dokter.dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('assets/img/AdminLTELogo.png') }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">RSHP Dokter</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation"
            >
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">DATA PASIEN</li>

                <!-- Data Pasien -->
                <li class="nav-item">
                    <a href="{{ route('dokter.pet.index') }}" class="nav-link {{ request()->routeIs('dokter.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-heart-fill"></i>
                        <p>Data Pasien (Pet)</p>
                    </a>
                </li>

                <li class="nav-header">REKAM MEDIS</li>

                <!-- Rekam Medis -->
                <li class="nav-item">
                    <a href="{{ route('dokter.rekam-medis.index') }}" class="nav-link {{ request()->routeIs('dokter.rekam-medis.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-medical"></i>
                        <p>Rekam Medis</p>
                    </a>
                </li>


                <li class="nav-header">PROFIL</li>

                <!-- Profil Dokter -->
                <li class="nav-item">
                    <a href="{{ route('dokter.profile.index') }}" class="nav-link {{ request()->routeIs('dokter.profile.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-badge-fill"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <li class="nav-header">LAINNYA</li>

                <!-- Logout -->
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar Dokter-->