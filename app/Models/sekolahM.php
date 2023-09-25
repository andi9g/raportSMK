<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sekolahM extends Model
{
    use HasFactory;
    protected $table = 'sekolah';
    protected $primaryKey = 'idsekolah';
    protected $guarded = [];
}
