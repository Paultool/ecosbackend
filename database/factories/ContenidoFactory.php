<?php

namespace Database\Factories;

use App\Models\Contenido;
use App\Models\Escena;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContenidoFactory extends Factory
{
    protected $model = Contenido::class;

    public function definition()
    {
        return [
            'escena_id' => Escena::factory(),
            'content_type' => $this->faker->randomElement(['text', 'image', 'audio', 'video']),
            'content_order' => $this->faker->numberBetween(1, 100),
            'content_data' => $this->faker->paragraph,
        ];
    }
}
