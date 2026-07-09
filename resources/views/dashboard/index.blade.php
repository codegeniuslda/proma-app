@extends('layouts.app')

@section('content')
<div class="card mb-16">
    <h1 class="mb-16">Dashboard</h1>

    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-2 mb-16">
        <div>
            <label for="period">Período</label>
            <select name="period" id="period">
                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hoje</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>Semana</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Mês</option>
                <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Personalizado</option>
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
            <button type="submit" class="btn btn-primary">Aplicar</button>
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
                <td>{{ $item['last_entry']->description }}</td>
                @else
                <td colspan="4">Sem registros</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="5">Nenhum estabelecimento cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection