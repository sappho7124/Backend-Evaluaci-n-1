@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Historial de Ventas</h2>
        <a href="{{ route('user.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-semibold">
            + Nueva Compra
        </a>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Venta</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarjeta</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Total</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($ventas as $venta)
                <tr>
                    <td class="px-4 py-3 font-semibold text-gray-900">#{{ str_pad($venta->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3 text-gray-800 text-sm font-medium">{{ $venta->nombre_cliente }}</td>
                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $venta->correo_cliente }}</td>
                    <td class="px-4 py-3 text-gray-500 text-sm">•••• {{ substr($venta->numero_tarjeta, -4) }}</td>
                    <td class="px-4 py-3 text-gray-900 font-bold">${{ number_format($venta->valor_total, 2) }}</td>
                    <td class="px-4 py-3 text-right">
                        <button onclick='showDetails({{ json_encode($venta) }})' 
                                class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-3 py-1 rounded text-sm font-semibold">
                            Ver Detalle
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay ventas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Detalle Venta -->
<div id="details-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800" id="modal-sale-title">Detalle de Venta</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4 text-sm bg-gray-50 p-3 rounded">
            <div>
                <p class="text-gray-500">Cliente:</p>
                <p id="modal-customer-name" class="font-semibold text-gray-800"></p>
            </div>
            <div>
                <p class="text-gray-500">Correo:</p>
                <p id="modal-customer-email" class="font-semibold text-gray-800"></p>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody id="modal-details-body" class="divide-y divide-gray-200">
                <!-- Se llena mediante JS -->
            </tbody>
        </table>

        <div class="flex justify-between items-center border-t pt-3">
            <span class="font-bold text-gray-700">Valor Total:</span>
            <span id="modal-sale-total" class="text-xl font-bold text-green-600"></span>
        </div>

        <div class="mt-6 flex justify-end">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-sm font-semibold">Cerrar</button>
        </div>
    </div>
</div>

<script>
    function showDetails(venta) {
        document.getElementById('modal-sale-title').innerText = `Detalle de Venta #${String(venta.id).padStart(5, '0')}`;
        document.getElementById('modal-customer-name').innerText = venta.nombre_cliente;
        document.getElementById('modal-customer-email').innerText = venta.correo_cliente;
        document.getElementById('modal-sale-total').innerText = `$${parseFloat(venta.valor_total).toFixed(2)}`;

        const tbody = document.getElementById('modal-details-body');
        tbody.innerHTML = '';

        venta.detalles.forEach(detalle => {
            const precio = detalle.producto ? parseFloat(detalle.producto.precio) : 0;
            const subtotal = precio * detalle.cantidad;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-3 py-2 text-sm text-gray-800 font-medium">${detalle.producto ? detalle.producto.nombre : 'Producto Eliminado'}</td>
                <td class="px-3 py-2 text-sm text-gray-600 text-center">${detalle.cantidad}</td>
                <td class="px-3 py-2 text-sm text-gray-600 text-right">$${precio.toFixed(2)}</td>
                <td class="px-3 py-2 text-sm text-gray-900 font-bold text-right">$${subtotal.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('details-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('details-modal').classList.add('hidden');
    }
</script>
@endsection