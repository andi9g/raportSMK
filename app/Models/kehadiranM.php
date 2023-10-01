<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kehadiranM extends Model
{
    use HasFactory;
    protected $table = 'kehadiran';
    protected $primaryKey = 'idkehadiran';
    protected $guarded = [];
}
