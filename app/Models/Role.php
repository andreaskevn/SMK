<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'roles_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
