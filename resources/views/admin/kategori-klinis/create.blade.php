@extends('layouts.lte.admin.main')
@section('title', 'Tambah Kategori Klinis')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Kategori Klinis</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori-klinis.index') }}">Kategori Klinis</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Form Tambah Kategori Klinis</h3></div>
                    <form action="{{ route('kategori-klinis.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i><strong>Informasi:</strong> ID akan dibuat otomatis.
                            </div>
                            <div class="mb-3">
                                <label for="nama_kategori_klinis" class="form-label">Nama Kategori Klinis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_kategori_klinis') is-invalid @enderror" 
                                       id="nama_kategori_klinis" name="nama_kategori_klinis" 
                                       placeholder="Contoh: Rawat Inap, Rawat Jalan" value="{{ old('nama_kategori_klinis') }}" required autofocus>
                                @error('nama_kategori_klinis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('kategori-klinis.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
