@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Listado de Juegos</h2>
    <a href="{{ route('juegos.create') }}" class="btn btn-primary">Nuevo Juego</a>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Año</th>
            <th>Idioma</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($juegos as $juego)
            <tr>
                <td>{{ $juego->id }}</td>
                <td>{{ $juego->titulo }}</td>
                <td>{{ $juego->anio }}</td>
                <td>{{ $juego->idioma }}</td>
                <td>
                    <a href="{{ route('juegos.show', $juego->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('juegos.destroy', $juego->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar juego?')">Borrar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No hay juegos registrados.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection