<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class petController extends Controller
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
                'pemilik.no_wa',
                'pemilik.alamat',
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('pet.nama', 'asc')
            ->get();
        
        return view('perawat.pet.index', compact('pets'));
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
                    'user.email as email_pemilik',
                    'pemilik.no_wa',
                    'pemilik.alamat',
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('pet.idpet', $id)
                ->first();
            
            if (!$pet) {
                return redirect()->route('perawat.pet.index')
                                ->with('error', 'Data pet tidak ditemukan.');
            }

            // Ambil riwayat rekam medis dengan nama dokter
            // rekam_medis.idreservasi_dokter -> temu_dokter.idreservasi_dokter -> role_user.idrole_user -> user.iduser
            $rekamMedis = DB::table('rekam_medis')
                ->leftJoin('temu_dokter', 'rekam_medis.idreservasi_dokter', '=', 'temu_dokter.idreservasi_dokter')
                ->leftJoin('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
                ->leftJoin('user', 'role_user.iduser', '=', 'user.iduser')
                ->where('rekam_medis.idpet', $id)
                ->select(
                    'rekam_medis.*',
                    'user.nama as nama_dokter'
                )
                ->orderBy('rekam_medis.created_at', 'desc')
                ->get();
            
            return view('perawat.pet.show', compact('pet', 'rekamMedis'));
            
        } catch (\Exception $e) {
            return redirect()->route('perawat.pet.index')
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}