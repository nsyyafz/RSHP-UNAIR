<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource (hanya rekam medis pet milik pemilik yang login).
     */
    public function index()
    {
        try {
            $iduser = Auth::id();
            
            // Ambil data pemilik
            $pemilik = DB::table('pemilik')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.dashboard')
                    ->with('error', 'Data pemilik tidak ditemukan');
            }
            
            // Ambil rekam medis untuk pet milik pemilik yang login
            $rekamMedis = DB::table('rekam_medis as rm')
                ->join('pet as p', 'p.idpet', '=', 'rm.idpet')
                ->leftJoin('role_user as ru_dokter', 'ru_dokter.idrole_user', '=', 'rm.dokter_pemeriksa')
                ->leftJoin('user as u_dokter', 'u_dokter.iduser', '=', 'ru_dokter.iduser')
                ->leftJoin('temu_dokter as td', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
                ->where('p.idpemilik', $pemilik->idpemilik)
                ->select(
                    'rm.*',
                    'p.nama as nama_pet',
                    'p.jenis_kelamin as jenis_pet',
                    'u_dokter.nama as nama_dokter',
                    'td.no_urut',
                    'td.waktu_daftar'
                )
                ->orderBy('rm.created_at', 'desc')
                ->get();
            
            return view('pemilik.rekam-medis.index', compact('rekamMedis'));
            
        } catch (\Exception $e) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Gagal memuat data rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource (detail rekam medis).
     */
    public function show(string $id)
    {
        try {
            $iduser = Auth::id();
            
            // Ambil data pemilik
            $pemilik = DB::table('pemilik')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.dashboard')
                    ->with('error', 'Data pemilik tidak ditemukan');
            }
            
            // Ambil detail rekam medis dengan validasi kepemilikan
            $rekamMedis = DB::table('rekam_medis as rm')
                ->join('pet as p', 'p.idpet', '=', 'rm.idpet')
                ->leftJoin('role_user as ru_dokter', 'ru_dokter.idrole_user', '=', 'rm.dokter_pemeriksa')
                ->leftJoin('user as u_dokter', 'u_dokter.iduser', '=', 'ru_dokter.iduser')
                ->leftJoin('temu_dokter as td', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
                ->leftJoin('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
                ->leftJoin('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
                ->where('rm.idrekam_medis', $id)
                ->where('p.idpemilik', $pemilik->idpemilik) // Validasi kepemilikan
                ->select(
                    'rm.*',
                    'p.nama as nama_pet',
                    'p.jenis_kelamin as jenis_pet',
                    'p.tanggal_lahir',
                    'p.warna_tanda',
                    'rh.nama_ras',
                    'jh.nama_jenis_hewan',
                    'u_dokter.nama as nama_dokter',
                    'td.no_urut',
                    'td.waktu_daftar'
                )
                ->first();
            
            if (!$rekamMedis) {
                return redirect()->route('pemilik.rekam-medis.index')
                    ->with('error', 'Data rekam medis tidak ditemukan atau bukan milik Anda');
            }
            
            // Ambil detail tindakan/terapi
            $detailTindakan = DB::table('detail_rekam_medis as drm')
                ->join('kode_tindakan_terapi as ktt', 'ktt.idkode_tindakan_terapi', '=', 'drm.idkode_tindakan_terapi')
                ->join('kategori as k', 'k.idkategori', '=', 'ktt.idkategori')
                ->join('kategori_klinis as kk', 'kk.idkategori_klinis', '=', 'ktt.idkategori_klinis')
                ->where('drm.idrekam_medis', $id)
                ->select(
                    'drm.*',
                    'ktt.kode',
                    'ktt.deskripsi_tindakan_terapi',
                    'k.nama_kategori',
                    'kk.nama_kategori_klinis'
                )
                ->orderBy('drm.iddetail_rekam_medis')
                ->get();
            
            return view('pemilik.rekam-medis.show', compact('rekamMedis', 'detailTindakan'));
            
        } catch (\Exception $e) {
            return redirect()->route('pemilik.rekam-medis.index')
                ->with('error', 'Gagal memuat detail rekam medis: ' . $e->getMessage());
        }
    }
}