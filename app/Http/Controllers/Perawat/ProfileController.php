<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil perawat yang sedang login
     */
    public function index()
    {
        try {
            $iduser = Auth::id();
            
            // Ambil data perawat
            $perawat = DB::table('perawat')
                ->join('user', 'perawat.iduser', '=', 'user.iduser')
                ->select(
                    'perawat.id_perawat',
                    'perawat.alamat',
                    'perawat.no_hp',
                    'perawat.jenis_kelamin',
                    'perawat.pendidikan',
                    'perawat.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('perawat.iduser', $iduser)
                ->first();
            
            if (!$perawat) {
                return redirect()->route('perawat.dashboard')
                    ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            return view('perawat.profile.index', compact('perawat'));
            
        } catch (\Exception $e) {
            return redirect()->route('perawat.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit profil perawat
     */
    public function edit()
    {
        try {
            $iduser = Auth::id();
            
            $perawat = DB::table('perawat')
                ->join('user', 'perawat.iduser', '=', 'user.iduser')
                ->select(
                    'perawat.id_perawat',
                    'perawat.alamat',
                    'perawat.no_hp',
                    'perawat.jenis_kelamin',
                    'perawat.pendidikan',
                    'perawat.iduser',
                    'user.nama',
                    'user.email'
                )
                ->where('perawat.iduser', $iduser)
                ->first();
            
            if (!$perawat) {
                return redirect()->route('perawat.profile.index')
                    ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            return view('perawat.profile.edit', compact('perawat'));
            
        } catch (\Exception $e) {
            return redirect()->route('perawat.profile.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update profil perawat
     */
    public function update(Request $request)
    {
        try {
            $iduser = Auth::id();
            
            // Cek apakah perawat ada
            $perawat = DB::table('perawat')
                ->where('iduser', $iduser)
                ->first();
            
            if (!$perawat) {
                return redirect()->route('perawat.profile.index')
                    ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:100|min:3',
                'email' => 'required|email|max:100|unique:user,email,' . $iduser . ',iduser',
                'alamat' => 'required|string|max:100|min:10',
                'no_hp' => 'required|string|max:45|min:10|regex:/^[0-9]+$/',
                'pendidikan' => 'required|string|max:100',
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
                'pendidikan.required' => 'Pendidikan terakhir wajib diisi.',
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
            
            // Update perawat
            DB::table('perawat')
                ->where('iduser', $iduser)
                ->update([
                    'alamat' => ucfirst(trim($validated['alamat'])),
                    'no_hp' => $this->formatNoHp($validated['no_hp']),
                    'pendidikan' => ucwords(strtolower(trim($validated['pendidikan']))),
                    'jenis_kelamin' => $validated['jenis_kelamin']
                ]);
            
            DB::commit();
            
            return redirect()->route('perawat.profile.index')
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