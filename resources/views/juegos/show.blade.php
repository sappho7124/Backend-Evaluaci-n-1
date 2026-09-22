@extends('layouts.app')

@section('content')
<h2>Detalle del Juego</h2>
<div class="card">
    <div class="card-body">
        <p><strong>ID:</strong> {{ $juego->id }}</p>
        <p><strong>Título:</strong> {{ $juego->titulo }}</p>
        <p><strong>Año:</strong> {{ $juego->anio }}</p>
        <p><strong>Idioma:</strong> {{ $juego->idioma }}</p>
    </div>
</div>
<a href="{{ route('juegos.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection