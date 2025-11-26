<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesertapklM extends Model
{
    use HasFactory;
    protected $table = 'pesertapkl';
    protected $primaryKey = 'idpesertapkl';
    protected $guarded = [];

    public function pkl()
    {
        return $this->hasOne(pklM::class, 'idpkl', 'idpkl');
    }

    public function siswa()
    {
        return $this->hasOne(siswaM::class, 'nisn', 'nisn');
    }

    public function kehadiranpkl()
    {
        return $this->hasOne(kehadiranpklM::class, 'idpesertapkl', 'idpesertapkl');
    }

    public function nilaipkl()
    {
        return $this->hasOne(nilaipklM::class, 'idpesertapkl', 'idpesertapkl');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'iduser', 'iduser');
    }
}
