<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penilaianexM extends Model
{
    use HasFactory;
    protected $table = 'penilaianex';
    protected $primaryKey = 'idpenilaianex';
    protected $guarded = [];
    protected $connection = "mysql";

    public function siswa()
    {
        return $this->hasOne(siswaM::class, "idsiswa", "idsiswa");
    }

    public function pembina()
    {
        return $this->hasOne(pembinaexM::class, "idpembinaex", "idpembinaex");
    }
}
