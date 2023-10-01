<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilairaportM extends Model
{
    use HasFactory;
    protected $table = 'nilairaport';
    protected $primaryKey = 'idnilairaport';
    protected $guarded = [];
    protected $connection = "mysql";

    public function siswa()
    {
        return $this->hasOne(siswaM::class, "idsiswa", "idsiswa");
    }

    public function mapel()
    {
        return $this->hasOne(mapelM::class, "idmapel", "idmapel");
    }

    public function detailraport()
    {
        return $this->hasOne(detailraportM::class, "iddetailraport", "iddetailraport");
    }
    
    public function elemen()
    {
        return $this->hasOne(elemenM::class, "idelemen", "idelemen");
    }

    public function raport()
    {
        return $this->hasOne(raportM::class, "idraport", "idraport");
    }

}
