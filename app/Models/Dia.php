<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Circuito;

class Dia extends Model
{
    use HasFactory;

    protected $fillable = [
        'circuito_id',
        'nombre',
        'horario',
        'descripcion',
        'nombre_english',
        'horario_english',
        'descripcion_english'
    ];
    public function circuito()
    {
        return $this->belongsTo(Circuito::class);
    }
}
