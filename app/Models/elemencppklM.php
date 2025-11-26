<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elemencppklM extends Model
{
    use HasFactory;
    protected $table = 'elemencppkl';
    protected $primaryKey = 'idelemencppkl';
    protected $fillable = ["idcppkl", "judulelemencppkl"];

    public function cppkl()
    {
        return $this->hasOne(cppklM::class, 'idcppkl', 'idcppkl');
    }
}
