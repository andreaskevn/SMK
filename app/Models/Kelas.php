<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = ['kelas_name', 'kelas_description', 'kelas_capacity', 'kelas_code'];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'kelas_user', 'kelas_id', 'user_id')->withTimestamps();
    }
}
