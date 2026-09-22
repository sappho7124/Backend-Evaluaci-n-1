@extends('layouts.app')

@section('content')
<h2 class="mb-4">Búsqueda Avanzada de Juegos</h2>

<form method="GET" action="{{ route('juegos.busqueda') }}" class="card card-body mb-4 bg-light">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Nombre (Juego o Expansión)</label>
            <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control" placeholder="Ej. Mar">
        </div>
        <div class="col-md-2">
            <label class="form-label">Año Desde</label>
            <input type="number" name="anio_desde" value="{{ request('anio_desde') }}" class="form-control" placeholder="2015">
        </div>
        <div class="col-md-2">
            <label class="form-label">Año Hasta</label>
            <input type="number" name="anio_hasta" value="{{ request('anio_hasta') }}" class="form-control" placeholder="2025">
        </div>
        <div class="col-md-4">
            <label class="form-label">Idioma</label>
            <select name="idioma_id" class="form-select">
                <option value="">-- Todos los Idiomas --</option>
                @foreach($idiomas as $idioma)
                    <option value="{{ $idioma->id }}" {{ request('idioma_id') == $idioma->id ? 'selected' : '' }}>
                        {{ $idioma->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="{{ route('juegos.busqueda') }}" class="btn btn-secondary">Limpiar Filtros</a>
    </div>
</form>

<h3>Resultados</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Juego</th>
            <th>Año</th>
            <th>Idioma</th>
            <th>Expansiones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($juegos as $juego)
            <tr>
                <td><strong>{{ $juego->titulo }}</strong></td>
                <td>{{ $juego->anio }}</td>
                <td>{{ $juego->idioma->nombre ?? 'N/A' }}</td>
                <td>
                    @if($juego->expansiones->isNotEmpty())
                        <ul class="mb-0">
                            @foreach($juego->expansiones as $expansion)
                                <li>{{ $expansion->titulo }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Sin expansiones</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No se encontraron resultados con los criterios seleccionados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection