<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik'; 
    protected $primaryKey = 'idpemilik';
    protected $fillable = ['no_wa', 'alamat'];
    
    // mematikan created_at dan updated_at
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    // Relasi ke pet (one to many)
    public function pets()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }
}
