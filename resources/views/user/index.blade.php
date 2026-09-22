@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Catálogo de Productos -->
    <div class="lg:col-span-2">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Catálogo de Productos</h2>
        
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($productos as $producto)
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-100 flex flex-col justify-between relative">
                    
                    @if($producto->es_promocion)
                        <span class="absolute -top-3 -right-2 bg-red-500 text-white text-xs font-extrabold px-2 py-1 rounded-full shadow">
                            🔥 Promoción -10%
                        </span>
                    @endif

                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-lg text-gray-800">{{ $producto->nombre }}</h3>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded">
                                {{ $producto->categoria->nombre ?? 'Sin Categoría' }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">Franquicia: <strong>{{ $producto->franquicia }}</strong></p>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($producto->descripcion, 80) }}</p>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                @if($producto->es_promocion)
                                    <span class="text-xs line-through text-gray-400 mr-1">${{ number_format($producto->precio, 2) }}</span>
                                    <span class="text-lg font-extrabold text-green-600">${{ number_format($producto->precio_final, 2) }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($producto->precio, 2) }}</span>
                                @endif
                            </div>

                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded {{ $producto->stock > 5 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                Stock: {{ $producto->stock }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="number" id="qty-{{ $producto->id }}" min="1" max="{{ $producto->stock }}" value="1"
                                   oninput="if(this.value < 1) this.value = 1; if(parseInt(this.value) > {{ $producto->stock }}) this.value = {{$producto->stock }};"
                                   class="w-20 rounded-md border-gray-300 border p-2 text-center text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            
                            <button type="button" 
                                    onclick='addToCart({{ json_encode($producto) }})'
                                    class="flex-1 bg-indigo-600 text-white py-2 px-3 rounded-md hover:bg-indigo-700 text-sm font-semibold">
                                Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white p-8 text-center rounded-lg shadow-md text-gray-500">
                    No hay productos disponibles para la venta.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Carrito y Formulario de Pago -->
    <div class="bg-white p-6 rounded-lg shadow-md h-fit">
        <h2 class="text-xl font-bold mb-4 flex justify-between items-center text-gray-800">
            <span>Carrito de Compra</span>
            <button type="button" onclick="clearCart()" class="text-xs text-red-600 hover:underline">Vaciar</button>
        </h2>

        <form action="{{ route('ventas.store') }}" method="POST" id="checkout-form">
            @csrf
            
            <div id="cart-items-container" class="divide-y divide-gray-200 min-h-[100px] mb-4">
                <p id="empty-cart-msg" class="text-gray-400 text-center py-6 text-sm">El carrito está vacío.</p>
            </div>

            <div class="border-t pt-4 space-y-3">
                <h3 class="font-bold text-sm text-gray-700">Datos de Pago</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600">Nombre Completo</label>
                    <input type="text" name="nombre_cliente" required placeholder="Juan Pérez"
                           class="w-full mt-1 p-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600">Correo Electrónico</label>
                    <input type="email" name="correo_cliente" required placeholder="juan@ejemplo.com"
                           class="w-full mt-1 p-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600">Número de Tarjeta</label>
                    <input type="text" name="numero_tarjeta" maxlength="20" required placeholder="4532 1234 5678 9012"
                           class="w-full mt-1 p-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="border-t mt-4 pt-4">
                <div class="flex justify-between font-bold text-lg text-gray-900 mb-4">
                    <span>Total a Pagar:</span>
                    <span id="cart-total">$0.00</span>
                </div>

                <button type="submit" id="btn-submit-sale" disabled 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-bold hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                    Pagar y Finalizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let cart = [];

    function addToCart(product) {
        const qtyInput = document.getElementById(`qty-${product.id}`);
        let quantity = parseInt(qtyInput.value) || 1;

        if (quantity <= 0) return;

        const existingItem = cart.find(item => item.id === product.id);
        const precioAplicado = product.precio_final;

        if (existingItem) {
            const newQty = existingItem.cantidad + quantity;
            if (newQty > product.stock) {
                alert(`No puedes agregar más de ${product.stock} unidades de este producto.`);
                existingItem.cantidad = product.stock;
            } else {
                existingItem.cantidad = newQty;
            }
        } else {
            if (quantity > product.stock) quantity = product.stock;
            cart.push({
                id: product.id,
                nombre: product.nombre,
                precio: precioAplicado,
                cantidad: quantity,
                stockMax: product.stock,
                esPromocion: product.es_promocion
            });
        }

        renderCart();
    }

    function updateCartQuantity(id, newQty) {
        const item = cart.find(i => i.id === id);
        if (item) {
            let qty = parseInt(newQty);
            if (isNaN(qty) || qty < 1) qty = 1;
            if (qty > item.stockMax) qty = item.stockMax;
            item.cantidad = qty;
            renderCart();
        }
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cart-items-container');
        const totalElement = document.getElementById('cart-total');
        const submitBtn = document.getElementById('btn-submit-sale');

        container.innerHTML = '';

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-gray-400 text-center py-6 text-sm">El carrito está vacío.</p>';
            totalElement.innerText = '$0.00';
            submitBtn.disabled = true;
            return;
        }

        let total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.precio * item.cantidad;
            total += itemTotal;

            const div = document.createElement('div');
            div.className = 'py-3 flex justify-between items-center';
            div.innerHTML = `
                <div class="flex-1 pr-2">
                    <h4 class="font-semibold text-sm text-gray-800">${item.nombre} ${item.esPromocion ? '<span class="text-xs text-red-500 font-bold">(-10%)</span>' : ''}</h4>
                    <span class="text-xs text-gray-500">$${item.precio.toFixed(2)} c/u</span>
                    <input type="hidden" name="items[${index}][producto_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][cantidad]" value="${item.cantidad}">
                </div>
                <div class="flex items-center space-x-2">
                    <input type="number" min="1" max="${item.stockMax}" value="${item.cantidad}"
                           onchange="updateCartQuantity(${item.id}, this.value)"
                           oninput="if(this.value < 1) this.value = 1; if(parseInt(this.value) > ${item.stockMax}) this.value = ${item.stockMax};"
                           class="w-14 rounded-md border-gray-300 border p-1 text-center text-xs">
                    <span class="text-sm font-bold text-gray-800 w-16 text-right">$${itemTotal.toFixed(2)}</span>
                    <button type="button" onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 font-bold px-1">&times;</button>
                </div>
            `;
            container.appendChild(div);
        });

        totalElement.innerText = `$${total.toFixed(2)}`;
        submitBtn.disabled = false;
    }
</script>
@endsection