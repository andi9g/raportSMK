<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembimbingpklM extends Model
{
    use HasFactory;
    protected $table = 'pembimbingpkl';
    protected $primaryKey = 'idpembimbingpkl';
    protected $fillable = ["iduser"];

    public function user()
    {
        return $this->hasOne(User::class, 'iduser', 'iduser');
    }
}
