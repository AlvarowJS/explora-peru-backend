<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lugare;

class Tour extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion_spanish',
        'descripcion_english',
        'incluye_spanish',
        'incluye_english',
        'lugares',
        'duracion',
        'img',
        'lugare_id',
    ];

    public function lugare()
    {
        return $this->belongsTo(Lugare::class);
    }
}
