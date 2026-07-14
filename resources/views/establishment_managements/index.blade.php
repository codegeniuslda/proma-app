@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;" class="mb-16">
        <h1>Gestão do Estabelecimento</h1>
        <div class="actions">
            <a class="btn btn-primary" href="{{ route('establishment-managements.create') }}">Novo Registro</a>
        </div>
    </div>

    <form method="GET" action="{{ route('establishment-managements.index') }}" class="card mb-16" style="padding:12px;">
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
            <a href="{{ route('establishment-managements.index') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Estabelecimento</th>
                <th>Colaborador que abriu</th>
                <th>Colaborador que fechou</th>
                <th>Abertura</th>
                <th>Fechamento</th>
                <th>Estado Estabelecimento</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($managements as $item)
            @php
            $descriptionStyle = 'max-width:260px;white-space:pre-wrap;';
            if ($item->description_status === 'critico') {
            $descriptionStyle .= 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            } elseif ($item->description_status === 'razoavel') {
            $descriptionStyle .= 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
            } elseif ($item->description_status === 'bom') {
            $descriptionStyle .= 'background-color:#dcfce7;color:#166534;font-weight:600;';
            }

            $establishmentStateStyle = '';
            if ($item->establishment_state === 'Aberto') {
            $establishmentStateStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
            } elseif ($item->establishment_state === 'Parcialmente') {
            $establishmentStateStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
            } elseif ($item->establishment_state === 'Fechado') {
            $establishmentStateStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            }
            @endphp
            <tr>
                <td>{{ $item->date->format('d/m/Y') }}</td>
                <td>{{ optional(optional($item->collaborator)->establishmentRelation)->name ?? '-' }}</td>
                <td>{{ $item->collaborator->name ?? '-' }}</td>
                <td>{{ $item->closedByCollaborator->name ?? '-' }}</td>
                <td>{{ $item->opened_at ?? '-' }}</td>
                <td>{{ $item->closed_at ?? '-' }}</td>
                <td style="{{ $establishmentStateStyle }}">{{ $item->establishment_state ?? '-' }}</td>
                <td style="{{ $descriptionStyle }}">
                    {{ $item->description }}
                    @if($item->description_status)
                    <div style="margin-top:6px;font-size:12px;">
                        Estado: {{ ucfirst($item->description_status) }}
                    </div>
                    @endif
                </td>
                <td>
                    <div class="actions">
                        <a class="btn btn-secondary"
                            href="{{ route('establishment-managements.edit', $item) }}">Editar</a>
                        <form action="{{ route('establishment-managements.destroy', $item) }}" method="POST"
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
        {{ $managements->links() }}
    </div>
</div>
@endsection