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
            <label for="collaborator_id">Colaborador </label>
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
            <label for="presence">Presença</label>
            <select name="presence" id="presence">
                <option value="">Todas</option>
                <option value="Presente" @selected($presenceFilter==='Presente' )>Presente</option>
                <option value="Ausente" @selected($presenceFilter==='Ausente' )>Ausente</option>
                <option value="Justificado" @selected($presenceFilter==='Justificado' )>Justificado</option>
            </select>
        </div>
        <div>
            <label for="establishment">Estabelecimento</label>
            <select name="establishment" id="establishment">
                <option value="">Todos</option>
                @foreach($establishmentOptions as $establishment)
                <option value="{{ $establishment }}" @selected((string) $establishmentFilter===(string) $establishment)>
                    {{ $establishment }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="actions" style="align-self:end;">
            <button type="submit" class="btn btn-primary">Aplicar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>
</div>

<div class="card mb-16">
    <h2 class="mb-16">Resumo Numérico (Estabelecimento Filtrado)</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Presenças</th>
                    <th>Ausentes</th>
                    <th>Justificado</th>
                    <th>Não Marcado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $presenceSummary['present'] }}</td>
                    <td>{{ $presenceSummary['absent'] }}</td>
                    <td>{{ $presenceSummary['justified'] }}</td>
                    <td>{{ $presenceSummary['not_marked'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-16">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;" class="mb-16">
        <h2 style="margin:0;">Resumo por Colaboradores</h2>
        <form method="GET" action="{{ route('dashboard') }}" style="display:flex;gap:8px;align-items:center;">
            <input type="hidden" name="period" value="{{ $period }}">
            <input type="hidden" name="date_from" value="{{ $from }}">
            <input type="hidden" name="date_to" value="{{ $to }}">
            <input type="hidden" name="collaborator_id" value="{{ $collaboratorFilter }}">
            <input type="hidden" name="presence" value="{{ $presenceFilter }}">
            <input type="hidden" name="establishment" value="{{ $establishmentFilter }}">

            <label for="per_page" style="margin:0;">Mostrar</label>
            <select id="per_page" name="per_page" onchange="this.form.submit()">
                <option value="25" @selected((int) $perPage===25)>25</option>
                <option value="50" @selected((int) $perPage===50)>50</option>
                <option value="100" @selected((int) $perPage===100)>100</option>
            </select>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Colaborador</th>
                    <th>Estabelecimento</th>
                    <th>Última Data</th>
                    <th>Presença</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collaboratorsSummary as $item)
                @php
                $presenceStyle = '';
                if (($item['presence'] ?? null) === 'Presente') {
                $presenceStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif (($item['presence'] ?? null) === 'Justificado') {
                $presenceStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif (($item['presence'] ?? null) === 'Ausente') {
                $presenceStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }
                @endphp
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['establishment'] ?? '-' }}</td>
                    <td>
                        {{ $item['last_date'] ? \Illuminate\Support\Carbon::parse($item['last_date'])->format('d/m/Y') : '-' }}
                    </td>
                    <td style="{{ $presenceStyle }}">{{ $item['presence'] ?? '-' }}</td>
                    <td style="white-space:pre-wrap;">{{ $item['description'] ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Nenhum colaborador encontrado para os filtros informados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">
        {{ $collaboratorsSummary->links() }}
    </div>
</div>

<div class="card mb-16">
    <h2 class="mb-16">Último Estado por Estabelecimento</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Estabelecimento</th>
                    <th>Data</th>
                    <th>Estado do Estabelecimento</th>
                    <th>Estado da Descrição</th>
                    <th>Descrição</th>
                    <th>Aberto por / Abertura</th>
                    <th>Fechado por / Fechamento</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($establishmentStatuses as $item)
                @php
                $establishmentStateStyle = '';
                $descriptionStatusStyle = '';

                if ($item['last_entry']) {
                if ($item['last_entry']->establishment_state === 'Aberto') {
                $establishmentStateStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif ($item['last_entry']->establishment_state === 'Parcialmente') {
                $establishmentStateStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif ($item['last_entry']->establishment_state === 'Fechado') {
                $establishmentStateStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }

                if ($item['last_entry']->description_status === 'bom') {
                $descriptionStatusStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif ($item['last_entry']->description_status === 'razoavel') {
                $descriptionStatusStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif ($item['last_entry']->description_status === 'critico') {
                $descriptionStatusStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }
                }
                @endphp
                <tr>
                    <td>{{ $item['name'] }}</td>
                    @if($item['last_entry'])
                    <td>{{ \Illuminate\Support\Carbon::parse($item['last_entry']->date)->format('d/m/Y') }}</td>
                    <td style="{{ $establishmentStateStyle }}">{{ $item['last_entry']->establishment_state ?? '-' }}
                    </td>
                    <td style="{{ $descriptionStatusStyle }}">
                        {{ ucfirst($item['last_entry']->description_status ?? '-') }}</td>
                    <td style="white-space:pre-wrap;">{{ $item['last_entry']->description ?? '-' }}</td>
                    <td>
                        {{ $item['last_entry']->collaborator->name ?? '-' }}
                        <div style="font-size:12px;color:#6b7280;">
                            {{ $item['last_entry']->opened_at ?? '-' }}
                        </div>
                    </td>
                    <td>
                        {{ $item['last_entry']->closedByCollaborator->name ?? '-' }}
                        <div style="font-size:12px;color:#6b7280;">
                            {{ $item['last_entry']->closed_at ?? '-' }}
                        </div>
                    </td>
                    @else
                    <td colspan="6">Sem registros</td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7">Nenhum estabelecimento cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <h2 class="mb-16">Histórico de Estados do Estabelecimento</h2>

    <form method="GET" action="{{ route('dashboard') }}" class="card mb-16" style="padding:12px;">
        <input type="hidden" name="period" value="{{ $period }}">
        <input type="hidden" name="date_from" value="{{ $from }}">
        <input type="hidden" name="date_to" value="{{ $to }}">
        <input type="hidden" name="collaborator_id" value="{{ $collaboratorFilter }}">
        <input type="hidden" name="presence" value="{{ $presenceFilter }}">
        <input type="hidden" name="establishment" value="{{ $establishmentFilter }}">
        <input type="hidden" name="per_page" value="{{ $perPage }}">

        <div class="grid grid-4">
            <div>
                <label for="history_establishment_id">Estabelecimento</label>
                <select id="history_establishment_id" name="history_establishment_id">
                    <option value="">Todos</option>
                    @foreach($historyEstablishments as $establishmentItem)
                    <option value="{{ $establishmentItem->id }}" @selected((string)
                        $historyEstablishmentFilter===(string) $establishmentItem->id)>
                        {{ $establishmentItem->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="history_collaborator_id">Colaborador</label>
                <select id="history_collaborator_id" name="history_collaborator_id">
                    <option value="">Todos</option>
                    @foreach($historyCollaboratorOptions as $collaboratorItem)
                    <option value="{{ $collaboratorItem->id }}" @selected((string) $historyCollaboratorFilter===(string)
                        $collaboratorItem->id)>
                        {{ $collaboratorItem->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="history_date_from">Data Inicial</label>
                <input type="date" id="history_date_from" name="history_date_from" value="{{ $historyDateFrom }}">
            </div>

            <div>
                <label for="history_date_to">Data Final</label>
                <input type="date" id="history_date_to" name="history_date_to" value="{{ $historyDateTo }}">
            </div>
        </div>

        <div class="grid grid-4" style="margin-top:12px;">
            <div>
                <label for="history_sort_by">Ordenar por</label>
                <select id="history_sort_by" name="history_sort_by">
                    <option value="date" @selected($historySortBy==='date' )>Data</option>
                    <option value="opened_at" @selected($historySortBy==='opened_at' )>Hora de Entrada</option>
                    <option value="closed_at" @selected($historySortBy==='closed_at' )>Hora de Saída</option>
                    <option value="collaborator_name" @selected($historySortBy==='collaborator_name' )>Nome do
                        Colaborador</option>
                    <option value="description_status" @selected($historySortBy==='description_status' )>Estado da
                        Descrição</option>
                    <option value="establishment_state" @selected($historySortBy==='establishment_state' )>Estado do
                        Estabelecimento</option>
                </select>
            </div>

            <div>
                <label for="history_sort_dir">Direção</label>
                <select id="history_sort_dir" name="history_sort_dir">
                    <option value="asc" @selected($historySortDir==='asc' )>Crescente</option>
                    <option value="desc" @selected($historySortDir==='desc' )>Decrescente</option>
                </select>
            </div>

            <div>
                <label for="history_per_page">Mostrar</label>
                <select id="history_per_page" name="history_per_page">
                    <option value="25" @selected((int) $historyPerPage===25)>25</option>
                    <option value="50" @selected((int) $historyPerPage===50)>50</option>
                    <option value="100" @selected((int) $historyPerPage===100)>100</option>
                </select>
            </div>
        </div>

        <div class="actions" style="margin-top:12px;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Estabelecimento</th>
                    <th>Data</th>
                    <th>Estado do Estabelecimento</th>
                    <th>Estado da Descrição</th>
                    <th>Descrição</th>
                    <th>Aberto por / Abertura</th>
                    <th>Fechado por / Fechamento</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($establishmentHistory as $history)
                @php
                $historyStateStyle = '';
                $historyDescriptionStyle = '';

                if (($history->establishment_state ?? null) === 'Aberto') {
                $historyStateStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif (($history->establishment_state ?? null) === 'Parcialmente') {
                $historyStateStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif (($history->establishment_state ?? null) === 'Fechado') {
                $historyStateStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }

                if (($history->description_status ?? null) === 'bom') {
                $historyDescriptionStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
                } elseif (($history->description_status ?? null) === 'razoavel') {
                $historyDescriptionStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
                } elseif (($history->description_status ?? null) === 'critico') {
                $historyDescriptionStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
                }
                @endphp
                <tr>
                    <td>{{ optional(optional($history->collaborator)->establishmentRelation)->name ?? 'Sem estabelecimento' }}
                    </td>
                    <td>{{ $history->date ? \Illuminate\Support\Carbon::parse($history->date)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="{{ $historyStateStyle }}">{{ $history->establishment_state ?? '-' }}</td>
                    <td style="{{ $historyDescriptionStyle }}">{{ ucfirst($history->description_status ?? '-') }}</td>
                    <td style="white-space:pre-wrap;">{{ $history->description ?? '-' }}</td>
                    <td>
                        {{ optional($history->collaborator)->name ?? '-' }}
                        <div style="font-size:12px;color:#6b7280;">
                            {{ $history->opened_at ?? '-' }}
                        </div>
                    </td>
                    <td>
                        {{ optional($history->closedByCollaborator)->name ?? '-' }}
                        <div style="font-size:12px;color:#6b7280;">
                            {{ $history->closed_at ?? '-' }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Nenhum histórico de gestão encontrado para os filtros informados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 12px;">
        {{ $establishmentHistory->links() }}
    </div>
</div>
@endsection