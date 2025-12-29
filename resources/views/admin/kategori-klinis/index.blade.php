@extends('layouts.lte.admin.main')

@section('title', 'Daftar Kategori Klinis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Kategori Klinis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kategori Klinis</li>
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
                        <h3 class="card-title">Data Kategori Klinis</h3>
                        <div class="card-tools">
                            <a href="{{ route('kategori-klinis.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Kategori Klinis
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
                                        <th style="width: 80px;">ID</th>
                                        <th>Nama Kategori Klinis</th>
                                        <th style="width: 200px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kategoriKlinis as $item)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $item->idkategori_klinis }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $item->nama_kategori_klinis }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('kategori-klinis.edit', $item->idkategori_klinis) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('kategori-klinis.destroy', $item->idkategori_klinis) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus {{ $item->nama_kategori_klinis }}?');">
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
                                        <td colspan="3" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada data kategori klinis</p>
                                                <a href="{{ route('kategori-klinis.create') }}" class="btn btn-primary btn-sm">
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
                    
                    @if(count($kategoriKlinis) > 0)
                    <div class="card-footer clearfix">
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ count($kategoriKlinis) }}</strong> data</span>
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
    /* Custom styles untuk mempercantik tampilan */
    .small-box {
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
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
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto hide alerts after 5 seconds
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