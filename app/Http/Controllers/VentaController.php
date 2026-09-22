<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    // Mostrar listado de ventas realizadas
    public function index()
    {
        $ventas = Venta::with('detalles.producto')->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    // Vista para realizar compras/ventas
    public function create()
    {
        $productos = Producto::with('categoria')->where('stock', '>', 0)->get();
        return view('user.index', compact('productos'));
    }

    // Procesar la venta
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalVenta = 0;
            $detallesParaInsertar = [];

            foreach ($request->items as $item) {
                $producto = Producto::lockForUpdate()->find($item['producto_id']);

                if ($producto->stock < $item['cantidad']) {
                    return back()->withErrors(["stock" => "El producto '{$producto->nombre}' no tiene suficiente stock disponible."]);
                }

                $subtotal = $producto->precio * $item['cantidad'];
                $totalVenta += $subtotal;

                // Descontar el stock
                $producto->decrement('stock', $item['cantidad']);

                $detallesParaInsertar[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ];
            }

            // Registrar Venta
            $venta = Venta::create([
                'total' => $totalVenta,
                'fecha' => now(),
            ]);

            // Registrar detalles
            foreach ($detallesParaInsertar as $detalle) {
                $venta->detalles()->create($detalle);
            }

            DB::commit();
            return redirect()->route('user.index')->with('success', 'Venta realizada con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al procesar la venta: ' . $e::getMessage()]);
        }
    }
}