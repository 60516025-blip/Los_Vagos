<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nota extends Model
{
    // Campos que se pueden asignar desde un formulario
    protected $fillable = ['estudiante_id', 'evaluacion', 'nota'];

    // Cada nota pertenece a un estudiante
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }
}