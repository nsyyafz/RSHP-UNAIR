@extends('layouts.lte.perawat.main')

@section('title', 'Daftar Rekam Medis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Transaksi</li>
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
                        <h3 class="card-title">Data Rekam Medis</h3>
                        <div class="card-tools">
                            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                            </a>
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
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">No</th>
                                        <th style="width: 120px;">No. Urut</th>
                                        <th>Nama Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th>Diagnosa</th>
                                        <th style="width: 150px;">Tanggal Periksa</th>
                                        <th style="width: 200px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rekamMedis as $index => $rm)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-hash"></i> {{ $rm->no_urut ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong><i class="bi bi-heart-fill text-danger"></i> {{ $rm->nama_pet }}</strong>
                                        </td>
                                        <td>
                                            <i class="bi bi-person-fill text-primary"></i> {{ $rm->nama_pemilik }}
                                        </td>
                                        <td>
                                            <span class="badge text-bg-success">
                                                <i class="bi bi-person-badge-fill"></i> {{ $rm->nama_dokter ?? 'Tidak ada' }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($rm->diagnosa, 50) }}</small>
                                        </td>
                                        <td>
                                            <small><i class="bi bi-calendar-event"></i> {{ $rm->waktu_daftar ? \Carbon\Carbon::parse($rm->waktu_daftar)->format('d/m/Y H:i') : '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('perawat.rekam-medis.show', $rm->idrekam_medis) }}" 
                                                   class="btn btn-info btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('perawat.rekam-medis.edit', $rm->idrekam_medis) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('perawat.rekam-medis.destroy', $rm->idrekam_medis) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus rekam medis untuk pet {{ $rm->nama_pet }}? Data detail tindakan harus dihapus terlebih dahulu.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm"
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada data rekam medis</p>
                                                <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-plus-circle"></i> Tambah Data Pertama
                                                </a>
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
                            <span class="text-muted">Total: <strong>{{ $rekamMedis->count() }}</strong> data</span>
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
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