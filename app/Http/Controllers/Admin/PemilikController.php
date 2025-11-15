<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use App\Models\Pemilik;
// use App\Models\User;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eloquent
        // $pemiliks = Pemilik::with('user')->get();
        
        // Query Builder
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->get();
        
        return view('admin.pemilik.index', compact('pemiliks'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pemilik.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validatePemilik($request);
            
            // Helper untuk menyimpan data (user + pemilik)
            $this->createPemilik($validatedData);
            
            return redirect()->route('pemilik.index')
                           ->with('success', 'Data pemilik berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('pemilik.index')
                           ->with('error', 'Gagal menambahkan pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Eloquent
            // $pemilik = Pemilik::with(['user', 'pets'])->findOrFail($id);
            
            // Query Builder
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.*', 'user.nama', 'user.email')
                ->where('pemilik.idpemilik', $id)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Ambil pets terkait
            $pets = DB::table('pet')
                ->where('idpemilik', $id)
                ->get();
            
            return view('admin.pemilik.show', compact('pemilik', 'pets'));
        } catch (\Exception $e) {
            return redirect()->route('pemilik.index')
                           ->with('error', 'Data pemilik tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Eloquent
            // $pemilik = Pemilik::with('user')->findOrFail($id);
            
            // Query Builder
            $pemilik = DB::table('pemilik')
                ->join('user', 'pemilik.iduser', '=', 'user.iduser')
                ->select('pemilik.*', 'user.nama', 'user.email')
                ->where('pemilik.idpemilik', $id)
                ->first();
            
            if (!$pemilik) {
                return redirect()->route('pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            return view('admin.pemilik.edit', compact('pemilik'));
        } catch (\Exception $e) {
            return redirect()->route('pemilik.index')
                        ->with('error', 'Data pemilik tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Eloquent
            // $pemilik = Pemilik::with('user')->findOrFail($id);
            // DB::transaction(function () use ($pemilik, $validatedData) {
            //     $pemilik->user->update([
            //         'nama' => $validatedData['nama'],
            //         'email' => $validatedData['email']
            //     ]);
            //     $pemilik->update([
            //         'no_wa' => $this->formatNoWa($validatedData['no_wa']),
            //         'alamat' => $this->formatAlamat($validatedData['alamat'])
            //     ]);
            // });
            
            // Query Builder
            // Cek apakah data ada
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()->route('pemilik.index')
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
            
            return redirect()->route('pemilik.index')
                           ->with('success', 'Data pemilik berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemilik.index')
                           ->with('error', 'Gagal memperbarui pemilik: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Eloquent
            // $pemilik = Pemilik::findOrFail($id);
            // if ($pemilik->pets()->count() > 0) {
            //     return redirect()->route('pemilik.index')
            //                    ->with('error', 'Pemilik tidak dapat dihapus karena masih memiliki hewan peliharaan terdaftar.');
            // }
            // DB::transaction(function () use ($pemilik) {
            //     $iduser = $pemilik->iduser;
            //     $pemilik->delete();
            //     User::destroy($iduser);
            // });
            
            // Query Builder
            // Cek apakah data ada
            $pemilik = DB::table('pemilik')
                ->where('idpemilik', $id)
                ->first();

            if (!$pemilik) {
                return redirect()->route('pemilik.index')
                                ->with('error', 'Data pemilik tidak ditemukan.');
            }
            
            // Cek apakah pemilik memiliki pet
            $count = DB::table('pet')
                ->where('idpemilik', $id)
                ->count();
            
            if ($count > 0) {
                return redirect()->route('pemilik.index')
                               ->with('error', 'Pemilik tidak dapat dihapus karena masih memiliki hewan peliharaan terdaftar.');
            }
            
            // Hapus data dalam transaksi (pemilik dulu, baru user)
            DB::beginTransaction();
            
            $iduser = $pemilik->iduser;
            
            // Hapus pemilik
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->delete();
            
            // Hapus user
            DB::table('user')
                ->where('iduser', $iduser)
                ->delete();
            
            DB::commit();
            
            return redirect()->route('pemilik.index')
                           ->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemilik.index')
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
                'min:8',
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
            'password.min' => 'Password minimal 8 karakter.',
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
     * Helper untuk membuat pemilik baru (user + pemilik)
     */
    protected function createPemilik(array $data)
    {
        try {
            // Eloquent
            // return DB::transaction(function () use ($data) {
            //     $user = User::create([
            //         'nama' => $this->formatNama($data['nama']),
            //         'email' => $data['email'],
            //         'password' => Hash::make($data['password'])
            //     ]);
            //     
            //     return Pemilik::create([
            //         'no_wa' => $this->formatNoWa($data['no_wa']),
            //         'alamat' => $this->formatAlamat($data['alamat']),
            //         'iduser' => $user->iduser
            //     ]);
            // });
            
            // Query Builder
            DB::beginTransaction();
            
            // Insert user dulu
            // Generate iduser baru
            $maxId = DB::table('user')->max('iduser');
            $iduser = $maxId ? $maxId + 1 : 1;
            $iduser = DB::table('user')->insertGetId([
                'iduser' => $iduser,
                'nama' => $this->formatNama($data['nama']),
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
            
            // Generate idpemilik baru
            $maxId = DB::table('pemilik')->max('idpemilik');
            $idpemilik = $maxId ? $maxId + 1 : 1;
            
            // Insert pemilik
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