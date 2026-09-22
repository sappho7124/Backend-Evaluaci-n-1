@extends('layouts.app')

@section('content')
<h2 class="mb-4">🔍 Búsqueda Avanzada Global</h2>

<form method="GET" action="{{ route('busqueda.avanzada') }}" class="card card-body mb-4 bg-light shadow-sm">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label font-weight-bold">Término de búsqueda</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar título, expansión, idioma...">
        </div>
        <div class="col-md-2">
            <label class="form-label font-weight-bold">Año Desde</label>
            <input type="number" name="anio_desde" value="{{ request('anio_desde') }}" class="form-control" placeholder="Ej. 2015">
        </div>
        <div class="col-md-2">
            <label class="form-label font-weight-bold">Año Hasta</label>
            <input type="number" name="anio_hasta" value="{{ request('anio_hasta') }}" class="form-control" placeholder="Ej. 2025">
        </div>
        <div class="col-md-4">
            <label class="form-label font-weight-bold">Idioma</label>
            <select name="idioma_id" class="form-select">
                <option value="">-- Todos los Idiomas --</option>
                @foreach($idiomas as $idioma)
                    <option value="{{ $idioma->id }}" {{ request('idioma_id') == $idioma->id ? 'selected' : '' }}>
                        {{ $idioma->nombre }} ({{ $idioma->codigo }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary me-2">Filtrar Base de Datos</button>
        <a href="{{ route('busqueda.avanzada') }}" class="btn btn-outline-secondary">Limpiar Filtros</a>
    </div>
</form>

@if(request()->hasAny(['q', 'anio_desde', 'anio_hasta', 'idioma_id']))

    {{-- RESULTADOS EN JUEGOS --}}
    <div class="mb-4">
        <h4>🎲 Juegos Coincidentes ({{ $resultadosJuegos->count() }})</h4>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Idioma</th>
                    <th>Expansiones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultadosJuegos as $juego)
                    <tr>
                        <td><strong>{{ $juego->titulo }}</strong></td>
                        <td>{{ $juego->anio }}</td>
                        <td>{{ $juego->idioma->nombre ?? 'N/A' }}</td>
                        <td>
                            @forelse($juego->expansiones as $exp)
                                <span class="badge bg-secondary">{{ $exp->titulo }}</span>
                            @empty
                                <span class="text-muted">Ninguna</span>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted text-center">No se encontraron juegos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- RESULTADOS EN EXPANSIONES --}}
    <div class="mb-4">
        <h4>🧩 Expansiones Coincidentes ({{ $resultadosExpansiones->count() }})</h4>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Expansión</th>
                    <th>Juego Base</th>
                    <th>Idioma</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultadosExpansiones as $expansion)
                    <tr>
                        <td><strong>{{ $expansion->titulo }}</strong></td>
                        <td>{{ $expansion->juego->titulo ?? 'N/A' }}</td>
                        <td>{{ $expansion->idioma->nombre ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-muted text-center">No se encontraron expansiones.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- RESULTADOS EN IDIOMAS --}}
    <div class="mb-4">
        <h4>🌐 Idiomas Coincidentes ({{ $resultadosIdiomas->count() }})</h4>
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Código</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultadosIdiomas as $idioma)
                    <tr>
                        <td><strong>{{ $idioma->nombre }}</strong></td>
                        <td><code>{{ $idioma->codigo }}</code></td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-muted text-center">No se encontraron idiomas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endif

@endsection