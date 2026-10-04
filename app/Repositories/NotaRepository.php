<?php

namespace App\Repositories;

use App\Models\Nota;

/**
 * Repositorio de notas: único punto de acceso a la tabla "notas".
 */
class NotaRepository
{
    public function crear(array $datos): Nota
    {
        return Nota::create($datos);
    }

    public function eliminar(int $id): void
    {
        Nota::findOrFail($id)->delete();
    }
}