@extends('layouts.lte.pemilik.main')

@section('title', 'Edit Profil')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Profil</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.profile.index') }}">Profil</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-pencil-square"></i> Form Edit Profil
                        </h3>
                    </div>
                    
                    <form action="{{ route('pemilik.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $pemilik->nama) }}"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $pemilik->email) }}"
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Email harus valid dan unik</small>
                            </div>

                            <!-- WhatsApp -->
                            <div class="mb-3">
                                <label for="no_wa" class="form-label">
                                    Nomor WhatsApp <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control @error('no_wa') is-invalid @enderror" 
                                           id="no_wa" 
                                           name="no_wa" 
                                           value="{{ old('no_wa', $pemilik->no_wa) }}"
                                           placeholder="081234567890"
                                           required>
                                    @error('no_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Hanya angka, minimal 10 digit. Contoh: 081234567890</small>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          placeholder="Masukkan alamat lengkap"
                                          required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 10 karakter, maksimal 100 karakter</small>
                            </div>

                            <hr>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Informasi:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Field yang bertanda <span class="text-danger">*</span> wajib diisi</li>
                                    <li>Pastikan data yang diinput sudah benar</li>
                                    <li>Nomor WhatsApp akan digunakan untuk komunikasi dengan rumah sakit</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('pemilik.profile.index') }}" class="btn btn-secondary">
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
    
    .form-label {
        font-weight: 600;
    }
    
    .required {
        color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto close alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert-danger');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Format nomor WhatsApp input (hanya angka)
        const noWaInput = document.getElementById('no_wa');
        noWaInput.addEventListener('input', function(e) {
            // Hapus semua karakter non-digit
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Validasi form sebelum submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const noWa = noWaInput.value;
            
            // Validasi nomor WA minimal 10 digit
            if (noWa.length < 10) {
                e.preventDefault();
                alert('Nomor WhatsApp minimal 10 digit!');
                noWaInput.focus();
                return false;
            }
            
            // Konfirmasi sebelum submit
            if (!confirm('Apakah Anda yakin ingin menyimpan perubahan profil?')) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush