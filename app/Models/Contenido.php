<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    use HasFactory;

    protected $fillable = ['escena_id', 'content_type', 'content_order', 'content_data'];

    public function escena()
    {
        return $this->belongsTo(Escena::class);
    }
}

