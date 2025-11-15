@extends('layouts.lte.main')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard RSHP</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row - Info boxes-->
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
                            <i class="bi bi-clipboard2-pulse-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rekam Medis</span>
                            <span class="info-box-number">{{ $jumlahRekam }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon text-bg-danger shadow-sm">
                            <i class="bi bi-people-fill"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total User</span>
                            <span class="info-box-number">{{ $jumlahUser }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row - Master Data Statistics-->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Master Data</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <i class="bi bi-list-ul" style="font-size: 2rem; color: #0d6efd;"></i>
                                        <h5 class="fw-bold mb-0 mt-2">{{ $jumlahJenis }}</h5>
                                        <span class="text-uppercase">Jenis Hewan</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <i class="bi bi-tags-fill" style="font-size: 2rem; color: #198754;"></i>
                                        <h5 class="fw-bold mb-0 mt-2">{{ $jumlahRas }}</h5>
                                        <span class="text-uppercase">Ras Hewan</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center border-end">
                                        <i class="bi bi-journal-medical" style="font-size: 2rem; color: #ffc107;"></i>
                                        <h5 class="fw-bold mb-0 mt-2">{{ $jumlahTindakan }}</h5>
                                        <span class="text-uppercase">Kode Tindakan</span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-center">
                                        <i class="bi bi-shield-fill" style="font-size: 2rem; color: #dc3545;"></i>
                                        <h5 class="fw-bold mb-0 mt-2">{{ $jumlahRole }}</h5>
                                        <span class="text-uppercase">Role</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row - Quick Stats-->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ringkasan Data Hewan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <i class="bi bi-heart-fill" style="font-size: 3rem; color: #0d6efd;"></i>
                                        </div>
                                        <h4 class="fw-bold mb-0">{{ $jumlahPet }}</h4>
                                        <p class="text-muted">Total Pet Terdaftar</p>
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
                            <h3 class="card-title">Ringkasan Sistem</h3>
                        </div>
                        <div class="card-body">
                            <div class="progress-group mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Rekam Medis</span>
                                    <span class="fw-bold">{{ $jumlahRekam }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>

                            <div class="progress-group mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Jenis Hewan Tersedia</span>
                                    <span class="fw-bold">{{ $jumlahJenis }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 80%"></div>
                                </div>
                            </div>

                            <div class="progress-group mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ras Hewan Terdaftar</span>
                                    <span class="fw-bold">{{ $jumlahRas }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 90%"></div>
                                </div>
                            </div>

                            <div class="progress-group">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>User Aktif</span>
                                    <span class="fw-bold">{{ $jumlahUser }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-danger" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row - Quick Access-->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Akses Cepat</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <a href="#" class="btn btn-app w-100">
                                        <i class="bi bi-heart-fill"></i> Pet
                                    </a>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <a href="#" class="btn btn-app w-100">
                                        <i class="bi bi-person-fill"></i> Pemilik
                                    </a>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <a href="#" class="btn btn-app w-100">
                                        <i class="bi bi-clipboard2-pulse-fill"></i> Rekam Medis
                                    </a>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <a href="#" class="btn btn-app w-100">
                                        <i class="bi bi-box-seam-fill"></i> Master Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection