<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tarifa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_tarifa',
        'archivo',
        'users_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
