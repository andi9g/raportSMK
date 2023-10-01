<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapelM extends Model
{
    use HasFactory;
    protected $table = 'mapel';
    protected $primaryKey = 'idmapel';
    protected $guarded = [];
    protected $connection = "mysql";
}
