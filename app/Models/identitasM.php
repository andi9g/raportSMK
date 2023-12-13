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
    protected $connection = "mysql";

    protected $fillable = ['ididentitas', 'iduser', 'nip', 'alamat','email', 'agama', 'posisi', 'jk', 'hp', 'inip'];

    public function walikelas()
    {
        return $this->hasOne(walikelasM::class, "ididentitas", "ididentitas");
    }

    public function user()
    {
        return $this->hasOne(User::class, "iduser", "iduser");
    }

}
