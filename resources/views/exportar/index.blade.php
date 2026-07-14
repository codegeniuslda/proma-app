@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Módulo Exportar</h1>
    <p>Use os botões abaixo para exportar os dados em PDF, completo ou por módulo.</p>

    <div class="actions" style="margin-top: 12px;">
        <a class="btn btn-primary" href="{{ route('sql-export.full', request()->query()) }}">Exportar PDF Completo</a>
    </div>

    <h2 style="margin-top: 20px;">Exportação por Módulo</h2>
    <div class="actions" style="margin-top: 10px;">
        @foreach ($modules as $moduleKey => $moduleLabel)
        <a class="btn btn-secondary"
            href="{{ route('sql-export.module', array_merge(['module' => $moduleKey], request()->query())) }}">
            Exportar PDF {{ $moduleLabel }}
        </a>
        @endforeach
    </div>
</div>
@endsection