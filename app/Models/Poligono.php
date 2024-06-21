<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poligono extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'coordenadas', 'escena_id', 'descripcion'];

    protected $casts = [
        'coordenadas' => 'array',
    ];

    public function escena()
    {
        return $this->belongsTo(Escena::class);
    }
}

