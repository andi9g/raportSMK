<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catatanM extends Model
{
    use HasFactory;
    protected $table = 'catatan';
    protected $primaryKey = 'idcatatan';
    protected $guarded = [];
}
