<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakulTable extends Migration
{
    public function up()
    {
        Schema::create('makul', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('kode', 20);
            $table->string('sks', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('makul');
    }
}