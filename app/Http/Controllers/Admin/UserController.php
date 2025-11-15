<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eloquent
        // $users = User::all();
        
        // Query Builder
        // Ambil semua user tanpa info role
        $users = DB::table('user')
            ->select('user.*')
            ->get();
        
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateUser($request);
            
            // Buat user baru
            $this->createUser($validatedData);
            
            return redirect()->route('user.index')
                           ->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Eloquent
            // $user = User::findOrFail($id);
            
            // Query Builder
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();
            
            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            return view('admin.user.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Data user tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Eloquent
            // $user = User::findOrFail($id);
            
            // Query Builder
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();
            
            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            return view('admin.user.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Data user tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Eloquent
            // $user = User::findOrFail($id);
            // $user->update($updateData);
            
            // Query Builder
            // Cek apakah user ada
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();

            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateUser($request, $id, true);
            
            // Update data user (hanya nama dan email)
            DB::table('user')
                ->where('iduser', $id)
                ->update([
                    'nama' => $this->formatNama($validatedData['nama']),
                    'email' => strtolower($validatedData['email'])
                ]);
            
            return redirect()->route('user.index')
                           ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Eloquent
            // $user = User::findOrFail($id);
            // if ($user->role()->exists()) {
            //     return redirect()->route('user.index')
            //                    ->with('error', 'User tidak dapat dihapus karena memiliki role.');
            // }
            // if ($user->pets()->exists()) {
            //     return redirect()->route('user.index')
            //                    ->with('error', 'User tidak dapat dihapus karena memiliki pet.');
            // }
            // $user->delete();
            
            // Query Builder
            // Cek apakah user ada
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();

            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            // Cek apakah user memiliki role
            $roleCount = DB::table('role_user')
                ->where('iduser', $id)
                ->count();
            
            if ($roleCount > 0) {
                return redirect()->route('user.index')
                               ->with('error', 'User tidak dapat dihapus karena memiliki role. Hapus role terlebih dahulu di menu Role.');
            }
            
            // Cek apakah user memiliki pet (sebagai pemilik)
            $petCount = DB::table('pet')
                ->where('idpemilik', $id)
                ->count();
            
            if ($petCount > 0) {
                return redirect()->route('user.index')
                               ->with('error', 'User tidak dapat dihapus karena memiliki hewan peliharaan terdaftar.');
            }
            
            // Hapus user
            DB::table('user')
                ->where('iduser', $id)
                ->delete();
            
            return redirect()->route('user.index')
                           ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Reset password user
     */
    public function resetPassword(string $id)
    {
        try {
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();
            
            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            return view('admin.user.reset-password', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Data user tidak ditemukan.');
        }
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request, string $id)
    {
        try {
            // Cek apakah user ada
            $user = DB::table('user')
                ->where('iduser', $id)
                ->first();

            if (!$user) {
                return redirect()->route('user.index')
                                ->with('error', 'Data user tidak ditemukan.');
            }
            
            // Validasi password
            $validatedData = $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed'
                ]
            ], [
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.'
            ]);
            
            // Update password
            DB::table('user')
                ->where('iduser', $id)
                ->update([
                    'password' => Hash::make($validatedData['password'])
                ]);
            
            return redirect()->route('user.index')
                           ->with('success', 'Password berhasil direset.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data user
     */
    protected function validateUser(Request $request, $id = null, $isUpdate = false)
    {
        // Rule unique untuk email
        $uniqueEmailRule = $id ?
            'unique:user,email,' . $id . ',iduser' :
            'unique:user,email';

        // Rule password (required hanya saat create)
        $rules = [
            'nama' => [
                'required',
                'string',
                'max:100',
                'min:3'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                $uniqueEmailRule
            ]
        ];

        // Tambahkan validasi password hanya untuk create
        if (!$isUpdate) {
            $rules['password'] = [
                'required',
                'string',
                'min:8',
                'confirmed'
            ];
        }

        return $request->validate($rules, [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);
    }

    /**
     * Helper untuk membuat user baru
     */
    protected function createUser(array $data)
    {
        try {
            // Eloquent
            // return User::create([
            //     'nama' => $this->formatNama($data['nama']),
            //     'email' => strtolower($data['email']),
            //     'password' => Hash::make($data['password'])
            // ]);
            
            // Query Builder
            // Generate iduser baru
            $maxId = DB::table('user')->max('iduser');
            $iduser = $maxId ? $maxId + 1 : 1;
            DB::table('user')->insert([
                'iduser' => $iduser,
                'nama' => $this->formatNama($data['nama']),
                'email' => strtolower($data['email']),
                'password' => Hash::make($data['password'])
            ]);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan user: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama
     */
    protected function formatNama($nama)
    {
        return ucwords(strtolower($nama));
    }
}