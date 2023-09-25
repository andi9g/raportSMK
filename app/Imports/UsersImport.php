<?php

namespace App\Imports;

use App\Models\User;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{


    public function model(array $row)
    {
        $cek = User::where("username", $row["username"])->count();
        if($cek == 1 || $row['name']==null) {
            return null;
        }

        return new User([
            'name'  => $row['name'],
            'username' => $row['username'],
            'password' => Hash::make("guru2023"),
        ]);
    }

    
}
