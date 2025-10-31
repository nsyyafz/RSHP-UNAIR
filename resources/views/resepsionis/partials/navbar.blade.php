<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #8e44ad 0%, #9b59b6 100%);">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('resepsionis.dashboard') }}">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png" 
                 alt="Logo" style="height: 40px; margin-right: 15px;">
            <div>
                <div style="font-size: 1.1rem;">Dashboard Resepsionis</div>
                <small style="font-size: 0.75rem; opacity: 0.9;">RSHP Universitas Airlangga</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('resepsionis.dashboard') }}">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-database"></i> Data Pendaftaran
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('resepsionis.pemilik') }}">
                            <i class="bi bi-people"></i> Data Pemilik
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('resepsionis.pet') }}">
                            <i class="bi bi-emoji-smile"></i> Data Hewan Peliharaan
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('resepsionis.jenis-hewan') }}">
                            <i class="bi bi-list-ul"></i> Jenis Hewan
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('resepsionis.ras-hewan') }}">
                            <i class="bi bi-bookmark-star"></i> Ras Hewan
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white">
                        <i class="bi bi-person-circle"></i> {{ session('user_name') }}
                    </span>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2" 
                                style="border-radius: 20px; padding: 0.4rem 1.2rem; border-width: 2px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 0.2rem;
    }
    
    .navbar-nav .nav-link:hover {
        color: #e056fd;
        background: rgba(255, 255, 255, 0.1);
    }
    
    .navbar-nav .nav-link.active {
        color: #e056fd;
        background: rgba(255, 255, 255, 0.15);
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(142, 68, 173, 0.15);
        border-radius: 10px;
        margin-top: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.7rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(90deg, #8e44ad, #9b59b6);
        color: #fff;
        padding-left: 2rem;
    }
    
    .dropdown-item i {
        margin-right: 0.5rem;
    }
    
    .dropdown-divider {
        margin: 0.5rem 0;
        border-color: rgba(142, 68, 173, 0.2);
    }
    
    .btn-outline-light:hover {
        background-color: #e056fd;
        border-color: #e056fd;
        color: #8e44ad;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(224, 86, 253, 0.3);
    }
    
    @media (max-width: 991.98px) {
        .navbar-nav .nav-link {
            margin: 0.2rem 0;
        }
        
        .btn-outline-light {
            margin-top: 0.5rem;
            width: 100%;
        }
    }
</style>