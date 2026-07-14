@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Módulo Exportar</h1>
    <p>Antes de exportar, escolha o módulo e aplique os filtros desejados (data, colaborador, estabelecimento,
        ordenação).</p>

    <form method="GET" action="{{ route('sql-export.index') }}" class="card mb-16"
        style="padding:12px;margin-top:12px;">
        <div class="grid grid-4">
            <div>
                <label for="module">Módulo</label>
                <select id="module" name="module">
                    @foreach ($modules as $moduleKey => $moduleLabel)
                    <option value="{{ $moduleKey }}" @selected(request('module', 'time-entries' )===$moduleKey)>
                        {{ $moduleLabel }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_from">Data Inicial</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div>
                <label for="date_to">Data Final</label>
                <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div>
                <label for="collaborator_id">ID Colaborador</label>
                <input type="number" id="collaborator_id" name="collaborator_id"
                    value="{{ request('collaborator_id') }}" placeholder="Ex: 10">
            </div>

            <div>
                <label for="establishment_id">ID Estabelecimento</label>
                <input type="number" id="establishment_id" name="establishment_id"
                    value="{{ request('establishment_id') }}" placeholder="Ex: 3">
            </div>

            <div>
                <label for="sort_by">Ordenar por</label>
                <input type="text" id="sort_by" name="sort_by" value="{{ request('sort_by') }}"
                    placeholder="Ex: date, name, collaborator_name">
            </div>

            <div>
                <label for="sort_dir">Direção</label>
                <select id="sort_dir" name="sort_dir">
                    <option value="" @selected(request('sort_dir')===null || request('sort_dir')==='' )>Padrão</option>
                    <option value="asc" @selected(request('sort_dir')==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir')==='desc' )>Decrescente</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
            <a href="{{ route('sql-export.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <div class="actions" style="margin-top: 12px;">
        <a class="btn btn-primary" href="{{ route('sql-export.full', request()->query()) }}">Exportar PDF Completo</a>
    </div>

    <h2 style="margin-top: 20px;">Exportação por Módulo</h2>
    <div class="actions" style="margin-top: 10px;">
        <a class="btn btn-secondary"
            href="{{ route('sql-export.module', array_merge(['module' => request('module', 'time-entries')], request()->query())) }}">
            Exportar PDF do Módulo Selecionado
        </a>

        @foreach ($modules as $moduleKey => $moduleLabel)
        <a class="btn btn-secondary"
            href="{{ route('sql-export.module', array_merge(['module' => $moduleKey], request()->query())) }}">
            Exportar PDF {{ $moduleLabel }}
        </a>
        @endforeach
    </div>
</div>
@endsection