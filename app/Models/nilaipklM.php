<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaipklM extends Model
{
    use HasFactory;
    protected $table = 'nilaipkl';
    protected $primaryKey = 'idnilaipkl';
    protected $guarded = [];

    public function pesertapkl()
    {
        return $this->hasOne(pesertapklM::class, 'idpesertapkl', 'idpesertapkl');
    }

    public function elemencppkl()
    {
        return $this->hasOne(elemencppklM::class, 'idelemencppkl', 'idelemencppkl');
    }
}
