@extends('layouts.lte.main')

@section('title', 'Daftar Pemilik')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pemilik</li>
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
                        <h3 class="card-title">Data Pemilik</h3>
                        <div class="card-tools">
                            <a href="{{ route('pemilik.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Pemilik
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
                                        <th>Nama Pemilik</th>
                                        <th style="width: 150px;">No. WhatsApp</th>
                                        <th>Alamat</th>
                                        <th style="width: 200px;">Email</th>
                                        <th style="width: 200px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pemiliks as $index => $pemilik)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-secondary">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <strong><i class="bi bi-person-fill text-primary"></i> {{ $pemilik->nama ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-success">
                                                <i class="bi bi-whatsapp"></i> {{ $pemilik->no_wa }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="bi bi-geo-alt text-danger"></i> {{ $pemilik->alamat }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope"></i> {{ $pemilik->email ?? '-' }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pemilik.edit', $pemilik->idpemilik) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('pemilik.destroy', $pemilik->idpemilik) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus data pemilik {{ $pemilik->nama ?? 'ini' }}?');">
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
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada data pemilik</p>
                                                <a href="{{ route('pemilik.create') }}" class="btn btn-primary btn-sm">
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
                    
                    @if($pemiliks->count() > 0)
                    <div class="card-footer clearfix">
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ $pemiliks->count() }}</strong> data</span>
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