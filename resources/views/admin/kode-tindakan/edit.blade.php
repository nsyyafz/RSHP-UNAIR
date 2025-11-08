<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kode Tindakan Terapi - Admin RSHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            content: '✏️';
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

        .form-control:disabled {
            background: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .required {
            color: #dc3545;
        }

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

        .id-display {
            background: linear-gradient(135deg, #003366, #005599);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            display: inline-block;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
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
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .btn-action-group {
                flex-direction: column;
            }

            .btn-submit, .btn-cancel {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div>
                <h1>✏️ Edit Kode Tindakan Terapi</h1>
                <p>Perbarui informasi kode tindakan terapi yang sudah ada</p>
            </div>
        </div>

        <div class="form-card">
            <h5><i class="bi bi-pencil-square"></i> Form Edit Data Kode Tindakan</h5>

            <div class="alert-info-custom">
                <i class="bi bi-info-circle-fill"></i>
                <strong>Informasi:</strong> ID Kode Tindakan tidak dapat diubah untuk menjaga integritas data.
            </div>

            <form action="{{ route('kode-tindakan.update', $kodeTindakan->idkode_tindakan_terapi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-hash"></i> ID Kode Tindakan
                    </label>
                    <div class="id-display">
                        <i class="bi bi-shield-check"></i> {{ $kodeTindakan->idkode_tindakan_terapi }}
                    </div>
                    <small class="form-text">ID tidak dapat diubah untuk menjaga integritas data</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-upc-scan"></i> Kode Tindakan <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="kode" 
                        class="form-control @error('kode') is-invalid @enderror" 
                        placeholder="Contoh: VKS01, OPS02, PMK03" 
                        value="{{ old('kode', $kodeTindakan->kode) }}"
                        required
                        autofocus
                        style="text-transform: uppercase;"
                    >
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Perbarui kode tindakan (akan otomatis uppercase)</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-file-text-fill"></i> Deskripsi Tindakan Terapi <span class="required">*</span>
                    </label>
                    <textarea 
                        name="deskripsi_tindakan_terapi" 
                        class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" 
                        rows="4"
                        placeholder="Contoh: Vaksinasi rabies untuk anjing dan kucing dewasa"
                        required
                    >{{ old('deskripsi_tindakan_terapi', $kodeTindakan->deskripsi_tindakan_terapi) }}</textarea>
                    @error('deskripsi_tindakan_terapi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Perbarui deskripsi tindakan terapi</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-folder-fill"></i> Kategori <span class="required">*</span>
                    </label>
                    <select 
                        name="idkategori" 
                        class="form-select @error('idkategori') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->idkategori }}" 
                            {{ old('idkategori', $kodeTindakan->idkategori) == $kategori->idkategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('idkategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Pilih kategori tindakan terapi</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-heart-pulse-fill"></i> Kategori Klinis <span class="required">*</span>
                    </label>
                    <select 
                        name="idkategori_klinis" 
                        class="form-select @error('idkategori_klinis') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Kategori Klinis --</option>
                        @foreach($kategoriKlinis as $klinis)
                        <option value="{{ $klinis->idkategori_klinis }}" 
                            {{ old('idkategori_klinis', $kodeTindakan->idkategori_klinis) == $klinis->idkategori_klinis ? 'selected' : '' }}>
                            {{ $klinis->nama_kategori_klinis }}
                        </option>
                        @endforeach
                    </select>
                    @error('idkategori_klinis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Pilih kategori klinis tindakan terapi</small>
                </div>

                <div class="btn-action-group">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('kode-tindakan.index') }}" class="btn-cancel">
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