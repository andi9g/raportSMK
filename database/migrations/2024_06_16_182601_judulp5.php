<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Judulp5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judulp5', function (Blueprint $table) {
            $table->bigIncrements('idjudulp5');
            $table->integer('iduser');
            $table->integer('idjurusan');
            $table->integer('idkelas');
            $table->integer('idraportp5');
            $table->String('judulp5');
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
