@extends('layouts.lte.main')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Hewan Peliharaan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pet.index') }}">Pet</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
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
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Form Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="bi bi-clipboard-plus"></i> Form Tambah Hewan Peliharaan
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        
                        <form action="{{ route('pet.store') }}" method="POST">
                            @csrf
                            
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <h5><i class="bi bi-exclamation-triangle"></i> Error!</h5>
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Informasi:</strong> Lengkapi semua data hewan dengan benar untuk keperluan rekam medis.
                                </div>

                                <div class="row">
                                    <!-- Nama Pet -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">
                                                Nama Pet <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('nama') is-invalid @enderror" 
                                                id="nama" 
                                                name="nama" 
                                                value="{{ old('nama') }}"
                                                placeholder="Contoh: Milo, Luna, Bobby"
                                                required
                                                autofocus
                                            >
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Tanggal Lahir -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">
                                                Tanggal Lahir <span class="text-danger">*</span>
                                            </label>
                                            <input 
                                                type="date" 
                                                class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                                id="tanggal_lahir" 
                                                name="tanggal_lahir" 
                                                value="{{ old('tanggal_lahir') }}"
                                                max="{{ date('Y-m-d') }}"
                                                required
                                            >
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Pemilik -->
                                <div class="mb-3">
                                    <label for="idpemilik" class="form-label">
                                        Pemilik <span class="text-danger">*</span>
                                    </label>
                                    <select 
                                        class="form-select @error('idpemilik') is-invalid @enderror" 
                                        id="idpemilik" 
                                        name="idpemilik"
                                        required
                                    >
                                        <option value="">-- Pilih Pemilik --</option>
                                        @foreach($pemiliks as $pemilik)
                                            <option value="{{ $pemilik->idpemilik }}" {{ old('idpemilik') == $pemilik->idpemilik ? 'selected' : '' }}>
                                                {{ $pemilik->nama_user ?? '-' }} ({{ $pemilik->no_wa }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('idpemilik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <!-- Jenis Kelamin -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label">
                                                Jenis Kelamin <span class="text-danger">*</span>
                                            </label>
                                            <select 
                                                class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                                id="jenis_kelamin" 
                                                name="jenis_kelamin"
                                                required
                                            >
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>♂ Jantan</option>
                                                <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>♀ Betina</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Jenis Hewan (hidden, diambil dari Ras) -->
                                    <!-- Ras Hewan -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="idras_hewan" class="form-label">
                                                Ras Hewan <span class="text-danger">*</span>
                                            </label>
                                            <select 
                                                class="form-select @error('idras_hewan') is-invalid @enderror" 
                                                id="idras_hewan" 
                                                name="idras_hewan"
                                                required
                                            >
                                                <option value="">-- Pilih Ras --</option>
                                                @foreach($rasHewans as $ras)
                                                    <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan') == $ras->idras_hewan ? 'selected' : '' }}>
                                                        {{ $ras->jenisHewan->nama_jenis_hewan ?? '' }} - {{ $ras->nama_ras }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('idras_hewan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Warna/Tanda Khusus -->
                                <div class="mb-3">
                                    <label for="warna_tanda" class="form-label">
                                        Warna/Tanda Khusus <span class="text-danger">*</span>
                                    </label>
                                    <textarea 
                                        class="form-control @error('warna_tanda') is-invalid @enderror" 
                                        id="warna_tanda" 
                                        name="warna_tanda" 
                                        rows="3"
                                        placeholder="Contoh: Coklat keemasan, memiliki tanda putih di dahi"
                                        required
                                    >{{ old('warna_tanda') }}</textarea>
                                    @error('warna_tanda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Jelaskan warna dominan dan tanda khusus yang membedakan hewan ini</small>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Simpan
                                </button>
                                <a href="{{ route('pet.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection