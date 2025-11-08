<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Relasi
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    // Accessor untuk menampilkan jenis kelamin dalam teks penuh
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'J' ? 'Jantan' : 'Betina';
    }

      // Accessor untuk menghitung umur
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        
        $lahir = new \DateTime($this->tanggal_lahir);
        $sekarang = new \DateTime();
        $umur = $lahir->diff($sekarang);
        
        if ($umur->y > 0) {
            return $umur->y . ' tahun ' . $umur->m . ' bulan';
        } elseif ($umur->m > 0) {
            return $umur->m . ' bulan';
        } else {
            return $umur->d . ' hari';
        }
    }
}