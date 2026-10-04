@extends('layout')

@section('contenido')
    <h1>Nuevo estudiante</h1>

    <form method="POST" action="{{ route('estudiantes.store') }}">
        @csrf
        <label>Código
            <input name="codigo" value="{{ old('codigo') }}" required>
        </label>
        <label>Nombres
            <input name="nombres" value="{{ old('nombres') }}" required>
        </label>
        <label>Apellidos
            <input name="apellidos" value="{{ old('apellidos') }}" required>
        </label>
        <button type="submit">Guardar</button>
        <a href="{{ route('estudiantes.index') }}">Cancelar</a>
    </form>
@endsection
