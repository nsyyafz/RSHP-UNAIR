<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    protected $fillable = ['nama_kategori'];

    // mematikan created_at dan updated_at
    public $timestamps = false;

    // Relasi ke tabel kode_tindakan_terapi (jika ada)
    public function kodeTindakan()
    {
        return $this->hasMany(KodeTindakan::class, 'idkategori', 'idkategori');
    }
}
