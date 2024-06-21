<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoligonosTable extends Migration
{
    public function up()
    {
        Schema::create('poligonos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->json('coordenadas');
            $table->foreignId('escena_id')->constrained('escenas')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('poligonos');
    }
}
