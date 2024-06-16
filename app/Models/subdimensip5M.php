<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subdimensip5M extends Model
{
    use HasFactory;
    protected $table = 'subdimensip5';
    protected $primaryKey = 'idsubdimensip5';
    protected $guarded = [];
    protected $connection = "mysql";


}
