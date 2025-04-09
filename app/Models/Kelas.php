<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = ['kelas_name', 'kelas_description', 'kelas_cover_header', 'kelas_capacity', 'kelas_code', 'kelas_status'];
    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'kelas_user', 'kelas_id', 'user_id')->withTimestamps();
    }
}
