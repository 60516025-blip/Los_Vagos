<?php

namespace App\Repositories;

use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositorio de estudiantes: único punto de acceso a la tabla "estudiantes".
 */
class EstudianteRepository
{
    public function todosConNotas(): Collection
    {
        return Estudiante::with('notas')->orderBy('apellidos')->get();
    }

    public function buscarConNotas(int $id): Estudiante
    {
        return Estudiante::with('notas')->findOrFail($id);
    }

    public function crear(array $datos): Estudiante
    {
        return Estudiante::create($datos);
    }

    public function eliminar(int $id): void
    {
        Estudiante::findOrFail($id)->delete();
    }
}