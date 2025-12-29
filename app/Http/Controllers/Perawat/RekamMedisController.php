<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     * Perawat bisa VIEW semua rekam medis
     */
    public function index()
    {
        $rekamMedis = $this->ambilSemuaRekamMedis();
        
        return view('perawat.rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * Show the form for creating a new resource.
     * Perawat bisa CREATE rekam medis
     */
    public function create()
    {
        // Ambil daftar temu dokter yang statusnya '1' (Selesai) tapi belum punya rekam medis
        $temuDokters = $this->ambilTemuDokterBelumAdaRekamMedis();
        
        return view('perawat.rekam-medis.create', compact('temuDokters'));
    }

    /**
     * Store a newly created resource in storage.
     * Perawat bisa CREATE rekam medis
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateRekamMedis($request);
        
        try {
            // Ambil data temu dokter
            $temuDokter = DB::table('temu_dokter')
                ->where('idreservasi_dokter', $validatedData['idreservasi_dokter'])
                ->first();
            
            if (!$temuDokter) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Data temu dokter tidak ditemukan.');
            }
            
            // Cek apakah temu dokter sudah punya rekam medis
            $cekRekamMedis = DB::table('rekam_medis')
                ->where('idreservasi_dokter', $validatedData['idreservasi_dokter'])
                ->exists();
            
            if ($cekRekamMedis) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Temu dokter ini sudah memiliki rekam medis.');
            }
            
            $result = $this->tambahRekamMedis(
                $temuDokter->idpet,
                $temuDokter->idrole_user,
                $validatedData['idreservasi_dokter'],
                $validatedData['anamnesa'],
                $validatedData['diagnosa'],
                $validatedData['temuan_klinis'] ?? ''
            );
            
            if ($result['ok']) {
                return redirect()->route('perawat.rekam-medis.show', $result['id'])
                               ->with('success', 'Rekam medis berhasil ditambahkan.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal menambahkan rekam medis: ' . $result['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Perawat bisa VIEW detail rekam medis (termasuk detail tindakan)
     */
    public function show(string $id)
    {
        $rekamMedis = $this->ambilRekamMedisById($id);
        
        if (!$rekamMedis) {
            return redirect()->route('perawat.rekam-medis.index')
                           ->with('error', 'Data rekam medis tidak ditemukan.');
        }
        
        $detailTindakan = $this->ambilDetailRekamMedis($id);
        
        return view('perawat.rekam-medis.show', compact('rekamMedis', 'detailTindakan'));
    }

    /**
     * Show the form for editing the specified resource.
     * Perawat bisa EDIT rekam medis
     */
    public function edit(string $id)
    {
        $rekamMedis = $this->ambilRekamMedisById($id);
        
        if (!$rekamMedis) {
            return redirect()->route('perawat.rekam-medis.index')
                           ->with('error', 'Data rekam medis tidak ditemukan.');
        }
        
        return view('perawat.rekam-medis.edit', compact('rekamMedis'));
    }

    /**
     * Update the specified resource in storage.
     * Perawat bisa UPDATE rekam medis
     */
    public function update(Request $request, string $id)
    {
        $rekamMedis = DB::table('rekam_medis')
            ->where('idrekam_medis', $id)
            ->first();
        
        if (!$rekamMedis) {
            return redirect()->route('perawat.rekam-medis.index')
                           ->with('error', 'Data rekam medis tidak ditemukan.');
        }
        
        $validatedData = $this->validateRekamMedisUpdate($request);
        
        try {
            $result = $this->updateRekamMedis(
                $id,
                $validatedData['anamnesa'],
                $validatedData['diagnosa'],
                $validatedData['temuan_klinis'] ?? ''
            );
            
            if ($result) {
                return redirect()->route('perawat.rekam-medis.show', $id)
                               ->with('success', 'Rekam medis berhasil diperbarui.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal memperbarui rekam medis.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * Perawat bisa DELETE rekam medis
     */
    public function destroy(string $id)
    {
        try {
            $rekamMedis = DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->first();
            
            if (!$rekamMedis) {
                return redirect()->route('perawat.rekam-medis.index')
                               ->with('error', 'Data rekam medis tidak ditemukan.');
            }
            
            // Cek apakah ada detail tindakan
            $countDetail = DB::table('detail_rekam_medis')
                ->where('idrekam_medis', $id)
                ->count();
            
            if ($countDetail > 0) {
                return redirect()->route('perawat.rekam-medis.index')
                               ->with('error', 'Rekam medis tidak dapat dihapus karena masih memiliki detail tindakan. Hubungi dokter untuk menghapus detail tindakan terlebih dahulu.');
            }
            
            $result = $this->hapusRekamMedis($id);
            
            if ($result) {
                return redirect()->route('perawat.rekam-medis.index')
                               ->with('success', 'Rekam medis berhasil dihapus.');
            } else {
                return redirect()->route('perawat.rekam-medis.index')
                               ->with('error', 'Gagal menghapus rekam medis.');
            }
        } catch (\Exception $e) {
            return redirect()->route('perawat.rekam-medis.index')
                           ->with('error', 'Gagal menghapus rekam medis: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS - REKAM MEDIS ==========

    /**
     * Ambil semua rekam medis dengan detail lengkap
     */
    protected function ambilSemuaRekamMedis()
    {
        return DB::table('rekam_medis as rm')
            ->join('pet as p', 'p.idpet', '=', 'rm.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->leftJoin('temu_dokter as td', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
            ->leftJoin('role_user as ru_dokter', 'ru_dokter.idrole_user', '=', 'td.idrole_user')
            ->leftJoin('user as u_dokter', 'u_dokter.iduser', '=', 'ru_dokter.iduser')
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'pm.idpemilik',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter',
                'td.no_urut',
                'td.waktu_daftar'
            )
            ->orderBy('rm.created_at', 'desc')
            ->get();
    }

    /**
     * Ambil rekam medis by id dengan detail lengkap
     */
    protected function ambilRekamMedisById($idrekam_medis)
    {
        return DB::table('rekam_medis as rm')
            ->join('pet as p', 'p.idpet', '=', 'rm.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->leftJoin('ras_hewan', 'p.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->leftJoin('temu_dokter as td', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
            ->leftJoin('role_user as ru_dokter', 'ru_dokter.idrole_user', '=', 'td.idrole_user')
            ->leftJoin('user as u_dokter', 'u_dokter.iduser', '=', 'ru_dokter.iduser')
            ->where('rm.idrekam_medis', $idrekam_medis)
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'p.jenis_kelamin as jenis_pet',
                'p.tanggal_lahir',
                'p.warna_tanda',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan',
                'pm.idpemilik',
                'u_pemilik.nama as nama_pemilik',
                'u_pemilik.email as email_pemilik',
                'pm.alamat as alamat_pemilik',
                'pm.no_wa as telp_pemilik',
                'u_dokter.nama as nama_dokter',
                'td.no_urut',
                'td.waktu_daftar'
            )
            ->first();
    }

    /**
     * Ambil temu dokter yang belum ada rekam medis
     */
    protected function ambilTemuDokterBelumAdaRekamMedis()
    {
        return DB::table('temu_dokter as td')
            ->join('pet as p', 'p.idpet', '=', 'td.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->join('role_user as ru', 'ru.idrole_user', '=', 'td.idrole_user')
            ->join('user as u_dokter', 'u_dokter.iduser', '=', 'ru.iduser')
            ->leftJoin('rekam_medis as rm', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->whereNull('rm.idrekam_medis') // Belum punya rekam medis
            ->where('td.status', '1') // Status Selesai
            ->select(
                'td.idreservasi_dokter',
                'td.no_urut',
                'td.waktu_daftar',
                'p.idpet',
                'p.nama as nama_pet',
                'p.jenis_kelamin as jenis_kelamin_pet',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter'
            )
            ->orderBy('td.waktu_daftar', 'desc')
            ->get();
    }

    /**
     * Tambah rekam medis baru
     */
    protected function tambahRekamMedis($idpet, $dokter_pemeriksa, $idreservasi_dokter, $anamnesa, $diagnosa, $temuan_klinis = '')
    {
        DB::beginTransaction();
        
        try {
            // Generate ID baru
            $maxId = DB::table('rekam_medis')->lockForUpdate()->max('idrekam_medis');
            $next_id = $maxId ? $maxId + 1 : 1;
            
            // Insert rekam medis
            $inserted = DB::table('rekam_medis')->insert([
                'idrekam_medis' => $next_id,
                'anamnesa' => trim($anamnesa),
                'diagnosa' => trim($diagnosa),
                'temuan_klinis' => trim($temuan_klinis),
                'dokter_pemeriksa' => $dokter_pemeriksa,
                'idreservasi_dokter' => $idreservasi_dokter,
                'created_at' => now(),
                'idpet' => $idpet
            ]);
            
            if ($inserted) {
                DB::commit();
                return ['ok' => true, 'id' => $next_id];
            } else {
                DB::rollBack();
                return ['ok' => false, 'error' => 'Gagal insert rekam medis'];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update rekam medis
     */
    protected function updateRekamMedis($idrekam_medis, $anamnesa, $diagnosa, $temuan_klinis = '')
    {
        return DB::table('rekam_medis')
            ->where('idrekam_medis', $idrekam_medis)
            ->update([
                'anamnesa' => trim($anamnesa),
                'diagnosa' => trim($diagnosa),
                'temuan_klinis' => trim($temuan_klinis)
            ]);
    }

    /**
     * Hapus rekam medis
     */
    protected function hapusRekamMedis($idrekam_medis)
    {
        try {
            return DB::table('rekam_medis')
                ->where('idrekam_medis', $idrekam_medis)
                ->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Ambil detail rekam medis (tindakan/terapi) by idrekam_medis - VIEW ONLY
     */
    protected function ambilDetailRekamMedis($idrekam_medis)
    {
        return DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'ktt.idkode_tindakan_terapi', '=', 'drm.idkode_tindakan_terapi')
            ->join('kategori as k', 'k.idkategori', '=', 'ktt.idkategori')
            ->join('kategori_klinis as kk', 'kk.idkategori_klinis', '=', 'ktt.idkategori_klinis')
            ->where('drm.idrekam_medis', $idrekam_medis)
            ->select(
                'drm.*',
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->orderBy('drm.iddetail_rekam_medis')
            ->get();
    }

    /**
     * Validasi data rekam medis untuk create
     */
    protected function validateRekamMedis(Request $request)
    {
        return $request->validate([
            'idreservasi_dokter' => [
                'required',
                'exists:temu_dokter,idreservasi_dokter',
                'unique:rekam_medis,idreservasi_dokter'
            ],
            'anamnesa' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000'
        ], [
            'idreservasi_dokter.required' => 'Temu dokter wajib dipilih.',
            'idreservasi_dokter.exists' => 'Temu dokter tidak ditemukan.',
            'idreservasi_dokter.unique' => 'Temu dokter ini sudah memiliki rekam medis.',
            'anamnesa.required' => 'Anamnesa wajib diisi.',
            'anamnesa.max' => 'Anamnesa maksimal 1000 karakter.',
            'diagnosa.required' => 'Diagnosa wajib diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
            'temuan_klinis.max' => 'Temuan klinis maksimal 1000 karakter.'
        ]);
    }

    /**
     * Validasi data rekam medis untuk update
     */
    protected function validateRekamMedisUpdate(Request $request)
    {
        return $request->validate([
            'anamnesa' => 'required|string|max:1000',
            'diagnosa' => 'required|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000'
        ], [
            'anamnesa.required' => 'Anamnesa wajib diisi.',
            'anamnesa.max' => 'Anamnesa maksimal 1000 karakter.',
            'diagnosa.required' => 'Diagnosa wajib diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
            'temuan_klinis.max' => 'Temuan klinis maksimal 1000 karakter.'
        ]);
    }
}