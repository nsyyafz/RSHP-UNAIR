@extends('layouts.lte.resepsionis.main')

@section('title', 'Edit Data Pet')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Pet</a></li>
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
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-pencil-square"></i> Form Edit Pet
                        </h3>
                    </div>
                    
                    <form action="{{ route('resepsionis.pet.update', $pet->idpet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <!-- Nama Pet -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="bi bi-heart-fill"></i> Nama Pet <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $pet->nama) }}"
                                       placeholder="Contoh: Fluffy"
                                       maxlength="100"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pemilik -->
                            <div class="mb-3">
                                <label for="idpemilik" class="form-label">
                                    <i class="bi bi-person-fill"></i> Pemilik <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('idpemilik') is-invalid @enderror" 
                                        id="idpemilik" 
                                        name="idpemilik" 
                                        required>
                                    <option value="">-- Pilih Pemilik --</option>
                                    @foreach($pemiliks as $pemilik)
                                        <option value="{{ $pemilik->idpemilik }}" 
                                                {{ old('idpemilik', $pet->idpemilik) == $pemilik->idpemilik ? 'selected' : '' }}>
                                            {{ $pemilik->nama_user }} - {{ $pemilik->no_wa }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idpemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Pilih pemilik dari hewan peliharaan</div>
                            </div>

                            <div class="row">
                                <!-- Jenis Hewan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_hewan" class="form-label">
                                            <i class="bi bi-tag-fill"></i> Jenis Hewan <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('jenis_hewan') is-invalid @enderror" 
                                                id="jenis_hewan">
                                            <option value="">-- Pilih Jenis Hewan --</option>
                                            @foreach($jenisHewans as $jenis)
                                                <option value="{{ $jenis->idjenis_hewan }}">
                                                    {{ $jenis->nama_jenis_hewan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-text">Pilih jenis hewan terlebih dahulu</div>
                                    </div>
                                </div>

                                <!-- Ras Hewan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="idras_hewan" class="form-label">
                                            <i class="bi bi-bookmark-fill"></i> Ras Hewan <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('idras_hewan') is-invalid @enderror" 
                                                id="idras_hewan" 
                                                name="idras_hewan" 
                                                required>
                                            <option value="">-- Pilih Ras Hewan --</option>
                                            @foreach($rasHewans as $ras)
                                                <option value="{{ $ras->idras_hewan }}" 
                                                        data-jenis="{{ $ras->idjenis_hewan }}"
                                                        {{ old('idras_hewan', $pet->idras_hewan) == $ras->idras_hewan ? 'selected' : '' }}>
                                                    {{ $ras->nama_ras }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('idras_hewan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">
                                            <i class="bi bi-gender-ambiguous"></i> Jenis Kelamin <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                                id="jenis_kelamin" 
                                                name="jenis_kelamin" 
                                                required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Jantan" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'J' ? 'selected' : '' }}>
                                                Jantan
                                            </option>
                                            <option value="Betina" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'B' ? 'selected' : '' }}>
                                                Betina
                                            </option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">
                                            <i class="bi bi-calendar-event"></i> Tanggal Lahir <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               id="tanggal_lahir" 
                                               name="tanggal_lahir" 
                                               value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}"
                                               max="{{ date('Y-m-d') }}"
                                               required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Warna/Tanda Khusus -->
                            <div class="mb-3">
                                <label for="warna_tanda" class="form-label">
                                    <i class="bi bi-palette-fill"></i> Warna/Tanda Khusus <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('warna_tanda') is-invalid @enderror" 
                                          id="warna_tanda" 
                                          name="warna_tanda" 
                                          rows="3"
                                          maxlength="45"
                                          placeholder="Contoh: Coklat dengan bercak putih di dada"
                                          required>{{ old('warna_tanda', $pet->warna_tanda) }}</textarea>
                                @error('warna_tanda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maksimal 45 karakter</div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Perubahan
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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;
    }
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .alert {
        border-radius: 0.375rem;
    }
    
    .form-label {
        font-weight: 500;
    }
    
    .text-danger {
        font-weight: bold;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 38px;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto close alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Initialize Select2 untuk Pemilik
        $('#idpemilik').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Pemilik',
            allowClear: true
        });

        // Filter Ras berdasarkan Jenis Hewan
        const jenisSelect = document.getElementById('jenis_hewan');
        const rasSelect = document.getElementById('idras_hewan');
        const allRasOptions = Array.from(rasSelect.options);
        
        // Get selected ras to determine jenis
        const selectedRas = rasSelect.value;
        if (selectedRas) {
            const selectedOption = rasSelect.querySelector(`option[value="${selectedRas}"]`);
            if (selectedOption) {
                const jenisId = selectedOption.getAttribute('data-jenis');
                jenisSelect.value = jenisId;
            }
        }
        
        jenisSelect.addEventListener('change', function() {
            const selectedJenis = this.value;
            
            // Reset ras select
            rasSelect.innerHTML = '<option value="">-- Pilih Ras Hewan --</option>';
            
            if (selectedJenis) {
                // Filter dan tambahkan ras sesuai jenis yang dipilih
                allRasOptions.forEach(option => {
                    if (option.value && option.getAttribute('data-jenis') === selectedJenis) {
                        rasSelect.appendChild(option.cloneNode(true));
                    }
                });
            } else {
                // Jika tidak ada jenis dipilih, tampilkan semua ras
                allRasOptions.forEach(option => {
                    if (option.value) {
                        rasSelect.appendChild(option.cloneNode(true));
                    }
                });
            }
        });

        // Validasi form sebelum submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const idpemilik = document.getElementById('idpemilik').value;
            const idrasHewan = document.getElementById('idras_hewan').value;
            const jenisKelamin = document.getElementById('jenis_kelamin').value;
            const tanggalLahir = document.getElementById('tanggal_lahir').value;
            const warnaTanda = document.getElementById('warna_tanda').value.trim();
            
            if (!nama || !idpemilik || !idrasHewan || !jenisKelamin || !tanggalLahir || !warnaTanda) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
                return false;
            }
            
            // Validasi panjang nama
            if (nama.length < 2) {
                e.preventDefault();
                alert('Nama pet minimal 2 karakter!');
                return false;
            }
            
            // Validasi tanggal lahir tidak boleh lebih dari hari ini
            const today = new Date();
            const birthDate = new Date(tanggalLahir);
            if (birthDate > today) {
                e.preventDefault();
                alert('Tanggal lahir tidak boleh lebih dari hari ini!');
                return false;
            }
        });
    });
</script>
@endpush