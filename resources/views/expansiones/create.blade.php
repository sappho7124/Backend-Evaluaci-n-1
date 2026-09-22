@extends('layouts.app')

@section('content')
<h2>Crear Nueva Expansión</h2>

<form action="/expansiones" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Juego Base</label>
        <select name="juego_id" class="form-select" required>
            <option value="">-- Selecciona el juego base --</option>
            @foreach($juegos as $juego)
                <option value="{{ $juego->id }}">{{ $juego->titulo }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Idioma</label>
        <select name="idioma_id" class="form-select" required>
            <option value="">-- Selecciona un idioma --</option>
            @foreach($idiomas as $idioma)
                <option value="{{ $idioma->id }}">{{ $idioma->nombre }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/expansiones" class="btn btn-secondary">Cancelar</a>
</form>
@endsection