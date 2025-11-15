@extends('layouts.lte.main')
@section('title', 'Edit Ras Hewan')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Edit Ras Hewan</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ras-hewan.index') }}">Ras Hewan</a></li>
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
                    <div class="card-header"><h3 class="card-title">Form Edit Ras Hewan</h3></div>
                    <form action="{{ route('ras-hewan.update', $rasHewan->idras_hewan) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">ID Ras Hewan</label>
                                <input type="text" class="form-control" value="{{ $rasHewan->idras_hewan }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="idjenis_hewan" class="form-label">Jenis Hewan <span class="text-danger">*</span></label>
                                <select class="form-select @error('idjenis_hewan') is-invalid @enderror" 
                                        id="idjenis_hewan" name="idjenis_hewan" required>
                                    <option value="">-- Pilih Jenis Hewan --</option>
                                    @foreach($jenisHewans as $jenis)
                                    <option value="{{ $jenis->idjenis_hewan }}" 
                                            {{ old('idjenis_hewan', $rasHewan->idjenis_hewan) == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis_hewan }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('idjenis_hewan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="nama_ras" class="form-label">Nama Ras <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_ras') is-invalid @enderror" 
                                       id="nama_ras" name="nama_ras" value="{{ old('nama_ras', $rasHewan->nama_ras) }}" required autofocus>
                                @error('nama_ras')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan Perubahan</button>
                            <a href="{{ route('ras-hewan.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection