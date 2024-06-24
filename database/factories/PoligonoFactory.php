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
        // Definimos los límites del área de la laguna
        $minLat = 19.776;
        $maxLat = 19.798;
        $minLng = -99.147;
        $maxLng = -99.127;
        $polygonSize = 0.001;

        // Generar un centro de coordenadas dentro de los límites
        $centerLat = $this->faker->randomFloat(6, $minLat, $maxLat);
        $centerLng = $this->faker->randomFloat(6, $minLng, $maxLng);

        // Generar las coordenadas del polígono basado en el centro
        $coordinates = [
            ['lat' => $centerLat - $polygonSize / 2, 'lng' => $centerLng - $polygonSize / 2],
            ['lat' => $centerLat - $polygonSize / 2, 'lng' => $centerLng + $polygonSize / 2],
            ['lat' => $centerLat + $polygonSize / 2, 'lng' => $centerLng + $polygonSize / 2],
            ['lat' => $centerLat + $polygonSize / 2, 'lng' => $centerLng - $polygonSize / 2],
            ['lat' => $centerLat - $polygonSize / 2, 'lng' => $centerLng - $polygonSize / 2], // Cerrar el polígono
        ];

        return [
            'nombre' => $this->faker->word,
            'coordenadas' => json_encode($coordinates),
            'escena_id' => Escena::factory(),
            'descripcion' => $this->faker->sentence,
        ];
    }
}
