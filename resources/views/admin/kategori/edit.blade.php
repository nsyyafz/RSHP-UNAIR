@extends('layouts.lte.main')

@section('title', 'Edit Kategori')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Kategori</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                        <h3 class="card-title">Form Edit Kategori</h3>
                    </div>
                    
                    <form action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
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
                                <strong>Informasi:</strong> ID Kategori tidak dapat diubah untuk menjaga integritas data.
                            </div>

                            <!-- ID Kategori (Disabled) -->
                            <div class="mb-3">
                                <label for="idkategori" class="form-label">
                                    ID Kategori
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="idkategori"
                                    value="{{ $kategori->idkategori }}"
                                    disabled
                                >
                                <small class="form-text text-muted">
                                    ID tidak dapat diubah untuk menjaga integritas data
                                </small>
                            </div>

                            <!-- Nama Kategori -->
                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">
                                    Nama Kategori <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nama_kategori') is-invalid @enderror" 
                                    id="nama_kategori"
                                    name="nama_kategori" 
                                    placeholder="Contoh: Pemeriksaan, Vaksinasi, Operasi" 
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    required
                                    autofocus
                                >
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Perbarui nama kategori sesuai kebutuhan (minimal 3 karakter, maksimal 100 karakter)
                                </small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
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