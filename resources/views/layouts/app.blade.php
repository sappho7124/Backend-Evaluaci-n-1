<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
    <nav class="bg-indigo-600 text-white p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Gestión de Tienda</h1>
            <div class="space-x-4">
                <a href="{{ route('user.index') }}" class="hover:underline {{ request()->routeIs('user.*') ? 'font-bold underline' : '' }}">Tienda / Vender</a>
                <a href="{{ route('categorias.index') }}" class="hover:underline {{ request()->routeIs('categorias.*') ? 'font-bold underline' : '' }}">Categorías</a>
                <a href="{{ route('productos.index') }}" class="hover:underline {{ request()->routeIs('productos.*') ? 'font-bold underline' : '' }}">Productos</a>
                <a href="{{ route('ventas.index') }}" class="hover:underline {{ request()->routeIs('ventas.*') ? 'font-bold underline' : '' }}">Historial Ventas</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto mt-6 p-4">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>