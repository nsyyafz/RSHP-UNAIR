<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardResepsionisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Total Pet yang terdaftar
            $jumlahPet = DB::table('pet')->count();
            
            // Total Pemilik
            $jumlahPemilik = DB::table('pemilik')->count();
            
            // Antrian Hari Ini (semua temu dokter hari ini)
            $antrianHariIni = DB::table('temu_dokter')
                ->whereDate('waktu_daftar', Carbon::today())
                ->count();
            
            // Antrian Pending (status = 0) hari ini
            $antrianPending = DB::table('temu_dokter')
                ->whereDate('waktu_daftar', Carbon::today())
                ->where('status', 0)
                ->count();
            
            // List Antrian Hari Ini dengan detail
            $antrianList = DB::table('temu_dokter')
                ->leftJoin('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
                ->leftJoin('dokter', 'role_user.iduser', '=', 'dokter.iduser')
                ->leftJoin('user as user_dokter', 'dokter.iduser', '=', 'user_dokter.iduser')
                ->leftJoin('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
                ->leftJoin('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
                ->leftJoin('user as user_pemilik', 'pemilik.iduser', '=', 'user_pemilik.iduser')
                ->select(
                    'temu_dokter.idreservasi_dokter',
                    'temu_dokter.no_urut',
                    'temu_dokter.waktu_daftar',
                    'temu_dokter.status',
                    'pet.idpet',
                    'pet.nama as nama_pet',
                    'user_pemilik.nama as nama_pemilik',
                    'user_dokter.nama as nama_dokter'
                )
                ->whereDate('temu_dokter.waktu_daftar', Carbon::today())
                ->orderBy('temu_dokter.no_urut', 'asc')
                ->get();
            
            return view('resepsionis.dashboard_resepsionis', compact(
                'jumlahPet',
                'jumlahPemilik',
                'antrianHariIni',
                'antrianPending',
                'antrianList'
            ));
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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