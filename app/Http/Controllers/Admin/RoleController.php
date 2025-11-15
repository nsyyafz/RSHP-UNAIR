<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        // Eloquent
        // $users = User::with('role')->get();
        
        // Query Builder
        // Tampilkan semua user dengan info role-nya (bisa null jika belum punya role)
        $users = DB::table('user')
            ->leftJoin('role_user', 'user.iduser', '=', 'role_user.iduser')
            ->leftJoin('role', 'role_user.idrole', '=', 'role.idrole')
            ->select(
                'user.iduser',
                'user.nama',
                'user.email',
                'role_user.idrole_user',
                'role.idrole',
                'role.nama_role'
            )
            ->get();
        
        return view('admin.role.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Eloquent
        // $users = User::whereDoesntHave('role')->get();
        
        // Query Builder
        // Ambil user yang belum punya role
        $users = DB::table('user')
            ->leftJoin('role_user', 'user.iduser', '=', 'role_user.iduser')
            ->whereNull('role_user.iduser')
            ->select('user.iduser', 'user.nama', 'user.email')
            ->get();
        
        return view('admin.role.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validateRole($request);
            
            // Helper untuk menyimpan data
            $this->createRole($validatedData);
            
            return redirect()->route('role.index')
                           ->with('success', 'Role berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                           ->with('error', 'Gagal menambahkan role: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Eloquent
            // $role = Role::with('user')->findOrFail($id);
            
            // Query Builder
            $roleUser = DB::table('role_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->select('role_user.*', 'role.nama_role', 'user.nama as nama_user', 'user.email')
                ->where('role_user.idrole_user', $id)
                ->first();
            
            if (!$roleUser) {
                return redirect()->route('role.index')
                                ->with('error', 'Data role tidak ditemukan.');
            }
            
            return view('admin.role.show', compact('roleUser'));
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                           ->with('error', 'Data role tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            // Eloquent
            // $role = Role::with('user')->findOrFail($id);
            // $users = User::where(function($query) use ($role) {
            //             $query->whereDoesntHave('role')
            //                 ->orWhere('iduser', $role->iduser);
            //         })->get();
            
            // Query Builder
            $roleUser = DB::table('role_user')
                ->join('user', 'role_user.iduser', '=', 'user.iduser')
                ->join('role', 'role_user.idrole', '=', 'role.idrole')
                ->select('role_user.*', 'role.nama_role', 'user.nama as nama_user', 'user.email')
                ->where('role_user.idrole_user', $id)
                ->first();
            
            if (!$roleUser) {
                return redirect()->route('role.index')
                                ->with('error', 'Data role tidak ditemukan.');
            }
            
            // User yang belum punya role + user ini sendiri
            $users = DB::table('user')
                ->leftJoin('role_user as ru', 'user.iduser', '=', 'ru.iduser')
                ->where(function($query) use ($roleUser) {
                    $query->whereNull('ru.iduser')
                          ->orWhere('user.iduser', $roleUser->iduser);
                })
                ->select('user.iduser', 'user.nama', 'user.email')
                ->get();
            
            return view('admin.role.edit', compact('roleUser', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                           ->with('error', 'Data role tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Eloquent
            // $role = Role::findOrFail($id);
            // $role->update([
            //     'nama_role' => $validatedData['nama_role'],
            //     'iduser' => $validatedData['iduser']
            // ]);
            
            // Query Builder
            // Cek apakah data ada
            $roleUser = DB::table('role_user')
                ->where('idrole_user', $id)
                ->first();

            if (!$roleUser) {
                return redirect()->route('role.index')
                                ->with('error', 'Data role tidak ditemukan.');
            }
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validateRole($request, $id);
            
            // Update data
            DB::table('role_user')
                ->where('idrole_user', $id)
                ->update([
                    'idrole' => $validatedData['idrole'],
                    'iduser' => $validatedData['iduser']
                ]);
            
            return redirect()->route('role.index')
                           ->with('success', 'Role berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                           ->with('error', 'Gagal memperbarui role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Eloquent
            // $role = Role::findOrFail($id);
            // $role->delete();
            
            // Query Builder
            // Cek apakah data ada
            $roleUser = DB::table('role_user')
                ->where('idrole_user', $id)
                ->first();

            if (!$roleUser) {
                return redirect()->route('role.index')
                                ->with('error', 'Data role tidak ditemukan.');
            }
            
            // Hapus data
            DB::table('role_user')
                ->where('idrole_user', $id)
                ->delete();
            
            return redirect()->route('role.index')
                           ->with('success', 'Role berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('role.index')
                           ->with('error', 'Gagal menghapus role: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data role
     */
    protected function validateRole(Request $request, $id = null)
    {
        // Rule unique untuk iduser (satu user hanya boleh punya 1 role)
        $uniqueUserRule = $id ?
            'unique:role_user,iduser,' . $id . ',idrole_user' :
            'unique:role_user,iduser';

        return $request->validate([
            'idrole' => [
                'required',
                'integer',
                'exists:role,idrole'
            ],
            'iduser' => [
                'required',
                'integer',
                'exists:user,iduser',
                $uniqueUserRule
            ]
        ], [
            'idrole.required' => 'Role wajib dipilih.',
            'idrole.exists' => 'Role tidak ditemukan.',
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists' => 'User tidak ditemukan.',
            'iduser.unique' => 'User sudah memiliki role.'
        ]);
    }

    /**
     * Helper untuk membuat role baru
     */
    protected function createRole(array $data)
    {
        try {
            // Eloquent
            // return Role::create([
            //     'nama_role' => $data['nama_role'],
            //     'iduser' => $data['iduser']
            // ]);
            
            // Query Builder
            // Generate idrole_user baru
            $maxId = DB::table('role_user')->max('idrole_user');
            $idrole_user = $maxId ? $maxId + 1 : 1;

            DB::table('role_user')->insert([
                'idrole_user' => $idrole_user,
                'idrole' => $data['idrole'],
                'iduser' => $data['iduser']
            ]);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan role: " . $e->getMessage());
        }
    }
}