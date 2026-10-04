<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Nota;
use App\Services\PromedioService;
use Illuminate\Http\Request;
use InvalidArgumentException;

/**
 * Controlador de notas: recibe la petición y delega al servicio.
 */
class NotaController extends Controller
{
    public function __construct(private PromedioService $servicio) {}

    public function store(Request $request, Estudiante $estudiante)
    {
        $datos = $request->validate([
            'evaluacion' => 'required|string|max:100',
            'nota'       => 'required|numeric',
        ]);

        try {
            $this->servicio->registrarNota($estudiante->id, $datos['evaluacion'], (float) $datos['nota']);
        } catch (InvalidArgumentException $e) {
            // La regla de negocio (0 a 20) la valida el servicio
            return back()->withInput()->withErrors(['nota' => $e->getMessage()]);
        }

        return redirect()->route('estudiantes.show', $estudiante)->with('ok', 'Nota registrada.');
    }

    public function destroy(Nota $nota)
    {
        $estudianteId = $nota->estudiante_id;
        $this->servicio->eliminarNota($nota->id);

        return redirect()->route('estudiantes.show', $estudianteId)->with('ok', 'Nota eliminada.');
    }
}