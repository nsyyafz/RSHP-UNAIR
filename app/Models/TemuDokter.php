<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemuDokter extends Model
{
    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';

    // mematikan created_at dan updated_at
    public $timestamps = false;

    protected $fillable = [
        'no_urut', 'waktu_daftar', 'iduser', 'idpet', 'status',
    ];
    
    // Relasi ke Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }
    
    // Relasi ke User (Dokter) - jika diperlukan nanti
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}