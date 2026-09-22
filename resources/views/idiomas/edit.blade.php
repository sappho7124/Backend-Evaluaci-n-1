@extends('layouts.app')

@section('content')
<h2>Editar Idioma</h2>
<form action="{{ route('idiomas.update', $idioma->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" value="{{ $idioma->nombre }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" value="{{ $idioma->codigo }}" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('idiomas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection