<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'hari-ini'); // default: hari-ini
        $temuDokter = $this->ambilSemuaTemuDokter($filter);
        
        return view('admin.temu-dokter.index', compact('temuDokter', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pets = $this->ambilSemuaPet();
        $dokters = $this->ambilSemuaDokter();
        
        return view('admin.temu-dokter.create', compact('pets', 'dokters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateTemuDokter($request);
        
        try {
            $result = $this->createTemuDokter($validatedData);
            
            if ($result['ok']) {
                return redirect()->route('temu-dokter.index')
                               ->with('success', 'Temu dokter berhasil ditambahkan.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal menambahkan temu dokter: ' . $result['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan temu dokter: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $temuDokter = $this->ambilTemuDokterById($id);
        
        if (!$temuDokter) {
            return redirect()->route('temu-dokter.index')
                           ->with('error', 'Data temu dokter tidak ditemukan.');
        }
        
        return view('admin.temu-dokter.show', compact('temuDokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $temuDokter = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->first();

            if (!$temuDokter) {
                return redirect()->route('temu-dokter.index')
                               ->with('error', 'Data temu dokter tidak ditemukan.');
            }
            
            $pets = $this->ambilSemuaPet();
            $dokters = $this->ambilSemuaDokter();
            
            return view('admin.temu-dokter.edit', compact('temuDokter', 'pets', 'dokters'));
        } catch (\Exception $e) {
            return redirect()->route('temu-dokter.index')
                           ->with('error', 'Data temu dokter tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $temuDokter = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->first();

            if (!$temuDokter) {
                return redirect()->route('temu-dokter.index')
                               ->with('error', 'Data temu dokter tidak ditemukan.');
            }
            
            $validatedData = $this->validateTemuDokter($request, $id);
            
            DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->update([
                    'no_urut' => $validatedData['no_urut'],
                    'waktu_daftar' => $validatedData['waktu_daftar'],
                    'status' => $validatedData['status'],
                    'idpet' => $validatedData['idpet'],
                    'idrole_user' => $validatedData['idrole_user']
                ]);
            
            return redirect()->route('temu-dokter.index')
                           ->with('success', 'Temu dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui temu dokter: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $temuDokter = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->first();

            if (!$temuDokter) {
                return redirect()->route('temu-dokter.index')
                               ->with('error', 'Data temu dokter tidak ditemukan.');
            }
            
            // Cek apakah temu dokter masih digunakan di rekam medis
            $countRekamMedis = DB::table('rekam_medis')
                ->where('dokter_pemeriksa', $id)
                ->count();
            
            if ($countRekamMedis > 0) {
                return redirect()->route('temu-dokter.index')
                               ->with('error', 'Temu dokter tidak dapat dihapus karena masih terdapat rekam medis terkait.');
            }
            
            DB::table('temu_dokter')
                ->where('idreservasi_dokter', $id)
                ->delete();
            
            return redirect()->route('temu-dokter.index')
                           ->with('success', 'Temu dokter berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('temu-dokter.index')
                           ->with('error', 'Gagal menghapus temu dokter: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Ambil semua temu dokter dengan detail lengkap dan filter
     */
    protected function ambilSemuaTemuDokter($filter = 'hari-ini')
    {
        $query = DB::table('temu_dokter as td')
            ->join('pet as p', 'p.idpet', '=', 'td.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->join('role_user as ru', 'ru.idrole_user', '=', 'td.idrole_user')
            ->join('user as u_dokter', 'u_dokter.iduser', '=', 'ru.iduser')
            ->select(
                'td.*',
                'p.nama as nama_pet',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter'
            );

        // Terapkan filter berdasarkan pilihan
        if ($filter === 'hari-ini') {
            $today = Carbon::today()->toDateString();
            $query->whereDate('td.waktu_daftar', $today);
        }
        // Jika 'semua', tidak perlu menambahkan kondisi WHERE

        return $query->orderBy('td.waktu_daftar', 'desc')
                    ->orderBy('td.no_urut', 'asc')
                    ->get();
    }

    /**
     * Ambil temu dokter by id dengan detail lengkap
     */
    protected function ambilTemuDokterById($idreservasi_dokter)
    {
        return DB::table('temu_dokter as td')
            ->join('pet as p', 'p.idpet', '=', 'td.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->join('role_user as ru', 'ru.idrole_user', '=', 'td.idrole_user')
            ->join('user as u_dokter', 'u_dokter.iduser', '=', 'ru.iduser')
            ->where('td.idreservasi_dokter', $idreservasi_dokter)
            ->select(
                'td.*',
                'p.nama as nama_pet',
                'p.jenis_kelamin as jenis_pet',
                'u_pemilik.nama as nama_pemilik',
                'pm.alamat as alamat_pemilik',
                'pm.no_wa as telp_pemilik',
                'u_dokter.nama as nama_dokter'
            )
            ->first();
    }

    /**
     * Ambil semua pet untuk dropdown
     */
    protected function ambilSemuaPet()
    {
        return DB::table('pet as p')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u', 'u.iduser', '=', 'pm.iduser')
            ->select(
                'p.idpet',
                'p.nama as nama_pet',
                'p.jenis_kelamin',
                'u.nama as nama_pemilik'
            )
            ->orderBy('p.nama')
            ->get();
    }

    /**
     * Ambil semua dokter untuk dropdown
     */
    protected function ambilSemuaDokter()
    {
        return DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->join('role as r', 'ru.idrole', '=', 'r.idrole')
            ->where('r.nama_role', 'Dokter')
            ->where('ru.status', 1)
            ->select(
                'ru.idrole_user',
                'u.nama as nama_dokter'
            )
            ->orderBy('u.nama')
            ->get();
    }

    /**
     * Validasi data temu dokter
     */
    protected function validateTemuDokter(Request $request, $id = null)
    {
        return $request->validate([
            'no_urut' => [
                'required',
                'integer',
                'min:1'
            ],
            'waktu_daftar' => [
                'required',
                'date'
            ],
            'status' => [
                'required',
                'in:0,1,2' // 0=Pending, 1=Selesai, 2=Dibatalkan (sesuaikan dengan kebutuhan)
            ],
            'idpet' => [
                'required',
                'exists:pet,idpet'
            ],
            'idrole_user' => [
                'required',
                'exists:role_user,idrole_user'
            ]
        ], [
            'no_urut.required' => 'Nomor urut wajib diisi.',
            'no_urut.integer' => 'Nomor urut harus berupa angka.',
            'no_urut.min' => 'Nomor urut minimal 1.',
            'waktu_daftar.required' => 'Waktu daftar wajib diisi.',
            'waktu_daftar.date' => 'Format waktu daftar tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'idpet.required' => 'Pet wajib dipilih.',
            'idpet.exists' => 'Pet tidak ditemukan.',
            'idrole_user.required' => 'Dokter wajib dipilih.',
            'idrole_user.exists' => 'Dokter tidak ditemukan.'
        ]);
    }

    /**
     * Helper untuk membuat temu dokter baru
     */
    protected function createTemuDokter(array $data)
    {
        DB::beginTransaction();
        
        try {
            // Generate ID baru
            $maxId = DB::table('temu_dokter')->lockForUpdate()->max('idreservasi_dokter');
            $next_id = $maxId ? $maxId + 1 : 1;
            
            $inserted = DB::table('temu_dokter')->insert([
                'idreservasi_dokter' => $next_id,
                'no_urut' => $data['no_urut'],
                'waktu_daftar' => $data['waktu_daftar'],
                'status' => $data['status'],
                'idpet' => $data['idpet'],
                'idrole_user' => $data['idrole_user']
            ]);
            
            if ($inserted) {
                DB::commit();
                return ['ok' => true, 'id' => $next_id];
            } else {
                DB::rollBack();
                return ['ok' => false, 'error' => 'Gagal insert temu dokter'];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }
}