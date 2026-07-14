<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Exportação por Módulo</title>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #111;
    }

    h1,
    h2 {
        margin: 0 0 8px 0;
    }

    .meta {
        margin-bottom: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 4px 6px;
        text-align: left;
        vertical-align: top;
    }

    th {
        background: #f1f1f1;
    }
    </style>
</head>

<body>
    <h1>Exportação por Módulo (PDF)</h1>
    <div class="meta">Módulo: {{ $moduleLabel }} | Gerado em: {{ $generatedAt }}</div>

    @if($moduleKey === 'collaborators')
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código</th>
                <th>Estabelecimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->name }}</td>
                <td>{{ $row->worker_code }}</td>
                <td>{{ optional($row->establishmentRelation)->name ?? $row->establishment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif($moduleKey === 'time-entries')
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Colaborador</th>
                <th>Entrada</th>
                <th>Saída</th>
                <th>Presença</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            @php
            $presenceStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            if ($row->entry_time) {
            $entryTime = \Carbon\Carbon::createFromFormat('H:i:s', $row->entry_time)->format('H:i');
            if ($entryTime <= '07:30' ) { $presenceStyle='background-color:#d1fae5;color:#065f46;font-weight:600;' ; }
                elseif ($entryTime>= '07:31' && $entryTime <= '08:00' ) {
                    $presenceStyle='background-color:#ffedd5;color:#9a3412;font-weight:600;' ; } else {
                    $presenceStyle='background-color:#fee2e2;color:#991b1b;font-weight:600;' ; } } @endphp <tr>
                    <td>{{ optional($row->date)->format('d/m/Y') }}</td>
                    <td>{{ optional($row->collaborator)->name }}</td>
                    <td>{{ $row->entry_time }}</td>
                    <td>{{ $row->exit_time }}</td>
                    <td style="{{ $presenceStyle }}">{{ $row->presence }}</td>
                    <td>{{ $row->description }}</td>
                    </tr>
                    @endforeach
        </tbody>
    </table>
    @elseif($moduleKey === 'establishments')
    <table>
        <thead>
            <tr>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif($moduleKey === 'establishment-managements')
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Colaborador</th>
                <th>Fechado por</th>
                <th>Abertura</th>
                <th>Fechamento</th>
                <th>Estado</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            @php
            $descriptionStyle = 'max-width:260px;white-space:pre-wrap;';
            if ($row->description_status === 'critico') {
            $descriptionStyle .= 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            } elseif ($row->description_status === 'razoavel') {
            $descriptionStyle .= 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
            } elseif ($row->description_status === 'bom') {
            $descriptionStyle .= 'background-color:#dcfce7;color:#166534;font-weight:600;';
            }

            $establishmentStateStyle = '';
            if ($row->establishment_state === 'Aberto') {
            $establishmentStateStyle = 'background-color:#dcfce7;color:#166534;font-weight:600;';
            } elseif ($row->establishment_state === 'Parcialmente') {
            $establishmentStateStyle = 'background-color:#ffedd5;color:#9a3412;font-weight:600;';
            } elseif ($row->establishment_state === 'Fechado') {
            $establishmentStateStyle = 'background-color:#fee2e2;color:#991b1b;font-weight:600;';
            }
            @endphp
            <tr>
                <td>{{ optional($row->date)->format('d/m/Y') }}</td>
                <td>{{ optional($row->collaborator)->name }}</td>
                <td>{{ optional($row->closedByCollaborator)->name }}</td>
                <td>{{ $row->opened_at }}</td>
                <td>{{ $row->closed_at }}</td>
                <td style="{{ $establishmentStateStyle }}">{{ $row->establishment_state }}</td>
                <td style="{{ $descriptionStyle }}">
                    {{ $row->description }}
                    @if($row->description_status)
                    <div style="margin-top:6px;font-size:12px;">Estado: {{ ucfirst($row->description_status) }}</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>