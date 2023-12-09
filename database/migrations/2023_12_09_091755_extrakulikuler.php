<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Extrakulikuler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembinaex', function (Blueprint $table) {
            $table->bigIncrements('idpembinaex');
            $table->integer("iduser");
            $table->String("namaex");
            $table->enum("ket", ["umum", "khusus"]);
            $table->timestamps();
        });

        Schema::create('kelasex', function (Blueprint $table) {
            $table->bigIncrements('kelasex');
            $table->integer("idpembinaex");
            $table->integer("idjurusan");
            $table->integer("idkelas");
            $table->integer("idraport");
            $table->timestamps();
        });

        Schema::create('penilaianex', function (Blueprint $table) {
            $table->bigIncrements('idpenilaianex');
            $table->integer("idsiswa");
            $table->integer("idpembinaex");
            $table->integer("idraport");
            $table->enum("nilai", ["A","B", "C", "D"]);
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
        Schema::drop('pembinaex');
        Schema::drop('kelasex');
        Schema::drop('penilaianex');
    }
}
