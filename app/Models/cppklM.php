<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cppklM extends Model
{
    use HasFactory;
    protected $table = 'cppkl';
    protected $primaryKey = 'idcppkl';
    protected $fillable = ["judulcppkl", "index"];

    public function elemencppkl()
    {
        return $this->hasMany(elemencppklM::class, 'idcppkl', 'idcppkl');
    }
}
