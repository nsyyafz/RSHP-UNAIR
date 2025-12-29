@extends('layouts.lte.perawat.main')

@section('title', 'Detail Rekam Medis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">Rekam Medis</a></li>
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Informasi Pasien & Dokter -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-heart-fill text-danger"></i> Informasi Pasien</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 150px;">No. Urut</th>
                                <td><span class="badge text-bg-info">{{ $rekamMedis->no_urut ?? '-' }}</span></td>
                            </tr>
                            <tr>
                                <th>Nama Pet</th>
                                <td><strong>{{ $rekamMedis->nama_pet }}</strong></td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>{{ $rekamMedis->nama_jenis_hewan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Ras</th>
                                <td>{{ $rekamMedis->nama_ras ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $rekamMedis->jenis_pet == 'J' ? 'Jantan' : 'Betina' }}</td>
                            </tr>
                            <tr>
                                <th>Warna/Tanda</th>
                                <td>{{ $rekamMedis->warna_tanda ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Pemilik</th>
                                <td>{{ $rekamMedis->nama_pemilik }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $rekamMedis->alamat_pemilik }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $rekamMedis->telp_pemilik }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-person-badge-fill text-success"></i> Informasi Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 150px;">Dokter Pemeriksa</th>
                                <td><strong>{{ $rekamMedis->nama_dokter ?? 'Tidak ada' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Tanggal Periksa</th>
                                <td>{{ $rekamMedis->waktu_daftar ? \Carbon\Carbon::parse($rekamMedis->waktu_daftar)->format('d F Y, H:i') : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dibuat</th>
                                <td>{{ $rekamMedis->created_at ? \Carbon\Carbon::parse($rekamMedis->created_at)->format('d F Y, H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Rekam Medis -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-journal-medical"></i> Data Rekam Medis</h5>
                        <a href="{{ route('perawat.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-primary"><i class="bi bi-clipboard-pulse"></i> Anamnesa</h6>
                            <p class="text-muted ps-3">{{ $rekamMedis->anamnesa }}</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <h6 class="text-primary"><i class="bi bi-clipboard-check"></i> Diagnosa</h6>
                            <p class="text-muted ps-3">{{ $rekamMedis->diagnosa }}</p>
                        </div>
                        <hr>
                        <div class="mb-0">
                            <h6 class="text-primary"><i class="bi bi-search"></i> Temuan Klinis</h6>
                            <p class="text-muted ps-3">{{ $rekamMedis->temuan_klinis ?: '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Tindakan (View Only) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-list-check"></i> Detail Tindakan / Terapi</h5>
                    </div>
                    <div class="card-body">
                        @if($detailTindakan->count() > 0)
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle"></i> Detail tindakan hanya dapat dikelola oleh dokter. Perawat dapat melihat informasi ini.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 120px;">Kode</th>
                                        <th>Deskripsi Tindakan</th>
                                        <th style="width: 150px;">Kategori</th>
                                        <th style="width: 150px;">Kategori Klinis</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detailTindakan as $index => $detail)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><span class="badge text-bg-secondary">{{ $detail->kode }}</span></td>
                                        <td>{{ $detail->deskripsi_tindakan_terapi }}</td>
                                        <td><span class="badge text-bg-info">{{ $detail->nama_kategori }}</span></td>
                                        <td><span class="badge text-bg-warning">{{ $detail->nama_kategori_klinis }}</span></td>
                                        <td><small>{{ $detail->detail }}</small></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> Belum ada detail tindakan. Detail tindakan akan ditambahkan oleh dokter.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <div>
                        <a href="{{ route('perawat.rekam-medis.edit', $rekamMedis->idrekam_medis) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit Rekam Medis
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
    
    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .table-borderless th {
        font-weight: 600;
        color: #495057;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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