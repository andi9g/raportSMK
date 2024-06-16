<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class judulp5M extends Model
{
    use HasFactory;
    protected $table = 'judulp5';
    protected $primaryKey = 'idjudulp5';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function raportp5()
    {
        return $this->hasOne(raportp5M::class, 'idraportp5','idraportp5');
    }
}
