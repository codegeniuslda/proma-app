@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;" class="mb-16">
        <h1>Colaboradores</h1>
        <a class="btn btn-primary" href="{{ route('collaborators.create') }}">Novo Colaborador</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Carga Horária</th>
                <th>Estabelecimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($collaborators as $collaborator)
            <tr>
                <td>{{ $collaborator->name }}</td>
                <td>{{ $collaborator->workload_hours }}</td>
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