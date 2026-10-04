<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Services\PromedioService;
use Illuminate\Http\Request;

/**
 * Controlador de estudiantes: recibe la petición y delega al servicio.
 */
class EstudianteController extends Controller
{
    public function __construct(private PromedioService $servicio) {}

    public function index()
    {
        $estudiantes = $this->servicio->listarConPromedio();

        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo'    => 'required|string|max:20|unique:estudiantes,codigo',
            'nombres'   => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
        ]);

        $this->servicio->registrarEstudiante($datos);

        return redirect()->route('estudiantes.index')->with('ok', 'Estudiante registrado.');
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante = $this->servicio->detalle($estudiante->id);

        return view('estudiantes.show', compact('estudiante'));
    }

    public function destroy(Estudiante $estudiante)
    {
        $this->servicio->eliminarEstudiante($estudiante->id);

        return redirect()->route('estudiantes.index')->with('ok', 'Estudiante eliminado.');
    }
}