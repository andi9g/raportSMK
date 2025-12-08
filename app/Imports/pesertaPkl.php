<?php

namespace App\Imports;

use App\Models\pesertapklM;
use App\Models\cppklM;
use App\Models\elemencppklM;
use App\Models\nilaipklM;
use App\Models\kehadiranpklM;
use App\Models\catatanpklM;
use Maatwebsite\Excel\Concerns\ToModel;

class pesertaPkl implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public $idpkl;

    public function __construct($idpkl)
    {
        $this->idpkl = $idpkl;
    }


    public function model(array $row)
    {
        // $pesertapkl = null;

        $cek = pesertapklM::where("idpkl", $this->idpkl)->where("nisn", $row[2]);
        if($cek->count() > 0) {
            $idpesertapkl = null;
            foreach($cek->get() as $key) {
                $idpesertapkl = $key->idpesertapkl;
                $pesertapkl = pesertapklM::where("idpesertapkl", $idpesertapkl)->first();
                // dd($pesertapkl);
                $pesertapkl->update([
                    'nisn' => sprintf("%010s", (string)$row[2]),
                    'tempatpkl' => $row[4],
                    'pembimbingdudi' => $row[5],
                    'jabatan' => $row[6],
                ]);
                // dd($pesertapkl->tempatpkl);  
            }

            $i = 7;
            $cp = cppklM::orderBy("index", "ASC")->get();
            // dd($cp);
            foreach($cp as $key) {
                $elemen = elemencppklM::where("idcppkl", $key->idcppkl)->orderBy("idelemencppkl", "ASC")->get();
                foreach($elemen as $key2) {
                    $nilai = nilaipklM::where("idelemencppkl", $key2->idelemencppkl)->where("idpesertapkl", $idpesertapkl);
                    if($nilai->count()  > 1) {
                        $nilai->delete();
                        nilaipklM::create([
                            'idpesertapkl' => $pesertapkl->idpesertapkl,
                            'idelemencppkl' => $key2->idelemencppkl,
                            'nilai' => $row[$i],
                        ]);
                    }else if($nilai->count()  == 0) {
                        nilaipklM::create([
                            'idpesertapkl' => $pesertapkl->idpesertapkl,
                            'idelemencppkl' => $key2->idelemencppkl,
                            'nilai' => $row[$i],
                        ]);
                    }else {
                        $nilai->first()->update([
                            'idelemencppkl' => $key2->idelemencppkl,
                            'nilai' => $row[$i],
                        ]);
                    }
                    
                    $i++;
                }
            }

            // $catatanpkl = catatanpklM::where("idpesertapkl", $idpesertapkl)->first();
            // $catatanpkl->update([
            //     'catatanpkl' => $row[23],
            // ]);

                 

            $kehadiranpkl = kehadiranpklM::where("idpesertapkl", $idpesertapkl)->first();
            $kehadiranpkl->update([
                'sakit' => $row[24],
                'izin' => $row[25],
                'alfa' => $row[26],
            ]);
                
           

            return $pesertapkl;
                  
        }else {
            $pesertapkl = pesertapklM::create([
                'idpkl' => $this->idpkl,
                'nisn' => sprintf("%010s", (string)$row[2]),
                'tempatpkl' => $row[4],
                'pembimbingdudi' => $row[5],
                'jabatan' => $row[6],
                'iduser' => null,
            ]);


            $i = 7;
            $cp = cppklM::orderBy("index", "ASC")->get();
            foreach($cp as $key) {
                $elemen = elemencppklM::where("idcppkl", $key->idcppkl)->orderBy("idelemencppkl", "ASC")->get();
                foreach($elemen as $key2) {
                    $nilai = nilaipklM::create([
                        'idpesertapkl' => $pesertapkl->idpesertapkl,
                        'idelemencppkl' => $key2->idelemencppkl,
                        'nilai' => $row[$i],
                    ]);
                    $i++;
                }
            }

            $kehadiranpkl = kehadiranpklM::create([
                'idpesertapkl' => $pesertapkl->idpesertapkl,
                'sakit' => $row[24],
                'izin' => $row[25],
                'alfa' => $row[26],
            ]);
            $catatanpkl = catatanpklM::create([
                'idpesertapkl' => $pesertapkl->idpesertapkl,
                'catatanpkl' => $row[23],
            ]);

            return $pesertapkl;
        }

        
    }
}
