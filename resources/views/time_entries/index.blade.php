@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;" class="mb-16">
        <h1>Registros de Ponto</h1>
        <div class="actions">
            <a class="btn btn-secondary" href="{{ route('time-entries.import.form') }}">Importar Excel</a>
            <a class="btn btn-primary" href="{{ route('time-entries.create') }}">Novo Registro</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Colaborador</th>
                <th>Estabelecimento</th>
                <th>Carga Horária</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Presença</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($timeEntries as $entry)
            <tr>
                <td>{{ $entry->date->format('d/m/Y') }}</td>
                <td>{{ $entry->collaborator->name ?? '-' }}</td>
                <td>{{ $entry->establishment }}</td>
                <td>{{ $entry->workload_hours }}</td>
                <td>{{ $entry->entry_time }}</td>
                <td>{{ $entry->exit_time }}</td>
                <td>{{ $entry->presence }}</td>
                <td style="max-width:260px;white-space:pre-wrap;">{{ $entry->description }}</td>
                <td>
                    <div class="actions">
                        <a class="btn btn-secondary" href="{{ route('time-entries.edit', $entry) }}">Editar</a>
                        <form action="{{ route('time-entries.destroy', $entry) }}" method="POST"
                            onsubmit="return confirm('Excluir registro?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">Nenhum registro encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 12px;">
        {{ $timeEntries->links() }}
    </div>
</div>
@endsection