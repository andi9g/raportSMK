<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temap5M extends Model
{
    use HasFactory;
    protected $table = 'temap5';
    protected $primaryKey = 'idtemap5';
    protected $guarded = [];
    protected $connection = "mysql";

    public function dimensip5()
    {
        return $this->hasOne(dimensip5M::class, "idtemap5", "idtemap5");
    }
}
