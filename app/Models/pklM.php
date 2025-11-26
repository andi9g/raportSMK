<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pklM extends Model
{
    use HasFactory;
    protected $table = 'pkl';
    protected $primaryKey = 'idpkl';
    protected $fillable = ["idpkl", "idkelas", "tahunajaran", "status", "tanggalmulai", "tanggalselesai"];

    public function pesertapkl()
    {
        return $this->hasOne(pesertapklM::class, 'ididpkl', 'ididpkl');
    }

    public function kelas()
    {
        return $this->hasOne(kelasM::class, 'idkelas', 'idkelas');
    }
}
