@extends('layout')

@section('contenido')
    <h1>Estudiantes y promedios</h1>
    <a href="{{ route('estudiantes.create') }}" role="button">+ Nuevo estudiante</a>

    <table>
        <tr>
            <th>Código</th><th>Estudiante</th><th>N° notas</th>
            <th>Promedio</th><th>Condición</th><th>Acciones</th>
        </tr>
        @forelse ($estudiantes as $e)
            <tr>
                <td>{{ $e->codigo }}</td>
                <td>{{ $e->apellidos }}, {{ $e->nombres }}</td>
                <td>{{ $e->notas->count() }}</td>
                <td>{{ number_format($e->promedio, 2) }}</td>
                <td>{{ $e->condicion }}</td>
                <td>
                    <a href="{{ route('estudiantes.show', $e) }}">Ver notas</a>
                    <form method="POST" action="{{ route('estudiantes.destroy', $e) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar estudiante?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Aún no hay estudiantes registrados.</td></tr>
        @endforelse
    </table>
@endsection