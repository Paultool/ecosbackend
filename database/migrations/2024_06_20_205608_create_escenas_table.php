<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscenasTable extends Migration
{
    public function up()
    {
        Schema::create('escenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decada_id')->constrained('decadas')->onDelete('cascade');
            $table->string('title');
            $table->integer('z_index')->default(0);
            $table->string('scene_type');
            $table->integer('order_index');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('escenas');
    }
}
