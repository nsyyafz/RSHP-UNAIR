<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        
        return view('resepsionis.pet.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemiliks = DB::table('pemilik')
            ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama as nama_user', 'pemilik.no_wa')
            ->get();
        
        $jenisHewans = DB::table('jenis_hewan')->get();
        
        $rasHewans = DB::table('ras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'ras_hewan.idras_hewan',
                'ras_hewan.nama_ras',
                'ras_hewan.idjenis_hewan',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->get()
            ->map(function($ras) {
                // Buat nested object untuk kompatibilitas dengan view
                $ras->jenisHewan = (object)[
                    'nama_jenis_hewan' => $ras->nama_jenis_hewan
                ];
                return $ras;
            });
        
        return view('resepsionis.pet.create', compact('pemiliks', 'jenisHewans', 'rasHewans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validatePet($request);
            $pet = $this->createPet($validatedData);
            
            return redirect()->route('resepsionis.pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pet.index')
                           ->with('error', 'Gagal menambahkan hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
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
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('pet.idpet', $id)
                ->first();
            
            if (!$pet) {
                return redirect()->route('resepsionis.pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            return view('resepsionis.pet.show', compact('pet'));
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pet.index')
                           ->with('error', 'Data hewan peliharaan tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();
            
            if (!$pet) {
                return redirect()->route('resepsionis.pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            $pemiliks = DB::table('pemilik')
                ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.idpemilik', 'user.nama as nama_user', 'pemilik.no_wa')
                ->get();
            
            $jenisHewans = DB::table('jenis_hewan')->get();
            
            $rasHewans = DB::table('ras_hewan')
                ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'ras_hewan.idras_hewan',
                    'ras_hewan.nama_ras',
                    'ras_hewan.idjenis_hewan',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->get()
                ->map(function($ras) {
                    $ras->jenisHewan = (object)[
                        'nama_jenis_hewan' => $ras->nama_jenis_hewan
                    ];
                    return $ras;
                });
            
            return view('resepsionis.pet.edit', compact('pet', 'pemiliks', 'jenisHewans', 'rasHewans'));
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pet.index')
                           ->with('error', 'Data hewan peliharaan tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()->route('resepsionis.pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            $validatedData = $this->validatePet($request, $id);
            
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
            
            return redirect()->route('resepsionis.pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pet.index')
                           ->with('error', 'Gagal memperbarui hewan peliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pet = DB::table('pet')
                ->where('idpet', $id)
                ->first();

            if (!$pet) {
                return redirect()->route('resepsionis.pet.index')
                                ->with('error', 'Data hewan peliharaan tidak ditemukan.');
            }
            
            DB::table('pet')
                ->where('idpet', $id)
                ->delete();
            
            return redirect()->route('resepsionis.pet.index')
                           ->with('success', 'Data hewan peliharaan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pet.index')
                           ->with('error', 'Gagal menghapus hewan peliharaan: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    protected function validatePet(Request $request, $id = null)
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:100', 'min:2'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'warna_tanda' => ['required', 'string', 'max:45', 'min:3'],
            'jenis_kelamin' => ['required', 'in:Jantan,Betina'],
            'idpemilik' => ['required', 'integer', 'exists:pemilik,idpemilik'],
            'idras_hewan' => ['required', 'integer', 'exists:ras_hewan,idras_hewan']
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

    protected function createPet(array $data)
    {
        try {
            $maxId = DB::table('pet')->max('idpet');
            $idpet = $maxId ? $maxId + 1 : 1;
            
            DB::table('pet')->insert([
                'idpet' => $idpet,
                'nama' => $this->formatNama($data['nama']),
                'tanggal_lahir' => $data['tanggal_lahir'],
                'warna_tanda' => $this->formatWarnaTanda($data['warna_tanda']),
                'jenis_kelamin' => $this->convertJenisKelamin($data['jenis_kelamin']),
                'idpemilik' => $data['idpemilik'],
                'idras_hewan' => $data['idras_hewan']
            ]);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan hewan peliharaan: " . $e->getMessage());
        }
    }

    protected function formatNama($nama)
    {
        return ucwords(strtolower($nama));
    }

    protected function formatWarnaTanda($warnaTanda)
    {
        return ucfirst(trim($warnaTanda));
    }

    protected function convertJenisKelamin($jenisKelamin)
    {
        return $jenisKelamin === 'Jantan' ? 'J' : 'B';
    }
}