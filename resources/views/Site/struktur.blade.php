<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - RSHP</title>
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

        /* Organization Chart Section */
        .org-chart-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 51, 102, 0.1);
            margin-bottom: 3rem;
        }
        .org-chart-section h2 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        .org-structure-img {
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.15);
            transition: all 0.3s ease;
            border: 5px solid #ffd700;
        }
        .org-structure-img:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 51, 102, 0.25);
        }

        /* Information Cards */
        .info-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }
        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.15);
        }
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #003366, #ffd700);
        }
        .info-card .card-body {
            padding: 2.5rem;
            padding-left: 3rem;
        }
        .info-card .card-title {
            color: #003366;
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .info-card .card-title span {
            font-size: 2rem;
        }
        .info-card ul {
            list-style: none;
            padding: 0;
        }
        .info-card ul li {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(0, 51, 102, 0.1);
            color: #555;
            line-height: 1.8;
        }
        .info-card ul li:last-child {
            border-bottom: none;
        }
        .info-card ul li strong {
            color: #003366;
            display: inline-block;
            min-width: 140px;
        }

        /* Alert Info Box */
        .info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
            border-left: 5px solid #003366;
            border-radius: 15px;
            padding: 2rem;
            margin: 3rem 0;
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.08);
            display: flex;
            align-items: start;
        }
        .info-box-icon {
            font-size: 3rem;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }
        .info-box h5 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .info-box p {
            color: #555;
            line-height: 1.8;
            margin: 0;
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
        .cta-card .btn {
            background: #ffd700;
            color: #003366;
            border: none;
            font-weight: 700;
            padding: 0.8rem 2.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .cta-card .btn:hover {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3);
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 3rem 0;
            }
            .org-chart-section {
                padding: 2rem 1.5rem;
            }
            .info-box {
                flex-direction: column;
                text-align: center;
            }
            .info-box-icon {
                margin: 0 auto 1rem;
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
                <h1 class="display-3 fw-bold mb-3">Struktur Organisasi</h1>
                <p class="lead col-lg-8 mx-auto">
                    Rumah Sakit Hewan Pendidikan Universitas Airlangga
                </p>
            </div>
        </section>

        <div class="container">
            <!-- Organization Chart -->
            <section class="org-chart-section">
                <h2>📊 Struktur Organisasi Lengkap</h2>
                <div class="text-center">
                    <img src="https://rshp.unair.ac.id/wp-content/uploads/2022/08/Struktur-Pimpinan-Unair-lambang-baru_page-0001.jpg" 
                         alt="Struktur Organisasi RSHP Lengkap" 
                         class="img-fluid org-structure-img">
                </div>
            </section>

            <!-- Information Cards -->
            <section class="mb-5">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span>👥</span>
                                    Struktur Pimpinan
                                </h5>
                                <p class="mb-3">Struktur pimpinan RSHP terdiri dari:</p>
                                <ul>
                                    <li>
                                        <strong>Direktur:</strong> Memimpin dan mengkoordinasi seluruh kegiatan
                                    </li>
                                    <li>
                                        <strong>Wakil Direktur 1:</strong> Bidang Pelayanan Medis, Pendidikan dan Penelitian
                                    </li>
                                    <li>
                                        <strong>Wakil Direktur 2:</strong> Bidang SDM, Sarana Prasarana dan Keuangan
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <span>🎯</span>
                                    Fungsi dan Tanggung Jawab
                                </h5>
                                <p class="mb-3">Setiap bagian memiliki peran penting:</p>
                                <ul>
                                    <li>
                                        <strong>Pelayanan Medis:</strong> Mengelola layanan kesehatan hewan
                                    </li>
                                    <li>
                                        <strong>Pendidikan:</strong> Menyelenggarakan program pendidikan profesi
                                    </li>
                                    <li>
                                        <strong>Penelitian:</strong> Mengembangkan riset di bidang kedokteran hewan
                                    </li>
                                    <li>
                                        <strong>Manajemen:</strong> Mengelola SDM, fasilitas, dan keuangan
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Info Box -->
            <div class="info-box">
                <span class="info-box-icon">ℹ️</span>
                <div>
                    <h5>Informasi Struktur Organisasi</h5>
                    <p>
                        Struktur organisasi RSHP dirancang untuk memberikan pelayanan optimal dengan pembagian tugas dan tanggung jawab yang jelas. Setiap bagian bekerja secara sinergis untuk mencapai visi dan misi RSHP sebagai rumah sakit hewan pendidikan terkemuka.
                    </p>
                </div>
            </div>

            <!-- CTA Section -->
            <section class="mb-5">
                <div class="cta-card">
                    <h3>Ingin Mengetahui Lebih Lanjut?</h3>
                    <p>Hubungi kami untuk informasi lebih detail tentang struktur organisasi dan layanan RSHP</p>
                    <a href="#" class="btn btn-lg">📞 Hubungi Kami</a>
                </div>
            </section>
        </div>
    </main>

    @include('site.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>