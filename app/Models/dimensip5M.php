<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dimensip5M extends Model
{
    use HasFactory;
    protected $table = 'dimensip5';
    protected $primaryKey = 'iddimensip5';
    protected $guarded = [];
    protected $connection = "mysql";

    public function subdimensip5()
    {
        return $this->hasOne(subdimensip5M::class, "iddimensip5", "iddimensip5");
    }
}
