<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penilaianp5M extends Model
{
    use HasFactory;
    protected $table = 'penilaianp5';
    protected $primaryKey = 'idpenilaianp5';
    protected $guarded = [];
    protected $connection = "mysql";

    public function siswa()
    {
        return $this->hasOne(siswaM::class, "nisn", "nisn");
    }
}
