@extends('layouts.lte.main')
@section('title', 'Edit Kode Tindakan')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Edit Kode Tindakan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kode-tindakan.index') }}">Kode Tindakan</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Form Edit Kode Tindakan Terapi</h3></div>
                    <form action="{{ route('kode-tindakan.update', $kodeTindakan->idkode_tindakan_terapi) }}" method="POST">
                        @csrf @method('PUT')
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
                                <label class="form-label">ID Kode Tindakan</label>
                                <input type="text" class="form-control" value="{{ $kodeTindakan->idkode_tindakan_terapi }}" disabled>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode Tindakan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                                               id="kode" name="kode" value="{{ old('kode', $kodeTindakan->kode) }}" required autofocus>
                                        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idkategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select @error('idkategori') is-invalid @enderror" 
                                                id="idkategori" name="idkategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach($kategoris as $kat)
                                            <option value="{{ $kat->idkategori }}" 
                                                    {{ old('idkategori', $kodeTindakan->idkategori) == $kat->idkategori ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('idkategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="idkategori_klinis" class="form-label">Kategori Klinis <span class="text-danger">*</span></label>
                                <select class="form-select @error('idkategori_klinis') is-invalid @enderror" 
                                        id="idkategori_klinis" name="idkategori_klinis" required>
                                    <option value="">-- Pilih Kategori Klinis --</option>
                                    @foreach($kategoriKlinis as $klinis)
                                    <option value="{{ $klinis->idkategori_klinis }}" 
                                            {{ old('idkategori_klinis', $kodeTindakan->idkategori_klinis) == $klinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $klinis->nama_kategori_klinis }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('idkategori_klinis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi Tindakan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" 
                                          id="deskripsi_tindakan_terapi" name="deskripsi_tindakan_terapi" 
                                          rows="4" required>{{ old('deskripsi_tindakan_terapi', $kodeTindakan->deskripsi_tindakan_terapi) }}</textarea>
                                @error('deskripsi_tindakan_terapi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
                            <a href="{{ route('kode-tindakan.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection