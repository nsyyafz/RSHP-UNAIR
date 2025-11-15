<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--end::Navbar Search-->
            
            <!--begin::Appointment Dropdown-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-calendar-event"></i>
                    <span class="navbar-badge badge text-bg-info">5</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">5 Janji Temu Hari Ini</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-heart-fill text-danger" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="dropdown-item-title">
                                    Bruno - Vaksinasi
                                </h3>
                                <p class="fs-7">Pemilik: Budi Santoso</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 10:00 WIB
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-heart-fill text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="dropdown-item-title">
                                    Luna - Pemeriksaan Rutin
                                </h3>
                                <p class="fs-7">Pemilik: Siti Nurhaliza</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 13:00 WIB
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-heart-fill text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 class="dropdown-item-title">
                                    Milo - Sterilisasi
                                </h3>
                                <p class="fs-7">Pemilik: Ahmad Wijaya</p>
                                <p class="fs-7 text-secondary">
                                    <i class="bi bi-clock-fill me-1"></i> 15:30 WIB
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Janji Temu</a>
                </div>
            </li>
            <!--end::Appointment Dropdown-->
            
            <!--begin::Emergency Alert-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span class="navbar-badge badge text-bg-danger">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">2 Kasus Emergency</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-heart-pulse-fill text-danger me-2"></i> 
                        Bella - Keracunan Makanan
                        <span class="float-end text-danger fs-7">URGENT</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-bandaid-fill text-warning me-2"></i> 
                        Max - Luka Gigitan
                        <span class="float-end text-warning fs-7">MODERATE</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Kasus</a>
                </div>
            </li>
            <!--end::Emergency Alert-->
            
            <!--begin::Notifications Dropdown-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">8</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">8 Notifikasi Baru</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-clipboard2-pulse me-2"></i> 3 rekam medis menunggu verifikasi
                        <span class="float-end text-secondary fs-7">5 menit</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-capsule me-2"></i> Stok obat Amoxicillin menipis
                        <span class="float-end text-secondary fs-7">30 menit</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-calendar-check me-2"></i> 2 janji temu baru terdaftar
                        <span class="float-end text-secondary fs-7">1 jam</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-person-plus me-2"></i> Pemilik baru mendaftar
                        <span class="float-end text-secondary fs-7">2 jam</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
                </div>
            </li>
            <!--end::Notifications Dropdown-->
            
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    @auth
                        <img
                            src="{{ asset('assets/img/user2-160x160.jpg') }}"
                            class="user-image rounded-circle shadow"
                            alt="User Image"
                        />
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    @else
                        <img
                            src="{{ asset('assets/img/user2-160x160.jpg') }}"
                            class="user-image rounded-circle shadow"
                            alt="User Image"
                        />
                        <span class="d-none d-md-inline">Guest</span>
                    @endauth
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary">
                        @auth
                            <img
                                src="{{ asset('assets/img/user2-160x160.jpg') }}"
                                class="rounded-circle shadow"
                                alt="User Image"
                            />
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->email }}</small>
                            </p>
                        @else
                            <img
                                src="{{ asset('assets/img/user2-160x160.jpg') }}"
                                class="rounded-circle shadow"
                                alt="User Image"
                            />
                            <p>
                                Guest User
                                <small>guest@rshp.com</small>
                            </p>
                        @endauth
                    </li>
                    <!--end::User Image-->
                    
                    <!--begin::Menu Body-->
                    <li class="user-body">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-4 text-center">
                                <a href="#">
                                    <i class="bi bi-clipboard2-pulse"></i>
                                    <span class="d-block">Rekam Medis</span>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#">
                                    <i class="bi bi-calendar-event"></i>
                                    <span class="d-block">Jadwal</span>
                                </a>
                            </div>
                            <div class="col-4 text-center">
                                <a href="#">
                                    <i class="bi bi-graph-up"></i>
                                    <span class="d-block">Laporan</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Row-->
                    </li>
                    <!--end::Menu Body-->
                    
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">
                            <i class="bi bi-person-circle me-1"></i> Profile
                        </a>
                        <a href="#" class="btn btn-default btn-flat float-end">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
