<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Hewan Peliharaan - Admin RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .page-header {
            background: linear-gradient(135deg, #003366 0%, #005599 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.2);
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '🐾';
            position: absolute;
            font-size: 10rem;
            opacity: 0.1;
            right: -2rem;
            top: -2rem;
        }
        .page-header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            position: relative;
            z-index: 1;
        }
        .page-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 51, 102, 0.08);
            overflow: hidden;
            border: none;
            padding: 2.5rem;
        }
        .form-card h5 {
            color: #003366;
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid #ffd700;
        }
        .form-label {
            color: #003366;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #005599;
            box-shadow: 0 0 0 0.2rem rgba(0, 85, 153, 0.15);
        }
        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .required { color: #dc3545; }
        .alert-info-custom {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: none;
            border-left: 4px solid #2196f3;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
        .alert-info-custom i {
            color: #2196f3;
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }
        .btn-action-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
        }
        .btn-submit {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #005599, #003366);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.3);
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
            color: white;
        }
        @media (max-width: 768px) {
            .page-header { padding: 1.5rem; }
            .page-header h1 { font-size: 1.5rem; }
            .form-card { padding: 1.5rem; }
            .btn-action-group { flex-direction: column; }
            .btn-submit, .btn-cancel { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div>
                <h1>🐾 Tambah Hewan Peliharaan Baru</h1>
                <p>Daftarkan hewan peliharaan baru ke dalam sistem</p>
            </div>
        </div>

        <div class="form-card">
            <h5><i class="bi bi-clipboard-plus"></i> Form Pendaftaran Hewan</h5>

            <div class="alert-info-custom">
                <i class="bi bi-info-circle-fill"></i>
                <strong>Informasi:</strong> Lengkapi semua data hewan dengan benar untuk keperluan rekam medis.
            </div>

            <form action="{{ route('pet.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="bi bi-tag-fill"></i> Nama Hewan <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama" 
                            class="form-control @error('nama') is-invalid @enderror" 
                            placeholder="Contoh: Milo, Luna, Bobby" 
                            value="{{ old('nama') }}"
                            required
                            autofocus
                        >
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="bi bi-calendar-fill"></i> Tanggal Lahir <span class="required">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="tanggal_lahir" 
                            class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                            value="{{ old('tanggal_lahir') }}"
                            max="{{ date('Y-m-d') }}"
                            required
                        >
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-person-badge-fill"></i> Pemilik <span class="required">*</span>
                    </label>
                    <select 
                        name="idpemilik" 
                        class="form-select @error('idpemilik') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Pemilik --</option>
                        @foreach($pemiliks as $pemilik)
                        <option value="{{ $pemilik->idpemilik }}" {{ old('idpemilik') == $pemilik->idpemilik ? 'selected' : '' }}>
                            {{ $pemilik->user->nama ?? '-' }} ({{ $pemilik->no_wa }})
                        </option>
                        @endforeach
                    </select>
                    @error('idpemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="bi bi-circle-fill"></i> Ras Hewan <span class="required">*</span>
                        </label>
                        <select 
                            name="idras_hewan" 
                            class="form-select @error('idras_hewan') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Pilih Ras Hewan --</option>
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

                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="bi bi-gender-ambiguous"></i> Jenis Kelamin <span class="required">*</span>
                        </label>
                        <select 
                            name="jenis_kelamin" 
                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
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

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-palette-fill"></i> Warna & Tanda Khusus <span class="required">*</span>
                    </label>
                    <textarea 
                        name="warna_tanda" 
                        class="form-control @error('warna_tanda') is-invalid @enderror" 
                        rows="3"
                        placeholder="Contoh: Coklat keemasan, memiliki tanda putih di dahi"
                        required
                    >{{ old('warna_tanda') }}</textarea>
                    @error('warna_tanda')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Jelaskan warna dominan dan tanda khusus yang membedakan hewan ini</small>
                </div>

                <div class="btn-action-group">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i> Simpan Data
                    </button>
                    <a href="{{ route('pet.index') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="text-center mt-4">
            <p style="color: #999; font-size: 0.9rem;">
                © 2025 RSHP Universitas Airlangga - Admin Panel
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>