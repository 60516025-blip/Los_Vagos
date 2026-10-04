<?php

namespace App\Services;

use App\Models\Estudiante;
use App\Models\Nota;
use App\Repositories\EstudianteRepository;
use App\Repositories\NotaRepository;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Capa de servicio: contiene la lógica de negocio del sistema de notas.
 * Valida reglas, calcula promedios y coordina a los repositorios.
 */
class PromedioService
{
    public const NOTA_MINIMA = 0;
    public const NOTA_MAXIMA = 20;
    public const NOTA_APROBATORIA = 11;

    public function __construct(
        private EstudianteRepository $estudiantes,
        private NotaRepository $notas,
    ) {}

    /** Lista de estudiantes, cada uno con su promedio y condición. */
    public function listarConPromedio(): Collection
    {
        return $this->estudiantes->todosConNotas()
            ->map(fn (Estudiante $e) => $this->agregarPromedio($e));
    }

    /** Un estudiante con sus notas, promedio y condición. */
    public function detalle(int $id): Estudiante
    {
        return $this->agregarPromedio($this->estudiantes->buscarConNotas($id));
    }

    public function registrarEstudiante(array $datos): Estudiante
    {
        return $this->estudiantes->crear($datos);
    }

    public function eliminarEstudiante(int $id): void
    {
        $this->estudiantes->eliminar($id);
    }

    /** Regla de negocio: la nota debe estar entre 0 y 20. */
    public function registrarNota(int $estudianteId, string $evaluacion, float $nota): Nota
    {
        if ($nota < self::NOTA_MINIMA || $nota > self::NOTA_MAXIMA) {
            throw new InvalidArgumentException(
                'La nota debe estar entre ' . self::NOTA_MINIMA . ' y ' . self::NOTA_MAXIMA . '.'
            );
        }

        return $this->notas->crear([
            'estudiante_id' => $estudianteId,
            'evaluacion'    => $evaluacion,
            'nota'          => $nota,
        ]);
    }

    public function eliminarNota(int $id): void
    {
        $this->notas->eliminar($id);
    }

    /** Promedio simple: suma de notas entre la cantidad de notas. */
    public function calcularPromedio(Collection $notas): float
    {
        if ($notas->isEmpty()) {
            return 0.0;
        }

        return round((float) $notas->avg('nota'), 2);
    }

    public function condicion(float $promedio, int $cantidadNotas): string
    {
        if ($cantidadNotas === 0) {
            return 'Sin notas';
        }

        return $promedio >= self::NOTA_APROBATORIA ? 'Aprobado' : 'Desaprobado';
    }

    private function agregarPromedio(Estudiante $estudiante): Estudiante
    {
        $estudiante->promedio  = $this->calcularPromedio($estudiante->notas);
        $estudiante->condicion = $this->condicion($estudiante->promedio, $estudiante->notas->count());

        return $estudiante;
    }
}