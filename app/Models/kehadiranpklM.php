<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kehadiranpklM extends Model
{
    use HasFactory;
    protected $table = 'kehadiranpkl';
    protected $primaryKey = 'idkehadiranpkl';
    protected $guarded = [];

    public function pesertapkl()
    {
        return $this->hasOne(pesertapklM::class, 'idpesertapkl', 'idpesertapkl');
    }
}
