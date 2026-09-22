<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('detalles.producto')->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        // Solo productos con stock mayor a cero (0)
        $productos = Producto::with('categoria')->where('stock', '>', 0)->get();
        return view('user.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:150',
            'correo_cliente' => 'required|email|max:150',
            'numero_tarjeta' => 'required|string|max:20',
            'items'          => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad'    => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $valorTotal = 0;
            $detallesParaInsertar = [];

            foreach ($request->items as $item) {
                $producto = Producto::lockForUpdate()->find($item['producto_id']);

                if (!$producto || $producto->stock <= 0) {
                    DB::rollBack();
                    return back()->withErrors(["stock" => "El producto '{$producto->nombre}' no tiene stock disponible."]);
                }

                if ($producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return back()->withErrors(["stock" => "El producto '{$producto->nombre}' no tiene suficiente stock disponible (Quedan {$producto->stock})."]);
                }

                $precioEfectivo = $producto->stock > 20 ? round($producto->precio * 0.90, 2) : $producto->precio;
                $subtotal = $precioEfectivo * $item['cantidad'];
                $valorTotal += $subtotal;

                $producto->decrement('stock', $item['cantidad']);

                $detallesParaInsertar[] = [
                    'producto_id' => $producto->id,
                    'cantidad'    => $item['cantidad'],
                ];
            }

            $venta = Venta::create([
                'nombre_cliente' => $request->nombre_cliente,
                'correo_cliente' => $request->correo_cliente,
                'numero_tarjeta' => $request->numero_tarjeta,
                'valor_total'    => $valorTotal,
            ]);

            foreach ($detallesParaInsertar as $detalle) {
                $venta->detalles()->create($detalle);
            }

            DB::commit();
            return redirect()->route('user.index')->with('success', '¡Compra realizada con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar la venta: ' . $e->getMessage()]);
        }
    }
}