<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kepalasekolahM extends Model
{
    use HasFactory;

    protected $table = 'kepalasekolah';
    protected $primaryKey = 'idkepalasekolah';
    protected $guarded = [];
    protected $connection = 'mysql';
        
    //protected $fillable = ['name1','name2'];
        
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

}
