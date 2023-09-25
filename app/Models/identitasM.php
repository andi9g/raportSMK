<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identitasM extends Model
{
    use HasFactory;
    protected $table = 'identitas';
    protected $primaryKey = 'ididentitas';
    protected $guarded = [];

    public function walikelas()
    {
        return $this->hasOne(walikelasM::class, "ididentitas", "ididentitas");
    }

}
