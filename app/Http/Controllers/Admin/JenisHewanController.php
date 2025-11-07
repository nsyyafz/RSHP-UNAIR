<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisHewan;

class JenisHewanController extends Controller
{
    public function index()
    {   
        // $jenisHewan = JenisHewan::select ('idjenis_hewan', 'nama_jenis_hewan')->get();
        $jenisHewans = JenisHewan::all();
        return view('admin.jenis-hewan.index', compact('jenisHewans'));
    }

    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // Validasi input
    $validatedData = $this->validateJenisHewan($request);

    // Helper untuk menyimpan data
    $jenisHewan = $this->createJenisHewan($validatedData);

    return redirect()->route('jenis-hewan.index')
                     ->with('success', 'Jenis hewan berhasil ditambahkan.');
    }

    protected function validateJenisHewan(Request $request, $id = null)
    {
    // data yang bersifat uniq
    $uniqueRule = $id ?
        'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan' :
        'unique:jenis_hewan,nama_jenis_hewan';

    // validasi data input
    return $request->validate([
        'nama_jenis_hewan' => [
            'required',
            'string',
            'max:55',
            'min:3',
            $uniqueRule
        ]
    ], [
        'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
        'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
        'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
        'nama_jenis_hewan.min' => 'Nama jenis hewan minimal 3 karakter.',
        'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada.'
    ]);
    }

    protected function createJenisHewan(array $data)
    {
    try {
        return JenisHewan::create([
            'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
        ]);
    } catch (\Exception $e) {
        throw new \Exception("Gagal menyimpan jenis hewan: " . $e->getMessage());
    }
    }

    protected function formatNamaJenisHewan($nama)
    {
        return ucwords(strtolower($nama));
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
            $jenisHewan = JenisHewan::findOrFail($id);
            return view('admin.jenis-hewan.edit', compact('jenisHewan'));
        } catch (\Exception $e) {
            return redirect()->route('jenis-hewan.index')
                            ->with('error', 'Data jenis hewan tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cari data jenis hewan
            $jenisHewan = JenisHewan::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateJenisHewan($request, $id);
            
            // Update data
            $jenisHewan->update([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
            ]);
            
            return redirect()->route('jenis-hewan.index')
                            ->with('success', 'Jenis hewan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('jenis-hewan.index')
                            ->with('error', 'Gagal memperbarui jenis hewan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jenisHewan = JenisHewan::findOrFail($id);
            
            // Cek apakah jenis hewan masih digunakan di tabel lain (opsional)
            // Uncomment jika ada relasi dengan tabel lain
            if ($jenisHewan->pets()->count() > 0) {
                return redirect()->route('jenis-hewan.index')
                                 ->with('error', 'Jenis hewan tidak dapat dihapus karena masih digunakan.');
            }
            
            $jenisHewan->delete();
            
            return redirect()->route('jenis-hewan.index')
                            ->with('success', 'Jenis hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('jenis-hewan.index')
                            ->with('error', 'Gagal menghapus jenis hewan: ' . $e->getMessage());
        }
    }
}
