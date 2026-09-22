@extends('layouts.app')

@section('content')
<h2>Editar Juego</h2>

<form action="/juegos/{{ $juego->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" value="{{ $juego->titulo }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Año</label>
        <input type="number" name="anio" value="{{ $juego->anio }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Idioma</label>
        <select name="idioma_id" class="form-select" required>
            @foreach($idiomas as $idioma)
                <option value="{{ $idioma->id }}" {{ $idioma->id == $juego->idioma_id ? 'selected' : '' }}>
                    {{ $idioma->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="/juegos" class="btn btn-secondary">Cancelar</a>
</form>
@endsection