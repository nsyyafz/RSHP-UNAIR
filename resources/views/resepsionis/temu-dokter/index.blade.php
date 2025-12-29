@extends('layouts.lte.resepsionis.main')

@section('title', 'Daftar Temu Dokter')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Temu Dokter</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Temu Dokter</h3>
                        <div class="card-tools d-flex gap-2">
                            <!-- Filter Buttons -->
                            <div class="btn-group" role="group">
                                <a href="{{ route('resepsionis.temu-dokter.index', ['filter' => 'hari-ini']) }}" 
                                   class="btn btn-sm {{ ($filter ?? 'hari-ini') === 'hari-ini' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="bi bi-calendar-day"></i> Hari Ini
                                </a>
                                <a href="{{ route('resepsionis.temu-dokter.index', ['filter' => 'semua']) }}" 
                                   class="btn btn-sm {{ ($filter ?? 'hari-ini') === 'semua' ? 'btn-primary' : 'btn-outline-primary' }}">
                                    <i class="bi bi-list-ul"></i> Semua
                                </a>
                            </div>
                            
                            <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Temu Dokter
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">No Urut</th>
                                        <th style="width: 150px;">Waktu Daftar</th>
                                        <th>Nama Pet</th>
                                        <th>Pemilik</th>
                                        <th>Dokter</th>
                                        <th style="width: 120px;" class="text-center">Status</th>
                                        <th style="width: 200px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($temuDokter as $item)
                                    <tr>
                                        <td>
                                            <span class="badge text-bg-primary">{{ $item->no_urut }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar"></i>
                                                {{ \Carbon\Carbon::parse($item->waktu_daftar)->format('d M Y') }}
                                            </small>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($item->waktu_daftar)->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <strong>{{ $item->nama_pet }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $item->nama_pemilik }}</span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-info">
                                                <i class="bi bi-person-badge"></i>
                                                {{ $item->nama_dokter }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 0)
                                                <span class="badge text-bg-warning">
                                                    <i class="bi bi-clock-history"></i> Pending
                                                </span>
                                            @elseif($item->status == 1)
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
                                            <div class="btn-group" role="group"> 
                                                <a href="{{ route('resepsionis.temu-dokter.edit', $item->idreservasi_dokter) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('resepsionis.temu-dokter.destroy', $item->idreservasi_dokter) }}" 
                                                      method="POST" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Yakin ingin menghapus temu dokter ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm"
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                                @if(($filter ?? 'hari-ini') === 'hari-ini')
                                                    <p class="mt-3">Tidak ada antrian hari ini</p>
                                                    <small class="text-muted">Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}</small>
                                                @else
                                                    <p class="mt-3">Tidak ada data temu dokter</p>
                                                @endif
                                                <div class="mt-3">
                                                    <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-plus-circle"></i> Tambah Data Pertama
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if(count($temuDokter) > 0)
                    <div class="card-footer clearfix">
                        <div class="float-start">
                            @if(($filter ?? 'hari-ini') === 'hari-ini')
                                <span class="text-muted">
                                    <i class="bi bi-calendar-check"></i> 
                                    Menampilkan antrian <strong>hari ini</strong> 
                                    ({{ \Carbon\Carbon::now()->format('d M Y') }})
                                </span>
                            @else
                                <span class="text-muted">
                                    <i class="bi bi-list-check"></i> 
                                    Menampilkan <strong>semua</strong> antrian
                                </span>
                            @endif
                        </div>
                        <div class="float-end">
                            <span class="text-muted">Total: <strong>{{ count($temuDokter) }}</strong> temu dokter</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
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