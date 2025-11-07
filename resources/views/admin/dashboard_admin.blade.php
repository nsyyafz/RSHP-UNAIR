<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar-custom {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            box-shadow: 0 4px 15px rgba(0, 51, 102, 0.3);
            padding: 1rem 0;
        }
        
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .navbar-brand:hover {
            color: #ffd700;
            transform: scale(1.05);
        }
        
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 5px;
        }
        
        .navbar-custom .nav-link:hover {
            color: #ffd700;
            background: rgba(255, 215, 0, 0.1);
        }
        
        .navbar-custom .dropdown-menu {
            background: white;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.2);
            border-radius: 10px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .navbar-custom .dropdown-item {
            color: #003366;
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .navbar-custom .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(0, 51, 102, 0.1) 0%, transparent 100%);
            color: #005599;
            padding-left: 2rem;
        }
        
        .navbar-custom .dropdown-item i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }
        
        .navbar-custom .dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        /* Hero Section */
        .hero-admin {
            background: linear-gradient(135deg, #003366 0%, #005599 70%, #ffd700 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-admin::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,215,0,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .hero-admin h1 {
            font-weight: 700;
            font-size: 2.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }
        
        .hero-admin p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #003366, #ffd700);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.2);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
        }
        
        .stat-title {
            color: #003366;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-number {
            color: #003366;
            font-weight: 800;
            font-size: 2.5rem;
            display: block;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .hero-admin h1 {
                font-size: 2rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-heart-pulse-fill"></i> RSHP Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Dropdown Data Master -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-database"></i> Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('jenis-hewan.index') }}">
                                <i class="bi bi-list-ul"></i> Jenis Hewan
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('ras-hewan.index') }}">
                                <i class="bi bi-tag"></i> Ras Hewan
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('kategori.index') }}">
                                <i class="bi bi-folder"></i> Kategori
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('kategori-klinis.index') }}">
                                <i class="bi bi-clipboard-pulse"></i> Kategori Klinis
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('kode-tindakan.index') }}">
                                <i class="bi bi-file-medical"></i> Kode Tindakan
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Dropdown Manajemen -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> Manajemen
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('pet.index') }}">
                                <i class="bi bi-heart"></i> Data Pet
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('pemilik.index') }}">
                                <i class="bi bi-people"></i> Data Pemilik
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('user.index') }}">
                                <i class="bi bi-person-badge"></i> Data User
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('role.index') }}">
                                <i class="bi bi-shield-check"></i> Data Role
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-admin">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1>Selamat Datang, Admin RSHP 🐾</h1>
                    <p class="mb-0">
                        Kelola data hewan, pemilik, serta layanan klinis dengan mudah melalui dashboard ini.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🐶</div>
                    <div class="stat-title">Jumlah Hewan</div>
                    <span class="stat-number">{{ $jumlahPet ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-title">Jumlah Pemilik</div>
                    <span class="stat-number">{{ $jumlahPemilik ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-title">Jenis Hewan</div>
                    <span class="stat-number">{{ $jumlahJenis ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🩺</div>
                    <div class="stat-title">Rekam Medis</div>
                    <span class="stat-number">{{ $jumlahRekam ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🏷️</div>
                    <div class="stat-title">Ras Hewan</div>
                    <span class="stat-number">{{ $jumlahRas ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">👨‍💼</div>
                    <div class="stat-title">Jumlah User</div>
                    <span class="stat-number">{{ $jumlahUser ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🛡️</div>
                    <div class="stat-title">Jumlah Role</div>
                    <span class="stat-number">{{ $jumlahRole ?? 0 }}</span>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">💉</div>
                    <div class="stat-title">Kode Tindakan</div>
                    <span class="stat-number">{{ $jumlahTindakan ?? 0 }}</span>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>