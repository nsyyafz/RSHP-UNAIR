@extends('layouts.lte.admin.main')

@section('title', 'Tambah Rekam Medis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rekam-medis.index') }}">Rekam Medis</a></li>
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
                        <h3 class="card-title">Form Tambah Rekam Medis</h3>
                    </div>
                    
                    <form action="{{ route('rekam-medis.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($temuDokters->count() == 0)
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Tidak ada temu dokter yang tersedia!</strong>
                                <p class="mb-0 mt-2">Belum ada temu dokter dengan status "Selesai" yang belum memiliki rekam medis. Silakan selesaikan temu dokter terlebih dahulu.</p>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Informasi:</strong> Pilih temu dokter yang telah selesai untuk membuat rekam medis. Detail tindakan dapat ditambahkan setelah rekam medis disimpan.
                            </div>
                            @endif

                            <!-- Pilih Temu Dokter -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-calendar-check"></i> Pilih Temu Dokter
                                    </h5>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="idreservasi_dokter" class="form-label">Temu Dokter <span class="text-danger">*</span></label>
                                        <select class="form-select @error('idreservasi_dokter') is-invalid @enderror" 
                                                id="idreservasi_dokter" 
                                                name="idreservasi_dokter"
                                                required
                                                {{ $temuDokters->count() == 0 ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Temu Dokter --</option>
                                            @foreach($temuDokters as $td)
                                            <option value="{{ $td->idreservasi_dokter }}" 
                                                    {{ old('idreservasi_dokter') == $td->idreservasi_dokter ? 'selected' : '' }}
                                                    data-pet="{{ $td->nama_pet }}"
                                                    data-jenis="{{ $td->jenis_pet }}"
                                                    data-pemilik="{{ $td->nama_pemilik }}"
                                                    data-dokter="{{ $td->nama_dokter }}">
                                                No. {{ $td->no_urut }} - {{ $td->nama_pet }} ({{ $td->jenis_pet == 'J' ? 'Jantan' : 'Betina' }}) | Pemilik: {{ $td->nama_pemilik }} | Dokter: {{ $td->nama_dokter }} | {{ \Carbon\Carbon::parse($td->waktu_daftar)->format('d/m/Y H:i') }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('idreservasi_dokter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Pilih temu dokter yang sudah selesai</small>
                                    </div>
                                </div>

                                <!-- Info Temu Dokter yang dipilih -->
                                <div class="col-md-12" id="info-temu-dokter" style="display: none;">
                                    <div class="alert alert-secondary">
                                        <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi Temu Dokter</h6>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Pet:</strong> <span id="info-pet">-</span></p>
                                                <p class="mb-1"><strong>Jenis Kelamin:</strong> <span id="info-jenis">-</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Pemilik:</strong> <span id="info-pemilik">-</span></p>
                                                <p class="mb-1"><strong>Dokter:</strong> <span id="info-dokter">-</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Rekam Medis -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-journal-medical"></i> Data Rekam Medis
                                    </h5>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="anamnesa" class="form-label">Anamnesa <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('anamnesa') is-invalid @enderror" 
                                                  id="anamnesa" 
                                                  name="anamnesa" 
                                                  rows="4"
                                                  placeholder="Tuliskan hasil anamnesa (riwayat penyakit, keluhan, gejala yang dialami)"
                                                  required
                                                  {{ $temuDokters->count() == 0 ? 'disabled' : '' }}>{{ old('anamnesa') }}</textarea>
                                        @error('anamnesa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="diagnosa" class="form-label">Diagnosa <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('diagnosa') is-invalid @enderror" 
                                                  id="diagnosa" 
                                                  name="diagnosa" 
                                                  rows="4"
                                                  placeholder="Tuliskan diagnosa penyakit atau kondisi kesehatan"
                                                  required
                                                  {{ $temuDokters->count() == 0 ? 'disabled' : '' }}>{{ old('diagnosa') }}</textarea>
                                        @error('diagnosa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Maksimal 1000 karakter</small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="temuan_klinis" class="form-label">Temuan Klinis</label>
                                        <textarea class="form-control @error('temuan_klinis') is-invalid @enderror" 
                                                  id="temuan_klinis" 
                                                  name="temuan_klinis" 
                                                  rows="4"
                                                  placeholder="Tuliskan temuan klinis dari pemeriksaan (opsional)"
                                                  {{ $temuDokters->count() == 0 ? 'disabled' : '' }}>{{ old('temuan_klinis') }}</textarea>
                                        @error('temuan_klinis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Opsional - Maksimal 1000 karakter</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-success">
                                <i class="bi bi-lightbulb"></i> <strong>Catatan:</strong> Setelah rekam medis disimpan, Anda dapat menambahkan detail tindakan/terapi pada halaman detail rekam medis.
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary" {{ $temuDokters->count() == 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-save"></i> Simpan Rekam Medis
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

    #info-temu-dokter {
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectTemuDokter = document.getElementById('idreservasi_dokter');
        const infoDiv = document.getElementById('info-temu-dokter');
        
        selectTemuDokter.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (this.value) {
                // Tampilkan info
                document.getElementById('info-pet').textContent = selectedOption.dataset.pet || '-';
                document.getElementById('info-jenis').textContent = selectedOption.dataset.jenis == 'J' ? 'Jantan' : 'Betina';
                document.getElementById('info-pemilik').textContent = selectedOption.dataset.pemilik || '-';
                document.getElementById('info-dokter').textContent = selectedOption.dataset.dokter || '-';
                
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        });

        // Trigger jika ada old value
        if (selectTemuDokter.value) {
            selectTemuDokter.dispatchEvent(new Event('change'));
        }

        // Character counter untuk textarea
        const textareas = ['anamnesa', 'diagnosa', 'temuan_klinis'];
        textareas.forEach(id => {
            const textarea = document.getElementById(id);
            if (textarea) {
                textarea.addEventListener('input', function() {
                    const maxLength = 1000;
                    const currentLength = this.value.length;
                    const small = this.nextElementSibling.nextElementSibling || this.nextElementSibling;
                    
                    if (small && small.tagName === 'SMALL') {
                        if (currentLength > maxLength) {
                            small.textContent = `Melebihi batas! ${currentLength}/${maxLength} karakter`;
                            small.classList.add('text-danger');
                        } else {
                            small.textContent = id === 'temuan_klinis' 
                                ? `Opsional - ${currentLength}/${maxLength} karakter`
                                : `${currentLength}/${maxLength} karakter`;
                            small.classList.remove('text-danger');
                        }
                    }
                });
            }
        });
    });
</script>
@endpush