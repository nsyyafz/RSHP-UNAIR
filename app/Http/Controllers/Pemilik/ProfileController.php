<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil pemilik yang sedang login
     */
    public function index()
    {
        try {
            $iduser = Auth::id();
            
            // Ambil data pemilik
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'pemilik.idpemilik',
                    'pemilik.alamat',
                    'pemilik.no_wa',
                    'pemilik.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('pemilik.iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.dashboard')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Hitung statistik
            $totalPet = DB::table('pet')
                ->where('idpemilik', $pemilik->idpemilik)
                ->count();
            
            $totalTemuDokter = DB::table('temu_dokter')
                ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
                ->where('pet.idpemilik', $pemilik->idpemilik)
                ->count();
            
            $totalRekamMedis = DB::table('rekam_medis')
                ->join('pet', 'rekam_medis.idpet', '=', 'pet.idpet')
                ->where('pet.idpemilik', $pemilik->idpemilik)
                ->count();
            
            return view('pemilik.profile.index', compact('pemilik', 'totalPet', 'totalTemuDokter', 'totalRekamMedis'));
            
        } catch (\Exception $e) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit profil pemilik
     */
    public function edit()
    {
        try {
            $iduser = Auth::id();
            
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select(
                    'pemilik.idpemilik',
                    'pemilik.alamat',
                    'pemilik.no_wa',
                    'pemilik.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('pemilik.iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.profile.index')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            return view('pemilik.profile.edit', compact('pemilik'));
            
        } catch (\Exception $e) {
            return redirect()->route('pemilik.profile.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update profil pemilik
     */
    public function update(Request $request)
    {
        try {
            $iduser = Auth::id();
            
            // Cek apakah pemilik ada
            $pemilik = DB::table('pemilik')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.profile.index')
                    ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:100|min:3',
                'email' => 'required|email|max:100|unique:user,email,' . $iduser . ',iduser',
                'alamat' => 'required|string|max:100|min:10',
                'no_wa' => 'required|string|max:45|min:10|regex:/^[0-9]+$/'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.min' => 'Nama minimal 3 karakter.',
                'nama.max' => 'Nama maksimal 100 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'email.max' => 'Email maksimal 100 karakter.',
                'alamat.required' => 'Alamat wajib diisi.',
                'alamat.min' => 'Alamat minimal 10 karakter.',
                'alamat.max' => 'Alamat maksimal 100 karakter.',
                'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
                'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
                'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
                'no_wa.max' => 'Nomor WhatsApp maksimal 45 karakter.'
            ]);
            
            DB::beginTransaction();
            
            // Update user
            DB::table('user')
                ->where('iduser', $iduser)
                ->update([
                    'nama' => ucwords(strtolower(trim($validated['nama']))),
                    'email' => trim($validated['email'])
                ]);
            
            // Update pemilik
            DB::table('pemilik')
                ->where('iduser', $iduser)
                ->update([
                    'alamat' => ucfirst(trim($validated['alamat'])),
                    'no_wa' => $this->formatNoWa($validated['no_wa'])
                ]);
            
            DB::commit();
            
            return redirect()->route('pemilik.profile.index')
                ->with('success', 'Profil berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper untuk format nomor WhatsApp
     */
    protected function formatNoWa($noWa)
    {
        // Hapus spasi dan karakter non-digit
        $noWa = preg_replace('/[^0-9]/', '', $noWa);
        
        // Jika diawali 0, ganti dengan 62
        if (substr($noWa, 0, 1) === '0') {
            $noWa = '62' . substr($noWa, 1);
        }
        
        return $noWa;
    }
}