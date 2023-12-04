<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penilaianp5M extends Model
{
    use HasFactory;
    protected $table = 'penilaianp5';
    protected $primaryKey = 'idpenilaianp5';
    protected $guarded = [];
    protected $connection = "mysql";
}
