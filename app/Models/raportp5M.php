<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raportp5M extends Model
{
    use HasFactory;
    protected $table = 'raportp5';
    protected $primaryKey = 'idraportp5';
    protected $guarded = [];
    protected $connection = "mysql";

    public function temap5()
    {
        return $this->hasOne(temap5M::class, "idraportp5", "idraportp5");
    }
    public function identitasp5()
    {
        return $this->hasOne(identitasp5M::class, "idraportp5", "idraportp5");
    }
}
