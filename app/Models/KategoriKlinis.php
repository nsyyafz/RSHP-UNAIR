<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKlinis extends Model
{
    protected $table = 'kategori_klinis';
    protected $primaryKey = 'idkategori_klinis';

    // mematikan created_at dan updated_at
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori_klinis',
    ];
}
