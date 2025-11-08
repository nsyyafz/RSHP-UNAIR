<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateKategori($request);
            
            // Helper untuk menyimpan data
            $kategori = $this->createKategori($validatedData);
            
            return redirect()->route('kategori.index')
                           ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kategori = Kategori::with('kodeTindakan')->findOrFail($id);
            return view('admin.kategori.show', compact('kategori'));
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Data kategori tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return view('admin.kategori.edit', compact('kategori'));
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Data kategori tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data kategori
            $kategori = Kategori::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateKategori($request, $id);
            
            // Update data
            $kategori->update([
                'nama_kategori' => $this->formatNamaKategori($validatedData['nama_kategori'])
            ]);
            
            return redirect()->route('kategori.index')
                           ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            
            // Cek apakah kategori masih digunakan di tabel lain
            if ($kategori->kodeTindakan()->count() > 0) {
                return redirect()->route('kategori.index')
                               ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada kode tindakan terapi.');
            }
            
            $kategori->delete();
            
            return redirect()->route('kategori.index')
                           ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                           ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data kategori
     */
    protected function validateKategori(Request $request, $id = null)
    {
        // Rule unique untuk nama kategori
        $uniqueRule = $id ?
            'unique:kategori,nama_kategori,' . $id . ',idkategori' :
            'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'min:3',
                $uniqueRule
            ]
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
            'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.'
        ]);
    }

    /**
     * Helper untuk membuat kategori baru
     */
    protected function createKategori(array $data)
    {
        try {
            return Kategori::create([
                'nama_kategori' => $this->formatNamaKategori($data['nama_kategori'])
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan kategori: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama kategori
     */
    protected function formatNamaKategori($nama)
    {
        return ucwords(strtolower($nama));
    }
}