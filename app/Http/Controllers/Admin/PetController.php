<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Pet;
// use App\Models\Pemilik;
// use App\Models\RasHewan;
// use App\Models\JenisHewan;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eloquent
        // $pets = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();
        
        // Query Builder
        $pets = DB::table('pet')
            ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
            ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'pet.*',
                'user.nama as nama_pemilik',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get();
        
        return view('admin.pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Eloquent
        // $pemiliks = Pemilik::with('user')->get();
        // $jenisHewans = JenisHewan::all();
        // $rasHewans = RasHewan::with('jenisHewan')->get();
        
        // Query Builder
        $pemiliks = DB::table('pemilik')
            ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama as nama_user', 'pemilik.no_wa')
            ->get();
        
        $jenisHewans = DB::table('jenis_hewan')->get();
        
        $rasHewans = DB::table('ras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.*', 'jenis_hewan.nama_jenis_hewan')
            ->get();
        
        return view('admin.pet.create', compact('pemiliks', 'jenisHewans', 'rasHewans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validatePet($request);
            
            // Helper untuk menyimpan data
            $pet = $this->createPet($validatedData);
            
            return redirect()->route('pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('pet.index')
                           ->with('error', 'Gagal menambahkan hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Eloquent
            // $pet = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->findOrFail($id);
            
            // Query Builder
            $pet = DB::table('pet')
                ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
                ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'pet.*',
                    'user.nama as nama_pemilik',
                    'pemilik.no_wa',
                    'pemilik.alamat',
                    'ras_hewan.nama_ras_hewan',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('pet.idpet', $id)
                ->first();
            
            if (!$pet) {
                return redirect()->route('pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            return view('admin.pet.show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('pet.index')
                           ->with('error', 'Data hewan peliharaan tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Eloquent
            // $pet = Pet::findOrFail($id);
            // $pemiliks = Pemilik::with('user')->get();
            // $jenisHewans = JenisHewan::all();
            // $rasHewans = RasHewan::with('jenisHewan')->get();
            
            // Query Builder
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();
            
            if (!$pet) {
                return redirect()->route('pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            $pemiliks = DB::table('pemilik')
                ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.idpemilik', 'user.nama as nama_user', 'pemilik.no_wa')
                ->get();
            
            $jenisHewans = DB::table('jenis_hewan')->get();
            
            $rasHewans = DB::table('ras_hewan')
                ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select('ras_hewan.*', 'jenis_hewan.nama_jenis_hewan')
                ->get();
            
            return view('admin.pet.edit', compact('pet', 'pemiliks', 'jenisHewans', 'rasHewans'));
        } catch (\Exception $e) {
            return redirect()->route('pet.index')
                           ->with('error', 'Data hewan peliharaan tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Eloquent
            // $pet = Pet::findOrFail($id);
            // $pet->update([
            //     'nama' => $this->formatNama($validatedData['nama']),
            //     'tanggal_lahir' => $validatedData['tanggal_lahir'],
            //     'warna_tanda' => $this->formatWarnaTanda($validatedData['warna_tanda']),
            //     'jenis_kelamin' => $this->convertJenisKelamin($validatedData['jenis_kelamin']),
            //     'idpemilik' => $validatedData['idpemilik'],
            //     'idras_hewan' => $validatedData['idras_hewan']
            // ]);
            
            // Query Builder
            // Cek apakah data ada
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()->route('pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            // Validasi input
            $validatedData = $this->validatePet($request, $id);
            
            // Update data
            DB::table('pet')
                ->where('idpet', $id)
                ->update([
                    'nama' => $this->formatNama($validatedData['nama']),
                    'tanggal_lahir' => $validatedData['tanggal_lahir'],
                    'warna_tanda' => $this->formatWarnaTanda($validatedData['warna_tanda']),
                    'jenis_kelamin' => $this->convertJenisKelamin($validatedData['jenis_kelamin']),
                    'idpemilik' => $validatedData['idpemilik'],
                    'idras_hewan' => $validatedData['idras_hewan']
                ]);
            
            return redirect()->route('pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('pet.index')
                           ->with('error', 'Gagal memperbarui hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Eloquent
            // $pet = Pet::findOrFail($id);
            // if ($pet->rekamMedis()->count() > 0) {
            //     return redirect()->route('pet.index')
            //                      ->with('error', 'Hewan tidak dapat dihapus karena memiliki rekam medis.');
            // }
            // $pet->delete();
            
            // Query Builder
            // Cek apakah data ada
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()->route('pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            // Cek apakah pet memiliki rekam medis (opsional)
            // Uncomment jika ada tabel rekam medis
            // $count = DB::table('rekam_medis')->where('idpet', $id)->count();
            // if ($count > 0) {
            //     return redirect()->route('pet.index')
            //                      ->with('error', 'Hewan tidak dapat dihapus karena memiliki rekam medis.');
            // }
            
            // Hapus data
            DB::table('pet')
                ->where('idpet', $id)
                ->delete();
            
            return redirect()->route('pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pet.index')
                           ->with('error', 'Gagal menghapus hewan peliharaan: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data pet
     */
    protected function validatePet(Request $request, $id = null)
    {
        return $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'min:2'
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'warna_tanda' => [
                'required',
                'string',
                'max:45',
                'min:3'
            ],
            'jenis_kelamin' => [
                'required',
                'in:Jantan,Betina'
            ],
            'idpemilik' => [
                'required',
                'integer',
                'exists:pemilik,idpemilik'
            ],
            'idras_hewan' => [
                'required',
                'integer',
                'exists:ras_hewan,idras_hewan'
            ]
        ], [
            'nama.required' => 'Nama hewan wajib diisi.',
            'nama.min' => 'Nama hewan minimal 2 karakter.',
            'nama.max' => 'Nama hewan maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'warna_tanda.required' => 'Warna/tanda khusus wajib diisi.',
            'warna_tanda.min' => 'Warna/tanda minimal 3 karakter.',
            'warna_tanda.max' => 'Warna/tanda maksimal 45 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh Jantan atau Betina.',
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idpemilik.exists' => 'Pemilik tidak ditemukan.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
            'idras_hewan.exists' => 'Ras hewan tidak ditemukan.'
        ]);
    }

    /**
     * Helper untuk membuat pet baru
     */
    protected function createPet(array $data)
    {
        try {
            // Eloquent
            // return Pet::create([
            //     'nama' => $this->formatNama($data['nama']),
            //     'tanggal_lahir' => $data['tanggal_lahir'],
            //     'warna_tanda' => $this->formatWarnaTanda($data['warna_tanda']),
            //     'jenis_kelamin' => $this->convertJenisKelamin($data['jenis_kelamin']),
            //     'idpemilik' => $data['idpemilik'],
            //     'idras_hewan' => $data['idras_hewan']
            // ]);
            
            // Query Builder
            // Generate idpet baru
            $maxId = DB::table('pet')->max('idpet');
            $idpet = $maxId ? $maxId + 1 : 1;
            $pet = DB::table('pet')->insert([
                'idpet' => $idpet,
                'nama' => $this->formatNama($data['nama']),
                'tanggal_lahir' => $data['tanggal_lahir'],
                'warna_tanda' => $this->formatWarnaTanda($data['warna_tanda']),
                'jenis_kelamin' => $this->convertJenisKelamin($data['jenis_kelamin']),
                'idpemilik' => $data['idpemilik'],
                'idras_hewan' => $data['idras_hewan']
            ]);
            
            return $pet;
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan hewan peliharaan: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama
     */
    protected function formatNama($nama)
    {
        return ucwords(strtolower($nama));
    }

    /**
     * Helper untuk format warna/tanda
     */
    protected function formatWarnaTanda($warnaTanda)
    {
        return ucfirst(trim($warnaTanda));
    }

    /**
     * Helper untuk convert jenis kelamin ke kode
     * Jantan -> J, Betina -> B
     */
    protected function convertJenisKelamin($jenisKelamin)
    {
        return $jenisKelamin === 'Jantan' ? 'J' : 'B';
    }
}