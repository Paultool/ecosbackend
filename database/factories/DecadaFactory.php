<?php

namespace Database\Factories;

use App\Models\Decada;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecadaFactory extends Factory
{
    protected $model = Decada::class;

    public function definition()
    {
        return [
            'name' => $this->faker->year,
            'description' => $this->faker->sentence,
        ];
    }
}
