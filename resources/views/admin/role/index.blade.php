@extends('layouts.lte.admin.main')

@section('title', 'Manajemen Role')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Manajemen Role</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manajemen Role</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data User & Role</h3>
                    </div>
                    
                    <div class="card-body p-0">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 130px;">ID User</th>
                                        <th style="width: 180px;">Nama User</th>
                                        <th style="width: 220px;">Email</th>
                                        <th style="width: 180px;">Role</th>
                                        <th style="width: 200px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                    @php
                                        // Role yang dilindungi (punya tabel sendiri)
                                        $protectedRoles = ['pemilik', 'dokter', 'perawat'];
                                        $isProtected = in_array(strtolower($user->nama_role ?? ''), $protectedRoles);
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-dark">{{ $user->iduser }}</span>
                                        </td>
                                        <td>
                                            <strong><i class="bi bi-person-fill text-primary"></i> {{ $user->nama }}</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope"></i> {{ $user->email }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($user->nama_role)
                                                @php
                                                    $roleLower = strtolower($user->nama_role);
                                                    $badgeClass = match($roleLower) {
                                                        'admin' => 'text-bg-danger',
                                                        'dokter' => 'text-bg-success',
                                                        'perawat' => 'text-bg-info',
                                                        'pemilik' => 'text-bg-primary',
                                                        'staff' => 'text-bg-warning',
                                                        default => 'text-bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    <i class="bi bi-shield-check"></i> {{ $user->nama_role }}
                                                </span>
                                                @if($isProtected)
                                                    <span class="badge text-bg-secondary" data-bs-toggle="tooltip" title="Role ini tidak dapat diubah karena memiliki tabel khusus">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge text-bg-secondary">
                                                    <i class="bi bi-person"></i> -
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($isProtected)
                                                <!-- Role yang dilindungi hanya bisa dilihat -->
                                                <div class="btn-group" role="group">
                                                    <span class="badge text-bg-secondary py-2 px-3" data-bs-toggle="tooltip" title="Role ini dikelola melalui menu {{ ucfirst($user->nama_role) }}">
                                                        <i class="bi bi-lock-fill me-1"></i> Dilindungi
                                                    </span>
                                                </div>
                                            @else
                                                <!-- Role yang tidak dilindungi bisa diedit/hapus -->
                                                <div class="btn-group" role="group">
                                                    @if($user->idrole_user)
                                                        <a href="{{ route('role.edit', $user->idrole_user) }}" 
                                                           class="btn btn-warning btn-sm"
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteModal{{ $user->iduser }}"
                                                                title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('role.create') }}?user={{ $user->iduser }}" 
                                                           class="btn btn-primary btn-sm"
                                                           data-bs-toggle="tooltip" 
                                                           title="Tambah Role">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- Modal Konfirmasi Hapus (hanya untuk role yang tidak dilindungi) -->
                                            @if(!$isProtected && $user->idrole_user)
                                            <div class="modal fade" id="deleteModal{{ $user->iduser }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->iduser }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $user->iduser }}">
                                                                <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-4">
                                                            <i class="bi bi-trash" style="font-size: 3rem; color: #dc3545;"></i>
                                                            <p class="mt-3 mb-2">Apakah Anda yakin ingin menghapus role:</p>
                                                            <h5 class="text-primary">{{ $user->nama_role }}</h5>
                                                            <p class="text-muted small">untuk user: <strong>{{ $user->nama }}</strong></p>
                                                            <div class="alert alert-warning mt-3" role="alert">
                                                                <i class="bi bi-info-circle"></i> Role akan dihapus dari sistem!
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="bi bi-x-circle"></i> Batal
                                                            </button>
                                                            <form action="{{ route('role.destroy', $user->idrole_user) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="bi bi-trash"></i> Ya, Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada data user</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if(count($users) > 0)
                    <div class="card-footer clearfix">
                        <div class="float-start">
                            <span class="text-muted">
                                <i class="bi bi-info-circle"></i> 
                                <small>Role <strong>Pemilik</strong>, <strong>Dokter</strong>, dan <strong>Perawat</strong> dikelola melalui menu masing-masing</small>
                            </span>
                        </div>
                        <div class="float-end">
                            <span class="text-muted">Total User: <strong>{{ count($users) }}</strong> | 
                            User dengan Role: <strong>{{ collect($users)->whereNotNull('nama_role')->count() }}</strong></span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .btn-group .btn {
        border-radius: 0.25rem;
        margin: 0 2px;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.35em 0.65em;
    }
    
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;
    }
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .alert {
        border-radius: 0.375rem;
    }

    .modal-content {
        border-radius: 0.5rem;
        border: none;
    }

    .modal-header.bg-danger {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .badge.text-bg-secondary.py-2 {
        cursor: help;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto close alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush