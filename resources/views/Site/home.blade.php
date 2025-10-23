<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Section - Modern Asymmetric Layout */
        .hero-section {
            background: linear-gradient(135deg, #003366 0%, #005599 70%, #ffd700 100%);
            color: white;
            padding: 5rem 0;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png') no-repeat center;
            background-size: contain;
            opacity: 0.1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
        }
        .hero-logo {
            width: 100px;
            height: 100px;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3));
        }
        .hero-section .btn-light {
            background-color: #fff;
            color: #003366;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            padding: 0.8rem 2rem;
        }
        .hero-section .btn-light:hover {
            background-color: #ffd700;
            color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255,215,0,0.4);
        }
        .hero-section .btn-outline-light {
            border: 2px solid #fff;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.8rem 2rem;
        }
        .hero-section .btn-outline-light:hover {
            background-color: #fff;
            color: #003366;
            transform: translateY(-2px);
        }

        /* Section Titles */
        .section-title {
            color: #003366;
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #003366, #ffd700);
            border-radius: 2px;
        }

        /* Service Cards - Grid Modern */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .service-card {
            transition: all 0.4s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,51,102,0.1);
            position: relative;
        }
        .service-card::before {
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
        .service-card:hover::before {
            transform: scaleX(1);
        }
        .service-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 35px rgba(0,51,102,0.25);
        }
        .service-card .card-body {
            padding: 2.5rem 2rem;
        }
        .icon-box {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            transition: transform 0.4s ease;
        }
        .service-card:hover .icon-box {
            transform: scale(1.2) rotate(5deg);
        }
        .service-card .card-title {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        /* Stats Section - Horizontal Cards */
        .stats-section {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            padding: 4rem 0;
            margin: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #ffd700;
            display: block;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            color: #fff;
            font-weight: 500;
            font-size: 1.1rem;
        }

        /* Registration Banner - Side by Side */
        .registration-banner {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 3rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0,51,102,0.1);
            position: relative;
            overflow: hidden;
        }
        .registration-banner::before {
            content: '📱';
            position: absolute;
            top: -20px;
            right: -20px;
            font-size: 200px;
            opacity: 0.05;
        }
        .registration-banner h3 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: linear-gradient(90deg, #003366, #005599);
            border: none;
            font-weight: 600;
            padding: 0.8rem 2.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,51,102,0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #005599, #003366);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,51,102,0.4);
        }

        /* News Cards - Masonry Style */
        .news-section {
            margin: 4rem 0;
        }
        .news-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,51,102,0.08);
            overflow: hidden;
            height: 100%;
        }
        .news-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #003366, #ffd700);
        }
        .news-card:hover {
            box-shadow: 0 15px 35px rgba(0,51,102,0.15);
            transform: translateY(-10px);
        }
        .news-card .card-body {
            padding: 2rem;
            padding-left: 2.5rem;
        }
        .news-card .card-title {
            color: #003366;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
        }
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        .badge.bg-primary {
            background: linear-gradient(90deg, #003366, #005599) !important;
        }
        .badge.bg-success {
            background: linear-gradient(90deg, #28a745, #20c997) !important;
        }
        .badge.bg-info {
            background: linear-gradient(90deg, #17a2b8, #138496) !important;
        }
        .badge.bg-warning {
            background: linear-gradient(90deg, #ffd700, #ffed4e) !important;
            color: #003366 !important;
        }
        .btn-outline-primary {
            color: #003366;
            border-color: #003366;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 20px;
            padding: 0.4rem 1.2rem;
        }
        .btn-outline-primary:hover {
            background-color: #003366;
            border-color: #003366;
            color: #fff;
            transform: translateX(5px);
        }

        /* Contact Info - Icon Cards */
        .contact-section {
            margin: 4rem 0;
        }
        .contact-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,51,102,0.1);
            overflow: hidden;
        }
        .contact-item {
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border-radius: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            margin: 1rem;
            box-shadow: 0 5px 15px rgba(0,51,102,0.05);
        }
        .contact-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,51,102,0.15);
        }
        .contact-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            display: inline-block;
        }
        .contact-item h5 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .contact-item p {
            color: #666;
            margin: 0;
            line-height: 1.8;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                padding: 3rem 0;
            }
            .hero-logo {
                width: 80px;
                height: 80px;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        @include('site.partials.navbar')
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-10 mx-auto text-center">
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png" alt="Logo Unair" class="hero-logo">
                        <h1 class="display-3 fw-bold mb-3">Rumah Sakit Hewan Pendidikan</h1>
                        <h2 class="h2 mb-4">Universitas Airlangga</h2>
                        <p class="lead mb-5 col-lg-8 mx-auto">
                            Memberikan pelayanan kesehatan hewan berkualitas tinggi dengan didukung oleh tenaga profesional dan fasilitas modern. Kami siap melayani hewan kesayangan Anda 24 jam.
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="#" class="btn btn-light btn-lg">📋 Pendaftaran Online</a>
                            <a href="#" class="btn btn-outline-light btn-lg">📞 Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Services -->
        <section class="container mb-5">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="services-grid">
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">🩺</div>
                        <h4 class="card-title">Pelayanan Medis</h4>
                        <p class="card-text">Pemeriksaan kesehatan, diagnosis, dan pengobatan oleh dokter hewan berpengalaman dengan fasilitas lengkap.</p>
                    </div>
                </div>
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">🏥</div>
                        <h4 class="card-title">Rawat Inap</h4>
                        <p class="card-text">Fasilitas rawat inap dengan perawatan intensif dan monitoring 24 jam untuk kesembuhan optimal hewan Anda.</p>
                    </div>
                </div>
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">💉</div>
                        <h4 class="card-title">Vaksinasi</h4>
                        <p class="card-text">Program vaksinasi lengkap untuk pencegahan penyakit menular seperti rabies, panleukopenia, dan lainnya.</p>
                    </div>
                </div>
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">🔬</div>
                        <h4 class="card-title">Laboratorium</h4>
                        <p class="card-text">Pemeriksaan laboratorium lengkap untuk diagnosis akurat dengan peralatan modern dan canggih.</p>
                    </div>
                </div>
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">🔪</div>
                        <h4 class="card-title">Bedah & Operasi</h4>
                        <p class="card-text">Tindakan pembedahan dengan teknologi anestesi modern dan tim medis yang profesional.</p>
                    </div>
                </div>
                <div class="card service-card">
                    <div class="card-body text-center">
                        <div class="icon-box">📷</div>
                        <h4 class="card-title">Radiologi & USG</h4>
                        <p class="card-text">Diagnostic imaging dengan X-Ray dan Ultrasonografi untuk pemeriksaan internal yang detail.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Layanan Emergency</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <span class="stat-number">10+</span>
                            <span class="stat-label">Dokter Hewan Profesional</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <span class="stat-number">3000+</span>
                            <span class="stat-label">Pasien per Tahun</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Komitmen Pelayanan</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Online Registration Banner -->
        <section class="container mb-5">
            <div class="card registration-banner">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <h3>Pendaftaran Online</h3>
                        <p class="mb-0">
                            Rumah Sakit Hewan Pendidikan Universitas Airlangga berinovasi untuk selalu meningkatkan kualitas pelayanan dengan fitur pendaftaran online yang mempermudah untuk mendaftarkan hewan kesayangan Anda.
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="#" class="btn btn-primary btn-lg">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest News -->
        <section class="container news-section">
            <h2 class="section-title">Berita Terkini</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card news-card">
                        <div class="card-body">
                            <span class="badge bg-primary mb-3">Terbaru</span>
                            <h5 class="card-title">Open Recruit Staf RSHP Unair</h5>
                            <p class="text-muted small mb-3">📅 1 Juni 2025</p>
                            <p class="card-text mb-3">RSHP Unair membuka kesempatan bagi kandidat terbaik untuk bergabung dalam tim kami.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card news-card">
                        <div class="card-body">
                            <span class="badge bg-success mb-3">Prestasi</span>
                            <h5 class="card-title">Tim Satu Sehat, Juara 1 Senam Bugar Airlangga</h5>
                            <p class="text-muted small mb-3">📅 4 November 2024</p>
                            <p class="card-text mb-3">Tim yang terdiri dari RSHP, RSGM, RSU Airlangga dan Pusat Layanan Kesehatan meraih juara 1.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card news-card">
                        <div class="card-body">
                            <span class="badge bg-info mb-3">Edukasi</span>
                            <h5 class="card-title">Seminar & Workshop Sitologi RSHP 2024</h5>
                            <p class="text-muted small mb-3">📅 27 Agustus 2024</p>
                            <p class="card-text mb-3">Acara berharga bagi para ahli, peneliti, dan praktisi di bidang sitologi untuk berbagi pengetahuan.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card news-card">
                        <div class="card-body">
                            <span class="badge bg-warning mb-3">Kegiatan</span>
                            <h5 class="card-title">RSHP Goes to Banyuwangi</h5>
                            <p class="text-muted small mb-3">📅 5 Agustus 2024</p>
                            <p class="card-text mb-3">Kegiatan kesehatan mental RSHP Unair dengan mengunjungi destinasi wisata di Banyuwangi.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya →</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary btn-lg">Lihat Semua Berita →</a>
            </div>
        </section>

        <!-- Contact Info -->
        <section class="container contact-section">
            <h2 class="section-title text-center">Informasi Kontak</h2>
            <div class="card contact-card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="contact-item">
                            <div class="contact-icon">📍</div>
                            <h5>Alamat</h5>
                            <p>Gedung RS Hewan Pendidikan<br>
                            Kampus C Universitas Airlangga<br>
                            Surabaya 60115, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-item">
                            <div class="contact-icon">📞</div>
                            <h5>Telepon</h5>
                            <p>(031) 5927832</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-item">
                            <div class="contact-icon">📧</div>
                            <h5>Email</h5>
                            <p>rshp@fkh.unair.ac.id</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('site.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>