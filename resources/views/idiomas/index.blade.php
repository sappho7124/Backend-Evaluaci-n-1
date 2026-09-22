@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Listado de Idiomas</h2>
    <a href="{{ route('idiomas.create') }}" class="btn btn-primary">Nuevo Idioma</a>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($idiomas as $idioma)
            <tr>
                <td>{{ $idioma->id }}</td>
                <td>{{ $idioma->nombre }}</td>
                <td>{{ $idioma->codigo }}</td>
                <td>
                    <a href="{{ route('idiomas.show', $idioma->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('idiomas.edit', $idioma->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('idiomas.destroy', $idioma->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar idioma?')">Borrar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">No hay idiomas registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection