@extends('layouts.lte.perawat.main')

@section('title', 'Edit Rekam Medis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">Rekam Medis</a></li>
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
            <div class="col-md-12">
                <!-- Informasi Pasien (Read Only) -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informasi Pasien & Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th style="width: 150px;">No. Urut</th>
                                        <td><span class="badge text-bg-info">{{ $rekamMedis->no_urut ?? '-' }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pet</th>
                                        <td><strong>{{ $rekamMedis->nama_pet }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Pemilik</th>
                                        <td>{{ $rekamMedis->nama_pemilik }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <th style="width: 150px;">Dokter</th>
                                        <td>{{ $rekamMedis->nama_dokter ?? 'Tidak ada' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Periksa</th>
                                        <td>{{ $rekamMedis->waktu_daftar ? \Carbon\Carbon::parse($rekamMedis->waktu_daftar)->format('d/m/Y H:i') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Edit -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Rekam Medis</h3>
                    </div>
                    
                    <form action="{{ route('perawat.rekam-medis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Informasi:</strong> Perawat dapat mengubah data rekam medis (anamnesa, diagnosa, temuan klinis). Detail tindakan dikelola oleh dokter.
                            </div>

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
                                                  required>{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
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
                                                  required>{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
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
                                                  placeholder="Tuliskan temuan klinis dari pemeriksaan (opsional)">{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                                        @error('temuan_klinis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Opsional - Maksimal 1000 karakter</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update Rekam Medis
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

    .table-borderless th {
        font-weight: 600;
        color: #495057;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                            small.classList.remove('text-muted');
                        } else {
                            small.textContent = id === 'temuan_klinis' 
                                ? `Opsional - ${currentLength}/${maxLength} karakter`
                                : `${currentLength}/${maxLength} karakter`;
                            small.classList.remove('text-danger');
                            small.classList.add('text-muted');
                        }
                    }
                });

                textarea.dispatchEvent(new Event('input'));
            }
        });
    });
</script>
@endpush