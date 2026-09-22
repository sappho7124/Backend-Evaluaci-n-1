@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Card -->
    <div class="bg-white p-6 rounded-lg shadow-md h-fit">
        <h2 class="text-lg font-bold mb-4" id="form-title">Agregar Categoría</h2>
        <form id="categoria-form" action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('nombre')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Guardar</button>
                <button type="button" id="cancel-btn" onclick="resetForm()" class="hidden w-full bg-gray-400 text-white py-2 px-4 rounded-md hover:bg-gray-500">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Table View -->
    <div class="bg-white p-6 rounded-lg shadow-md md:col-span-2">
        <h2 class="text-lg font-bold mb-4">Listado de Categorías</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Productos</th>
                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categorias as $categoria)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $categoria->nombre }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $categoria->productos_count }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <button onclick="editCategoria({{ $categoria->id }}, '{{ addslashes($categoria->nombre) }}')" class="text-blue-600 hover:text-blue-900 text-sm font-semibold">Editar</button>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Desea eliminar esta categoría?')" class="text-red-600 hover:text-red-900 text-sm font-semibold">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function editCategoria(id, nombre) {
        document.getElementById('form-title').innerText = 'Editar Categoría';
        document.getElementById('categoria-form').action = `/categorias/${id}`;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('nombre').value = nombre;
        document.getElementById('cancel-btn').classList.remove('hidden');
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Agregar Categoría';
        document.getElementById('categoria-form').action = "{{ route('categorias.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('nombre').value = '';
        document.getElementById('cancel-btn').classList.add('hidden');
    }
</script>
@endsection