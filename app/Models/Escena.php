<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escena extends Model
{
    use HasFactory;

    protected $fillable = ['decada_id', 'title', 'z_index', 'scene_type', 'order_index'];

    public function decada()
    {
        return $this->belongsTo(Decada::class);
    }

    public function contenido()
    {
        return $this->hasMany(Contenido::class);
    }

    public function poligono()
    {
        return $this->hasMany(Poligono::class);
    }
}
