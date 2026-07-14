@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Módulo Exportar</h1>
    <p>Use os mesmos filtros e ordenações dos módulos para exportar o PDF.</p>

    <div class="actions" style="margin:12px 0 20px 0;">
        <a class="btn btn-primary" href="{{ route('sql-export.full') }}">Exportar PDF Completo</a>
    </div>

    <h2>Registros de Ponto</h2>
    <form method="GET" action="{{ route('sql-export.module', ['module' => 'time-entries']) }}" class="card mb-16"
        style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="te_establishment_id">Estabelecimento</label>
                <select id="te_establishment_id" name="establishment_id">
                    <option value="">Todos</option>
                    @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" @selected((string) request('establishment_id')===(string)
                        $establishment->id)>
                        {{ $establishment->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="te_collaborator_id">Colaborador</label>
                <select id="te_collaborator_id" name="collaborator_id">
                    <option value="">Todos</option>
                    @foreach($collaborators as $collaborator)
                    <option value="{{ $collaborator->id }}" @selected((string) request('collaborator_id')===(string)
                        $collaborator->id)>
                        {{ $collaborator->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="te_date_from">Data Inicial</label>
                <input id="te_date_from" type="date" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div>
                <label for="te_date_to">Data Final</label>
                <input id="te_date_to" type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div>
                <label for="te_sort_by">Ordenar por</label>
                <select id="te_sort_by" name="sort_by">
                    <option value="date" @selected(request('sort_by', 'date' )==='date' )>Data</option>
                    <option value="entry_time" @selected(request('sort_by')==='entry_time' )>Hora de Entrada</option>
                    <option value="exit_time" @selected(request('sort_by')==='exit_time' )>Hora de Saída</option>
                    <option value="presence" @selected(request('sort_by')==='presence' )>Presença</option>
                    <option value="collaborator_name" @selected(request('sort_by')==='collaborator_name' )>Nome do
                        Colaborador</option>
                </select>
            </div>

            <div>
                <label for="te_sort_dir">Direção</label>
                <select id="te_sort_dir" name="sort_dir">
                    <option value="asc" @selected(request('sort_dir')==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir', 'desc' )==='desc' )>Decrescente</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-secondary">Exportar PDF (Filtrado)</button>
        </div>
    </form>

    <h2>Gestão do Estabelecimento</h2>
    <form method="GET" action="{{ route('sql-export.module', ['module' => 'establishment-managements']) }}"
        class="card mb-16" style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="em_establishment_id">Estabelecimento</label>
                <select id="em_establishment_id" name="establishment_id">
                    <option value="">Todos</option>
                    @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" @selected((string) request('establishment_id')===(string)
                        $establishment->id)>
                        {{ $establishment->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="em_collaborator_id">Colaborador</label>
                <select id="em_collaborator_id" name="collaborator_id">
                    <option value="">Todos</option>
                    @foreach($collaborators as $collaborator)
                    <option value="{{ $collaborator->id }}" @selected((string) request('collaborator_id')===(string)
                        $collaborator->id)>
                        {{ $collaborator->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="em_date_from">Data Inicial</label>
                <input id="em_date_from" type="date" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div>
                <label for="em_date_to">Data Final</label>
                <input id="em_date_to" type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div>
                <label for="em_sort_by">Ordenar por</label>
                <select id="em_sort_by" name="sort_by">
                    <option value="date" @selected(request('sort_by', 'date' )==='date' )>Data</option>
                    <option value="opened_at" @selected(request('sort_by')==='opened_at' )>Hora de Entrada</option>
                    <option value="closed_at" @selected(request('sort_by')==='closed_at' )>Hora de Saída</option>
                    <option value="collaborator_name" @selected(request('sort_by')==='collaborator_name' )>Nome do
                        Colaborador</option>
                    <option value="description_status" @selected(request('sort_by')==='description_status' )>Estado da
                        Descrição</option>
                    <option value="establishment_state" @selected(request('sort_by')==='establishment_state' )>Estado do
                        Estabelecimento</option>
                </select>
            </div>

            <div>
                <label for="em_sort_dir">Direção</label>
                <select id="em_sort_dir" name="sort_dir">
                    <option value="asc" @selected(request('sort_dir')==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir', 'desc' )==='desc' )>Decrescente</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-secondary">Exportar PDF (Filtrado)</button>
        </div>
    </form>

    <h2>Colaboradores</h2>
    <form method="GET" action="{{ route('sql-export.module', ['module' => 'collaborators']) }}" class="card mb-16"
        style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="co_establishment_id">Estabelecimento</label>
                <select id="co_establishment_id" name="establishment_id">
                    <option value="">Todos</option>
                    @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" @selected((string) request('establishment_id')===(string)
                        $establishment->id)>
                        {{ $establishment->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="co_sort_by">Ordenar por</label>
                <select id="co_sort_by" name="sort_by">
                    <option value="name" @selected(request('sort_by', 'name' )==='name' )>Nome</option>
                    <option value="worker_code" @selected(request('sort_by')==='worker_code' )>Código do Trabalhador
                    </option>
                </select>
            </div>

            <div>
                <label for="co_sort_dir">Direção</label>
                <select id="co_sort_dir" name="sort_dir">
                    <option value="asc" @selected(request('sort_dir', 'asc' )==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir')==='desc' )>Decrescente</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-secondary">Exportar PDF (Filtrado)</button>
        </div>
    </form>

    <h2>Estabelecimentos</h2>
    <form method="GET" action="{{ route('sql-export.module', ['module' => 'establishments']) }}" class="card"
        style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="es_sort_dir">Direção</label>
                <select id="es_sort_dir" name="sort_dir">
                    <option value="asc" @selected(request('sort_dir', 'asc' )==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir')==='desc' )>Decrescente</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-secondary">Exportar PDF (Filtrado)</button>
        </div>
    </form>
</div>
@endsection