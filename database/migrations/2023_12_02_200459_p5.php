<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class P5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('keteranganp5', function (Blueprint $table) {
            $table->bigIncrements('idketeranganp5');
            $table->string("inisialp5");
            $table->string("keteranganp5");
            $table->longText("deskripsi");
            $table->integer("index");
            $table->timestamps();
        });

        Schema::create('identitasp5', function (Blueprint $table) {
            $table->bigIncrements('ididentitasp5');
            $table->integer("iduser")->unique();
            $table->integer("idkelas");
            $table->integer("idraportp5");
            $table->integer("idjurusan");
            $table->String("namaproject");
            $table->timestamps();
        });

        Schema::create('raportp5', function (Blueprint $table) {
            $table->bigIncrements('idraportp5');
            $table->char("tahun", 4);
            $table->enum("semester", ["ganjil", "genap"]);
            $table->char("fase", 2);
            $table->String("tema");
            $table->enum("dimensi", ["p5", "pm"])->nullable();
            $table->boolean("ket")->default(1);
            $table->timestamps();
        });

        Schema::create('temap5', function (Blueprint $table) {
            $table->bigIncrements('idtemap5');
            $table->integer("idraportp5");
            $table->string("temap5");
            $table->timestamps();
        });

        Schema::create('dimensip5', function (Blueprint $table) {
            $table->bigIncrements('iddimensip5');
            $table->integer("idtemap5");
            $table->string("dimensip5");
            $table->timestamps();
        });

        Schema::create('subdimensip5', function (Blueprint $table) {
            $table->bigIncrements('idsubdimensip5');
            $table->integer("iddimensip5");
            $table->string("subdimensip5");
            $table->longText("deskripsi");
            $table->timestamps();
        });

        Schema::create('penilaianp5', function (Blueprint $table) {
            $table->bigIncrements('idpenilaianp5');
            $table->integer("idsubdimensip5");
            $table->string("idketeranganp5");
            $table->char("nisn", 11);
            $table->integer("iraportp5");
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
        Schema::drop('keteranganp5');
        Schema::drop('identitasp5');
        Schema::drop('temap5');
        Schema::drop('dimensip5');
        Schema::drop('subdimensip5');
        Schema::drop('penilaianp5');
        Schema::drop('raportp5');
    }
}
