<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Registro de Notas')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <nav>
            <ul><li><strong>Registro de Notas</strong></li></ul>
            <ul><li><a href="{{ route('estudiantes.index') }}">Estudiantes</a></li></ul>
        </nav>

        @if (session('ok'))
            <article>{{ session('ok') }}</article>
        @endif

        @if ($errors->any())
            <article>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        @yield('contenido')
    </main>
</body>
</html>