@extends('layouts.lte.pemilik.main')

@section('title', 'Detail Rekam Medis')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.rekam-medis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active">Detail</li>
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
            <!-- Informasi Pasien -->
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-heart-fill"></i> Informasi Pasien
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($rekamMedis->jenis_pet == 'J')
                                <i class="bi bi-gender-male" style="font-size: 4rem; color: #0d6efd;"></i>
                            @else
                                <i class="bi bi-gender-female" style="font-size: 4rem; color: #e83e8c;"></i>
                            @endif
                        </div>
                        
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 120px;">Nama</td>
                                <td>{{ $rekamMedis->nama_pet }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jenis/Ras</td>
                                <td>
                                    {{ $rekamMedis->nama_jenis_hewan ?? '-' }}<br>
                                    <small class="text-muted">{{ $rekamMedis->nama_ras ?? '-' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jenis Kelamin</td>
                                <td>
                                    @if($rekamMedis->jenis_pet == 'J')
                                        <span class="badge text-bg-primary">Jantan</span>
                                    @else
                                        <span class="badge text-bg-pink" style="background-color: #e83e8c; color: white;">Betina</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal Lahir</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($rekamMedis->tanggal_lahir)->format('d/m/Y') }}<br>
                                    <small class="text-muted">
                                        @php
                                            $tanggalLahir = \Carbon\Carbon::parse($rekamMedis->tanggal_lahir);
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
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Warna/Tanda</td>
                                <td>{{ $rekamMedis->warna_tanda ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Info Pemeriksaan -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-calendar-check"></i> Info Pemeriksaan
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td class="fw-bold" style="width: 120px;">Tanggal</td>
                                <td>{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dokter</td>
                                <td>
                                    <span class="badge text-bg-success">
                                        <i class="bi bi-person-badge"></i>
                                        {{ $rekamMedis->nama_dokter ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @if($rekamMedis->no_urut)
                            <tr>
                                <td class="fw-bold">No. Urut</td>
                                <td><span class="badge text-bg-primary">{{ $rekamMedis->no_urut }}</span></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <!-- Hasil Pemeriksaan -->
            <div class="col-md-8">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-clipboard-pulse"></i> Hasil Pemeriksaan
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Anamnesa -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="bi bi-chat-left-text"></i> Anamnesa
                            </h5>
                            <p class="text-justify">{{ $rekamMedis->anamnesa }}</p>
                        </div>

                        <!-- Temuan Klinis -->
                        @if($rekamMedis->temuan_klinis)
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="bi bi-search"></i> Temuan Klinis
                            </h5>
                            <p class="text-justify">{{ $rekamMedis->temuan_klinis }}</p>
                        </div>
                        @endif

                        <!-- Diagnosa -->
                        <div class="mb-4">
                            <h5 class="text-danger border-bottom pb-2">
                                <i class="bi bi-clipboard2-pulse"></i> Diagnosa
                            </h5>
                            <p class="text-justify">{{ $rekamMedis->diagnosa }}</p>
                        </div>

                        <!-- Detail Tindakan/Terapi -->
                        <div class="mb-3">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="bi bi-prescription2"></i> Tindakan & Terapi
                            </h5>
                            
                            @if($detailTindakan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60px;">No</th>
                                            <th style="width: 120px;">Kode</th>
                                            <th style="width: 200px;">Tindakan/Terapi</th>
                                            <th style="width: 150px;">Kategori</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detailTindakan as $index => $detail)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><span class="badge text-bg-secondary">{{ $detail->kode }}</span></td>
                                            <td>{{ $detail->deskripsi_tindakan_terapi }}</td>
                                            <td>
                                                <small class="text-muted">{{ $detail->nama_kategori }}</small><br>
                                                <small class="badge text-bg-info">{{ $detail->nama_kategori_klinis }}</small>
                                            </td>
                                            <td>{{ $detail->detail }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle"></i>
                                Belum ada detail tindakan atau terapi yang dicatat
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('pemilik.rekam-medis.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
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
    
    .text-justify {
        text-align: justify;
    }
    
    .table-sm td {
        padding: 0.5rem;
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