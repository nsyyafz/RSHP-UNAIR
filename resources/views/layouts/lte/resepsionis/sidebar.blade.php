<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('resepsionis.dashboard') }}" class="brand-link">
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
                    <a href="{{ route('resepsionis.dashboard') }}" class="nav-link {{ request()->routeIs('resepsionis.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">DATA PASIEN</li>

                <!-- Pemilik -->
                <li class="nav-item">
                    <a href="{{ route('resepsionis.pemilik.index') }}" class="nav-link {{ request()->routeIs('resepsionis.pemilik.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Data Pemilik</p>
                    </a>
                </li>

                <!-- Pet / Hewan -->
                <li class="nav-item">
                    <a href="{{ route('resepsionis.pet.index') }}" class="nav-link {{ request()->routeIs('resepsionis.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-heart-fill"></i>
                        <p>Data Pet</p>
                    </a>
                </li>

                <li class="nav-header">JADWAL</li>

                <!-- Temu Dokter -->
                <li class="nav-item">
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="nav-link {{ request()->routeIs('resepsionis.temu-dokter.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar-check-fill"></i>
                        <p>Temu Dokter</p>
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