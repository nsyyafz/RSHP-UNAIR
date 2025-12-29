@extends('layouts.lte.perawat.main')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Perawat RSHP</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-primary shadow-sm">
                        <i class="bi bi-heart-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pasien</span>
                        <span class="info-box-number">{{ $jumlahPasien }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Rekam Medis</span>
                        <span class="info-box-number">{{ $jumlahRekamMedis }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="bi bi-calendar-check-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jadwal Hari Ini</span>
                        <span class="info-box-number">{{ $jadwalHariIni }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekam Medis Terbaru -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rekam Medis Terbaru</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 120px;">Tanggal</th>
                                        <th>Nama Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter</th>
                                        <th>Diagnosa</th>
                                        <th style="width: 150px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rekamMedisList as $rekam)
                                    <tr>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i>
                                                {{ \Carbon\Carbon::parse($rekam->created_at)->format('d M Y') }}
                                            </small>
                                        </td>
                                        <td><strong>{{ $rekam->nama_pet }}</strong></td>
                                        <td>
                                            <span class="text-muted">{{ $rekam->nama_pemilik }}</span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $rekam->nama_dokter ?? 'Tidak ada' }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($rekam->diagnosa, 40) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('perawat.rekam-medis.show', $rekam->idrekam_medis) }}" 
                                            class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" 
                                            title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Belum ada rekam medis</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ringkasan Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-heart-pulse" style="font-size: 3rem; color: #0d6efd;"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ $jumlahPasien }}</h4>
                                    <p class="text-muted">Total Pasien</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-clipboard-data" style="font-size: 3rem; color: #198754;"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ $jumlahRekamMedis }}</h4>
                                    <p class="text-muted">Rekam Medis</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Jadwal hari ini:</span>
                            <span class="fw-bold fs-5">{{ $jadwalHariIni }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik</h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Pasien Terdaftar</span>
                                <span class="fw-bold">{{ $jumlahPasien }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Rekam Medis Dibuat</span>
                                <span class="fw-bold">{{ $jumlahRekamMedis }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 85%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Jadwal Hari Ini</span>
                                <span class="fw-bold">{{ $jadwalHariIni }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Akses Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('perawat.pet.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-heart-pulse-fill"></i> Data Pasien
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-app w-100">
                                    <i class="bi bi-file-earmark-plus-fill"></i> Buat Rekam
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-clipboard-data-fill"></i> Rekam Medis
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('perawat.profile.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-person-circle"></i> Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection