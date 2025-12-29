<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('pemilik.dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="{{ asset('assets/img/AdminLTELogo.png') }}"
                alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">RSHP</span>
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
                    <a href="{{ route('pemilik.dashboard') }}" class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">PET SAYA</li>

                <!-- Pet / Hewan Saya -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.pet.index') }}" class="nav-link {{ request()->routeIs('pemilik.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-heart-fill"></i>
                        <p>Daftar Pet</p>
                    </a>
                </li>

                <li class="nav-header">JADWAL & REKAM MEDIS</li>

                <!-- Jadwal Temu Dokter -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.temu-dokter.index') }}" class="nav-link {{ request()->routeIs('pemilik.temu-dokter.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar-check-fill"></i>
                        <p>Jadwal Temu Dokter</p>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.rekam-medis.index') }}" class="nav-link {{ request()->routeIs('pemilik.rekam-medis.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-clipboard2-pulse-fill"></i>
                        <p>Rekam Medis Pet</p>
                    </a>
                </li>

                <li class="nav-header">AKUN</li>

                <!-- Profil -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.profile.index') }}" class="nav-link {{ request()->routeIs('pemilik.profile.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
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
<!--end::Sidebar-->

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>