@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Card -->
    <div class="bg-white p-6 rounded-lg shadow-md h-fit">
        <h2 class="text-lg font-bold mb-4" id="form-title">Agregar Producto</h2>
        <form id="producto-form" action="{{ route('productos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="mb-3">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-3">
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select name="categoria_id" id="categoria_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-3">
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input type="number" step="0.01" min="0" name="precio" id="precio" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock Disponible</label>
                    <!-- Stock constraints applied via min="0" and client-side JS prevention -->
                    <input type="number" min="0" step="1" name="stock" id="stock" required
                           oninput="if(this.value < 0) this.value = 0;"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="mb-3">
                <label for="franquicia" class="block text-sm font-medium text-gray-700">Franquicia</label>
                <input type="text" name="franquicia" id="franquicia" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Guardar</button>
                <button type="button" id="cancel-btn" onclick="resetForm()" class="hidden w-full bg-gray-400 text-white py-2 px-4 rounded-md hover:bg-gray-500">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Table View -->
    <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2 overflow-x-auto">
        <h2 class="text-lg font-bold mb-4">Listado de Productos</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Franquicia</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($productos as $producto)
                    <tr>
                        <td class="px-3 py-3 font-medium text-gray-900">{{ $producto->nombre }}</td>
                        <td class="px-3 py-3 text-gray-500">{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td>
                        <td class="px-3 py-3 text-gray-500">{{ $producto->franquicia }}</td>
                        <td class="px-3 py-3 text-gray-900 font-semibold">${{ number_format($producto->precio, 2) }}</td>
                        <td class="px-3 py-3">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $producto->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $producto->stock }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-right space-x-2">
                            <button onclick='editProducto({{ json_encode($producto) }})' class="text-blue-600 hover:text-blue-900 text-sm font-semibold">Editar</button>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Desea eliminar este producto?')" class="text-red-600 hover:text-red-900 text-sm font-semibold">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 py-3 text-center text-gray-500">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function editProducto(producto) {
        document.getElementById('form-title').innerText = 'Editar Producto';
        document.getElementById('producto-form').action = `/productos/${producto.id}`;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('nombre').value = producto.nombre;
        document.getElementById('categoria_id').value = producto.categoria_id;
        document.getElementById('precio').value = producto.precio;
        document.getElementById('stock').value = producto.stock;
        document.getElementById('franquicia').value = producto.franquicia;
        document.getElementById('descripcion').value = producto.descripcion ?? '';
        document.getElementById('cancel-btn').classList.remove('hidden');
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Agregar Producto';
        document.getElementById('producto-form').action = "{{ route('productos.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('producto-form').reset();
        document.getElementById('cancel-btn').classList.add('hidden');
    }
</script>
@endsection