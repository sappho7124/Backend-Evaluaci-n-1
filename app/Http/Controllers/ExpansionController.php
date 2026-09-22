<?php

namespace App\Http\Controllers;

use App\Models\Expansion;
use App\Models\Juego;
use App\Models\Idioma;
use Illuminate\Http\Request;

class ExpansionController extends Controller
{
    public function index()
    {
        $expansiones = Expansion::with(['juego', 'idioma'])->get();
        return view('expansiones.index', compact('expansiones'));
    }

    public function show(Expansion $expansion)
    {
        $expansion->load(['juego', 'idioma']);
        return view('expansiones.show', compact('expansion'));
    }

    public function create()
    {
        $juegos = Juego::all();
        $idiomas = Idioma::all();
        return view('expansiones.create', compact('juegos', 'idiomas'));
    }

    public function store(Request $request)
    {
        Expansion::create($request->only(['juego_id', 'titulo', 'idioma_id']));
        return redirect()->route('expansiones.index')->with('success', 'Expansión creada correctamente.');
    }

    public function edit(Expansion $expansion)
    {
        $juegos = Juego::all();
        $idiomas = Idioma::all();
        return view('expansiones.edit', compact('expansion', 'juegos', 'idiomas'));
    }

    public function update(Request $request, Expansion $expansion)
    {
        $expansion->update($request->only(['juego_id', 'titulo', 'idioma_id']));
        return redirect()->route('expansiones.index')->with('success', 'Expansión actualizada correctamente.');
    }

    public function destroy(Expansion $expansion)
    {
        $expansion->delete();
        return redirect()->route('expansiones.index')->with('success', 'Expansión eliminada correctamente.');
    }
}