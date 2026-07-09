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

    <form method="GET" action="{{ route('time-entries.index') }}" class="card mb-16" style="padding:12px;">
        <div class="grid grid-4">
            <div>
                <label for="collaborator_id">Colaborador</label>
                <select id="collaborator_id" name="collaborator_id">
                    <option value="">Todos</option>
                    @foreach($collaborators as $collaborator)
                    <option value="{{ $collaborator->id }}" @selected(request('collaborator_id')==$collaborator->id)>
                        {{ $collaborator->name }}
                    </option>
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
            <a href="{{ route('time-entries.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    @if(request()->filled('collaborator_id') || request()->filled('date_from') || request()->filled('date_to'))
    <div class="mb-16" style="font-size:14px;color:#374151;">
        Filtros aplicados:
        @if(request()->filled('collaborator_id'))
        Colaborador:
        {{ optional($collaborators->firstWhere('id', (int) request('collaborator_id')))->name ?? 'N/A' }}
        @endif
        @if(request()->filled('date_from'))
        | De: {{ \Illuminate\Support\Carbon::parse(request('date_from'))->format('d/m/Y') }}
        @endif
        @if(request()->filled('date_to'))
        | Até: {{ \Illuminate\Support\Carbon::parse(request('date_to'))->format('d/m/Y') }}
        @endif
    </div>
    @endif

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
            @php
            $presenceStyle = $entry->presence === 'Presente'
            ? 'background-color:#d1fae5;color:#065f46;font-weight:600;'
            : 'background-color:#fee2e2;color:#991b1b;font-weight:600;';

            $descriptionStyle = 'max-width:260px;white-space:pre-wrap;';
            if ($entry->description_status === 'critico') {
            $descriptionStyle .= 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            } elseif ($entry->description_status === 'razoavel') {
            $descriptionStyle .= 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
            } elseif ($entry->description_status === 'bom') {
            $descriptionStyle .= 'background-color:#dcfce7;color:#166534;font-weight:600;';
            }
            @endphp
            <tr>
                <td>{{ $entry->date->format('d/m/Y') }}</td>
                <td>{{ $entry->collaborator->name ?? '-' }}</td>
                <td>{{ $entry->establishment }}</td>
                <td>{{ $entry->workload_hours }}</td>
                <td>{{ $entry->entry_time }}</td>
                <td>{{ $entry->exit_time }}</td>
                <td style="{{ $presenceStyle }}">{{ $entry->presence }}</td>
                <td style="{{ $descriptionStyle }}">
                    {{ $entry->description }}
                    @if($entry->description_status)
                    <div style="margin-top:6px;font-size:12px;">
                        Estado: {{ ucfirst($entry->description_status) }}
                    </div>
                    @endif
                </td>
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