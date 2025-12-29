<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    // Konstanta untuk Role dan Status
    const ROLE_DOKTER = 2; // Sesuaikan dengan ID role dokter di database
    const STATUS_AKTIF = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = DB::table('dokter')
            ->join('user', 'dokter.iduser', '=', 'user.iduser')
            ->select('dokter.*', 'user.nama', 'user.email')
            ->get();
        
        return view('admin.dokter.index', compact('dokters'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dokter.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateDokter($request);
            
            // Helper untuk menyimpan data (user + role + dokter)
            $this->createDokter($validatedData);
            
            return redirect()->route('dokter.index')
                           ->with('success', 'Data dokter berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('dokter.index')
                           ->with('error', 'Gagal menambahkan dokter: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $dokter = DB::table('dokter')
                ->join('user', 'dokter.iduser', '=', 'user.iduser')
                ->select('dokter.*', 'user.nama', 'user.email')
                ->where('dokter.id_dokter', $id)
                ->first();
            
            if (!$dokter) {
                return redirect()->route('dokter.index')
                                ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            // Bisa ditambahkan data terkait seperti jadwal praktek, pasien, dll
            
            return view('admin.dokter.show', compact('dokter'));
        } catch (\Exception $e) {
            return redirect()->route('dokter.index')
                           ->with('error', 'Data dokter tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $dokter = DB::table('dokter')
                ->join('user', 'dokter.iduser', '=', 'user.iduser')
                ->select('dokter.*', 'user.nama', 'user.email')
                ->where('dokter.id_dokter', $id)
                ->first();
            
            if (!$dokter) {
                return redirect()->route('dokter.index')
                                ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            return view('admin.dokter.edit', compact('dokter'));
        } catch (\Exception $e) {
            return redirect()->route('dokter.index')
                        ->with('error', 'Data dokter tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cek apakah data ada
            $dokter = DB::table('dokter')
                ->where('id_dokter', $id)
                ->first();

            if (!$dokter) {
                return redirect()->route('dokter.index')
                                ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateDokterUpdate($request, $dokter->iduser);
            
            // Update data user dan dokter dalam transaksi
            DB::beginTransaction();
            
            // Update user
            DB::table('user')
                ->where('iduser', $dokter->iduser)
                ->update([
                    'nama' => $this->formatNama($validatedData['nama']),
                    'email' => $validatedData['email']
                ]);
            
            // Update dokter
            DB::table('dokter')
                ->where('id_dokter', $id)
                ->update([
                    'alamat' => $this->formatAlamat($validatedData['alamat']),
                    'no_hp' => $this->formatNoHp($validatedData['no_hp']),
                    'bidang_dokter' => ucwords(strtolower(trim($validatedData['bidang_dokter']))),
                    'jenis_kelamin' => $validatedData['jenis_kelamin']
                ]);
            
            DB::commit();
            
            return redirect()->route('dokter.index')
                           ->with('success', 'Data dokter berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dokter.index')
                           ->with('error', 'Gagal memperbarui dokter: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cek apakah data ada
            $dokter = DB::table('dokter')
                ->where('id_dokter', $id)
                ->first();

            if (!$dokter) {
                return redirect()->route('dokter.index')
                                ->with('error', 'Data dokter tidak ditemukan.');
            }
            
            // Cek apakah dokter memiliki data terkait (misal: jadwal praktek, konsultasi, dll)
            // Contoh:
            // $count = DB::table('jadwal_praktek')->where('id_dokter', $id)->count();
            // if ($count > 0) {
            //     return redirect()->route('dokter.index')
            //                    ->with('error', 'Dokter tidak dapat dihapus karena masih memiliki jadwal praktek.');
            // }
            
            // Hapus data dalam transaksi
            DB::beginTransaction();
            
            $iduser = $dokter->iduser;
            
            // 1. Hapus dokter
            DB::table('dokter')
                ->where('id_dokter', $id)
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
            
            return redirect()->route('dokter.index')
                           ->with('success', 'Data dokter berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dokter.index')
                           ->with('error', 'Gagal menghapus dokter: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data dokter untuk create
     */
    protected function validateDokter(Request $request)
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
                'unique:dokter,no_hp'
            ],
            'bidang_dokter' => [
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
            'bidang_dokter.required' => 'Bidang dokter/spesialisasi wajib diisi.',
            'bidang_dokter.max' => 'Bidang dokter maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.'
        ]);
    }

    /**
     * Validasi data dokter untuk update
     */
    protected function validateDokterUpdate(Request $request, $iduser)
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
            'bidang_dokter' => [
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
            'bidang_dokter.required' => 'Bidang dokter/spesialisasi wajib diisi.',
            'bidang_dokter.max' => 'Bidang dokter maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.'
        ]);
    }

    /**
     * Helper untuk membuat dokter baru (user + role + dokter)
     */
    protected function createDokter(array $data)
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
            
            // 2. Insert ke role_user (assign role dokter)
            $maxRoleUserId = DB::table('role_user')->max('idrole_user');
            $idroleUser = $maxRoleUserId ? $maxRoleUserId + 1 : 1;
            
            DB::table('role_user')->insert([
                'idrole_user' => $idroleUser,
                'iduser' => $iduser,
                'idrole' => self::ROLE_DOKTER,
                'status' => self::STATUS_AKTIF
            ]);
            
            // 3. Generate dan insert dokter
            $maxDokterId = DB::table('dokter')->max('id_dokter');
            $idDokter = $maxDokterId ? $maxDokterId + 1 : 1;
            
            DB::table('dokter')->insert([
                'id_dokter' => $idDokter,
                'alamat' => $this->formatAlamat($data['alamat']),
                'no_hp' => $this->formatNoHp($data['no_hp']),
                'bidang_dokter' => ucwords(strtolower(trim($data['bidang_dokter']))),
                'jenis_kelamin' => $data['jenis_kelamin'],
                'iduser' => $iduser
            ]);
            
            DB::commit();
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Gagal menyimpan dokter: " . $e->getMessage());
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