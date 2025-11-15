<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>
                            Master Data
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('jenis-hewan.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Jenis Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ras-hewan.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Ras Hewan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori-klinis.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori Klinis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kode-tindakan.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kode Tindakan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pemilik -->
                <li class="nav-item">
                    <a href="{{ route('pemilik.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Pemilik</p>
                    </a>
                </li>

                <!-- Pet / Hewan -->
                <li class="nav-item">
                    <a href="{{ route('pet.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-heart-fill"></i>
                        <p>Pet / Hewan</p>
                    </a>
                </li>

                <li class="nav-header">MANAJEMEN USER</li>

                <!-- User -->
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>User</p>
                    </a>
                </li>

                <!-- Role -->
                <li class="nav-item">
                    <a href="{{ route('role.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-shield-fill"></i>
                        <p>Role</p>
                    </a>
                </li>

                <li class="nav-header">LAINNYA</li>

                <!-- Pengaturan -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear-wide-connected"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
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