@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Módulo Exportar</h1>
    <p>Use os botões abaixo para exportar o backup SQL completo ou por módulo.</p>

    <div class="actions" style="margin-top: 12px;">
        <a class="btn btn-primary" href="{{ route('sql-export.full') }}">Exportar SQL Completo</a>
    </div>

    <h2 style="margin-top: 20px;">Exportação por Módulo</h2>
    <div class="actions" style="margin-top: 10px;">
        @foreach ($modules as $moduleKey => $moduleLabel)
        <a class="btn btn-secondary" href="{{ route('sql-export.module', ['module' => $moduleKey]) }}">
            Exportar SQL {{ $moduleLabel }}
        </a>
        @endforeach
    </div>
</div>
@endsection