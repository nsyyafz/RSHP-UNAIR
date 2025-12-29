@extends('layouts.lte.resepsionis.main')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Resepsionis RSHP</h3>
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
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-primary shadow-sm">
                        <i class="bi bi-heart-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pet</span>
                        <span class="info-box-number">{{ $jumlahPet }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pemilik</span>
                        <span class="info-box-number">{{ $jumlahPemilik }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="bi bi-calendar-check-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Antrian Hari Ini</span>
                        <span class="info-box-number">{{ $antrianHariIni }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon text-bg-danger shadow-sm">
                        <i class="bi bi-clock-history"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Antrian Pending</span>
                        <span class="info-box-number">{{ $antrianPending }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Antrian Hari Ini -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Antrian Temu Dokter Hari Ini</h3>
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
                                        <th style="width: 80px;">No. Urut</th>
                                        <th style="width: 120px;">Waktu</th>
                                        <th>Nama Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter</th>
                                        <th style="width: 120px;" class="text-center">Status</th>
                                        <th style="width: 150px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($antrianList as $antrian)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $antrian->no_urut }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($antrian->waktu_daftar)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td><strong>{{ $antrian->nama_pet }}</strong></td>
                                        <td>
                                            <span class="text-muted">{{ $antrian->nama_pemilik }}</span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $antrian->nama_dokter }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($antrian->status == 0)
                                                <span class="badge text-bg-warning">
                                                    <i class="bi bi-clock-history"></i> Pending
                                                </span>
                                            @elseif($antrian->status == 1)
                                                <span class="badge text-bg-success">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </span>
                                            @else
                                                <span class="badge text-bg-danger">
                                                    <i class="bi bi-x-circle"></i> Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('resepsionis.temu-dokter.edit', $antrian->idreservasi_dokter) }}" 
                                               class="btn btn-warning btn-sm"
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tidak ada antrian hari ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(count($antrianList) > 0)
                    <div class="card-footer clearfix">
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ count($antrianList) }}</strong> antrian</span>
                        </div>
                    </div>
                    @endif
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
                                        <i class="bi bi-heart-fill" style="font-size: 3rem; color: #0d6efd;"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ $jumlahPet }}</h4>
                                    <p class="text-muted">Total Pet</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-person-fill" style="font-size: 3rem; color: #198754;"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ $jumlahPemilik }}</h4>
                                    <p class="text-muted">Total Pemilik</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Rata-rata pet per pemilik:</span>
                            <span class="fw-bold fs-5">
                                @if($jumlahPemilik > 0)
                                    {{ number_format($jumlahPet / $jumlahPemilik, 1) }}
                                @else
                                    0
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Antrian</h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Antrian Hari Ini</span>
                                <span class="fw-bold">{{ $antrianHariIni }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>

                        <div class="progress-group mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Antrian Pending</span>
                                <span class="fw-bold">{{ $antrianPending }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 70%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Pet Terdaftar</span>
                                <span class="fw-bold">{{ $jumlahPet }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 90%"></div>
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
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-person-fill"></i> Pemilik
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-heart-fill"></i> Pet
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-app w-100">
                                    <i class="bi bi-calendar-check-fill"></i> Temu Dokter
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-app w-100">
                                    <i class="bi bi-person-plus-fill"></i> Tambah Pemilik
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-app w-100">
                                    <i class="bi bi-heart-fill"></i> Tambah Pet
                                </a>
                            </div>
                            <div class="col-md-2 col-6 mb-3">
                                <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-app w-100">
                                    <i class="bi bi-calendar-plus-fill"></i> Buat Jadwal
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