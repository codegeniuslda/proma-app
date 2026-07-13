@extends('layouts.app')

@section('content')
<div class="card mb-16">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;" class="mb-16">
        <h1 style="margin:0;">Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>

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
            <label for="establishment">Estabelecimento (opcional)</label>
            <select name="establishment" id="establishment">
                <option value="">Todos</option>
                @foreach($establishmentOptions as $establishment)
                <option value="{{ $establishment }}" @selected((string) $establishmentFilter===(string) $establishment)>
                    {{ $establishment }}
                </option>
                @endforeach
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
    <div class="table-wrap">
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
</div>

<div class="card">
    <h2 class="mb-16">Último Estado por Estabelecimento</h2>
    <div class="table-wrap">
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
                @php
                $presenceStyle = '';
                if ($item['last_entry']) {
                $presenceStyle = $item['last_entry']->presence === 'Presente'
                ? 'background-color:#dcfce7;color:#166534;font-weight:600;'
                : 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }

                $descriptionStatusStyle = '';
                if ($item['last_entry']) {
                if ($item['last_entry']->description_status === 'critico') {
                $descriptionStatusStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                } elseif ($item['last_entry']->description_status === 'razoavel') {
                $descriptionStatusStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif ($item['last_entry']->description_status === 'bom') {
                $descriptionStatusStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                }
                }

                $establishmentStateStyle = '';
                if ($item['last_entry']) {
                if ($item['last_entry']->establishment_state === 'Aberto') {
                $establishmentStateStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif ($item['last_entry']->establishment_state === 'Parcialmente') {
                $establishmentStateStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif ($item['last_entry']->establishment_state === 'Fechado') {
                $establishmentStateStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }
                }
                @endphp
                <tr>
                    <td>{{ $item['name'] }}</td>
                    @if($item['last_entry'])
                    <td>{{ \Illuminate\Support\Carbon::parse($item['last_entry']->date)->format('d/m/Y') }}</td>
                    <td style="{{ $presenceStyle }}">{{ $item['last_entry']->presence }}</td>
                    <td style="{{ $descriptionStatusStyle }}">{{ $item['last_entry']->description_status ?? '-' }}</td>
                    <td style="{{ $establishmentStateStyle }}">{{ $item['last_entry']->establishment_state ?? '-' }}
                    </td>
                    <td style="white-space:pre-wrap;">{{ $item['last_entry']->description }}</td>
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