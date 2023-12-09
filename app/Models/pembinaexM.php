<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembinaexM extends Model
{
    use HasFactory;
    protected $table = 'pembinaex';
    protected $primaryKey = 'idpembinaex';
    protected $guarded = [];
    protected $connection = "mysql";

    public function user()
    {
        return $this->hasOne(User::class, "iduser", "iduser");
    }
}
