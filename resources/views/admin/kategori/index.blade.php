<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori Layanan - Admin RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '🏥';
            position: absolute;
            font-size: 10rem;
            opacity: 0.1;
            right: -2rem;
            top: -2rem;
        }

        .page-header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            position: relative;
            z-index: 1;
        }

        .page-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Back Button */
        .btn-back {
            background: white;
            color: #003366;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: #ffd700;
            color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        /* Stats Card */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.08);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            border-left: 4px solid #ffd700;
        }

        .stats-icon {
            font-size: 2.5rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            border-radius: 12px;
        }

        .stats-content h3 {
            color: #003366;
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }

        .stats-content p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }

        /* Card */
        .data-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 51, 102, 0.08);
            overflow: hidden;
            border: none;
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 1.5rem 2rem;
            border-bottom: 3px solid #ffd700;
        }

        .card-header-custom h5 {
            color: #003366;
            font-weight: 700;
            margin: 0;
            font-size: 1.3rem;
        }

        /* Table Styling */
        .table-container {
            padding: 0;
            overflow-x: auto;
        }

        .custom-table {
            margin: 0;
            width: 100%;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        }

        .custom-table thead th {
            color: #003366;
            font-weight: 700;
            padding: 1rem 1.5rem;
            border: none;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.8px;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .custom-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
            transform: scale(1.01);
            box-shadow: 0 3px 10px rgba(0, 51, 102, 0.1);
        }

        .custom-table tbody td {
            padding: 1.2rem 1.5rem;
            color: #555;
            vertical-align: middle;
        }

        .custom-table tbody tr:last-child {
            border-bottom: none;
        }

        /* Number Badge */
        .number-badge {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #003366;
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* ID Badge */
        .id-badge {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #999;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin: 0;
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
            border-left: 5px solid #003366;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.08);
        }

        .info-box h6 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .info-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-box ul li {
            padding: 0.5rem 0;
            color: #555;
            line-height: 1.8;
            display: flex;
            align-items: start;
            gap: 0.5rem;
        }

        .info-box ul li::before {
            content: '•';
            color: #ffd700;
            font-weight: 700;
            font-size: 1.5rem;
            line-height: 1.2;
        }

        .info-box ul li strong {
            color: #003366;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .custom-table thead th,
            .custom-table tbody td {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }

            .stats-card {
                flex-direction: column;
                text-align: center;
            }

            .info-box {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1>🏥 Daftar Kategori Layanan</h1>
                    <p>Kategori tindakan medis veteriner di RSHP Universitas Airlangga</p>
                </div>
                <a href="/admin/dashboard" class="btn-back">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="stats-card">
            <div class="stats-icon">📊</div>
            <div class="stats-content">
                <h3>{{ count($kategoris) }}</h3>
                <p>Total Kategori Layanan Tersedia</p>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5>📋 Data Kategori Layanan</h5>
            </div>
            
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th style="width: 150px;">ID Kategori</th>
                            <th>Nama Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td>
                                <span class="number-badge">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="id-badge">{{ $kategori->idkategori }}</span>
                            </td>
                            <td>
                                <strong style="color: #003366;">{{ $kategori->nama_kategori }}</strong>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <p>Belum ada data kategori layanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-box">
            <h6>💡 Informasi Kategori Layanan</h6>
            <ul>
                <li>
                    <div>
                        <strong>Vaksinasi</strong> - Layanan vaksinasi untuk hewan peliharaan
                    </div>
                </li>
                <li>
                    <div>
                        <strong>Bedah/Operasi</strong> - Tindakan bedah dan operasi medis
                    </div>
                </li>
                <li>
                    <div>
                        <strong>Cairan Infus</strong> - Pemberian cairan infus dan terapi cairan
                    </div>
                </li>
                <li>
                    <div>
                        <strong>Terapi Injeksi</strong> - Pemberian obat melalui suntikan
                    </div>
                </li>
                <li>
                    <div>
                        <strong>Terapi Oral</strong> - Pemberian obat dalam bentuk oral
                    </div>
                </li>
            </ul>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-4">
            <p style="color: #999; font-size: 0.9rem;">
                © 2025 RSHP Universitas Airlangga - Admin Panel
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>