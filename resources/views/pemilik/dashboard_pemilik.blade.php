@extends('layouts.lte.pemilik.main')

@section('title', 'Dashboard Pemilik')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Pemilik RSHP</h3>
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
                        <span class="info-box-text">Total Pet</span>
                        <span class="info-box-number">{{ $totalPet }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="bi bi-calendar-check-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Temu Dokter Menunggu</span>
                        <span class="info-box-number">{{ $temuMenunggu }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Rekam Medis</span>
                        <span class="info-box-number">{{ $totalRekamMedis }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">
                            <i class="bi bi-house-heart"></i> Selamat Datang, {{ Auth::user()->nama }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="mb-3">Ringkasan Aktivitas Anda</h5>
                                <p class="text-muted">Berikut adalah ringkasan data hewan peliharaan dan layanan kesehatan yang telah Anda gunakan di Rumah Sakit Hewan Peliharaan kami.</p>
                                
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="bi bi-heart-fill text-primary" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2 mb-0">{{ $totalPet }}</h4>
                                            <small class="text-muted">Hewan Peliharaan</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="bi bi-clock-history text-warning" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2 mb-0">{{ $temuMenunggu }}</h4>
                                            <small class="text-muted">Antrian Menunggu</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="bi bi-clipboard-data text-success" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2 mb-0">{{ $totalRekamMedis }}</h4>
                                            <small class="text-muted">Riwayat Medis</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center d-flex align-items-center justify-content-center">
                                <div>
                                    <i class="bi bi-hospital" style="font-size: 8rem; color: #e9ecef;"></i>
                                </div>
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
                        <h3 class="card-title">
                            <i class="bi bi-grid-3x3-gap"></i> Akses Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('pemilik.pet.index') }}" class="btn btn-outline-primary w-100 p-4">
                                    <i class="bi bi-heart-fill d-block" style="font-size: 2rem;"></i>
                                    <span class="d-block mt-2">Data Pet</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('pemilik.temu-dokter.index') }}" class="btn btn-outline-warning w-100 p-4">
                                    <i class="bi bi-calendar-check-fill d-block" style="font-size: 2rem;"></i>
                                    <span class="d-block mt-2">Temu Dokter</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('pemilik.rekam-medis.index') }}" class="btn btn-outline-success w-100 p-4">
                                    <i class="bi bi-clipboard-data-fill d-block" style="font-size: 2rem;"></i>
                                    <span class="d-block mt-2">Rekam Medis</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ route('pemilik.profile.index') }}" class="btn btn-outline-info w-100 p-4">
                                    <i class="bi bi-person-circle d-block" style="font-size: 2rem;"></i>
                                    <span class="d-block mt-2">Profil</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Penting -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Informasi Penting
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            <h5 class="alert-heading">
                                <i class="bi bi-lightbulb"></i> Tips Kesehatan Hewan Peliharaan
                            </h5>
                            <hr>
                            <ul class="mb-0">
                                <li>Pastikan hewan peliharaan Anda mendapatkan vaksinasi rutin</li>
                                <li>Berikan makanan bergizi dan air bersih setiap hari</li>
                                <li>Lakukan pemeriksaan kesehatan berkala minimal 6 bulan sekali</li>
                                <li>Jaga kebersihan kandang dan lingkungan hewan peliharaan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection