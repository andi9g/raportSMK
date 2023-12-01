<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sinkronM extends Model
{
    use HasFactory;
    protected $table = 'sinkron';
    protected $primaryKey = 'idsinkron';
    protected $guarded = [];
    protected $connection = "mysql";
}
