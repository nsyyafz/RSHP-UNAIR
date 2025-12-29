@extends('layouts.lte.perawat.main')

@section('title', 'Daftar Pasien')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Pasien</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pasien</li>
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
                        <h3 class="card-title">Data Pasien (Hewan Peliharaan)</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari pasien...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
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
                            <table class="table table-striped table-hover mb-0" id="petTable">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 110px;">Nama Hewan</th>
                                        <th style="width: 110px;">Pemilik</th>
                                        <th style="width: 160px;">Jenis/Ras</th>
                                        <th style="width: 110px;">JK</th>
                                        <th style="width: 140px;">Warna/Tanda</th>
                                        <th style="width: 120px;">Tgl lahir</th>
                                        <th style="width: 100px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pets as $index => $pet)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $pet->nama }}</strong>
                                        </td>
                                        <td>
                                            <i class="bi bi-person-fill text-primary"></i> 
                                            <small>{{ $pet->nama_pemilik ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ $pet->nama_jenis_hewan ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $pet->nama_ras ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($pet->jenis_kelamin == 'J')
                                                <span class="badge text-bg-primary">
                                                    <i class="bi bi-gender-male"></i> Jantan
                                                </span>
                                            @else
                                                <span class="badge text-bg-pink" style="background-color: #e83e8c; color: white;">
                                                    <i class="bi bi-gender-female"></i> Betina
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $pet->warna_tanda ?? '-' }}</td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}</strong><br>
                                            <small class="text-muted">
                                                @php
                                                    $tanggalLahir = \Carbon\Carbon::parse($pet->tanggal_lahir);
                                                    $tahun = $tanggalLahir->age;
                                                    $bulan = $tanggalLahir->diff(now())->m;
                                                    
                                                    if ($tahun > 0) {
                                                        echo $tahun . ' tahun';
                                                        if ($bulan > 0) echo ' ' . $bulan . ' bulan';
                                                    } elseif ($bulan > 0) {
                                                        echo $bulan . ' bulan';
                                                    } else {
                                                        echo $tanggalLahir->diff(now())->d . ' hari';
                                                    }
                                                @endphp
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('perawat.pet.show', $pet->idpet) }}" 
                                               class="btn btn-info btn-sm"
                                               data-bs-toggle="tooltip" 
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada data pasien</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($pets->count() > 0)
                    <div class="card-footer clearfix">
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ $pets->count() }}</strong> pasien</span>
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
        const table = document.getElementById('petTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            
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