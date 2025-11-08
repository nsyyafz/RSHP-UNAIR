<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User;
use App\Models\Role;

class PemilikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemiliks = Pemilik::with('user')->get();
        return view('admin.pemilik.index', compact('pemiliks'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil user yang belum jadi pemilik DAN tidak punya role
        $users = User::whereDoesntHave('pemilik')
                    ->whereDoesntHave('role') // Gunakan relasi, bukan kolom
                    ->get();
        
        return view('admin.pemilik.create', compact('users'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $this->validatePemilik($request);
            
            // Helper untuk menyimpan data
            $pemilik = $this->createPemilik($validatedData);
            
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
            $pemilik = Pemilik::with(['user', 'pets'])->findOrFail($id);
            return view('admin.pemilik.show', compact('pemilik'));
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
            $pemilik = Pemilik::with('user')->findOrFail($id);
            
            // User yang belum jadi pemilik + user ini sendiri (dan tidak punya role)
            $users = User::where(function($query) use ($pemilik) {
                        $query->whereDoesntHave('pemilik')
                            ->orWhere('iduser', $pemilik->iduser);
                    })
                    ->whereDoesntHave('role') // Pakai relasi
                    ->get();
            
            return view('admin.pemilik.edit', compact('pemilik', 'users'));
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
            // Cari data pemilik
            $pemilik = Pemilik::findOrFail($id);
            
            // Validasi input dengan mengecualikan ID yang sedang diedit
            $validatedData = $this->validatePemilik($request, $id);
            
            // Update data
            $pemilik->update([
                'no_wa' => $this->formatNoWa($validatedData['no_wa']),
                'alamat' => $this->formatAlamat($validatedData['alamat']),
                'iduser' => $validatedData['iduser']
            ]);
            
            return redirect()->route('pemilik.index')
                           ->with('success', 'Data pemilik berhasil diperbarui.');
        } catch (\Exception $e) {
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
            $pemilik = Pemilik::findOrFail($id);
            
            // Cek apakah pemilik memiliki pet
            if ($pemilik->pets()->count() > 0) {
                return redirect()->route('pemilik.index')
                               ->with('error', 'Pemilik tidak dapat dihapus karena masih memiliki hewan peliharaan terdaftar.');
            }
            
            $pemilik->delete();
            
            return redirect()->route('pemilik.index')
                           ->with('success', 'Data pemilik berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('pemilik.index')
                           ->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }

    // ========== HELPER METHODS ==========

    /**
     * Validasi data pemilik
     */
    protected function validatePemilik(Request $request, $id = null)
    {
        // Rule unique untuk no_wa
        $uniqueNoWaRule = $id ?
            'unique:pemilik,no_wa,' . $id . ',idpemilik' :
            'unique:pemilik,no_wa';

        // Rule unique untuk iduser
        $uniqueUserRule = $id ?
            'unique:pemilik,iduser,' . $id . ',idpemilik' :
            'unique:pemilik,iduser';

        return $request->validate([
            'no_wa' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^[0-9]+$/',
                $uniqueNoWaRule
            ],
            'alamat' => [
                'required',
                'string',
                'max:500',
                'min:10'
            ],
            'iduser' => [
                'required',
                'integer',
                'exists:user,iduser',
                $uniqueUserRule
            ]
        ], [
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 20 digit.',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists' => 'User tidak ditemukan.',
            'iduser.unique' => 'User sudah terdaftar sebagai pemilik.'
        ]);
    }

    /**
     * Helper untuk membuat pemilik baru
     */
    protected function createPemilik(array $data)
    {
        try {
            return Pemilik::create([
                'no_wa' => $this->formatNoWa($data['no_wa']),
                'alamat' => $this->formatAlamat($data['alamat']),
                'iduser' => $data['iduser']
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan pemilik: " . $e->getMessage());
        }
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