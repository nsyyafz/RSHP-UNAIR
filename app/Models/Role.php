<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    protected $fillable = ['nama_role'];

    // Relasi ke tabel user
   public function user()
    {
        return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser')
                    ->using(RoleUser::class);
    }
}
