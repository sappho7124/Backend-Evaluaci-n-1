@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Listado de Expansiones</h2>
    <a href="{{ route('expansiones.create') }}" class="btn btn-primary">Nueva Expansión</a>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Juego Base</th>
            <th>Idioma</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($expansiones as $expansion)
            <tr>
                <td>{{ $expansion->id }}</td>
                <td>{{ $expansion->titulo }}</td>
                <td>{{ $expansion->juego->titulo ?? 'N/A' }}</td>
                <td>{{ $expansion->idioma->nombre ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('expansiones.show', $expansion->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('expansiones.edit', $expansion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('expansiones.destroy', $expansion->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar expansión?')">Borrar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No hay expansiones registradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection