<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource (hanya pet milik pemilik yang login).
     */
    public function index()
    {
            $iduser = Auth::id();
            
            // Ambil data pemilik
            $pemilik = DB::table('pemilik')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.dashboard')
                    ->with('error', 'Data pemilik tidak ditemukan');
            }
            
            // Ambil pet milik pemilik yang login
            $pets = DB::table('pet')
                ->leftJoin('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
                ->leftJoin('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
                ->select(
                    'pet.*',
                    'ras_hewan.nama_ras',
                    'jenis_hewan.nama_jenis_hewan'
                )
                ->where('pet.idpemilik', $pemilik->idpemilik)
                ->orderBy('pet.nama', 'asc')
                ->get();
            
            return view('pemilik.pet.index', compact('pets'));
    }
}