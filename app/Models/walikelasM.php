<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class walikelasM extends Model
{
    use HasFactory;
    protected $table = 'walikelas';
    protected $primaryKey = 'idwalikelas';
    protected $guarded = [];

    public function jurusan()
    {
        return $this->hasOne(jurusanM::class, "idjurusan", "idjurusan");
    }

    public function kelas()
    {
        return $this->hasOne(kelasM::class, "idkelas", "idkelas");
    }

    public function identitas()
    {
        return $this->hasOne(identitasM::class, "ididentitas", "ididentitas");
    }

    


}
