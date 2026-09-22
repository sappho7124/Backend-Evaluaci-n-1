<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Expansion;
use App\Models\Idioma;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $idiomas = Idioma::all();

        $term = $request->input('q');
        $anioDesde = $request->input('anio_desde');
        $anioHasta = $request->input('anio_hasta');
        $idiomaId = $request->input('idioma_id');

        $resultadosJuegos = collect();
        $resultadosExpansiones = collect();
        $resultadosIdiomas = collect();

        // Se ejecuta la búsqueda solo si al menos un filtro fue enviado
        if ($request->hasAny(['q', 'anio_desde', 'anio_hasta', 'idioma_id'])) {
            
            // 1. Búsqueda en Juegos
            $queryJuegos = Juego::with(['idioma', 'expansiones']);
            if ($term) {
                $queryJuegos->where(function ($q) use ($term) {
                    $q->where('titulo', 'LIKE', "%{$term}%")
                      ->orWhereHas('expansiones', fn($exp) => $exp->where('titulo', 'LIKE', "%{$term}%"));
                });
            }
            if ($anioDesde) $queryJuegos->where('anio', '>=', $anioDesde);
            if ($anioHasta) $queryJuegos->where('anio', '<=', $anioHasta);
            if ($idiomaId) $queryJuegos->where('idioma_id', $idiomaId);
            $resultadosJuegos = $queryJuegos->get();

            // 2. Búsqueda en Expansiones
            $queryExp = Expansion::with(['juego', 'idioma']);
            if ($term) {
                $queryExp->where(function ($q) use ($term) {
                    $q->where('titulo', 'LIKE', "%{$term}%")
                      ->orWhereHas('juego', fn($j) => $j->where('titulo', 'LIKE', "%{$term}%"));
                });
            }
            if ($idiomaId) $queryExp->where('idioma_id', $idiomaId);
            $resultadosExpansiones = $queryExp->get();

            // 3. Búsqueda en Idiomas
            $queryIdiomas = Idioma::query();
            if ($term) {
                $queryIdiomas->where('nombre', 'LIKE', "%{$term}%")
                             ->orWhere('codigo', 'LIKE', "%{$term}%");
            }
            if ($idiomaId) $queryIdiomas->where('id', $idiomaId);
            $resultadosIdiomas = $queryIdiomas->get();
        }

        return view('busqueda.avanzada', compact(
            'idiomas',
            'resultadosJuegos',
            'resultadosExpansiones',
            'resultadosIdiomas'
        ));
    }
}