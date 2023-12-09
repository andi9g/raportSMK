<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelasexM extends Model
{
    use HasFactory;
    protected $table = 'kelasex';
    protected $primaryKey = 'idkelasex';
    protected $guarded = [];
    protected $connection = "mysql";
    
}
