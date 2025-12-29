<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TemuDokterController extends Controller
{
    /**
     * Display a listing of the resource (hanya temu dokter milik pemilik yang login).
     */
    public function index(Request $request)
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
            
            // Ambil filter dari request (default: semua)
            $filter = $request->get('filter', 'semua');
            
            // Query temu dokter milik pemilik yang login
            $query = DB::table('temu_dokter as td')
                ->join('pet as p', 'p.idpet', '=', 'td.idpet')
                ->join('role_user as ru', 'ru.idrole_user', '=', 'td.idrole_user')
                ->join('user as u_dokter', 'u_dokter.iduser', '=', 'ru.iduser')
                ->select(
                    'td.*',
                    'p.nama as nama_pet',
                    'u_dokter.nama as nama_dokter'
                )
                ->where('p.idpemilik', $pemilik->idpemilik);
            
            // Terapkan filter berdasarkan pilihan
            if ($filter === 'hari-ini') {
                $today = Carbon::today()->toDateString();
                $query->whereDate('td.waktu_daftar', $today);
            } elseif ($filter === 'mendatang') {
                $query->where('td.waktu_daftar', '>=', Carbon::now())
                      ->where('td.status', '0');
            } elseif ($filter === 'selesai') {
                $query->where('td.status', '1');
            } elseif ($filter === 'dibatalkan') {
                $query->where('td.status', '2');
            }
            // Jika 'semua', tidak perlu menambahkan kondisi WHERE tambahan
            
            $temuDokter = $query->orderBy('td.waktu_daftar', 'desc')
                               ->orderBy('td.no_urut', 'asc')
                               ->get();
            
            return view('pemilik.temu-dokter.index', compact('temuDokter', 'filter'));
    }
}