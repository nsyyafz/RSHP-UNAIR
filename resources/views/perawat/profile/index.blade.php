@extends('layouts.lte.perawat.main')

@section('title', 'Profil Perawat')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Profil Perawat</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="rounded-circle bg-info text-white d-inline-flex align-items-center justify-content-center"
                                 style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ strtoupper(substr($perawat->nama ?? 'P', 0, 1)) }}
                            </div>
                        </div>
                        
                        <h4 class="mb-1">{{ $perawat->nama ?? '-' }}</h4>
                        <p class="text-muted mb-0">
                            <i class="bi bi-heart-pulse"></i> Perawat
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-info-circle"></i> Informasi Kontak
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="bi bi-envelope"></i> Email</strong>
                            <p class="text-muted mb-0">{{ $perawat->email ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <strong><i class="bi bi-phone"></i> No. HP</strong>
                            <p class="text-muted mb-0">{{ $perawat->no_hp ?? '-' }}</p>
                        </div>
                        <div class="mb-0">
                            <strong><i class="bi bi-geo-alt"></i> Alamat</strong>
                            <p class="text-muted mb-0">{{ $perawat->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-8">
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-person-badge"></i> Data Profil
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('perawat.profile.edit') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Edit Profil
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td style="width: 200px;"><strong>Nama Lengkap</strong></td>
                                    <td>{{ $perawat->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $perawat->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td>
                                        @if($perawat->jenis_kelamin == 'L')
                                            <span class="badge text-bg-primary">
                                                <i class="bi bi-gender-male"></i> Laki-laki
                                            </span>
                                        @elseif($perawat->jenis_kelamin == 'P')
                                            <span class="badge" style="background-color: #e83e8c; color: white;">
                                                <i class="bi bi-gender-female"></i> Perempuan
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pendidikan</strong></td>
                                    <td>
                                        <span class="badge text-bg-info">
                                            <i class="bi bi-mortarboard"></i> {{ $perawat->pendidikan ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>No. HP</strong></td>
                                    <td>{{ $perawat->no_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>{{ $perawat->alamat ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
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
    
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    });
</script>
@endpush