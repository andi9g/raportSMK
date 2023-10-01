<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ujianM extends Model
{
    use HasFactory;
    protected $table = 'ujian';
    protected $primaryKey = 'idujian';
    protected $guarded = [];

    
}
