<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kajurpklM extends Model
{
    use HasFactory;
    protected $table = 'kajurpkl';
    protected $primaryKey = 'idkajurpkl';
    protected $fillable = ["iduser", "idpkl", "idjurusan"];
    
    public function user()
    {
        return $this->hasOne(User::class, 'iduser', 'iduser');
    }
    public function jurusan()
    {
        return $this->hasOne(jurusanM::class, 'idjurusan', 'idjurusan');
    }
}
