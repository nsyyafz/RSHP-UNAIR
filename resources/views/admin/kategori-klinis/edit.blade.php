@extends('layouts.lte.main')
@section('title', 'Edit Kategori Klinis')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Edit Kategori Klinis</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori-klinis.index') }}">Kategori Klinis</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <div class="card-header"><h3 class="card-title">Form Edit Kategori Klinis</h3></div>
                    <form action="{{ route('kategori-klinis.update', $kategoriKlinis->idkategori_klinis) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i><strong>Informasi:</strong> ID tidak dapat diubah.
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ID Kategori Klinis</label>
                                <input type="text" class="form-control" value="{{ $kategoriKlinis->idkategori_klinis }}" disabled>
                                <small class="form-text text-muted">ID tidak dapat diubah</small>
                            </div>
                            <div class="mb-3">
                                <label for="nama_kategori_klinis" class="form-label">Nama Kategori Klinis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_kategori_klinis') is-invalid @enderror" 
                                       id="nama_kategori_klinis" name="nama_kategori_klinis" 
                                       value="{{ old('nama_kategori_klinis', $kategoriKlinis->nama_kategori_klinis) }}" required autofocus>
                                @error('nama_kategori_klinis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
                            <a href="{{ route('kategori-klinis.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection