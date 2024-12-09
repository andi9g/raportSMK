<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raportM extends Model
{
    use HasFactory;
    protected $table = 'raport';
    protected $primaryKey = 'idraport';
    protected $guarded = [];
    protected $connection = "mysql";

    public function kelas()
    {
        return $this->hasOne(kelasM::class, 'idkelas','idkelas');
    }


}
