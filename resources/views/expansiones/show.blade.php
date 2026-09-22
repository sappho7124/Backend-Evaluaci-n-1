@extends('layouts.app')

@section('content')
<h2>Detalle de Expansión</h2>
<div class="card">
    <div class="card-body">
        <p><strong>ID:</strong> {{ $expansion->id }}</p>
        <p><strong>Título:</strong> {{ $expansion->titulo }}</p>
        <p><strong>Juego Base:</strong> {{ $expansion->juego_base }}</p>
        <p><strong>Idioma:</strong> {{ $expansion->idioma }}</p>
    </div>
</div>
<a href="{{ route('expansiones.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection