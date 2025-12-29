<?php

namespace App\Http\Controllers\Admin;

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

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return view('admin.dashboard_admin', [
        'jumlahPet' => Pet::count(),
        'jumlahPemilik' => Pemilik::count(),
        'jumlahJenis' => JenisHewan::count(),
        'jumlahRekam' => RekamMedis::count(),
        'jumlahRas' => RasHewan::count(),
        'jumlahUser' => User::count(),
        'jumlahRole' => Role::count(),
        'jumlahTindakan' => KodeTindakan::count(),
        'jumlahTemuDokter' => TemuDokter::count(),
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
