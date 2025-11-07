<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RasHewan extends Model
{
    protected $table = 'ras_hewan';
    protected $primaryKey = 'idras_hewan';
    
    protected $fillable = [
        'nama_ras',
        'idjenis_hewan'
    ];

    // mematikan created_at dan updated_at
    public $timestamps = false;
    
    // Relasi ke tabel jenis_hewan
    public function jenisHewan()
    {
        return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }
}
