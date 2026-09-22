<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ventas - NerdVault</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <a href="{{ route('user.index') }}" class="font-bold text-xl tracking-wide flex items-center gap-2">
                <span>🎲</span> NerdVault
            </a>
            
            <div class="flex space-x-2">
                <a href="{{ route('user.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium transition-colors hover:bg-indigo-700 {{ request()->routeIs('user.index') ? 'bg-indigo-800' : '' }}">
                    🛒 Tienda
                </a>
                <a href="{{ route('productos.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium transition-colors hover:bg-indigo-700 {{ request()->routeIs('productos.*') ? 'bg-indigo-800' : '' }}">
                    📦 Productos
                </a>
                <a href="{{ route('categorias.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium transition-colors hover:bg-indigo-700 {{ request()->routeIs('categorias.*') ? 'bg-indigo-800' : '' }}">
                    🏷️ Categorías
                </a>
                <a href="{{ route('ventas.index') }}" 
                   class="px-3 py-2 rounded-md text-sm font-medium transition-colors hover:bg-indigo-700 {{ request()->routeIs('ventas.*') ? 'bg-indigo-800' : '' }}">
                    📋 Ventas
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex justify-between items-center">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-4 text-center text-sm border-t border-gray-700 mt-auto">
        &copy; {{ date('Y') }} Sistema de Ludoteca. Todos los derechos reservados.
    </footer>

</body>
</html>