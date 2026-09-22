<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ludoteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('juegos.index') }}">🎲 Ludoteca</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('juegos.index') }}">Juegos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('idiomas.index') }}">Idiomas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expansiones.index') }}">Expansiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('busqueda.avanzada') }}">Búsqueda Avanzada</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Mostrar alerta tras la creación, actualización o eliminación -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>