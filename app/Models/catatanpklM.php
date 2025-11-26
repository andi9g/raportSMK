<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catatanpklM extends Model
{
    use HasFactory;
    protected $table = 'catatanpkl';
    protected $primaryKey = 'idcatatanpkl';
    protected $guarded = [];
    
    public function pesertapkl()
    {
        return $this->hasOne(pesertapklM::class, 'idpesertapkl', 'idpesertapkl');
    }
}
