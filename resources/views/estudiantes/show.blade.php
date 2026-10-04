@extends('layout')

@section('contenido')
    <h1>{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</h1>
    <p>
        Código: <strong>{{ $estudiante->codigo }}</strong> |
        Promedio: <strong>{{ number_format($estudiante->promedio, 2) }}</strong> |
        Condición: <strong>{{ $estudiante->condicion }}</strong>
    </p>

    <h2>Registrar nota</h2>
    <form method="POST" action="{{ route('notas.store', $estudiante) }}">
        @csrf
        <label>Evaluación
            <input name="evaluacion" value="{{ old('evaluacion') }}" placeholder="Ej: Práctica 1" required>
        </label>
        <label>Nota (0 a 20)
            <input name="nota" type="number" step="0.01" value="{{ old('nota') }}" required>
        </label>
        <button type="submit">Guardar nota</button>
    </form>

    <h2>Notas registradas</h2>
    <table>
        <tr><th>Evaluación</th><th>Nota</th><th>Acciones</th></tr>
        @forelse ($estudiante->notas as $n)
            <tr>
                <td>{{ $n->evaluacion }}</td>
                <td>{{ number_format($n->nota, 2) }}</td>
                <td>
                    <form method="POST" action="{{ route('notas.destroy', $n) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar nota?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">Aún no hay notas.</td></tr>
        @endforelse
    </table>

    <a href="{{ route('estudiantes.index') }}">← Volver a la lista</a>
@endsection