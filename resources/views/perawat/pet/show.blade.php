@extends('layouts.lte.perawat.main')

@section('title', 'Detail pet')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.pet.index') }}">pet</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <!-- Informasi pet -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <div class="profile-img-container">
                                <i class="bi bi-heart-pulse-fill" style="font-size: 5rem; color: #0d6efd;"></i>
                            </div>
                        </div>

                        <h3 class="profile-username text-center">{{ $pet->nama }}</h3>

                        <p class="text-muted text-center">
                            {{ $pet->nama_jenis_hewan ?? '-' }} - {{ $pet->nama_ras ?? '-' }}
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Jenis Kelamin</b>
                                <span class="float-end">
                                    @if($pet->jenis_kelamin == 'J')
                                        <span class="badge text-bg-primary">
                                            <i class="bi bi-gender-male"></i> Jantan
                                        </span>
                                    @else
                                        <span class="badge text-bg-pink" style="background-color: #e83e8c; color: white;">
                                            <i class="bi bi-gender-female"></i> Betina
                                        </span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Tanggal Lahir</b>
                                <span class="float-end">{{ \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Umur</b>
                                <span class="float-end">
                                    @php
                                        $tanggalLahir = \Carbon\Carbon::parse($pet->tanggal_lahir);
                                        $tahun = $tanggalLahir->age;
                                        $bulan = $tanggalLahir->diff(now())->m;
                                        
                                        if ($tahun > 0) {
                                            echo $tahun . ' tahun';
                                            if ($bulan > 0) echo ' ' . $bulan . ' bulan';
                                        } elseif ($bulan > 0) {
                                            echo $bulan . ' bulan';
                                        } else {
                                            echo $tanggalLahir->diff(now())->d . ' hari';
                                        }
                                    @endphp
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Warna/Tanda</b>
                                <span class="float-end">{{ $pet->warna_tanda ?? '-' }}</span>
                            </li>
                        </ul>

                        <a href="{{ route('perawat.pet.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Informasi Pemilik -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-person-fill"></i> Informasi Pemilik</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="bi bi-person me-2"></i> Nama Pemilik</strong>
                                <p class="text-muted mb-3">{{ $pet->nama_pemilik ?? '-' }}</p>

                                <strong><i class="bi bi-envelope me-2"></i> Email</strong>
                                <p class="text-muted mb-3">{{ $pet->email_pemilik ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-telephone me-2"></i> No. WhatsApp</strong>
                                <p class="text-muted mb-3">{{ $pet->no_wa ?? '-' }}</p>

                                <strong><i class="bi bi-geo-alt me-2"></i> Alamat</strong>
                                <p class="text-muted mb-3">{{ $pet->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Riwayat Rekam Medis -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-file-medical"></i> Riwayat Rekam Medis</h3>
                        <div class="card-tools">
                            <a href="{{ route('perawat.rekam-medis.create') }}?idpet={{ $pet->idpet }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($rekamMedis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 140px;">Tanggal</th>
                                        <th style="width: 150px;">Dokter</th>
                                        <th>Anamnesa</th>
                                        <th>Diagnosa</th>
                                        <th style="width: 100px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekamMedis as $index => $rm)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($rm->created_at)
                                                <strong>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</strong><br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($rm->created_at)->format('H:i') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <i class="bi bi-person-badge text-primary"></i>
                                            <small>{{ $rm->nama_dokter ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($rm->anamnesa ?? '-', 40) }}</small>
                                        </td>
                                        <td>
                                            <strong class="text-primary">{{ Str::limit($rm->diagnosa ?? '-', 40) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('perawat.rekam-medis.show', $rm->idrekam_medis) }}" 
                                            class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" 
                                            title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Belum ada riwayat rekam medis</p>
                        </div>
                        @endif
                    </div>
                    @if($rekamMedis->count() > 0)
                    <div class="card-footer">
                        <span class="text-muted">Total: <strong>{{ $rekamMedis->count() }}</strong> rekam medis</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-img-container {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .profile-img-container i {
        color: white !important;
    }
    
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endpush

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