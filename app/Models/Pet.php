<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    public $timestamps = false;
    
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'warna_tanda',
        'jenis_kelamin',
        'idpemilik',
        'idras_hewan'
    ];
    
    // Relasi ke tabel pemilik
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }
    
    // Relasi ke tabel ras_hewan
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }
    
    // Relasi ke jenis_hewan melalui ras_hewan
    public function jenisHewan()
    {
        return $this->hasOneThrough(
            JenisHewan::class,
            RasHewan::class,
            'idras_hewan', // Foreign key on ras_hewan table
            'idjenis_hewan', // Foreign key on jenis_hewan table
            'idras_hewan', // Local key on pet table
            'idjenis_hewan' // Local key on ras_hewan table
        );
    }
}
