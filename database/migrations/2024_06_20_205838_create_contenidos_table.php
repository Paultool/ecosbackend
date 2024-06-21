<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenidosTable extends Migration
{
    public function up()
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escena_id')->constrained('escenas')->onDelete('cascade');
            $table->enum('content_type', ['text', 'image', 'audio', 'video']);
            $table->integer('content_order');
            $table->text('content_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contenidos');
    }
}
