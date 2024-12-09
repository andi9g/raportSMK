<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailraportM extends Model
{
    use HasFactory;
    protected $table = 'detailraport';
    protected $primaryKey = 'iddetailraport';
    protected $guarded = [];
    protected $connection = "mysql";

    public function raport()
    {
        return $this->hasOne(raportM::class, "idraport", "idraport");
    }

    public function nilairaport()
    {
        return $this->hasOne(nilairaportM::class, "iddetailraport", "iddetailraport");
    }

    public function mapel()
    {
        return $this->hasOne(mapelM::class, "idmapel", "idmapel");
    }

    public function jurusan()
    {
        return $this->hasOne(jurusanM::class, "idjurusan", "idjurusan");
    }

    public function kelas()
    {
        return $this->hasOne(kelasM::class, "idkelas", "idkelas");
    }
}
