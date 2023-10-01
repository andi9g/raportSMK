<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subelemenM extends Model
{
    use HasFactory;
    protected $table = 'subelemen';
    protected $primaryKey = 'idsubelemen';
    protected $guarded = [];
    protected $connection = "mysql";
}
