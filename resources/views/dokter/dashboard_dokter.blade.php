<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .hero-dokter {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 70%, #00d2ff 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-dokter::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0,210,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .hero-dokter h1 {
            font-weight: 700;
            font-size: 2.8rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            margin-bottom: 1rem;
        }

        .hero-dokter p {
            font-size: 1.2rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #2c3e50, #3498db);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(44, 62, 80, 0.2);
        }
        
        .stat-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
        }
        
        .stat-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-number {
            color: #3498db;
            font-weight: 800;
            font-size: 3rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-desc {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.1);
            text-align: center;
            margin-bottom: 3rem;
        }

        .welcome-card h3 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .welcome-card p {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

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
            opacity: 0;
        }
        
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .welcome-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        @media (max-width: 991.98px) {
            .hero-dokter h1 {
                font-size: 2rem;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('dokter.partials.navbar')

    <section class="hero-dokter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10 mx-auto text-center">
                    <h1>👨‍⚕️ Selamat Datang, dr. {{ session('user_name') ?? 'Dokter' }}</h1>
                    <p class="mb-0">
                        Kelola rekam medis dan tindakan terapi untuk hewan peliharaan dengan profesional
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="welcome-card">
            <h3>Dashboard Dokter Hewan</h3>
            <p>Akses menu di atas untuk melihat data rekam medis, tindakan terapi, dan informasi pasien</p>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-title">Total Rekam Medis</div>
                    <span class="stat-number">{{ $totalRekamMedis ?? 0 }}</span>
                    <div class="stat-desc">Semua rekam medis</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">🩺</div>
                    <div class="stat-title">Tindakan Hari Ini</div>
                    <span class="stat-number">{{ $tindakanHariIni ?? 0 }}</span>
                    <div class="stat-desc">Pemeriksaan hari ini</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">🐾</div>
                    <div class="stat-title">Pasien Aktif</div>
                    <span class="stat-number">{{ $pasienAktif ?? 0 }}</span>
                    <div class="stat-desc">Dalam perawatan</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon">💊</div>
                    <div class="stat-title">Terapi Berjalan</div>
                    <span class="stat-number">{{ $terapiBerjalan ?? 0 }}</span>
                    <div class="stat-desc">Sedang dijalankan</div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>