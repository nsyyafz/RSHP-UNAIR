@extends('layouts.lte.resepsionis.main')
@section('title', 'Tambah Temu Dokter')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Tambah Temu Dokter</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.temu-dokter.index') }}">Temu Dokter</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
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
                    <div class="card-header"><h3 class="card-title">Form Tambah Temu Dokter</h3></div>
                    <form action="{{ route('resepsionis.temu-dokter.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i><strong>Informasi:</strong> ID reservasi akan dibuat otomatis oleh sistem.
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no_urut" class="form-label">Nomor Urut <span class="text-danger">*</span></label>
                                        <input type="number" 
                                               class="form-control @error('no_urut') is-invalid @enderror" 
                                               id="no_urut" 
                                               name="no_urut" 
                                               value="{{ old('no_urut') }}"
                                               min="1"
                                               placeholder="Masukkan nomor urut" 
                                               required>
                                        @error('no_urut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="form-text text-muted">Nomor urut antrean pasien</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="waktu_daftar" class="form-label">Waktu Daftar <span class="text-danger">*</span></label>
                                        <input type="datetime-local" 
                                               class="form-control @error('waktu_daftar') is-invalid @enderror" 
                                               id="waktu_daftar" 
                                               name="waktu_daftar" 
                                               value="{{ old('waktu_daftar', date('Y-m-d\TH:i')) }}"
                                               required>
                                        @error('waktu_daftar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="form-text text-muted">Tanggal dan waktu pendaftaran</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idpet" class="form-label">Pet <span class="text-danger">*</span></label>
                                        <select class="form-select @error('idpet') is-invalid @enderror" id="idpet" name="idpet" required>
                                            <option value="">-- Pilih Pet --</option>
                                            @foreach($pets as $pet)
                                            <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                                                {{ $pet->nama_pet }} - {{ $pet->jenis_kelamin }} ({{ $pet->nama_pemilik }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('idpet')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="form-text text-muted">Pilih hewan peliharaan yang akan diperiksa</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idrole_user" class="form-label">Dokter <span class="text-danger">*</span></label>
                                        <select class="form-select @error('idrole_user') is-invalid @enderror" id="idrole_user" name="idrole_user" required>
                                            <option value="">-- Pilih Dokter --</option>
                                            @foreach($dokters as $dokter)
                                            <option value="{{ $dokter->idrole_user }}" {{ old('idrole_user') == $dokter->idrole_user ? 'selected' : '' }}>
                                                {{ $dokter->nama_dokter }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('idrole_user')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="form-text text-muted">Pilih dokter yang akan memeriksa</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Selesai</option>
                                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="form-text text-muted">Status reservasi temu dokter</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Simpan</button>
                            <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection