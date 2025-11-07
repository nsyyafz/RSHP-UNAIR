<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;
use App\Models\JenisHewan;

class RasHewanController extends Controller
{
    public function index()
    {
        $rasHewans = RasHewan::with('jenisHewan')->get();
        return view('admin.ras-hewan.index', compact('rasHewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisHewans = JenisHewan::select('idjenis_hewan', 'nama_jenis_hewan')->get();
        return view('admin.ras-hewan.create', compact('jenisHewans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $this->validateRasHewan($request);

        // Helper untuk menyimpan data
        $rasHewan = $this->createRasHewan($validatedData);

        return redirect()->route('ras-hewan.index')
                         ->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $rasHewan = RasHewan::findOrFail($id);
            $jenisHewans = JenisHewan::select('idjenis_hewan', 'nama_jenis_hewan')->get();
            return view('admin.ras-hewan.edit', compact('rasHewan', 'jenisHewans'));
        } catch (\Exception $e) {
            return redirect()->route('ras-hewan.index')
                            ->with('error', 'Data ras hewan tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data ras hewan
            $rasHewan = RasHewan::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateRasHewan($request, $id);
            
            // Update data
            $rasHewan->update([
                'nama_ras' => $this->formatNamaRas($validatedData['nama_ras']),
                'idjenis_hewan' => $validatedData['idjenis_hewan']
            ]);
            
            return redirect()->route('ras-hewan.index')
                            ->with('success', 'Ras hewan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('ras-hewan.index')
                            ->with('error', 'Gagal memperbarui ras hewan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $rasHewan = RasHewan::findOrFail($id);
            
            // Cek apakah ras hewan masih digunakan di tabel lain (opsional)
            // Uncomment jika ada relasi dengan tabel lain
            // if ($rasHewan->pets()->count() > 0) {
            //     return redirect()->route('ras-hewan.index')
            //                      ->with('error', 'Ras hewan tidak dapat dihapus karena masih digunakan.');
            // }
            
            $rasHewan->delete();
            
            return redirect()->route('ras-hewan.index')
                            ->with('success', 'Ras hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('ras-hewan.index')
                            ->with('error', 'Gagal menghapus ras hewan: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data ras hewan
     */
    protected function validateRasHewan(Request $request, $id = null)
    {
        // Data yang bersifat unique
        $uniqueRule = $id ?
            'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan' :
            'unique:ras_hewan,nama_ras';

        // Validasi data input
        return $request->validate([
            'nama_ras' => [
                'required',
                'string',
                'max:100',
                'min:3',
                $uniqueRule
            ],
            'idjenis_hewan' => [
                'required',
                'integer',
                'exists:jenis_hewan,idjenis_hewan'
            ]
        ], [
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'nama_ras.string' => 'Nama ras harus berupa teks.',
            'nama_ras.max' => 'Nama ras maksimal 100 karakter.',
            'nama_ras.min' => 'Nama ras minimal 3 karakter.',
            'nama_ras.unique' => 'Nama ras sudah ada.',
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
            'idjenis_hewan.integer' => 'Jenis hewan tidak valid.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak ditemukan.'
        ]);
    }

    /**
     * Helper untuk membuat ras hewan baru
     */
    protected function createRasHewan(array $data)
    {
        try {
            return RasHewan::create([
                'nama_ras' => $this->formatNamaRas($data['nama_ras']),
                'idjenis_hewan' => $data['idjenis_hewan']
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan ras hewan: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama ras
     */
    protected function formatNamaRas($nama)
    {
        return ucwords(strtolower($nama));
    }
}