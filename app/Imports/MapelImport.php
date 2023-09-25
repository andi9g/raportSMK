<?php

namespace App\Imports;

use App\Models\mapelM;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MapelImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek = mapelM::where("namamapel", $row["namamapel"])->count();

        if($cek > 0) {
            return null;
        }

        return new mapelM([
            "namamapel" => $row['namamapel'],
            "ket" => $row['ket'],
        ]);
    }
}
