<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Exportação Completa</title>
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
        margin-bottom: 16px;
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

    .section {
        margin-bottom: 20px;
        page-break-inside: avoid;
    }
    </style>
</head>

<body>
    <h1>Exportação Completa (PDF)</h1>
    <div class="meta">Gerado em: {{ $generatedAt }}</div>

    <div class="section">
        <h2>Colaboradores</h2>
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
                @foreach($collaborators as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->worker_code }}</td>
                    <td>{{ optional($row->establishmentRelation)->name ?? $row->establishment }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Registros de Ponto</h2>
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
                @foreach($timeEntries as $row)
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
    </div>

    <div class="section">
        <h2>Estabelecimentos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                @foreach($establishments as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Gestão do Estabelecimento</h2>
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
                @foreach($managements as $row)
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
    </div>
</body>

</html>