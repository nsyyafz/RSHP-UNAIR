<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PemilikController extends Controller
{
    // Konstanta untuk Role dan Status
    const ROLE_PEMILIK = 5;
    const STATUS_AKTIF = 1;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->get();
        
        return view('resepsionis.pemilik.index', compact('pemiliks'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resepsionis.pemilik.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validatePemilik($request);
            
            // Helper untuk menyimpan data (user + role + pemilik)
            $this->createPemilik($validatedData);
            
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('success', 'Data pemilik berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('error', 'Gagal menambahkan pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.*', 'user.nama', 'user.email')
                ->where('pemilik.idpemilik', $id)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('resepsionis.pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Ambil pets terkait
            $pets = DB::table('pet')
                ->where('idpemilik', $id)
                ->get();
            
            return view('resepsionis.pemilik.show', compact('pemilik', 'pets'));
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('error', 'Data pemilik tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.*', 'user.nama', 'user.email')
                ->where('pemilik.idpemilik', $id)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('resepsionis.pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            return view('resepsionis.pemilik.edit', compact('pemilik'));
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.pemilik.index')
                        ->with('error', 'Data pemilik tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Cek apakah data ada
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()->route('resepsionis.pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validatePemilikUpdate($request, $pemilik->iduser);
            
            // Update data user dan pemilik dalam transaksi
            DB::beginTransaction();
            
            // Update user
            DB::table('user')
                ->where('iduser', $pemilik->iduser)
                ->update([
                    'nama' => $this->formatNama($validatedData['nama']),
                    'email' => $validatedData['email']
                ]);
            
            // Update pemilik
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->update([
                    'no_wa' => $this->formatNoWa($validatedData['no_wa']),
                    'alamat' => $this->formatAlamat($validatedData['alamat'])
                ]);
            
            DB::commit();
            
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('success', 'Data pemilik berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('error', 'Gagal memperbarui pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cek apakah data ada
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()->route('resepsionis.pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Cek apakah pemilik memiliki pet
            $count = DB::table('pet')
                ->where('idpemilik', $id)
                ->count();
            
            if ($count > 0) {
                return redirect()->route('resepsionis.pemilik.index')
                               ->with('error', 'Pemilik tidak dapat dihapus karena masih memiliki hewan peliharaan terdaftar.');
            }
            
            // Hapus data dalam transaksi
            DB::beginTransaction();
            
            $iduser = $pemilik->iduser;
            
            // 1. Hapus pemilik
            DB::table('pemilik')
                ->where('idpemilik', $id)
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
            
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.pemilik.index')
                           ->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data pemilik untuk create
     */
    protected function validatePemilik(Request $request)
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
            'no_wa' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^[0-9]+$/',
                'unique:pemilik,no_wa'
            ],
            'alamat' => [
                'required',
                'string',
                'max:500',
                'min:10'
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
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 20 digit.',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.'
        ]);
    }

    /**
     * Validasi data pemilik untuk update
     */
    protected function validatePemilikUpdate(Request $request, $iduser)
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
            'no_wa' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^[0-9]+$/'
            ],
            'alamat' => [
                'required',
                'string',
                'max:500',
                'min:10'
            ]
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 20 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.'
        ]);
    }

    /**
     * Helper untuk membuat pemilik baru (user + role + pemilik)
     */
    protected function createPemilik(array $data)
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
            
            // 2. Insert ke role_user (assign role pemilik)
            $maxRoleUserId = DB::table('role_user')->max('idrole_user');
            $idroleUser = $maxRoleUserId ? $maxRoleUserId + 1 : 1;
            
            DB::table('role_user')->insert([
                'idrole_user' => $idroleUser,
                'iduser' => $iduser,
                'idrole' => self::ROLE_PEMILIK,
                'status' => self::STATUS_AKTIF
            ]);
            
            // 3. Generate dan insert pemilik
            $maxPemilikId = DB::table('pemilik')->max('idpemilik');
            $idpemilik = $maxPemilikId ? $maxPemilikId + 1 : 1;
            
            DB::table('pemilik')->insert([
                'idpemilik' => $idpemilik,
                'no_wa' => $this->formatNoWa($data['no_wa']),
                'alamat' => $this->formatAlamat($data['alamat']),
                'iduser' => $iduser
            ]);
            
            DB::commit();
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Gagal menyimpan pemilik: " . $e->getMessage());
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
     * Helper untuk format nomor WA
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

    /**
     * Helper untuk format alamat
     */
    protected function formatAlamat($alamat)
    {
        return ucfirst(trim($alamat));
    }
}