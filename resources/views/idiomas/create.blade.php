@extends('layouts.app')

@section('content')
<h2>Crear Nuevo Idioma</h2>

<form action="/idiomas" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/idiomas" class="btn btn-secondary">Cancelar</a>
</form>
@endsection