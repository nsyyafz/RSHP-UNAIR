<?php

namespace App\Http\Controllers\Dokter;

use App\Models\Pet;
use App\Models\Role;
use App\Models\User;
use App\Models\Pemilik;
use App\Models\RasHewan;
use App\Models\JenisHewan;
use App\Models\RekamMedis;
use App\Models\KodeTindakan;
use App\Models\TemuDokter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class DashboardDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rm = RekamMedis::all('idrekam_medis')->first();
        // Jika tabel temu_dokter tidak punya kolom dokter, 
        // maka ambil semua data tanpa filter dokter
        
        // Antrian hari ini - TemuDokter untuk hari ini saja
        $antrianHariIni = TemuDokter::whereDate('waktu_daftar', Carbon::today())
            ->count();
        
        // Total pasien - semua pet yang ada di temu_dokter
        $totalPasien = TemuDokter::distinct('idpet')
            ->count('idpet');
        
        // Total rekam medis
        // Jika tabel rekam_medis juga tidak punya kolom dokter, hapus where clause
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
        
        return view('dokter.dashboard_dokter', [
            'rm' => $rm,
            'antrianHariIni' => $antrianHariIni,
            'totalPasien' => $totalPasien,
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