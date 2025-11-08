<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKlinis;

class KategoriKlinisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.kategori-klinis.index', compact('kategoriKlinis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori-klinis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateKategoriKlinis($request);
            
            // Helper untuk menyimpan data
            $kategoriKlinis = $this->createKategoriKlinis($validatedData);
            
            return redirect()->route('kategori-klinis.index')
                           ->with('success', 'Kategori klinis berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-klinis.index')
                           ->with('error', 'Gagal menambahkan kategori klinis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kategoriKlinis = KategoriKlinis::findOrFail($id);
            return view('admin.kategori-klinis.show', compact('kategoriKlinis'));
        } catch (\Exception $e) {
            return redirect()->route('kategori-klinis.index')
                           ->with('error', 'Data kategori klinis tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $kategoriKlinis = KategoriKlinis::findOrFail($id);
            return view('admin.kategori-klinis.edit', compact('kategoriKlinis'));
        } catch (\Exception $e) {
            return redirect()->route('kategori-klinis.index')
                           ->with('error', 'Data kategori klinis tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data kategori klinis
            $kategoriKlinis = KategoriKlinis::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateKategoriKlinis($request, $id);
            
            // Update data
            $kategoriKlinis->update([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($validatedData['nama_kategori_klinis'])
            ]);
            
            return redirect()->route('kategori-klinis.index')
                           ->with('success', 'Kategori klinis berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-klinis.index')
                           ->with('error', 'Gagal memperbarui kategori klinis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategoriKlinis = KategoriKlinis::findOrFail($id);
            
            // Cek apakah kategori klinis masih digunakan di tabel lain (opsional)
            // Uncomment jika ada relasi dengan tabel lain
            // if ($kategoriKlinis->relatedTable()->count() > 0) {
            //     return redirect()->route('kategori-klinis.index')
            //                      ->with('error', 'Kategori klinis tidak dapat dihapus karena masih digunakan.');
            // }
            
            $kategoriKlinis->delete();
            
            return redirect()->route('kategori-klinis.index')
                           ->with('success', 'Kategori klinis berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-klinis.index')
                           ->with('error', 'Gagal menghapus kategori klinis: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data kategori klinis
     */
    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        // Rule unique untuk nama kategori klinis
        $uniqueRule = $id ?
            'unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis' :
            'unique:kategori_klinis,nama_kategori_klinis';

        return $request->validate([
            'nama_kategori_klinis' => [
                'required',
                'string',
                'max:100',
                'min:3',
                $uniqueRule
            ]
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string' => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 100 karakter.',
            'nama_kategori_klinis.min' => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis sudah ada.'
        ]);
    }

    /**
     * Helper untuk membuat kategori klinis baru
     */
    protected function createKategoriKlinis(array $data)
    {
        try {
            return KategoriKlinis::create([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis'])
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan kategori klinis: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama kategori klinis
     */
    protected function formatNamaKategoriKlinis($nama)
    {
        return ucwords(strtolower($nama));
    }
}