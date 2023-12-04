<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keteranganp5M extends Model
{
    use HasFactory;
    protected $table = 'keteranganp5';
    protected $primaryKey = 'idketeranganp5';
    protected $guarded = [];
    protected $connection = "mysql";
}
