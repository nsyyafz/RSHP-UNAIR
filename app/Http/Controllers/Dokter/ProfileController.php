<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil dokter yang sedang login
     */
    public function index()
    {
        try {
            $iduser = Auth::id();
            
            // Ambil data dokter
            $dokter = DB::table('dokter')
                ->join('user', 'dokter.iduser', '=', 'user.iduser')
                ->select(
                    'dokter.id_dokter',
                    'dokter.alamat',
                    'dokter.no_hp',
                    'dokter.bidang_dokter',
                    'dokter.jenis_kelamin',
                    'dokter.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('dokter.iduser', $iduser)
                ->first();
            
            if (!$dokter) {
                return redirect()->route('dokter.dashboard')
                    ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            return view('dokter.profile.index', compact('dokter'));
            
        } catch (\Exception $e) {
            return redirect()->route('dokter.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit profil dokter
     */
    public function edit()
    {
        try {
            $iduser = Auth::id();
            
            $dokter = DB::table('dokter')
                ->join('user', 'dokter.iduser', '=', 'user.iduser')
                ->select(
                    'dokter.id_dokter',
                    'dokter.alamat',
                    'dokter.no_hp',
                    'dokter.bidang_dokter',
                    'dokter.jenis_kelamin',
                    'dokter.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('dokter.iduser', $iduser)
                ->first();
            
            if (!$dokter) {
                return redirect()->route('dokter.profile.index')
                    ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            return view('dokter.profile.edit', compact('dokter'));
            
        } catch (\Exception $e) {
            return redirect()->route('dokter.profile.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update profil dokter
     */
    public function update(Request $request)
    {
        try {
            $iduser = Auth::id();
            
            // Cek apakah dokter ada
            $dokter = DB::table('dokter')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$dokter) {
                return redirect()->route('dokter.profile.index')
                    ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:100|min:3',
                'email' => 'required|email|max:100|unique:user,email,' . $iduser . ',iduser',
                'alamat' => 'required|string|max:100|min:10',
                'no_hp' => 'required|string|max:45|min:10|regex:/^[0-9]+$/',
                'bidang_dokter' => 'required|string|max:100',
                'jenis_kelamin' => 'required|in:L,P'
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.min' => 'Nama minimal 3 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'alamat.required' => 'Alamat wajib diisi.',
                'alamat.min' => 'Alamat minimal 10 karakter.',
                'no_hp.required' => 'Nomor HP wajib diisi.',
                'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
                'no_hp.min' => 'Nomor HP minimal 10 digit.',
                'bidang_dokter.required' => 'Bidang dokter wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in' => 'Jenis kelamin tidak valid.'
            ]);
            
            DB::beginTransaction();
            
            // Update user
            DB::table('user')
                ->where('iduser', $iduser)
                ->update([
                    'nama' => ucwords(strtolower(trim($validated['nama']))),
                    'email' => $validated['email']
                ]);
            
            // Update dokter
            DB::table('dokter')
                ->where('iduser', $iduser)
                ->update([
                    'alamat' => ucfirst(trim($validated['alamat'])),
                    'no_hp' => $this->formatNoHp($validated['no_hp']),
                    'bidang_dokter' => ucwords(strtolower(trim($validated['bidang_dokter']))),
                    'jenis_kelamin' => $validated['jenis_kelamin']
                ]);
            
            DB::commit();
            
            return redirect()->route('dokter.profile.index')
                ->with('success', 'Profil berhasil diperbarui.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Helper untuk format nomor HP
     */
    protected function formatNoHp($noHp)
    {
        // Hapus spasi dan karakter non-digit
        $noHp = preg_replace('/[^0-9]/', '', $noHp);
        
        // Jika diawali 0, ganti dengan 62
        if (substr($noHp, 0, 1) === '0') {
            $noHp = '62' . substr($noHp, 1);
        }
        
        return $noHp;
    }
}