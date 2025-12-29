@extends('layouts.lte.pemilik.main')

@section('title', 'Profil Saya')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Profil Saya</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row">
            <!-- Profil Card -->
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="profile-user-img mb-3">
                                <i class="bi bi-person-circle" style="font-size: 8rem; color: #0d6efd;"></i>
                            </div>
                        </div>

                        <h3 class="profile-username text-center">{{ $pemilik->nama }}</h3>

                        <p class="text-muted text-center">Pemilik Hewan Peliharaan</p>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <b><i class="bi bi-envelope me-2"></i>Email</b>
                                <span class="float-end">{{ $pemilik->email }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="bi bi-whatsapp me-2"></i>WhatsApp</b>
                                <span class="float-end">{{ $pemilik->no_wa ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="bi bi-geo-alt me-2"></i>Alamat</b>
                                <span class="float-end text-end" style="max-width: 200px;">
                                    {{ $pemilik->alamat ?? '-' }}
                                </span>
                            </li>
                        </ul>

                        <a href="{{ route('pemilik.profile.edit') }}" class="btn btn-primary w-100">
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-bar-chart"></i> Statistik Aktivitas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon">
                                        <i class="bi bi-heart-fill"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Pet</span>
                                        <span class="info-box-number">{{ $totalPet }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon">
                                        <i class="bi bi-calendar-check-fill"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Temu Dokter</span>
                                        <span class="info-box-number">{{ $totalTemuDokter }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon">
                                        <i class="bi bi-clipboard-data-fill"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Rekam Medis</span>
                                        <span class="info-box-number">{{ $totalRekamMedis }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">
                            <i class="bi bi-info-circle"></i> Informasi Akun
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">
                                            <i class="bi bi-person-badge"></i> Data Pribadi
                                        </h6>
                                        <hr>
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td style="width: 100px;">Nama</td>
                                                <td>: <strong>{{ $pemilik->nama }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>: {{ $pemilik->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>WhatsApp</td>
                                                <td>: {{ $pemilik->no_wa ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-success">
                                            <i class="bi bi-house"></i> Alamat
                                        </h6>
                                        <hr>
                                        <p class="text-muted">
                                            {{ $pemilik->alamat ?? 'Alamat belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-lightning"></i> Akses Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-6 mb-2">
                                <a href="{{ route('pemilik.pet.index') }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-heart-fill"></i><br>
                                    <small>Data Pet</small>
                                </a>
                            </div>
                            <div class="col-md-4 col-6 mb-2">
                                <a href="{{ route('pemilik.temu-dokter.index') }}" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-calendar-check"></i><br>
                                    <small>Temu Dokter</small>
                                </a>
                            </div>
                            <div class="col-md-4 col-6 mb-2">
                                <a href="{{ route('pemilik.rekam-medis.index') }}" class="btn btn-outline-success w-100">
                                    <i class="bi bi-clipboard-data"></i><br>
                                    <small>Rekam Medis</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-user-img {
        border: 3px solid #e9ecef;
        border-radius: 50%;
        display: inline-block;
        padding: 10px;
    }
    
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 1rem;
    }
    
    .info-box {
        box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
        border-radius: 0.25rem;
        padding: 1rem;
        min-height: 100px;
        display: flex;
        margin-bottom: 1rem;
    }
    
    .info-box-icon {
        border-radius: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        width: 70px;
        background-color: rgba(255, 255, 255, 0.3);
    }
    
    .info-box-content {
        padding-left: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .info-box-text {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .info-box-number {
        display: block;
        font-weight: 700;
        font-size: 1.5rem;
    }
</style>
@endpush

@push('scripts')
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
    });
</script>
@endpush