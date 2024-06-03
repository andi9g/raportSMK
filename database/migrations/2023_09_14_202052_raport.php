<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Raport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identitas', function (Blueprint $table) {
            $table->bigIncrements('ididentitas');
            $table->integer('iduser')->unique();
            $table->char('nip', 16)->nullable();
            $table->string('alamat');
            $table->string('email');
            $table->string('agama');
            $table->enum('posisi', ['guru','walikelas', "admin", "tu"]);
            $table->enum('jk',["L","P"]);
            $table->string('hp');
            $table->timestamps();
        });


        DB::table("identitas")->insert([
            "iduser" => 1,
            "nip" => null,
            "alamat" => "alamat",
            "email" => "admin@gmail.com",
            "agama" => "Islam",
            "posisi" => "admin",
            "jk" => "L",
            "hp" => "081268293603",
        ]);

        Schema::create('mapel', function (Blueprint $table) {
            $table->bigIncrements('idmapel');
            $table->string("namamapel");
            $table->enum("ket", ["umum", "kejuruan"]);
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('idkelas');
            $table->enum("namakelas", ["X","XI","XII"])->unique();
            $table->timestamps();
        });

        $kelas = [
            "X",
            "XI",
            "XII",
        ];

        foreach ($kelas as $item) {
            DB::table("kelas")->insert([
                "namakelas" => $item,
            ]);
        }

        Schema::create('walikelas', function (Blueprint $table) {
            $table->bigIncrements('idwalikelas');
            $table->integer("ididentitas")->unique();
            $table->integer("idkelas");
            $table->integer("idjurusan");
            $table->timestamps();
        });

        Schema::create('raport', function (Blueprint $table) {
            $table->bigIncrements('idraport');
            $table->string("namaraport");
            $table->date("tanggal");
            $table->char("tahun",5);
            $table->enum("semester", ["ganjil", "genap"]);
            $table->string("fase");
            $table->boolean("ket")->default(0);
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('sinkron', function (Blueprint $table) {
            $table->bigIncrements('idsinkron');
            $table->integer("idraport");
            $table->integer("iduser");
            $table->timestamps();
        });

        Schema::create('detailraport', function (Blueprint $table) {
            $table->bigIncrements('iddetailraport');
            $table->integer("iduser");
            $table->integer("idraport");
            $table->integer("idkelas");
            $table->integer("idmapel");
            $table->integer("idjurusan");
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('ujian', function (Blueprint $table) {
            $table->bigIncrements('idujian');
            $table->integer("idraport");
            $table->integer("idsiswa");
            $table->integer("idmapel");
            $table->double("lisan")->default(0);
            $table->double("nonlisan")->default(0);
            $table->double("persen")->default(0);
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('kehadiran', function (Blueprint $table) {
            $table->bigIncrements('idkehadiran');
            $table->integer("idraport");
            $table->integer("idsiswa");
            $table->integer("izin")->default(0);
            $table->integer("sakit")->default(0);
            $table->integer("tanpaketerangan")->default(0);
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('catatan', function (Blueprint $table) {
            $table->bigIncrements('idcatatan');
            $table->integer("iddetailraport");
            $table->integer("idmapel");
            $table->integer("idsiswa");
            $table->string("catatan")->nullable();
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('elemen', function (Blueprint $table) {
            $table->bigIncrements('idelemen');
            $table->integer('iddetailraport');
            $table->integer('iduser');
            $table->String('elemen');
            $table->double('persen')->nullable();
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('nilairaport', function (Blueprint $table) {
            $table->bigIncrements('idnilairaport');
            $table->integer("iddetailraport");
            $table->integer("idsiswa");
            $table->double("nilai");
            $table->string("idelemen");
            $table->integer("idtarget")->nullable();
            $table->timestamps();
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->bigIncrements('idjurusan');
            $table->string("jurusan")->unique();
            $table->string("namajurusan")->unique();
            $table->timestamps();
        });

        $jurusan = [
            "TJKT-TEKNIK JARINGAN KOMPUTER DAN TELEKOMUNIKASI",
            "TKJ-TEKNIK KOMPUTER DAN JARINGAN",
            "ATPH-AGRIBISNIS TANAMAN PANGAN DAN HOLTIKULTURA",
            "DPIB-DESAIN PERUMAHAN DAN INFORMASI BANGUNAN",
            "LDP-LANSKAP DAN PERTAMANAN",
        ];

        foreach ($jurusan as $j) {
            $x = explode("-",$j);
            $jurusan = $x[0];
            $namajurusan = $x[1];
            DB::table("jurusan")->insert([
                "jurusan" => $jurusan,
                "namajurusan" => $namajurusan,
            ]);
        }

        Schema::create('sekolah', function (Blueprint $table) {
            $table->bigIncrements('idsekolah');
            $table->String("namasekolah")->nullable();
            $table->String("npsn")->nullable();
            $table->String("nss")->nullable();
            $table->String("alamatsekolah")->nullable();
            $table->String("kelurahan")->nullable();
            $table->String("kecamatan")->nullable();
            $table->String("kabupatenkota")->nullable();
            $table->String("provinsi")->nullable();
            $table->String("website")->nullable();
            $table->String("email")->nullable();
            $table->timestamps();
        });

        DB::table("sekolah")->insert([
            "namasekolah" => "SMK NEGERI 1 GUNUNG KIJANG",
            "npsn" => "11003305",
            "nss" => "",
            "alamatsekolah" => "JL Poros Pulau Pucung, Lome KM. 48 Kode Pos 29153",
            "kelurahan" => "Malang Rapat",
            "kecamatan" => "Gunung Kijang",
            "kabupatenkota" => "Bintan",
            "provinsi" => "Kepulauan Riau",
            "website" => "www.smkn1gunungkijang.sch.id",
            "email" => "gunungkijangsmkn@gmail.com",
        ]);

        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('idsiswa');
            $table->integer("idkelas");
            $table->integer("idjurusan");
            $table->char("nisn", 11)->unique();
            $table->string("nis")->nullable();
            $table->string("nama");
            $table->string("tempatlahir")->nullable();
            $table->date("tanggallahir")->nullable();
            $table->enum("jk", ["L", "P"]);
            $table->string("agama");
            $table->string("statusdalamkeluarga")->nullable();
            $table->integer("anakke")->nullable();
            $table->string("alamat")->nullable();
            $table->string("hp")->nullable();
            $table->string("asalsekolah")->nullable();
            $table->date("tanggalmasuk")->nullable();
            $table->string("namaayah")->nullable();
            $table->string("namaibu")->nullable();
            $table->string("alamatortu")->nullable();
            $table->string("hportu")->nullable();
            $table->string("pekerjaanayah")->nullable();
            $table->string("pekerjaanibu")->nullable();
            $table->string("namawali")->nullable();
            $table->string("hpwali")->nullable();
            $table->string("alamatwali")->nullable();
            $table->string("pekerjaanwali")->nullable();
            $table->string("foto")->nullable();
            $table->timestamps();
        });

        Schema::create('import', function (Blueprint $table) {
            $table->bigIncrements('idimport');
            $table->string("namaimport");
            $table->string("url");
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
