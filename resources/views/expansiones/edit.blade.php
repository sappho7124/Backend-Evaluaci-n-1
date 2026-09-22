@extends('layouts.app')

@section('content')
<h2>Editar Expansión</h2>

<form action="{{ route('expansiones.update', $expansion->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" value="{{ $expansion->titulo }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Juego Base</label>
        <select name="juego_id" class="form-select" required>
            @foreach($juegos as $juego)
                <option value="{{ $juego->id }}" {{ $juego->id == $expansion->juego_id ? 'selected' : '' }}>
                    {{ $juego->titulo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Idioma</label>
        <select name="idioma_id" class="form-select" required>
            @foreach($idiomas as $idioma)
                <option value="{{ $idioma->id }}" {{ $idioma->id == $expansion->idioma_id ? 'selected' : '' }}>
                    {{ $idioma->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('expansiones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection