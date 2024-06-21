<?php

namespace Database\Factories;

use App\Models\Escena;
use App\Models\Decada;
use Illuminate\Database\Eloquent\Factories\Factory;

class EscenaFactory extends Factory
{
    protected $model = Escena::class;

    public function definition()
    {
        return [
            'decada_id' => Decada::factory(),
            'title' => $this->faker->sentence,
            'z_index' => $this->faker->numberBetween(0, 10),
            'scene_type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'order_index' => $this->faker->numberBetween(1, 100),
        ];
    }
}
