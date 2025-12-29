<?php

namespace App\Http\Controllers\Perawat;

use App\Models\Pet;
use App\Models\Role;
use App\Models\User;
use App\Models\Pemilik;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use App\Models\RekamMedis;
use App\Models\KodeTindakan;
use App\Models\TemuDokter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil rekam medis terbaru dengan join untuk mendapatkan nama pet, pemilik, dan dokter
        $rekamMedisList = DB::table('rekam_medis as rm')
            ->join('pet as p', 'p.idpet', '=', 'rm.idpet')
            ->join('pemilik as pm', 'pm.idpemilik', '=', 'p.idpemilik')
            ->join('user as u_pemilik', 'u_pemilik.iduser', '=', 'pm.iduser')
            ->leftJoin('role_user as ru_dokter', 'ru_dokter.idrole_user', '=', 'rm.dokter_pemeriksa')
            ->leftJoin('user as u_dokter', 'u_dokter.iduser', '=', 'ru_dokter.iduser')
            ->select(
                'rm.idrekam_medis',
                'rm.diagnosa',
                'rm.created_at',
                'p.nama as nama_pet',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter'
            )
            ->orderBy('rm.created_at', 'desc')
            ->limit(10) // Ambil 10 data terbaru
            ->get();
        
        // Antrian hari ini - TemuDokter untuk hari ini saja
        $jadwalHariIni = TemuDokter::whereDate('waktu_daftar', Carbon::today())
            ->count();
        
        // Total pasien - semua pet yang ada di temu_dokter
        $jumlahPasien = TemuDokter::distinct('idpet')
            ->count('idpet');
        
        // Total rekam medis
        $jumlahRekamMedis = RekamMedis::count('idrekam_medis');
        
        // List antrian hari ini dengan detail
        $antrianList = TemuDokter::with(['pet.pemilik'])
            ->whereDate('waktu_daftar', Carbon::today())
            ->orderBy('no_urut', 'asc')
            ->get()
            ->map(function($temu) {
                return (object)[
                    'no_urut' => $temu->no_urut,
                    'waktu_daftar' => $temu->waktu_daftar,
                    'nama_pet' => $temu->pet->nama ?? '-',
                    'nama_pemilik' => $temu->pet->pemilik->user->nama ?? '-',
                    'status' => $temu->status,
                    'idpet' => $temu->idpet,
                ];
            });
        
        return view('perawat.dashboard_perawat', [
            'rekamMedisList' => $rekamMedisList,
            'jadwalHariIni' => $jadwalHariIni,
            'jumlahPasien' => $jumlahPasien,
            'jumlahRekamMedis' => $jumlahRekamMedis,
            'antrianList' => $antrianList,
        ]);
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}