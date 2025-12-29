<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerawatController extends Controller
{
    // Konstanta untuk Role dan Status
    const ROLE_PERAWAT = 3; // Sesuaikan dengan ID role perawat di database
    const STATUS_AKTIF = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perawats = DB::table('perawat')
            ->join('user', 'perawat.iduser', '=', 'user.iduser')
            ->select('perawat.*', 'user.nama', 'user.email')
            ->get();
        
        return view('admin.perawat.index', compact('perawats'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.perawat.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validatePerawat($request);
            
            // Helper untuk menyimpan data (user + role + perawat)
            $this->createPerawat($validatedData);
            
            return redirect()->route('perawat.index')
                           ->with('success', 'Data perawat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('perawat.index')
                           ->with('error', 'Gagal menambahkan perawat: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $perawat = DB::table('perawat')
                ->join('user', 'perawat.iduser', '=', 'user.iduser')
                ->select('perawat.*', 'user.nama', 'user.email')
                ->where('perawat.id_perawat', $id)
                ->first();
            
            if (!$perawat) {
                return redirect()->route('perawat.index')
                                ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            // Bisa ditambahkan data terkait seperti jadwal kerja, pasien yang ditangani, dll
            
            return view('admin.perawat.show', compact('perawat'));
        } catch (\Exception $e) {
            return redirect()->route('perawat.index')
                           ->with('error', 'Data perawat tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $perawat = DB::table('perawat')
                ->join('user', 'perawat.iduser', '=', 'user.iduser')
                ->select('perawat.*', 'user.nama', 'user.email')
                ->where('perawat.id_perawat', $id)
                ->first();
            
            if (!$perawat) {
                return redirect()->route('perawat.index')
                                ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            return view('admin.perawat.edit', compact('perawat'));
        } catch (\Exception $e) {
            return redirect()->route('perawat.index')
                        ->with('error', 'Data perawat tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cek apakah data ada
            $perawat = DB::table('perawat')
                ->where('id_perawat', $id)
                ->first();

            if (!$perawat) {
                return redirect()->route('perawat.index')
                                ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validatePerawatUpdate($request, $perawat->iduser);
            
            // Update data user dan perawat dalam transaksi
            DB::beginTransaction();
            
            // Update user
            DB::table('user')
                ->where('iduser', $perawat->iduser)
                ->update([
                    'nama' => $this->formatNama($validatedData['nama']),
                    'email' => $validatedData['email']
                ]);
            
            // Update perawat
            DB::table('perawat')
                ->where('id_perawat', $id)
                ->update([
                    'alamat' => $this->formatAlamat($validatedData['alamat']),
                    'no_hp' => $this->formatNoHp($validatedData['no_hp']),
                    'pendidikan' => ucwords(strtolower(trim($validatedData['pendidikan']))),
                    'jenis_kelamin' => $validatedData['jenis_kelamin']
                ]);
            
            DB::commit();
            
            return redirect()->route('perawat.index')
                           ->with('success', 'Data perawat berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('perawat.index')
                           ->with('error', 'Gagal memperbarui perawat: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cek apakah data ada
            $perawat = DB::table('perawat')
                ->where('id_perawat', $id)
                ->first();

            if (!$perawat) {
                return redirect()->route('perawat.index')
                                ->with('error', 'Data perawat tidak ditemukan.');
            }
            
            // Cek apakah perawat memiliki data terkait (misal: jadwal kerja, perawatan pasien, dll)
            // Contoh:
            // $count = DB::table('jadwal_kerja')->where('id_perawat', $id)->count();
            // if ($count > 0) {
            //     return redirect()->route('perawat.index')
            //                    ->with('error', 'Perawat tidak dapat dihapus karena masih memiliki jadwal kerja.');
            // }
            
            // Hapus data dalam transaksi
            DB::beginTransaction();
            
            $iduser = $perawat->iduser;
            
            // 1. Hapus perawat
            DB::table('perawat')
                ->where('id_perawat', $id)
                ->delete();
            
            // 2. Hapus role_user (relasi user dengan role)
            DB::table('role_user')
                ->where('iduser', $iduser)
                ->delete();
            
            // 3. Hapus user
            DB::table('user')
                ->where('iduser', $iduser)
                ->delete();
            
            DB::commit();
            
            return redirect()->route('perawat.index')
                           ->with('success', 'Data perawat berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('perawat.index')
                           ->with('error', 'Gagal menghapus perawat: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data perawat untuk create
     */
    protected function validatePerawat(Request $request)
    {
        return $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'min:3'
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:user,email'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
            'alamat' => [
                'required',
                'string',
                'max:100',
                'min:10'
            ],
            'no_hp' => [
                'required',
                'string',
                'max:45',
                'min:10',
                'regex:/^[0-9]+$/',
                'unique:perawat,no_hp'
            ],
            'pendidikan' => [
                'required',
                'string',
                'max:100'
            ],
            'jenis_kelamin' => [
                'required',
                'in:L,P'
            ]
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 100 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.min' => 'Nomor HP minimal 10 digit.',
            'no_hp.max' => 'Nomor HP maksimal 45 digit.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',
            'pendidikan.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan.max' => 'Pendidikan maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.'
        ]);
    }

    /**
     * Validasi data perawat untuk update
     */
    protected function validatePerawatUpdate(Request $request, $iduser)
    {
        return $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                'min:3'
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:user,email,' . $iduser . ',iduser'
            ],
            'alamat' => [
                'required',
                'string',
                'max:100',
                'min:10'
            ],
            'no_hp' => [
                'required',
                'string',
                'max:45',
                'min:10',
                'regex:/^[0-9]+$/'
            ],
            'pendidikan' => [
                'required',
                'string',
                'max:100'
            ],
            'jenis_kelamin' => [
                'required',
                'in:L,P'
            ]
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 100 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.min' => 'Nomor HP minimal 10 digit.',
            'no_hp.max' => 'Nomor HP maksimal 45 digit.',
            'pendidikan.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan.max' => 'Pendidikan maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.'
        ]);
    }

    /**
     * Helper untuk membuat perawat baru (user + role + perawat)
     */
    protected function createPerawat(array $data)
    {
        try {
            DB::beginTransaction();
            
            // 1. Generate dan insert user
            $maxUserId = DB::table('user')->max('iduser');
            $iduser = $maxUserId ? $maxUserId + 1 : 1;
            
            DB::table('user')->insert([
                'iduser' => $iduser,
                'nama' => $this->formatNama($data['nama']),
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            
            // 2. Insert ke role_user (assign role perawat)
            $maxRoleUserId = DB::table('role_user')->max('idrole_user');
            $idroleUser = $maxRoleUserId ? $maxRoleUserId + 1 : 1;
            
            DB::table('role_user')->insert([
                'idrole_user' => $idroleUser,
                'iduser' => $iduser,
                'idrole' => self::ROLE_PERAWAT,
                'status' => self::STATUS_AKTIF
            ]);
            
            // 3. Generate dan insert perawat
            $maxPerawatId = DB::table('perawat')->max('id_perawat');
            $idPerawat = $maxPerawatId ? $maxPerawatId + 1 : 1;
            
            DB::table('perawat')->insert([
                'id_perawat' => $idPerawat,
                'alamat' => $this->formatAlamat($data['alamat']),
                'no_hp' => $this->formatNoHp($data['no_hp']),
                'pendidikan' => ucwords(strtolower(trim($data['pendidikan']))),
                'jenis_kelamin' => $data['jenis_kelamin'],
                'iduser' => $iduser
            ]);
            
            DB::commit();
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Gagal menyimpan perawat: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama
     */
    protected function formatNama($nama)
    {
        return ucwords(strtolower(trim($nama)));
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

    /**
     * Helper untuk format alamat
     */
    protected function formatAlamat($alamat)
    {
        return ucfirst(trim($alamat));
    }
}