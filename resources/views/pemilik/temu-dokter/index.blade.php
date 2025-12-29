@extends('layouts.lte.pemilik.main')

@section('title', 'Jadwal Temu Dokter')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Jadwal Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Temu Dokter</li>
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
                        <h3 class="card-title">Riwayat Jadwal Temu Dokter</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari jadwal...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Tabs -->
                    <div class="card-body border-bottom pb-0">
                        <ul class="nav nav-pills mb-3" id="filterTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $filter === 'semua' ? 'active' : '' }}" 
                                   href="{{ route('pemilik.temu-dokter.index', ['filter' => 'semua']) }}">
                                    <i class="bi bi-list-ul"></i> Semua
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $filter === 'hari-ini' ? 'active' : '' }}" 
                                   href="{{ route('pemilik.temu-dokter.index', ['filter' => 'hari-ini']) }}">
                                    <i class="bi bi-calendar-day"></i> Hari Ini
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $filter === 'mendatang' ? 'active' : '' }}" 
                                   href="{{ route('pemilik.temu-dokter.index', ['filter' => 'mendatang']) }}">
                                    <i class="bi bi-calendar-check"></i> Mendatang
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $filter === 'selesai' ? 'active' : '' }}" 
                                   href="{{ route('pemilik.temu-dokter.index', ['filter' => 'selesai']) }}">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $filter === 'dibatalkan' ? 'active' : '' }}" 
                                   href="{{ route('pemilik.temu-dokter.index', ['filter' => 'dibatalkan']) }}">
                                    <i class="bi bi-x-circle"></i> Dibatalkan
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-0">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" id="temuDokterTable">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 100px;">No. Urut</th>
                                        <th style="width: 180px;">Waktu Daftar</th>
                                        <th style="width: 150px;">Nama Pet</th>
                                        <th style="width: 150px;">Dokter</th>
                                        <th style="width: 120px;" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($temuDokter as $index => $td)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-primary" style="font-size: 1.2rem;">
                                                {{ $td->no_urut }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($td->waktu_daftar)->format('d/m/Y') }}</strong><br>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($td->waktu_daftar)->format('H:i') }} WIB
                                            </small>
                                        </td>
                                        <td>
                                            <strong>{{ $td->nama_pet }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $td->nama_dokter ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($td->status == '0')
                                                <span class="badge text-bg-warning">
                                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                                </span>
                                            @elseif($td->status == '1')
                                                <span class="badge text-bg-success">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </span>
                                            @elseif($td->status == '2')
                                                <span class="badge text-bg-danger">
                                                    <i class="bi bi-x-circle"></i> Dibatalkan
                                                </span>
                                            @else
                                                <span class="badge text-bg-secondary">
                                                    <i class="bi bi-question-circle"></i> -
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-calendar-x" style="font-size: 3rem;"></i>
                                                <p class="mt-3">
                                                    @if($filter === 'hari-ini')
                                                        Tidak ada jadwal temu dokter hari ini
                                                    @elseif($filter === 'mendatang')
                                                        Tidak ada jadwal temu dokter mendatang
                                                    @elseif($filter === 'selesai')
                                                        Belum ada jadwal temu dokter yang selesai
                                                    @elseif($filter === 'dibatalkan')
                                                        Tidak ada jadwal temu dokter yang dibatalkan
                                                    @else
                                                        Belum ada jadwal temu dokter
                                                    @endif
                                                </p>
                                                <small>Hubungi resepsionis untuk membuat jadwal temu dokter</small>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($temuDokter->count() > 0)
                    <div class="card-footer clearfix">
                        <div class="float-start">
                            <small class="text-muted">
                                Filter: <strong>
                                    @if($filter === 'semua')
                                        Semua Jadwal
                                    @elseif($filter === 'hari-ini')
                                        Hari Ini
                                    @elseif($filter === 'mendatang')
                                        Mendatang
                                    @elseif($filter === 'selesai')
                                        Selesai
                                    @elseif($filter === 'dibatalkan')
                                        Dibatalkan
                                    @endif
                                </strong>
                            </small>
                        </div>
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ $temuDokter->count() }}</strong> jadwal</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Informasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><i class="bi bi-calendar-check text-success"></i> Jadwal temu dokter berisi riwayat kunjungan hewan peliharaan Anda ke dokter</p>
                        <p class="mb-2"><i class="bi bi-filter text-primary"></i> Gunakan <strong>Filter</strong> untuk melihat jadwal berdasarkan kategori tertentu</p>
                        <p class="mb-2"><i class="bi bi-person-badge text-info"></i> Untuk membuat jadwal baru, silakan hubungi <strong>Resepsionis</strong></p>
                        <p class="mb-0"><i class="bi bi-clock-history text-warning"></i> Pastikan datang tepat waktu sesuai nomor urut yang tertera</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Legend -->
        @if($temuDokter->count() > 0)
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-bookmark-check"></i> Keterangan Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-2">
                                <span class="badge text-bg-warning">
                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                </span>
                                <small class="ms-2">Jadwal belum dilaksanakan</small>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <span class="badge text-bg-success">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                                <small class="ms-2">Pemeriksaan telah selesai</small>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <span class="badge text-bg-danger">
                                    <i class="bi bi-x-circle"></i> Dibatalkan
                                </span>
                                <small class="ms-2">Jadwal telah dibatalkan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
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
    
    .nav-pills .nav-link {
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .nav-pills .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
    
    .nav-pills .nav-link.active {
        background-color: #007bff;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto close alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('temuDokterTable');
        const tbody = table.querySelector('tbody');
        const rows = tbody.getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            
            // Skip if only empty row exists
            if (rows.length === 1 && rows[0].cells.length === 1) {
                return;
            }
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
</script>
@endpush