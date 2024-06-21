<?php

namespace Database\Factories;

use App\Models\Poligono;
use App\Models\Escena;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoligonoFactory extends Factory
{
    protected $model = Poligono::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word,
            'coordenadas' => json_encode([
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
            ]),
            'escena_id' => Escena::factory(),
            'descripcion' => $this->faker->sentence,
        ];
    }
}
