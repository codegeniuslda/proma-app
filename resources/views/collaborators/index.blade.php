@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;" class="mb-16">
        <h1>Colaboradores</h1>
        <a class="btn btn-primary" href="{{ route('collaborators.create') }}">Novo Colaborador</a>
    </div>

    <form method="GET" action="{{ route('collaborators.index') }}" class="card mb-16" style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="establishment_id">Estabelecimento</label>
                <select id="establishment_id" name="establishment_id">
                    <option value="">Todos</option>
                    @foreach($establishments as $establishment)
                    <option value="{{ $establishment->id }}" @selected(request('establishment_id')==$establishment->id)>
                        {{ $establishment->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sort_by">Ordenar por</label>
                <select id="sort_by" name="sort_by">
                    <option value="name" @selected(request('sort_by', 'name' )==='name' )>Nome</option>
                    <option value="worker_code" @selected(request('sort_by')==='worker_code' )>Código do Trabalhador
                    </option>
                </select>
            </div>

            <div>
                <label for="sort_dir">Direção</label>
                <select id="sort_dir" name="sort_dir">
                    <option value="asc" @selected(request('sort_dir', 'asc' )==='asc' )>Crescente</option>
                    <option value="desc" @selected(request('sort_dir')==='desc' )>Decrescente</option>
                </select>
            </div>

            <div>
                <label for="per_page">Mostrar</label>
                <select id="per_page" name="per_page">
                    <option value="25" @selected((int) request('per_page', 25)===25)>25</option>
                    <option value="50" @selected((int) request('per_page')===50)>50</option>
                    <option value="100" @selected((int) request('per_page')===100)>100</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('collaborators.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    @if(request()->filled('establishment_id'))
    <div class="mb-16" style="font-size:14px;color:#374151;">
        Filtros aplicados:
        Estabelecimento:
        {{ optional($establishments->firstWhere('id', (int) request('establishment_id')))->name ?? 'N/A' }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código do Trabalhador</th>
                <th>Estabelecimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($collaborators as $collaborator)
            <tr>
                <td>{{ $collaborator->name }}</td>
                <td>{{ $collaborator->worker_code }}</td>
                <td>{{ $collaborator->establishment }}</td>
                <td>
                    <div class="actions">
                        <a class="btn btn-secondary" href="{{ route('collaborators.edit', $collaborator) }}">Editar</a>
                        <form action="{{ route('collaborators.destroy', $collaborator) }}" method="POST"
                            onsubmit="return confirm('Remover colaborador?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Nenhum colaborador cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 12px;">
        {{ $collaborators->links() }}
    </div>
</div>
@endsection