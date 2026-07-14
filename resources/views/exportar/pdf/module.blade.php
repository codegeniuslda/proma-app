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
                <th>ID</th>
                <th>Nome</th>
                <th>Código</th>
                <th>Estabelecimento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->id }}</td>
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
                <th>ID</th>
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
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ optional($row->date)->format('Y-m-d') }}</td>
                <td>{{ optional($row->collaborator)->name }}</td>
                <td>{{ $row->entry_time }}</td>
                <td>{{ $row->exit_time }}</td>
                <td>{{ $row->presence }}</td>
                <td>{{ $row->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif($moduleKey === 'establishments')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif($moduleKey === 'establishment-managements')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Colaborador</th>
                <th>Fechado por</th>
                <th>Abertura</th>
                <th>Fechamento</th>
                <th>Estado</th>
                <th>Status</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ optional($row->date)->format('Y-m-d') }}</td>
                <td>{{ optional($row->collaborator)->name }}</td>
                <td>{{ optional($row->closedByCollaborator)->name }}</td>
                <td>{{ $row->opened_at }}</td>
                <td>{{ $row->closed_at }}</td>
                <td>{{ $row->establishment_state }}</td>
                <td>{{ $row->description_status }}</td>
                <td>{{ $row->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>

</html>