<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kepalasekolahpklM extends Model
{
    use HasFactory;
    protected $table = 'kepalasekolahpkl';
    protected $primaryKey = 'idkepalasekolahpkl';
    protected $fillable = ["iduser", "idpkl"];
    
    public function user()
    {
        return $this->hasOne(User::class, 'iduser', 'iduser');
    }
}
