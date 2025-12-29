@extends('layouts.lte.dokter.main')

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
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekam-medis.index') }}">Rekam Medis</a></li>
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
                                <th>Jenis Kelamin</th>
                                <td>{{ $rekamMedis->jenis_pet == 'J' ? 'Jantan' : 'Betina' }}</td>
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

        <!-- Detail Tindakan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-list-check"></i> Detail Tindakan / Terapi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Daftar Detail Tindakan -->
                        @if($detailTindakan->count() > 0)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 120px;">Kode</th>
                                        <th>Deskripsi Tindakan</th>
                                        <th style="width: 150px;">Kategori</th>
                                        <th style="width: 150px;">Kategori Klinis</th>
                                        <th>Detail</th>
                                        <th style="width: 120px;" class="text-center">Aksi</th>
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
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editDetailModal"
                                                    data-id="{{ $detail->iddetail_rekam_medis }}"
                                                    data-kode="{{ $detail->idkode_tindakan_terapi }}"
                                                    data-detail="{{ $detail->detail }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('dokter.rekam-medis.detail.destroy', ['id' => $rekamMedis->idrekam_medis, 'iddetail' => $detail->iddetail_rekam_medis]) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Yakin ingin menghapus detail tindakan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada detail tindakan. Silakan tambahkan detail tindakan di bawah.
                        </div>
                        @endif

                        <!-- Form Tambah Detail Tindakan -->
                        <div class="border-top pt-4">
                            <h6 class="mb-3"><i class="bi bi-plus-circle"></i> Tambah Detail Tindakan Baru</h6>
                            <form action="{{ route('dokter.rekam-medis.detail.store', $rekamMedis->idrekam_medis) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="idkode_tindakan_terapi" class="form-label">Kode Tindakan <span class="text-danger">*</span></label>
                                            <select class="form-select @error('idkode_tindakan_terapi') is-invalid @enderror" 
                                                    id="idkode_tindakan_terapi" 
                                                    name="idkode_tindakan_terapi"
                                                    required>
                                                <option value="">-- Pilih Kode Tindakan --</option>
                                                @foreach($kodeTindakan as $kt)
                                                <option value="{{ $kt->idkode_tindakan_terapi }}" {{ old('idkode_tindakan_terapi') == $kt->idkode_tindakan_terapi ? 'selected' : '' }}>
                                                    {{ $kt->kode }} - {{ $kt->deskripsi_tindakan_terapi }} ({{ $kt->nama_kategori }})
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('idkode_tindakan_terapi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="detail" class="form-label">Detail Tindakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('detail') is-invalid @enderror" 
                                                      id="detail" 
                                                      name="detail" 
                                                      rows="3"
                                                      placeholder="Tuliskan detail tindakan yang dilakukan"
                                                      required>{{ old('detail') }}</textarea>
                                            @error('detail')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Minimal 3 karakter, maksimal 1000 karakter</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Tambah Detail Tindakan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Detail Tindakan -->
<div class="modal fade" id="editDetailModal" tabindex="-1" aria-labelledby="editDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editDetailForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editDetailModalLabel">Edit Detail Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_idkode_tindakan_terapi" class="form-label">Kode Tindakan <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_idkode_tindakan_terapi" name="idkode_tindakan_terapi" required>
                            <option value="">-- Pilih Kode Tindakan --</option>
                            @foreach($kodeTindakan as $kt)
                            <option value="{{ $kt->idkode_tindakan_terapi }}">
                                {{ $kt->kode }} - {{ $kt->deskripsi_tindakan_terapi }} ({{ $kt->nama_kategori }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_detail" class="form-label">Detail Tindakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_detail" name="detail" rows="4" required></textarea>
                        <small class="text-muted">Minimal 3 karakter, maksimal 1000 karakter</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>
            </form>
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

    .border-top {
        border-top: 2px solid #dee2e6 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Handle edit modal
        const editModal = document.getElementById('editDetailModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const kode = button.getAttribute('data-kode');
            const detail = button.getAttribute('data-detail');
            
            // Set form action
            const form = document.getElementById('editDetailForm');
            form.action = '/admin/rekam-medis/' + {{ $rekamMedis->idrekam_medis }} + '/detail/' + id;
            
            // Set form values
            document.getElementById('edit_idkode_tindakan_terapi').value = kode;
            document.getElementById('edit_detail').value = detail;
        });

        // Character counter
        const detailTextarea = document.getElementById('detail');
        if (detailTextarea) {
            detailTextarea.addEventListener('input', function() {
                const currentLength = this.value.length;
                const small = this.nextElementSibling.nextElementSibling;
                if (small && small.tagName === 'SMALL') {
                    small.textContent = `${currentLength}/1000 karakter`;
                }
            });
        }
    });
</script>
@endpush