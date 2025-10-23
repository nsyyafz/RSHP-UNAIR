<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi, Misi, dan Tujuan - RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Hero Header */
        .page-header {
            background: linear-gradient(135deg, #003366 0%, #005599 70%, #ffd700 100%);
            color: white;
            padding: 5rem 0;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png') no-repeat center;
            background-size: contain;
            opacity: 0.1;
        }

        /* Section Cards */
        .vision-card, .mission-card, .goals-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.1);
            margin-bottom: 3rem;
            transition: all 0.3s ease;
        }
        .vision-card:hover, .mission-card:hover, .goals-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.2);
        }

        /* Card Headers */
        .card-header-custom {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            color: white;
            padding: 2rem;
            position: relative;
        }
        .card-header-custom h2 {
            margin: 0;
            font-weight: 700;
            font-size: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .card-header-custom .icon {
            font-size: 3rem;
        }

        /* Vision Content */
        .vision-content {
            padding: 2.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        }
        .vision-content p {
            font-size: 1.15rem;
            line-height: 2;
            color: #333;
        }

        /* Mission Items */
        .mission-list {
            padding: 2rem;
        }
        .mission-item {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 15px;
            border-left: 5px solid #ffd700;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 51, 102, 0.05);
        }
        .mission-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.15);
            border-left-color: #003366;
        }
        .mission-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #003366, #005599);
            color: #ffd700;
            font-weight: 800;
            font-size: 1.3rem;
            border-radius: 50%;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        .mission-text {
            flex: 1;
            color: #333;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Goals Section */
        .goals-grid {
            padding: 2rem;
        }
        .goal-card {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            color: white;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .goal-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .goal-card:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #005599 0%, #003366 100%);
        }
        .goal-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: block;
        }
        .goal-text {
            font-size: 1.1rem;
            line-height: 1.8;
            position: relative;
            z-index: 1;
        }

        /* Contact Card */
        .contact-card {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            color: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.2);
        }
        .contact-card h5 {
            color: #ffd700;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .contact-info {
            font-size: 1.05rem;
            line-height: 2;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 3rem 0;
            }
            .card-header-custom h2 {
                font-size: 1.5rem;
            }
            .mission-item {
                flex-direction: column;
                text-align: center;
            }
            .mission-number {
                margin: 0 auto 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        @include('site.partials.navbar')
    </header>

    <main>
        <!-- Page Header -->
        <section class="page-header">
            <div class="container text-center position-relative">
                <h1 class="display-3 fw-bold mb-3">Visi, Misi & Tujuan</h1>
                <p class="lead col-lg-8 mx-auto">
                    Rumah Sakit Hewan Pendidikan Universitas Airlangga dalam melaksanakan tugas dan fungsinya
                </p>
            </div>
        </section>

        <div class="container">
            <!-- VISI -->
            <div class="vision-card">
                <div class="card-header-custom">
                    <h2>
                        <span class="icon">🎯</span>
                        VISI
                    </h2>
                </div>
                <div class="vision-content">
                    <p>
                        Menjadi <strong>Rumah Sakit Hewan Pendidikan terkemuka</strong> di tingkat nasional dan internasional dalam pemberian pelayanan paripurna, pendidikan, dan penelitian di bidang kesehatan hewan, yang <strong>unggul dan mandiri</strong> serta bermartabat berdasarkan moral, agama, etika dengan tetap berorientasi pada kesejahteraan masyarakat.
                    </p>
                </div>
            </div>

            <!-- MISI -->
            <div class="mission-card">
                <div class="card-header-custom">
                    <h2>
                        <span class="icon">🚀</span>
                        MISI
                    </h2>
                </div>
                <div class="mission-list">
                    <div class="mission-item d-flex align-items-start">
                        <div class="mission-number">1</div>
                        <p class="mission-text">
                            Menyelenggarakan fungsi pelayanan terintegrasi, bermutu dan mengutamakan keselamatan dan kesehatan pasien (klien).
                        </p>
                    </div>

                    <div class="mission-item d-flex align-items-start">
                        <div class="mission-number">2</div>
                        <p class="mission-text">
                            Menyelenggarakan pendidikan dan pelatihan terintegrasi bidang kedokteran hewan dan kesehatan lainnya untuk menghasilkan lulusan atau tenaga kesehatan yang kompeten di bidangnya.
                        </p>
                    </div>

                    <div class="mission-item d-flex align-items-start">
                        <div class="mission-number">3</div>
                        <p class="mission-text">
                            Melakukan penelitian terintegrasi berbasis pada keunggulan bidang kedokteran hewan dan kesehatan lainnya yang berorientasi pada produk inovasi.
                        </p>
                    </div>

                    <div class="mission-item d-flex align-items-start">
                        <div class="mission-number">4</div>
                        <p class="mission-text">
                            Menjadi pusat rujukan pelayanan kedokteran hewan dan kesehatan lain yang unggul.
                        </p>
                    </div>

                    <div class="mission-item d-flex align-items-start">
                        <div class="mission-number">5</div>
                        <p class="mission-text">
                            Mengembangkan manajemen rumah sakit hewan yang produktif, efisien, bermutu, dan berbasis kinerja.
                        </p>
                    </div>
                </div>
            </div>

            <!-- TUJUAN -->
            <div class="goals-card">
                <div class="card-header-custom">
                    <h2>
                        <span class="icon">🏆</span>
                        TUJUAN
                    </h2>
                </div>
                <div class="goals-grid">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="goal-card">
                                <span class="goal-icon">🔬</span>
                                <p class="goal-text">
                                    Menjadi Rumah Sakit Hewan yang <strong>adaptif, kreatif dan proaktif</strong> terhadap tuntutan perkembangan ilmu pengetahuan dan teknologi di bidang pengobatan kesehatan hewan.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="goal-card">
                                <span class="goal-icon">💎</span>
                                <p class="goal-text">
                                    Menjadi Rumah Sakit Hewan <strong>mandiri</strong> yang bertatakelola baik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="contact-card mb-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5>📍 Rumah Sakit Hewan Pendidikan</h5>
                        <div class="contact-info">
                            <p class="mb-2"><strong>Gedung RS Hewan Pendidikan</strong></p>
                            <p class="mb-2">Kampus C Universitas Airlangga</p>
                            <p class="mb-0">Surabaya 60115, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="contact-info">
                            <p class="mb-2">📧 rshp@fkh.unair.ac.id</p>
                            <p class="mb-0">📞 (031) 5927832</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('site.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>