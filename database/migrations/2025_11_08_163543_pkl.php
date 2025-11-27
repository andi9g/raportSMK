<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pkl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('pembimbingpkl');
        Schema::dropIfExists('cppkl');
        Schema::dropIfExists('elemencppkl');
        Schema::dropIfExists('pkl');
        Schema::dropIfExists('pesertapkl');
        Schema::dropIfExists('nilaipkl');
        Schema::dropIfExists('kehadiranpkl');
        Schema::dropIfExists('catatanpkl');
        Schema::dropIfExists('walikelaspkl');
        Schema::dropIfExists('kajurpkl');
        Schema::dropIfExists('kepalasekolahpkl');
        
        Schema::create('catatanpkl', function (Blueprint $table) {
            $table->bigIncrements('idcatatanpkl');
            $table->integer('idpesertapkl');
            $table->longtext('catatanpkl');
            $table->timestamps();
        });

        Schema::create('pembimbingpkl', function (Blueprint $table) {
            $table->bigIncrements('idpembimbingpkl');
            $table->integer('iduser');
            $table->timestamps();
        });

        Schema::create('cppkl', function (Blueprint $table) {
            $table->bigIncrements('idcppkl');
            $table->string('judulcppkl');
            $table->integer('index');
            $table->timestamps();
        });

        Schema::create('elemencppkl', function (Blueprint $table) {
            $table->bigIncrements('idelemencppkl');
            $table->integer('idcppkl');
            $table->string('judulelemencppkl');
            $table->timestamps();
        });

        Schema::create('pkl', function (Blueprint $table) {
            $table->bigIncrements('idpkl');
            $table->integer('idkelas');
            $table->char('tahunajaran', 10);
            $table->boolean('status');
            $table->date('tanggalmulai');
            $table->date('tanggalselesai');
            $table->date('tanggalcetak');
            $table->timestamps();
        });

        Schema::create('pesertapkl', function (Blueprint $table) {
            $table->bigIncrements('idpesertapkl');
            $table->integer('idpkl');
            $table->char('nisn', 10);
            $table->string('tempatpkl');
            $table->string('pembimbingdudi');
            $table->string('jabatan');
            $table->integer('iduser')->nullable();
            $table->timestamps();
        });

        Schema::create('nilaipkl', function (Blueprint $table) {
            $table->bigIncrements('idnilaipkl');
            $table->integer('idpesertapkl');
            $table->integer('idelemencppkl');
            $table->integer('nilai');
            $table->timestamps();
        });

        Schema::create('kehadiranpkl', function (Blueprint $table) {
            $table->bigIncrements('idkehadiranpkl');
            $table->integer('idpesertapkl');
            $table->integer('izin');
            $table->integer('sakit');
            $table->integer('alfa');
            $table->timestamps();
        });
        
        Schema::create('walikelaspkl', function (Blueprint $table) {
            $table->bigIncrements('idwalikelaspkl');
            $table->integer('iduser');
            $table->integer('idpkl');
            $table->integer('idjurusan');
            $table->timestamps();
        });
        Schema::create('kajurpkl', function (Blueprint $table) {
            $table->bigIncrements('idkajurpkl');
            $table->integer('iduser');
            $table->integer('idpkl');
            $table->integer('idjurusan');
            $table->timestamps();
        });
        
        Schema::create('kepalasekolahpkl', function (Blueprint $table) {
            $table->bigIncrements('idkepalasekolahpkl');
            $table->integer('iduser');
            $table->integer('idpkl');
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
       
    }
}
