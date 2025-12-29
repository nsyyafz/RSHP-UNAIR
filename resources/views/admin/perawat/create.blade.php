@extends('layouts.lte.admin.main')

@section('title', 'Tambah Perawat')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Perawat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.index') }}">Perawat</a></li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Perawat</h3>
                    </div>
                    
                    <form action="{{ route('perawat.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <!-- Informasi Akun -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-person-circle"></i> Informasi Akun
                                    </h5>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" 
                                               name="nama" 
                                               value="{{ old('nama') }}"
                                               placeholder="Masukkan nama lengkap perawat"
                                               required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}"
                                               placeholder="contoh@email.com"
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password"
                                               placeholder="Minimal 6 karakter"
                                               required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation"
                                               placeholder="Ulangi password"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Perawat -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-clipboard2-pulse"></i> Informasi Perawat
                                    </h5>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('pendidikan') is-invalid @enderror" 
                                               id="pendidikan" 
                                               name="pendidikan" 
                                               value="{{ old('pendidikan') }}"
                                               placeholder="Contoh: D3 Keperawatan, S1 Kesehatan, dll"
                                               required>
                                        @error('pendidikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                                id="jenis_kelamin" 
                                                name="jenis_kelamin"
                                                required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('no_hp') is-invalid @enderror" 
                                               id="no_hp" 
                                               name="no_hp" 
                                               value="{{ old('no_hp') }}"
                                               placeholder="08xxxxxxxxxx"
                                               required>
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: 08xxxxxxxxxx (hanya angka)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                  id="alamat" 
                                                  name="alamat" 
                                                  rows="3"
                                                  placeholder="Masukkan alamat lengkap"
                                                  required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('perawat.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data
                                </button>
                            </div>
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
        margin-bottom: 1rem;
    }
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .border-bottom {
        border-color: #dee2e6 !important;
    }
    
    h5 i {
        margin-right: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format nomor HP otomatis
        const noHpInput = document.getElementById('no_hp');
        if (noHpInput) {
            noHpInput.addEventListener('input', function(e) {
                // Hapus semua karakter selain angka
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
@endpush