@extends('layouts.app')

@section('content')
<h2>Detalle de Idioma</h2>
<div class="card">
    <div class="card-body">
        <p><strong>ID:</strong> {{ $idioma->id }}</p>
        <p><strong>Nombre:</strong> {{ $idioma->nombre }}</p>
        <p><strong>Código:</strong> {{ $idioma->codigo }}</p>
    </div>
</div>
<a href="{{ route('idiomas.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection