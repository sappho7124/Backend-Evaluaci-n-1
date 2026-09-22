<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Idioma;
use Illuminate\Http\Request;

class JuegoController extends Controller
{

    public function busqueda(Request $request)
    {
        $query = Juego::with(['idioma', 'expansiones']);

        // 1. Búsqueda parcial por nombre (Juego o Expansión)
        if ($request->filled('nombre')) {
            $nombre = $request->input('nombre');
            $query->where(function ($q) use ($nombre) {
                $q->where('titulo', 'LIKE', "%{$nombre}%")
                ->orWhereHas('expansiones', function ($qExp) use ($nombre) {
                    $qExp->where('titulo', 'LIKE', "%{$nombre}%");
                });
            });
        }

        // 2. Rango de años de creación
        if ($request->filled('anio_desde')) {
            $query->where('anio', '>=', $request->input('anio_desde'));
        }
        if ($request->filled('anio_hasta')) {
            $query->where('anio', '<=', $request->input('anio_hasta'));
        }

        // 3. Filtro por idioma
        if ($request->filled('idioma_id')) {
            $query->where('idioma_id', $request->input('idioma_id'));
        }

        $juegos = $query->get();
        $idiomas = Idioma::all();

        return view('juegos.busqueda', compact('juegos', 'idiomas'));
    }
    // READ (Todos con JOIN de Idioma)
    public function index()
    {
        $juegos = Juego::all();

        return view('juegos.index', compact('juegos'));
    }

    // READ (Uno)
    public function show($id)
    {
        $juego = Juego::find($id);

        // Si no existe el juego, devolvemos un 404
        if (!$juego) {
            abort(404, 'Juego no encontrado');
        }

        return view('juegos.show', compact('juego'));
    }

    // CREATE
    public function store(Request $request)
    {
        Juego::create($request->only(['titulo', 'anio', 'idioma_id']));

        return response()->json(['message' => 'Juego creado correctamente']);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        Juego::update($id, $request->only(['titulo', 'anio', 'idioma_id']));

        return response()->json(['message' => 'Juego actualizado correctamente']);
    }

    // DELETE
    public function destroy($id)
    {
        Juego::destroy($id);

        return response()->json(['message' => 'Juego eliminado correctamente']);
    }

    public function create()
    {
        $idiomas = Idioma::all();
        return view('juegos.create', compact('idiomas'));
    }
}
?>