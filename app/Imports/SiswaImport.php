<?php

namespace App\Imports;

use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nisn = sprintf("%010s", $row['nisn']);
        $cek = siswaM::where("nisn", $nisn);

        $rombel = explode(" ", $row["rombel"]);
        $kelas = kelasM::where("namakelas", $rombel[0])->first()->idkelas;

        if($rombel[1] == "TKJ") {
            $jurusan = "TJKT";
        }else {
            $jurusan = $rombel[1];
        }

        $jurusan = jurusanM::where("jurusan", $jurusan)->first()->idjurusan;


        if($cek->count() == 1) {
            $cek->first()->update([
                "idjurusan" => $jurusan,
                "idkelas" => $kelas,
                "nama" => empty($row["nama"])?null:$row["nama"],
                "nisn" => empty($row["nisn"])?null:$row["nisn"],
                "tempatlahir" => empty($row["tempatlahir"])?null:$row["tempatlahir"],
                "tanggallahir" => empty($row["tanggallahir"])?null:$row["tanggallahir"],
                "jk" => empty($row["jk"])?null:$row["jk"],
                "agama" => empty($row["agama"])?null:$row["agama"],
                "anakke" => empty($row["anakke"])?null:$row["anakke"],
                "alamat" => empty($row["alamat"])?null:$row["alamat"],
                "hp" => empty($row["hp"])?null:$row["hp"],
                "asalsekolah" => empty($row["asalsekolah"])?null:$row["asalsekolah"],
                "namaayah" => empty($row["namaayah"])?null:$row["namaayah"],
                "namaibu" => empty($row["namaibu"])?null:$row["namaibu"],
                "hportu" => empty($row["hportu"])?null:$row["hportu"],
                "alamatortu" => empty($row["alamat"])?null:$row["alamat"],
                "pekerjaanayah" => empty($row["pekerjaanayah"])?null:$row["pekerjaanayah"],
                "pekerjaanibu" => empty($row["pekerjaanibu"])?null:$row["pekerjaanibu"],
                "namawali" => empty($row["namawali"])?null:$row["namawali"],
                "pekerjaanwali" => empty($row["pekerjaanwali"])?null:$row["pekerjaanwali"],
            ]);

            return null;
        }

        return new siswaM([
            "idjurusan" => $jurusan,
            "idkelas" => $kelas,
            "nama" => empty($row["nama"])?null:$row["nama"],
            "nisn" => empty($row["nisn"])?null:$row["nisn"],
            "tempatlahir" => empty($row["tempatlahir"])?null:$row["tempatlahir"],
            "tanggallahir" => empty($row["tanggallahir"])?null:$row["tanggallahir"],
            "jk" => empty($row["jk"])?null:$row["jk"],
            "agama" => empty($row["agama"])?null:$row["agama"],
            "anakke" => empty($row["anakke"])?null:$row["anakke"],
            "alamat" => empty($row["alamat"])?null:$row["alamat"],
            "hp" => empty($row["hp"])?null:$row["hp"],
            "asalsekolah" => empty($row["asalsekolah"])?null:$row["asalsekolah"],
            "namaayah" => empty($row["namaayah"])?null:$row["namaayah"],
            "namaibu" => empty($row["namaibu"])?null:$row["namaibu"],
            "hportu" => empty($row["hportu"])?null:$row["hportu"],
            "alamatortu" => empty($row["alamat"])?null:$row["alamat"],
            "pekerjaanayah" => empty($row["pekerjaanayah"])?null:$row["pekerjaanayah"],
            "pekerjaanibu" => empty($row["pekerjaanibu"])?null:$row["pekerjaanibu"],
            "namawali" => empty($row["namawali"])?null:$row["namawali"],
            "pekerjaanwali" => empty($row["pekerjaanwali"])?null:$row["pekerjaanwali"],
        ]);

    }
}
