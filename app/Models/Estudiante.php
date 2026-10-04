<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    // Campos que se pueden asignar desde un formulario
    protected $fillable = ['codigo', 'nombres', 'apellidos'];

    // Un estudiante tiene muchas notas
    public function notas(): HasMany
    {
        return $this->hasMany(Nota::class);
    }
}