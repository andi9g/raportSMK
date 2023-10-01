<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elemenM extends Model
{
    use HasFactory;
    protected $table = 'elemen';
    protected $primaryKey = 'idelemen';
    protected $guarded = [];
    protected $connection = "mysql";
}
