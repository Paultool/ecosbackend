<?php


namespace App\Models;
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Decada;
use App\Models\Escena;
use App\Models\Contenido;
use App\Models\Poligono;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Decada::factory(5)
            ->has(
                Escena::factory(3)
                    ->has(Contenido::factory(5), 'contenido')
                    ->has(Poligono::factory(2), 'poligono')
            )
            ->create();
    }
}
