<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dia;

class Circuito extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'incluye_spanish',
        'incluye_english',
        'no_incluye_spanish',
        'no_incluye_english',
        'duracion',
        'img',
        'archivo_english',
        'archivo_spanish'
    ];

    public function dias()
    {
        return $this->hasMany(Dia::class);
    }
}
