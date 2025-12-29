<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     * Dokter hanya bisa VIEW rekam medis
     */
    public function index()
    {
        $rekamMedis = $this->ambilSemuaRekamMedis();
        
        return view('dokter.rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * Display the specified resource.
     * Dokter bisa VIEW detail rekam medis dan CRUD detail tindakan
     */
    public function show(string $id)
    {
        $rekamMedis = $this->ambilRekamMedisById($id);
        
        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                           ->with('error', 'Data rekam medis tidak ditemukan.');
        }
        
        $detailTindakan = $this->ambilDetailRekamMedis($id);
        $kodeTindakan = $this->ambilSemuaKodeTindakan();
        
        return view('dokter.rekam-medis.show', compact('rekamMedis', 'detailTindakan', 'kodeTindakan'));
    }

    // ========== DETAIL TINDAKAN METHODS (CRUD) ==========

    /**
     * Tambah detail tindakan
     */
    public function storeDetail(Request $request, string $idrekam_medis)
    {
        // Cek apakah rekam medis ada
        $rekamMedis = DB::table('rekam_medis')
            ->where('idrekam_medis', $idrekam_medis)
            ->first();
        
        if (!$rekamMedis) {
            return redirect()->route('dokter.rekam-medis.index')
                           ->with('error', 'Data rekam medis tidak ditemukan.');
        }
        
        $validatedData = $this->validateDetailTindakan($request);
        
        try {
            $result = $this->tambahDetailTindakan(
                $idrekam_medis,
                $validatedData['idkode_tindakan_terapi'],
                $validatedData['detail']
            );
            
            if ($result['ok']) {
                return redirect()->route('dokter.rekam-medis.show', $idrekam_medis)
                               ->with('success', 'Detail tindakan berhasil ditambahkan.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal menambahkan detail tindakan: ' . $result['error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan detail tindakan: ' . $e->getMessage());
        }
    }

    /**
     * Update detail tindakan
     */
    public function updateDetail(Request $request, string $iddetail_rekam_medis)
    {
        $validatedData = $this->validateDetailTindakan($request);
        
        try {
            // Ambil idrekam_medis dari detail
            $detail = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $iddetail_rekam_medis)
                ->first();
            
            if (!$detail) {
                return redirect()->back()
                               ->with('error', 'Data detail tindakan tidak ditemukan.');
            }
            
            $result = $this->updateDetailTindakan(
                $iddetail_rekam_medis,
                $validatedData['idkode_tindakan_terapi'],
                $validatedData['detail']
            );
            
            if ($result) {
                return redirect()->route('dokter.rekam-medis.show', $detail->idrekam_medis)
                               ->with('success', 'Detail tindakan berhasil diperbarui.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal memperbarui detail tindakan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui detail tindakan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus detail tindakan
     */
    public function destroyDetail(string $iddetail_rekam_medis)
    {
        try {
            // Ambil idrekam_medis sebelum dihapus
            $detail = DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $iddetail_rekam_medis)
                ->first();
            
            if (!$detail) {
                return redirect()->back()
                               ->with('error', 'Data detail tindakan tidak ditemukan.');
            }
            
            $result = $this->hapusDetailTindakan($iddetail_rekam_medis);
            
            if ($result) {
                return redirect()->route('dokter.rekam-medis.show', $detail->idrekam_medis)
                               ->with('success', 'Detail tindakan berhasil dihapus.');
            } else {
                return redirect()->back()
                               ->with('error', 'Gagal menghapus detail tindakan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus detail tindakan: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS - REKAM MEDIS (VIEW ONLY) ==========

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

    // ========== HELPER METHODS - DETAIL TINDAKAN (CRUD) ==========

    /**
     * Ambil detail rekam medis (tindakan/terapi) by idrekam_medis
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
     * Ambil semua kode tindakan untuk dropdown
     */
    protected function ambilSemuaKodeTindakan()
    {
        return DB::table('kode_tindakan_terapi as ktt')
            ->join('kategori as k', 'k.idkategori', '=', 'ktt.idkategori')
            ->join('kategori_klinis as kk', 'kk.idkategori_klinis', '=', 'ktt.idkategori_klinis')
            ->select(
                'ktt.*',
                'k.nama_kategori',
                'kk.nama_kategori_klinis'
            )
            ->orderBy('ktt.kode')
            ->get();
    }

    /**
     * Tambah detail tindakan/terapi
     */
    protected function tambahDetailTindakan($idrekam_medis, $idkode_tindakan_terapi, $detail)
    {
        DB::beginTransaction();
        
        try {
            // Generate ID detail baru
            $maxId = DB::table('detail_rekam_medis')->lockForUpdate()->max('iddetail_rekam_medis');
            $next_id = $maxId ? $maxId + 1 : 1;
            
            $inserted = DB::table('detail_rekam_medis')->insert([
                'iddetail_rekam_medis' => $next_id,
                'detail' => trim($detail),
                'idrekam_medis' => $idrekam_medis,
                'idkode_tindakan_terapi' => $idkode_tindakan_terapi
            ]);
            
            if ($inserted) {
                DB::commit();
                return ['ok' => true, 'id' => $next_id];
            } else {
                DB::rollBack();
                return ['ok' => false, 'error' => 'Gagal insert detail tindakan'];
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update detail tindakan
     */
    protected function updateDetailTindakan($iddetail_rekam_medis, $idkode_tindakan_terapi, $detail)
    {
        return DB::table('detail_rekam_medis')
            ->where('iddetail_rekam_medis', $iddetail_rekam_medis)
            ->update([
                'idkode_tindakan_terapi' => $idkode_tindakan_terapi,
                'detail' => trim($detail)
            ]);
    }

    /**
     * Hapus detail tindakan
     */
    protected function hapusDetailTindakan($iddetail_rekam_medis)
    {
        return DB::table('detail_rekam_medis')
            ->where('iddetail_rekam_medis', $iddetail_rekam_medis)
            ->delete();
    }

    /**
     * Validasi data detail tindakan
     */
    protected function validateDetailTindakan(Request $request)
    {
        return $request->validate([
            'idkode_tindakan_terapi' => [
                'required',
                'exists:kode_tindakan_terapi,idkode_tindakan_terapi'
            ],
            'detail' => [
                'required',
                'string',
                'min:3',
                'max:1000'
            ]
        ], [
            'idkode_tindakan_terapi.required' => 'Kode tindakan wajib dipilih.',
            'idkode_tindakan_terapi.exists' => 'Kode tindakan tidak ditemukan.',
            'detail.required' => 'Detail tindakan wajib diisi.',
            'detail.string' => 'Detail tindakan harus berupa teks.',
            'detail.min' => 'Detail tindakan minimal 3 karakter.',
            'detail.max' => 'Detail tindakan maksimal 1000 karakter.'
        ]);
    }
}