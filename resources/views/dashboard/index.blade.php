@extends('layouts.app')

@section('content')
<div class="card mb-16">
    <h1 class="mb-16">Dashboard</h1>

    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-2 mb-16">
        <div>
            <label for="period">Período</label>
            <select name="period" id="period">
                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Personalizado</option>
                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hoje</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Semana</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Mês</option>
            </select>
        </div>
        <div></div>
        <div>
            <label for="date_from">Data inicial</label>
            <input type="date" id="date_from" name="date_from" value="{{ $from }}">
        </div>
        <div>
            <label for="date_to">Data final</label>
            <input type="date" id="date_to" name="date_to" value="{{ $to }}">
        </div>
        <div>
            <label for="collaborator_id">Colaborador (opcional)</label>
            <select name="collaborator_id" id="collaborator_id">
                <option value="">Todos</option>
                @foreach($collaboratorOptions as $collaborator)
                <option value="{{ $collaborator->id }}" @selected((string) $collaboratorFilter===(string)
                    $collaborator->id)>
                    {{ $collaborator->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="presence">Presença (opcional)</label>
            <select name="presence" id="presence">
                <option value="">Todas</option>
                <option value="Presente" @selected($presenceFilter==='Presente' )>Presente</option>
                <option value="Nao Presente" @selected($presenceFilter==='Nao Presente' )>Nao Presente</option>
            </select>
        </div>
        <div>
            <label for="establishment_state">Estado Estabelecimento (opcional)</label>
            <select name="establishment_state" id="establishment_state">
                <option value="">Todos</option>
                <option value="Aberto" @selected($establishmentStateFilter==='Aberto' )>Aberto</option>
                <option value="Fechado" @selected($establishmentStateFilter==='Fechado' )>Fechado</option>
                <option value="Parcialmente" @selected($establishmentStateFilter==='Parcialmente' )>Parcialmente
                </option>
            </select>
        </div>
        <div class="actions" style="align-self:end;">
            <button type="submit" class="btn btn-primary">Aplicar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>
</div>

<div class="card mb-16">
    <h2 class="mb-16">Presenças e Ausências por Colaborador</h2>
    <table>
        <thead>
            <tr>
                <th>Colaborador</th>
                <th>Presenças</th>
                <th>Ausências</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($collaboratorStats as $stat)
            <tr>
                <td>{{ $stat['name'] }}</td>
                <td>{{ $stat['present'] }}</td>
                <td>{{ $stat['absent'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Sem dados no período selecionado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <h2 class="mb-16">Último Estado por Estabelecimento</h2>
    <table>
        <thead>
            <tr>
                <th>Estabelecimento</th>
                <th>Data</th>
                <th>Presença</th>
                <th>Status Descrição</th>
                <th>Estado Estabelecimento</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($establishmentStatuses as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                @if($item['last_entry'])
                <td>{{ \Illuminate\Support\Carbon::parse($item['last_entry']->date)->format('d/m/Y') }}</td>
                <td>{{ $item['last_entry']->presence }}</td>
                <td>{{ $item['last_entry']->description_status ?? '-' }}</td>
                <td>{{ $item['last_entry']->establishment_state ?? '-' }}</td>
                <td>{{ $item['last_entry']->description }}</td>
                @else
                <td colspan="5">Sem registros</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="6">Nenhum estabelecimento cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection