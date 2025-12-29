@extends('layouts.lte.pemilik.main')

@section('title', 'Rekam Medis')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rekam Medis</li>
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
                        <h3 class="card-title">Riwayat Rekam Medis Hewan Peliharaan</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari rekam medis...">
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
                            <table class="table table-striped table-hover mb-0" id="rekamMedisTable">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 150px;">Tanggal Periksa</th>
                                        <th style="width: 130px;">Nama Pet</th>
                                        <th style="width: 130px;">Dokter</th>
                                        <th>Diagnosa</th>
                                        <th style="width: 100px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rekamMedis as $index => $rm)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</strong><br>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <strong>{{ $rm->nama_pet }}</strong><br>
                                            <small class="text-muted">
                                                @if($rm->jenis_pet == 'J')
                                                    <i class="bi bi-gender-male text-primary"></i> Jantan
                                                @else
                                                    <i class="bi bi-gender-female" style="color: #e83e8c;"></i> Betina
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $rm->nama_dokter ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($rm->diagnosa, 100) }}</small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pemilik.rekam-medis.show', $rm->idrekam_medis) }}" 
                                               class="btn btn-info btn-sm"
                                               data-bs-toggle="tooltip" 
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Belum ada riwayat rekam medis</p>
                                                <small>Rekam medis akan muncul setelah pemeriksaan dokter</small>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($rekamMedis->count() > 0)
                    <div class="card-footer clearfix">
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ $rekamMedis->count() }}</strong> rekam medis</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Card -->
        @if($rekamMedis->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Informasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><i class="bi bi-check-circle text-success"></i> Rekam medis berisi riwayat pemeriksaan kesehatan hewan peliharaan Anda</p>
                        <p class="mb-2"><i class="bi bi-eye text-primary"></i> Klik tombol <strong>Lihat Detail</strong> untuk melihat informasi lengkap</p>
                        <p class="mb-0"><i class="bi bi-shield-check text-info"></i> Data rekam medis bersifat rahasia dan hanya dapat diakses oleh Anda dan tenaga medis</p>
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
        const table = document.getElementById('rekamMedisTable');
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