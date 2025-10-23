<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pet - Admin RSHP</title>
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
            content: '🐾';
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

        .data-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 51, 102, 0.08);
            overflow: hidden;
            border: none;
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

        .pet-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            margin-right: 10px;
        }

        .gender-badge {
            font-size: 1.3rem;
            margin-right: 0.3rem;
        }

        .badge-pemilik {
            background: linear-gradient(135deg, #e91e63, #f06292);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .badge-ras {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

        .badge-jenis {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-block;
        }

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

        .info-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #ffd700;
            padding: 1.2rem;
            border-radius: 10px;
            margin-top: 1.5rem;
        }

        .info-box small {
            color: #555;
            line-height: 1.6;
        }

        .info-box strong {
            color: #003366;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .custom-table thead th,
            .custom-table tbody td {
                padding: 0.8rem;
                font-size: 0.85rem;
            }

            .stats-card {
                flex-direction: column;
                text-align: center;
            }

            .pet-avatar {
                width: 35px;
                height: 35px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1>🐾 Daftar Hewan Peliharaan (Pet)</h1>
                    <p>Data lengkap hewan peliharaan terdaftar di RSHP Universitas Airlangga</p>
                </div>
                <a href="/admin/dashboard" class="btn-back">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon">📊</div>
            <div class="stats-content">
                <h3>{{ $pets->count() }}</h3>
                <p>Total Hewan Peliharaan Terdaftar</p>
            </div>
        </div>

        <div class="data-card">
            <div class="card-header-custom">
                <h5>📋 Data Pet</h5>
            </div>
            
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 20%;">Nama Pet</th>
                            <th style="width: 110px;">Tgl Lahir</th>
                            <th style="width: 15%;">Warna/Tanda</th>
                            <th style="width: 100px;">Gender</th>
                            <th style="width: 15%;">Pemilik</th>
                            <th style="width: 12%;">Ras</th>
                            <th style="width: 13%;">Jenis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $index => $pet)
                        <tr>
                            <td>
                                <span class="number-badge">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="pet-avatar">
                                        @if($pet->jenisHewan && str_contains(strtolower($pet->jenisHewan->nama_jenis_hewan ?? ''), 'anjing'))
                                            🐕
                                        @elseif($pet->jenisHewan && str_contains(strtolower($pet->jenisHewan->nama_jenis_hewan ?? ''), 'kucing'))
                                            🐈
                                        @else
                                            🐾
                                        @endif
                                    </div>
                                    <strong style="color: #003366;">{{ $pet->nama }}</strong>
                                </div>
                            </td>
                            <td>
                                @if($pet->tanggal_lahir)
                                    {{ date('d-m-Y', strtotime($pet->tanggal_lahir)) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $pet->warna_tanda ?? '-' }}</td>
                            <td>
                                <span class="gender-badge">
                                    @if(strtoupper($pet->jenis_kelamin) == 'P')
                                        ♀️
                                    @elseif(strtoupper($pet->jenis_kelamin) == 'L')
                                        ♂️
                                    @else
                                        ❓
                                    @endif
                                </span>
                                <small style="color: #666;">
                                    {{ strtoupper($pet->jenis_kelamin) == 'P' ? 'Betina' : (strtoupper($pet->jenis_kelamin) == 'L' ? 'Jantan' : '-') }}
                                </small>
                            </td>
                            <td>
                                @if($pet->pemilik && $pet->pemilik->user)
                                    <span class="badge-pemilik">
                                        {{ $pet->pemilik->user->nama }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pet->rasHewan)
                                    <span class="badge-ras">
                                        {{ $pet->rasHewan->nama_ras }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pet->jenisHewan)
                                    <span class="badge-jenis">
                                        {{ $pet->jenisHewan->nama_jenis_hewan }}
                                    </span>
                                @elseif($pet->rasHewan && $pet->rasHewan->jenisHewan)
                                    <span class="badge-jenis">
                                        {{ $pet->rasHewan->jenisHewan->nama_jenis_hewan }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <p>Belum ada data pet</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="info-box">
                <small>
                    <strong>Keterangan Gender:</strong> ♂️ Jantan (L) | ♀️ Betina (P)<br>
                    <strong>Info:</strong> Data pet mencakup informasi lengkap hewan peliharaan beserta pemilik, ras, dan jenis hewan.
                </small>
            </div>
        </div>

        <div class="text-center mt-4">
            <p style="color: #999; font-size: 0.9rem;">
                © 2025 RSHP Universitas Airlangga - Admin Panel
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>