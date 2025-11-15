@extends('layouts.lte.main')

@section('title', 'Tambah Jenis Hewan')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Jenis Hewan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jenis-hewan.index') }}">Jenis Hewan</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Jenis Hewan</h3>
                    </div>
                    
                    <form action="{{ route('jenis-hewan.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Info Alert -->
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Informasi:</strong> ID Jenis Hewan akan dibuat secara otomatis oleh sistem.
                            </div>

                            <!-- Nama Jenis Hewan -->
                            <div class="mb-3">
                                <label for="nama_jenis_hewan" class="form-label">
                                    Nama Jenis Hewan <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nama_jenis_hewan') is-invalid @enderror" 
                                    id="nama_jenis_hewan"
                                    name="nama_jenis_hewan" 
                                    placeholder="Contoh: Kucing, Anjing, Kelinci" 
                                    value="{{ old('nama_jenis_hewan') }}"
                                    required
                                    autofocus
                                >
                                @error('nama_jenis_hewan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Masukkan nama jenis hewan dengan jelas (minimal 3 karakter, maksimal 55 karakter)
                                </small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('jenis-hewan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .alert {
        border-radius: 0.375rem;
    }
</style>
@endpush