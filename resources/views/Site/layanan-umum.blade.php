<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - RSHP</title>
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

        /* Service Cards */
        .service-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.1);
            margin-bottom: 3rem;
            transition: all 0.3s ease;
            background: #fff;
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.2);
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #003366, #ffd700);
        }
        .service-card .card-body {
            padding: 3rem;
        }
        .service-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .service-card h2 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .service-card .lead {
            color: #555;
            line-height: 1.9;
            margin-bottom: 1.5rem;
        }
        .service-card h5 {
            color: #005599;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        /* Sub Services Grid */
        .sub-service {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #ffd700;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 51, 102, 0.05);
            height: 100%;
        }
        .sub-service:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.15);
            border-left-color: #003366;
        }
        .sub-service strong {
            color: #003366;
            font-size: 1.1rem;
            display: block;
            margin-bottom: 0.5rem;
        }
        .sub-service .small {
            color: #666;
            line-height: 1.6;
        }

        /* Feature Boxes */
        .feature-box {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.05);
            height: 100%;
        }
        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 51, 102, 0.15);
        }
        .feature-box > div {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .feature-box strong {
            color: #003366;
            font-size: 1.2rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* Alert Boxes */
        .alert-info-custom {
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
            border-left: 5px solid #003366;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        .alert-info-custom strong {
            color: #003366;
            font-size: 1.1rem;
        }

        .alert-warning-custom {
            background: linear-gradient(135deg, #fff3cd 0%, #f8f9fa 100%);
            border-left: 5px solid #ffd700;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        .alert-warning-custom strong {
            color: #003366;
            font-size: 1.1rem;
        }

        /* Category Badge */
        .category-badge {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(0, 51, 102, 0.2);
        }

        /* CTA Card */
        .cta-card {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            border-radius: 25px;
            padding: 3.5rem;
            text-align: center;
            color: white;
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.2);
            position: relative;
            overflow: hidden;
        }
        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .cta-card h3 {
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        .cta-card p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        .cta-card .btn-light {
            background: #ffd700;
            color: #003366;
            border: none;
            font-weight: 700;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .cta-card .btn-light:hover {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3);
        }
        .cta-card .btn-outline-light {
            border: 2px solid #fff;
            color: #fff;
            font-weight: 700;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .cta-card .btn-outline-light:hover {
            background: #fff;
            color: #003366;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 3rem 0;
            }
            .service-card .card-body {
                padding: 2rem 1.5rem;
            }
            .cta-card {
                padding: 2.5rem 1.5rem;
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
                <h1 class="display-3 fw-bold mb-3">Layanan Kami</h1>
                <p class="lead col-lg-10 mx-auto">
                    Rumah Sakit Hewan Pendidikan Universitas Airlangga melakukan layanan kesehatan hewan yang komprehensif, baik atas kehendak klien atau rujukan dokter hewan praktisi
                </p>
            </div>
        </section>

        <div class="container">
            <!-- Poliklinik Section -->
            <section class="service-section">
                <div class="card service-card position-relative">
                    <div class="card-body">
                        <div class="service-icon">🏥</div>
                        <h2>Poliklinik (Rawat Jalan)</h2>
                        <p class="lead">
                            Poliklinik adalah layanan rawat jalan dimana pelayanan kesehatan hewan dilakukan tanpa pasien menginap. Poliklinik melayani tindakan observasi, diagnosis, pengobatan, rehabilitasi medik, serta pelayanan kesehatan lainnya seperti permintaan surat keterangan sehat.
                        </p>
                        <p>
                            Tindakan observasi dan diagnosis dapat diteguhkan dengan berbagai macam pemeriksaan seperti pemeriksaan sitologi, dermatologi, hematologi, radiologi, ultrasonografi, bahkan pemeriksaan elektrokardiografi. Kami juga bekerja sama dengan Fakultas Kedokteran Hewan Universitas Airlangga untuk pemeriksaan kultur bakteri, histopatologi, dan pemeriksaan lainnya.
                        </p>
                        
                        <h5>Layanan Poliklinik:</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Rawat Jalan</strong>
                                    <p class="mb-0 small">Pemeriksaan dan pengobatan umum</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Vaksinasi</strong>
                                    <p class="mb-0 small">Program vaksinasi lengkap</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Akupuntur</strong>
                                    <p class="mb-0 small">Terapi akupuntur untuk hewan</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Kemoterapi</strong>
                                    <p class="mb-0 small">Terapi untuk kasus kanker</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Fisioterapi</strong>
                                    <p class="mb-0 small">Rehabilitasi dan pemulihan</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-service">
                                    <strong>✓ Mandi Terapi</strong>
                                    <p class="mb-0 small">Perawatan kulit dan bulu</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert-info-custom">
                            <strong>🔬 Rapid Test Tersedia:</strong> Kami mempunyai rapid test untuk pemeriksaan cepat penyakit berbahaya pada kucing (panleukopenia, calicivirus, rhinotracheitis, FIP) dan anjing (parvovirus, canine distemper).
                        </div>
                    </div>
                </div>
            </section>

            <!-- Rawat Inap Section -->
            <section class="service-section">
                <div class="card service-card position-relative">
                    <div class="card-body">
                        <div class="service-icon">🛏️</div>
                        <h2>Rawat Inap</h2>
                        <p class="lead">
                            Rawat inap dilakukan pada pasien-pasien yang berat atau parah dan membutuhkan perawatan intensif. Pasien akan diobservasi dan mendapat perawatan intensif di bawah pengawasan dokter dan paramedis yang handal.
                        </p>
                        
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="feature-box">
                                    <div>🏥</div>
                                    <strong>Kandang Individual</strong>
                                    <p class="small mb-0">Fasilitas terpisah untuk setiap pasien</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-box">
                                    <div>👁️</div>
                                    <strong>Monitoring 24 Jam</strong>
                                    <p class="small mb-0">Pengawasan berkelanjutan</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-box">
                                    <div>💊</div>
                                    <strong>Perawatan Intensif</strong>
                                    <p class="small mb-0">Terapi dan pengobatan optimal</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert-warning-custom">
                            <strong>📋 Informed Consent:</strong> Sebelum rawat inap, klien wajib mengisi informed consent yang artinya klien telah diberi penjelasan detail tentang kondisi penyakit pasien dan menyetujui rencana terapi. Klien juga diberitahu biaya yang dibebankan untuk semua layanan.
                        </div>

                        <p class="mb-0 mt-3"><strong>💳 Metode Pembayaran:</strong> Tunai dan Kartu Debit Bank</p>
                    </div>
                </div>
            </section>

            <!-- Bedah Section -->
            <section class="service-section">
                <div class="card service-card position-relative">
                    <div class="card-body">
                        <div class="service-icon">🔪</div>
                        <h2>Layanan Bedah</h2>
                        <p class="lead">
                            Layanan operasi dengan peralatan modern dan tim bedah profesional untuk berbagai tindakan bedah minor dan mayor.
                        </p>

                        <div class="row g-4 mt-3">
                            <div class="col-md-6">
                                <div class="category-badge">Bedah Minor</div>
                                <ul class="list-unstyled">
                                    <li class="mb-2">✓ Jahit luka</li>
                                    <li class="mb-2">✓ Kastrasi</li>
                                    <li class="mb-2">✓ Othematoma</li>
                                    <li class="mb-2">✓ Scaling – root planning</li>
                                    <li class="mb-2">✓ Ekstraksi gigi</li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <div class="category-badge">Bedah Mayor</div>
                                <ul class="list-unstyled">
                                    <li class="mb-2">✓ Gastrotomi; Entrotomi; Enterektomi</li>
                                    <li class="mb-2">✓ Salivary mucocele</li>
                                    <li class="mb-2">✓ Ovariohisterektomi (OHE)</li>
                                    <li class="mb-2">✓ Sectio caesar</li>
                                    <li class="mb-2">✓ Piometra</li>
                                    <li class="mb-2">✓ Sistotomi; Urethrostomi</li>
                                    <li class="mb-2">✓ Fraktur tulang</li>
                                    <li class="mb-2">✓ Hernia (diafragmatika, perinealis, inguinalis)</li>
                                    <li class="mb-2">✓ Eksisi tumor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pemeriksaan Section -->
            <section class="service-section">
                <div class="card service-card position-relative">
                    <div class="card-body">
                        <div class="service-icon">🔬</div>
                        <h2>Pemeriksaan Diagnostik</h2>
                        <p class="lead">
                            Fasilitas pemeriksaan diagnostik lengkap dengan peralatan modern untuk diagnosis yang akurat.
                        </p>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>🔬 Pemeriksaan Sitologi</strong>
                                    <p class="mb-0 small">Analisis sel untuk diagnosis penyakit</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>🦠 Pemeriksaan Dermatologi</strong>
                                    <p class="mb-0 small">Diagnosis penyakit kulit</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>💉 Pemeriksaan Hematologi</strong>
                                    <p class="mb-0 small">Analisis darah lengkap</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>📷 Pemeriksaan Radiografi (X-Ray)</strong>
                                    <p class="mb-0 small">Pencitraan untuk diagnosis internal</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>🖥️ Pemeriksaan Ultrasonografi (USG)</strong>
                                    <p class="mb-0 small">Imaging organ dalam</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-service">
                                    <strong>❤️ Elektrokardiografi (EKG)</strong>
                                    <p class="mb-0 small">Pemeriksaan jantung</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert-info-custom">
                            <strong>🤝 Kerjasama FKH Unair:</strong> Untuk pemeriksaan khusus seperti kultur bakteri dan histopatologi, kami bekerja sama dengan Fakultas Kedokteran Hewan Universitas Airlangga.
                        </div>
                    </div>
                </div>
            </section>

            <!-- Grooming Section -->
            <section class="service-section">
                <div class="card service-card position-relative">
                    <div class="card-body">
                        <div class="service-icon">✂️</div>
                        <h2>Grooming</h2>
                        <p class="lead">
                            Selain layanan medis, Rumah Sakit Hewan Pendidikan Universitas Airlangga juga melayani grooming pada hewan kesayangan untuk menjaga kebersihan dan penampilan mereka.
                        </p>
                        <div class="row g-3 mt-3">
                            <div class="col-md-3">
                                <div class="feature-box">
                                    <div>🛁</div>
                                    <strong>Mandi</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="feature-box">
                                    <div>✂️</div>
                                    <strong>Potong Rambut</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="feature-box">
                                    <div>💅</div>
                                    <strong>Potong Kuku</strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="feature-box">
                                    <div>🧴</div>
                                    <strong>Perawatan Bulu</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="mb-5">
                <div class="cta-card">
                    <h3>Butuh Layanan Kami?</h3>
                    <p>Hubungi kami atau daftar online untuk mendapatkan pelayanan kesehatan terbaik untuk hewan kesayangan Anda</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#" class="btn btn-light btn-lg">📋 Daftar Online</a>
                        <a href="#" class="btn btn-outline-light btn-lg">📞 Hubungi Kami</a>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @include('site.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>