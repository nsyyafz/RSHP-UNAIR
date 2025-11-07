<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    protected $table = 'role_user';
    protected $primaryKey = 'idrole_user';
    
    protected $fillable = ['iduser', 'idrole'];

    // mematikan created_at dan updated_at
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
}
