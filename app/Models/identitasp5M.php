<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identitasp5M extends Model
{
    use HasFactory;
    protected $table = 'identitasp5';
    protected $primaryKey = 'ididentitasp5';
    protected $guarded = [];
    protected $connection = "mysql";

    public function user()
    {
        return $this->hasOne(User::class, "iduser", "iduser");
    }
    public function kelas()
    {
        return $this->hasOne(kelasM::class, "idkelas", "idkelas");
    }
    public function jurusan()
    {
        return $this->hasOne(jurusanM::class, "idjurusan", "idjurusan");
    }
}
