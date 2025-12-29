<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        $iduser = Auth::id();
        
        // Ambil data pemilik
        $pemilik = DB::table('pemilik')->where('iduser', $iduser)->first();
        
        if (!$pemilik) {
            return redirect()->route('login')->with('error', 'Data pemilik tidak ditemukan');
        }

        // Hitung total pet
        $totalPet = DB::table('pet')->where('idpemilik', $pemilik->idpemilik)->count();
        
        // Hitung temu dokter menunggu
        $temuMenunggu = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->where('temu_dokter.status', '0')
            ->count();
        
        // Hitung total rekam medis
        $totalRekamMedis = DB::table('rekam_medis')
            ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
            ->where('pet.idpemilik', $pemilik->idpemilik)
            ->count();

        return view('pemilik.dashboard_pemilik', compact(
            'totalPet',
            'temuMenunggu',
            'totalRekamMedis'
        ));
    }
}