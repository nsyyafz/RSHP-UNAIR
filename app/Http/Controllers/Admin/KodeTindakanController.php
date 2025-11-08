<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KodeTindakan;
use App\Models\Kategori;
use App\Models\KategoriKlinis;

class KodeTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeTindakans = KodeTindakan::with(['kategori', 'kategoriKlinis'])->get();
        return view('admin.kode-tindakan.index', compact('kodeTindakans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::select('idkategori', 'nama_kategori')->get();
        $kategoriKlinis = KategoriKlinis::select('idkategori_klinis', 'nama_kategori_klinis')->get();
        return view('admin.kode-tindakan.create', compact('kategoris', 'kategoriKlinis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateKodeTindakan($request);
            
            // Helper untuk menyimpan data
            $kodeTindakan = $this->createKodeTindakan($validatedData);
            
            return redirect()->route('kode-tindakan.index')
                           ->with('success', 'Kode tindakan terapi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kode-tindakan.index')
                           ->with('error', 'Gagal menambahkan kode tindakan terapi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kodeTindakan = KodeTindakan::with(['kategori', 'kategoriKlinis'])->findOrFail($id);
            return view('admin.kode-tindakan.show', compact('kodeTindakan'));
        } catch (\Exception $e) {
            return redirect()->route('kode-tindakan.index')
                           ->with('error', 'Data kode tindakan terapi tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $kodeTindakan = KodeTindakan::findOrFail($id);
            $kategoris = Kategori::select('idkategori', 'nama_kategori')->get();
            $kategoriKlinis = KategoriKlinis::select('idkategori_klinis', 'nama_kategori_klinis')->get();
            
            return view('admin.kode-tindakan.edit', compact('kodeTindakan', 'kategoris', 'kategoriKlinis'));
        } catch (\Exception $e) {
            return redirect()->route('kode-tindakan.index')
                           ->with('error', 'Data kode tindakan terapi tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data kode tindakan
            $kodeTindakan = KodeTindakan::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateKodeTindakan($request, $id);
            
            // Update data
            $kodeTindakan->update([
                'kode' => strtoupper($validatedData['kode']),
                'deskripsi_tindakan_terapi' => $this->formatDeskripsi($validatedData['deskripsi_tindakan_terapi']),
                'idkategori' => $validatedData['idkategori'],
                'idkategori_klinis' => $validatedData['idkategori_klinis']
            ]);
            
            return redirect()->route('kode-tindakan.index')
                           ->with('success', 'Kode tindakan terapi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kode-tindakan.index')
                           ->with('error', 'Gagal memperbarui kode tindakan terapi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kodeTindakan = KodeTindakan::findOrFail($id);
            
            // Cek apakah kode tindakan masih digunakan di tabel lain (opsional)
            // Uncomment jika ada relasi dengan tabel lain
            // if ($kodeTindakan->rekamMedis()->count() > 0) {
            //     return redirect()->route('kode-tindakan.index')
            //                      ->with('error', 'Kode tindakan tidak dapat dihapus karena masih digunakan.');
            // }
            
            $kodeTindakan->delete();
            
            return redirect()->route('kode-tindakan.index')
                           ->with('success', 'Kode tindakan terapi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kode-tindakan.index')
                           ->with('error', 'Gagal menghapus kode tindakan terapi: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data kode tindakan
     */
    protected function validateKodeTindakan(Request $request, $id = null)
    {
        // Rule unique untuk kode
        $uniqueKodeRule = $id ?
            'unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi' :
            'unique:kode_tindakan_terapi,kode';

        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                'min:2',
                $uniqueKodeRule
            ],
            'deskripsi_tindakan_terapi' => [
                'required',
                'string',
                'max:500',
                'min:5'
            ],
            'idkategori' => [
                'required',
                'integer',
                'exists:kategori,idkategori'
            ],
            'idkategori_klinis' => [
                'required',
                'integer',
                'exists:kategori_klinis,idkategori_klinis'
            ]
        ], [
            'kode.required' => 'Kode tindakan wajib diisi.',
            'kode.string' => 'Kode tindakan harus berupa teks.',
            'kode.max' => 'Kode tindakan maksimal 20 karakter.',
            'kode.min' => 'Kode tindakan minimal 2 karakter.',
            'kode.unique' => 'Kode tindakan sudah ada.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi tindakan terapi wajib diisi.',
            'deskripsi_tindakan_terapi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi_tindakan_terapi.max' => 'Deskripsi maksimal 500 karakter.',
            'deskripsi_tindakan_terapi.min' => 'Deskripsi minimal 5 karakter.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori.integer' => 'Kategori tidak valid.',
            'idkategori.exists' => 'Kategori tidak ditemukan.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
            'idkategori_klinis.integer' => 'Kategori klinis tidak valid.',
            'idkategori_klinis.exists' => 'Kategori klinis tidak ditemukan.'
        ]);
    }

    /**
     * Helper untuk membuat kode tindakan baru
     */
    protected function createKodeTindakan(array $data)
    {
        try {
            return KodeTindakan::create([
                'kode' => strtoupper($data['kode']),
                'deskripsi_tindakan_terapi' => $this->formatDeskripsi($data['deskripsi_tindakan_terapi']),
                'idkategori' => $data['idkategori'],
                'idkategori_klinis' => $data['idkategori_klinis']
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan kode tindakan: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format deskripsi
     */
    protected function formatDeskripsi($deskripsi)
    {
        return ucfirst(trim($deskripsi));
    }
}