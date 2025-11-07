<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RolesUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('idrole', 'nama_role')->get();
        return view('admin.user.create', compact('roles'));
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
            $user = $this->createUser($validatedData);
            
            // Assign role ke user
            $this->assignRoles($user, $validatedData['roles']);
            
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
            $user = User::with('role')->findOrFail($id);
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
            $user = User::with('role')->findOrFail($id);
            $roles = Role::select('idrole', 'nama_role')->get();
            $userRoles = $user->role->pluck('idrole')->toArray();
            
            return view('admin.user.edit', compact('user', 'roles', 'userRoles'));
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
            // Cari data user
            $user = User::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateUser($request, $id);
            
            // Update data user
            $updateData = [
                'nama' => $this->formatNama($validatedData['nama']),
                'email' => strtolower($validatedData['email'])
            ];
            
            // Update password jika diisi
            if (!empty($validatedData['password'])) {
                $updateData['password'] = Hash::make($validatedData['password']);
            }
            
            $user->update($updateData);
            
            // Update roles
            if (isset($validatedData['roles'])) {
                $this->syncRoles($user, $validatedData['roles']);
            }
            
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
            $user = User::findOrFail($id);
            
            // Cek apakah user memiliki data terkait (opsional)
            if ($user->Pemilik()->exists()) {
                return redirect()->route('user.index')
                               ->with('error', 'User tidak dapat dihapus karena memiliki data pemilik terkait.');
            }
            
            // Hapus role_user terlebih dahulu
            $user->role()->detach();
            
            // Hapus user
            $user->delete();
            
            return redirect()->route('user.index')
                           ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')
                           ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data user
     */
    protected function validateUser(Request $request, $id = null)
    {
        // Rule unique untuk email
        $uniqueEmailRule = $id ?
            'unique:user,email,' . $id . ',iduser' :
            'unique:user,email';

        // Rule password (required hanya saat create)
        $passwordRule = $id ? ['nullable'] : ['required'];
        $passwordRule[] = 'string';
        $passwordRule[] = 'min:8';
        $passwordRule[] = 'confirmed';

        return $request->validate([
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
            ],
            'password' => $passwordRule,
            'roles' => [
                'required',
                'array',
                'min:1'
            ],
            'roles.*' => [
                'required',
                'integer',
                'exists:role,idrole'
            ]
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required' => 'Role wajib dipilih.',
            'roles.min' => 'Minimal pilih 1 role.',
            'roles.*.exists' => 'Role tidak valid.'
        ]);
    }

    /**
     * Helper untuk membuat user baru
     */
    protected function createUser(array $data)
    {
        try {
            return User::create([
                'nama' => $this->formatNama($data['nama']),
                'email' => strtolower($data['email']),
                'password' => Hash::make($data['password'])
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan user: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk assign roles ke user (saat create)
     */
    protected function assignRoles(User $user, array $roleIds)
    {
        try {
            foreach ($roleIds as $roleId) {
                RoleUser::create([
                    'iduser' => $user->iduser,
                    'idrole' => $roleId
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Gagal assign role: " . $e->getMessage());
        }
    }

    /**
     * Helper untuk sync roles (saat update)
     */
    protected function syncRoles(User $user, array $roleIds)
    {
        try {
            // Hapus role yang lama
            $user->role()->detach();
            
            // Assign role yang baru
            $this->assignRoles($user, $roleIds);
        } catch (\Exception $e) {
            throw new \Exception("Gagal update role: " . $e->getMessage());
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