<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
            content: '👥';
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

        /* Card */
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-header-custom h5 {
            color: #003366;
            font-weight: 700;
            margin: 0;
            font-size: 1.3rem;
        }

        /* Add Button */
        .btn-add {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #005599, #003366);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.3);
            color: white;
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn-edit {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: #003366;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #ffb300, #ffc107);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
            color: #003366;
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c82333, #dc3545);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
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

        /* Role Badge */
        .role-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0.2rem;
        }

        .role-admin {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .role-dokter {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .role-staff {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
        }

        .role-default {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            color: white;
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

        /* Stats Cards */
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

        /* Alert Messages */
        .alert-custom {
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 5px 20px rgba(0, 51, 102, 0.08);
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error-custom {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
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
                padding: 0.8rem;
                font-size: 0.85rem;
            }

            .stats-card {
                flex-direction: column;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
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
                    <h1>👥 Manajemen User</h1>
                    <p>Kelola data pengguna sistem RSHP Universitas Airlangga</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Berhasil!</strong><br>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error-custom">
            <i class="bi bi-exclamation-circle-fill" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Error!</strong><br>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Stats Card -->
        <div class="stats-card">
            <div class="stats-icon">📊</div>
            <div class="stats-content">
                <h3>{{ $users->count() }}</h3>
                <p>Total User Terdaftar</p>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="data-card">
            <div class="card-header-custom">
                <h5><i class="bi bi-list-ul"></i> Daftar User</h5>
                <a href="{{ route('user.create') }}" class="btn-add">
                    <i class="bi bi-plus-circle"></i> Tambah User
                </a>
            </div>
            
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 130px;">ID User</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 25%;">Email</th>
                            <th>Role</th>
                            <th style="width: 200px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td>
                                <span class="number-badge">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="id-badge">{{ $user->iduser }}</span>
                            </td>
                            <td>
                                <strong style="color: #003366;">{{ $user->nama }}</strong>
                            </td>
                            <td>
                                <i class="bi bi-envelope" style="color: #005599;"></i> {{ $user->email }}
                            </td>
                            <td>
                                @if($user->role->count() > 0)
                                    @foreach($user->role as $role)
                                        <span class="role-badge {{ 
                                            strtolower($role->nama_role) == 'admin' ? 'role-admin' : 
                                            (strtolower($role->nama_role) == 'dokter' ? 'role-dokter' : 
                                            (strtolower($role->nama_role) == 'staff' ? 'role-staff' : 'role-default'))
                                        }}">
                                            {{ $role->nama_role }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="role-badge role-default">Tidak Ada Role</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons justify-content-center">
                                    <a href="{{ route('user.edit', $user->iduser) }}" class="btn-action btn-edit">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button type="button" class="btn-action btn-delete" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $user->iduser }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="deleteModal{{ $user->iduser }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->iduser }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 15px; border: none; overflow: hidden;">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border: none;">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $user->iduser }}">
                                                    <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="padding: 2rem; text-align: center;">
                                                <div style="font-size: 3rem; margin-bottom: 1rem;">🗑️</div>
                                                <p style="font-size: 1.1rem; color: #555; margin-bottom: 0.5rem;">
                                                    Apakah Anda yakin ingin menghapus user:
                                                </p>
                                                <p style="font-size: 1.3rem; font-weight: 700; color: #003366; margin-bottom: 0.5rem;">
                                                    "{{ $user->nama }}"
                                                </p>
                                                <p style="font-size: 0.95rem; color: #666; margin-bottom: 1rem;">
                                                    Email: {{ $user->email }}
                                                </p>
                                                <p style="font-size: 0.9rem; color: #dc3545;">
                                                    <i class="bi bi-info-circle"></i> Data yang dihapus tidak dapat dikembalikan!
                                                </p>
                                            </div>
                                            <div class="modal-footer" style="border: none; padding: 1rem 2rem; background: #f8f9fa;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px; padding: 0.6rem 1.5rem;">
                                                    <i class="bi bi-x-circle"></i> Batal
                                                </button>
                                                <form action="{{ route('user.destroy', $user->iduser) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; padding: 0.6rem 1.5rem; background: linear-gradient(135deg, #dc3545, #c82333); border: none;">
                                                        <i class="bi bi-trash"></i> Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <p>Belum ada data user. Klik tombol "Tambah User" untuk menambahkan data.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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