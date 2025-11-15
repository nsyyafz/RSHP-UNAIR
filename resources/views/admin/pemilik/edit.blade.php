@extends('layouts.lte.main')

@section('title', 'Edit Pemilik')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.index') }}">Pemilik</a></li>
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
                        <h3 class="card-title">Form Edit Pemilik</h3>
                    </div>
                    
                    <form action="{{ route('pemilik.update', $pemilik->idpemilik) }}" method="POST">
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

                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Info:</strong> Edit data pemilik akan mengupdate data user terkait.
                            </div>

                            <h5 class="mb-3 text-primary"><i class="bi bi-person-badge"></i> Data Akun</h5>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       placeholder="Masukkan nama lengkap" 
                                       value="{{ old('nama', $pemilik->nama) }}" 
                                       required 
                                       autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 3 karakter</small>
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
                                       placeholder="contoh@email.com" 
                                       value="{{ old('email', $pemilik->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Email harus unik dan valid</small>
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3 text-success"><i class="bi bi-person-lines-fill"></i> Data Pemilik</h5>

                            <!-- Nomor WhatsApp -->
                            <div class="mb-3">
                                <label for="no_wa" class="form-label">
                                    Nomor WhatsApp <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_wa') is-invalid @enderror" 
                                       id="no_wa" 
                                       name="no_wa" 
                                       placeholder="08123456789 atau 628123456789" 
                                       value="{{ old('no_wa', $pemilik->no_wa) }}" 
                                       required>
                                @error('no_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 10 digit, hanya angka. Format akan otomatis disesuaikan (0xxx → 62xxx).</small>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="4" 
                                          placeholder="Masukkan alamat lengkap"
                                          required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 10 karakter, maksimal 500 karakter</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                            <a href="{{ route('pemilik.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto format nomor WhatsApp
        const noWaInput = document.getElementById('no_wa');
        
        if (noWaInput) {
            noWaInput.addEventListener('input', function(e) {
                // Hanya izinkan angka
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
@endpush