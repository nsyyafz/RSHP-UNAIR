@extends('layouts.lte.perawat.main')

@section('title', 'Edit Profil Perawat')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Profil Perawat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.profile.index') }}">Profil</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card card-modern">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>Form Edit Profil
                        </h5>
                    </div>
                    
                    <form action="{{ route('perawat.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama', $perawat->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $perawat->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" 
                                       id="pendidikan" name="pendidikan" value="{{ old('pendidikan', $perawat->pendidikan) }}" 
                                       placeholder="Contoh: D3 Keperawatan, S1 Keperawatan" required>
                                @error('pendidikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" name="no_hp" value="{{ old('no_hp', $perawat->no_hp) }}" 
                                       placeholder="08xxxxxxxxxx" required>
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format akan otomatis diubah ke 62xxx</div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" required>{{ old('alamat', $perawat->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-save me-1"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('perawat.profile.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
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
    .card-modern {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 1.25rem;
    }

    .card-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.125);
        padding: 1.25rem;
    }

    .btn-info {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 153, 142, 0.4);
        color: white;
    }

    .btn-secondary {
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #11998e;
        box-shadow: 0 0 0 0.2rem rgba(17, 153, 142, 0.25);
    }
</style>
@endpush