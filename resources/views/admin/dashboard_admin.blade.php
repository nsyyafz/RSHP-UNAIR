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

        /* Activity Table Card */
        .activity-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.1);
            border: none;
            overflow: hidden;
        }
        
        .activity-card .card-header {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            padding: 1.5rem;
            border: none;
        }
        
        .activity-card .card-body {
            padding: 2rem;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #003366;
            font-weight: 700;
            border: none;
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(0, 51, 102, 0.05) 0%, transparent 100%);
            transform: translateX(5px);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .badge-activity {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .badge-primary {
            background: linear-gradient(90deg, #003366, #005599);
        }
        
        .badge-success {
            background: linear-gradient(90deg, #28a745, #20c997);
        }
        
        .badge-warning {
            background: linear-gradient(90deg, #ffd700, #ffed4e);
            color: #003366;
        }
        
        .badge-info {
            background: linear-gradient(90deg, #17a2b8, #138496);
        }

        /* Quick Actions */
        .quick-actions {
            margin: 2rem 0;
        }
        
        .action-btn {
            background: white;
            border: 2px solid #003366;
            color: #003366;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .action-btn:hover {
            background: linear-gradient(90deg, #003366, #005599);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 51, 102, 0.3);
        }
        
        .action-btn i {
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .hero-admin h1 {
                font-size: 2rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
            
            .action-btn {
                width: 100%;
                margin: 0.5rem 0;
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
    <!-- Include Navbar -->
    @include('admin.partials.navbar')

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
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🐶</div>
                    <div class="stat-title">Jumlah Hewan</div>
                    <span class="stat-number">{{ $jumlahPet ?? 0 }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-title">Jumlah Pemilik</div>
                    <span class="stat-number">{{ $jumlahPemilik ?? 0 }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-title">Jenis Hewan</div>
                    <span class="stat-number">{{ $jumlahJenis ?? 0 }}</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">🩺</div>
                    <div class="stat-title">Rekam Medis</div>
                    <span class="stat-number">{{ $jumlahRekam ?? 0 }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="container quick-actions text-center">
        <a href="{{ route('jenis-hewan') }}" class="action-btn">
            <i class="bi bi-list-ul"></i> Kelola Jenis Hewan
        </a>
        <a href="{{ route('pemilik') }}" class="action-btn">
            <i class="bi bi-people"></i> Kelola Pemilik
        </a>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>