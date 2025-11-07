<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    protected $table = 'jenis_hewan'; 
    protected $primaryKey = 'idjenis_hewan';
    protected $fillable = ['nama_jenis_hewan']; 

    // mematikan created_at dan updated_at
    public $timestamps = false;

}
