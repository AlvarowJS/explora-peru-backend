<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'lugares',
        'descripcion_spanish',
        'descripcion_english',
        'incluye_spanish',
        'incluye_english',
        'no_incluye_spanish',
        'no_incluye_english',
        'duracion',
        'img',
        'archivo_english',
        'archivo_spanish'
    ];
}
