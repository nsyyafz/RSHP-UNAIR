<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\JenisHewan;

class JenisHewanController extends Controller
{
    public function index()
    {
        // Eloquent
        // $jenisHewan = JenisHewan::all();

        // Query Builder
        $jenisHewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->get();

        return view('admin.jenis-hewan.index', compact('jenisHewan'));
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
            // Eloquent
            // $jenisHewan = JenisHewan::findOrFail($id);

            // Query Builder
            $jenisHewan = DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->first();

            if (!$jenisHewan) {
                return redirect()->route('jenis-hewan.index')
                                ->with('error', 'Data jenis hewan tidak ditemukan.');
            }

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
            // Eloquent
            // $jenisHewan = JenisHewan::findOrFail($id);
            // $jenisHewan->update([
            //     'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
            // ]);

            // Query Builder
            // Cek apakah data ada
            $jenisHewan = DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->first();

            if (!$jenisHewan) {
                return redirect()->route('jenis-hewan.index')
                                ->with('error', 'Data jenis hewan tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateJenisHewan($request, $id);
            
            // Update data
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
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
            // Eloquent
            // $jenisHewan = JenisHewan::findOrFail($id);
            // if ($jenisHewan->pets()->count() > 0) {
            //     return redirect()->route('jenis-hewan.index')
            //                      ->with('error', 'Jenis hewan tidak dapat dihapus karena masih digunakan.');
            // }
            // $jenisHewan->delete();

            // Query Builder
            // Cek apakah data ada
            $jenisHewan = DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->first();

            if (!$jenisHewan) {
                return redirect()->route('jenis-hewan.index')
                                ->with('error', 'Data jenis hewan tidak ditemukan.');
            }
            
            // Cek apakah jenis hewan masih digunakan di tabel lain (opsional)
            // Uncomment jika ada relasi dengan tabel lain
            $count = DB::table('ras_hewan')->where('idjenis_hewan', $id)->count();
            if ($count > 0) {
                return redirect()->route('jenis-hewan.index')
                                 ->with('error', 'Jenis hewan tidak dapat dihapus karena masih digunakan.');
            }
            
            // Hapus data
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->delete();
            
            return redirect()->route('jenis-hewan.index')
                            ->with('success', 'Jenis hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('jenis-hewan.index')
                            ->with('error', 'Gagal menghapus jenis hewan: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data jenis hewan
     */
    protected function validateJenisHewan(Request $request, $id = null)
    {
        // Data yang bersifat unique
        $uniqueRule = $id ?
            'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan' :
            'unique:jenis_hewan,nama_jenis_hewan';

        // Validasi data input
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
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 55 karakter.',
            'nama_jenis_hewan.min' => 'Nama jenis hewan minimal 3 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada.'
        ]);
    }

    /**
     * Helper untuk format nama jenis hewan
     */
    protected function formatNamaJenisHewan($nama)
    {
        return ucwords(strtolower($nama));
    }

    /**
     * Helper untuk membuat data baru
     */
    protected function createJenisHewan(array $data)
    {
        try {
            // Eloquent
            // return JenisHewan::create([
            //     'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            // ]);

            // Query Builder

            // Generate idjenis_hewan baru
            $maxId = DB::table('jenis_hewan')->max('idjenis_hewan');
            $idjenis_hewan = $maxId ? $maxId + 1 : 1;
            $jenisHewan = DB::table('jenis_hewan')->insert([
                'idjenis_hewan' => $idjenis_hewan,
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            ]);

            return $jenisHewan;
        } catch (\Exception $e) {
            throw new \Exception('Gagal menyimpan data jenis hewan: ' . $e->getMessage());
        }
    }
}