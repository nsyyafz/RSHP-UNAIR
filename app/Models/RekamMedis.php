<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';

    // mematikan created_at dan updated_at
    public $timestamps = false;

    protected $fillable = [
        'idpet',
        'tanggal',
        'keluhan',
        'diagnosis',
        'tindakan',
        'obat'
    ];

    // Relasi ke tabel pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }
} 