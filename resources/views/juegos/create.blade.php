@extends('layouts.app')

@section('content')
<h2>Crear Nuevo Juego</h2>

<form action="/juegos" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Año</label>
        <input type="number" name="anio" class="form-control" required>
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
    <a href="/juegos" class="btn btn-secondary">Cancelar</a>
</form>
@endsection