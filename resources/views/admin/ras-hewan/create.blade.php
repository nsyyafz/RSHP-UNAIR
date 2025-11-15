@extends('layouts.lte.main')
@section('title', 'Tambah Ras Hewan')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Ras Hewan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ras-hewan.index') }}">Ras Hewan</a></li>
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
                    <div class="card-header"><h3 class="card-title">Form Tambah Ras Hewan</h3></div>
                    <form action="{{ route('ras-hewan.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label for="idjenis_hewan" class="form-label">Jenis Hewan <span class="text-danger">*</span></label>
                                <select class="form-select @error('idjenis_hewan') is-invalid @enderror" 
                                        id="idjenis_hewan" name="idjenis_hewan" required>
                                    <option value="">-- Pilih Jenis Hewan --</option>
                                    @foreach($jenisHewans as $jenis)
                                    <option value="{{ $jenis->idjenis_hewan }}" {{ old('idjenis_hewan') == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis_hewan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('idjenis_hewan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="nama_ras" class="form-label">Nama Ras <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ras') is-invalid @enderror" 
                                       id="nama_ras" name="nama_ras" placeholder="Contoh: Persian, Golden Retriever" 
                                       value="{{ old('nama_ras') }}" required autofocus>
                                @error('nama_ras')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('ras-hewan.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection