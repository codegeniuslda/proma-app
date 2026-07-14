<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProMa - Controle</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f4f6f8;
        color: #1f2937;
    }

    nav {
        background: #111827;
        padding: 12px 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 16px;
        align-items: center;
    }

    nav a {
        color: #fff;
        text-decoration: none;
        font-weight: 600;
    }

    .container {
        max-width: 1100px;
        margin: 24px auto;
        padding: 0 16px;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    h1 {
        margin-top: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    th,
    td {
        border-bottom: 1px solid #e5e7eb;
        padding: 10px;
        text-align: left;
        vertical-align: top;
    }

    th {
        background: #f9fafb;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .btn-danger {
        background: #dc2626;
        color: #fff;
    }

    .btn-secondary {
        background: #6b7280;
        color: #fff;
    }

    .mb-16 {
        margin-bottom: 16px;
    }

    .grid {
        display: grid;
        gap: 12px;
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    label {
        font-weight: 600;
        font-size: 14px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        box-sizing: border-box;
    }

    textarea {
        min-height: 110px;
        resize: vertical;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 12px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 12px;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .table-wrap table {
        min-width: 760px;
    }

    @media (max-width: 1024px) {
        .container {
            max-width: 100%;
            padding: 0 14px;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        nav {
            padding: 10px 12px;
            gap: 8px 12px;
        }

        .container {
            margin: 14px auto;
            padding: 0 10px;
        }

        .card {
            padding: 12px;
        }

        th,
        td {
            padding: 8px;
            font-size: 13px;
        }

        .btn {
            padding: 8px 10px;
            font-size: 13px;
        }

        .table-wrap table {
    </style>
</head>

<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        @if (auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('time-entries.index') }}">Registros de Ponto</a>
        <a href="{{ route('establishment-managements.index') }}">Gestão do Estabelecimento</a>
        <a href="{{ route('collaborators.index') }}">Colaboradores</a>
        <a href="{{ route('establishments.index') }}">Estabelecimentos</a>
        <a href="{{ route('sql-export.index') }}">Exportar</a>
        @endif
        <!-- <a href="{{ route('time-entries.import.form') }}">Importar Excel</a> -->
    </nav>

    <div class="container">
        @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </div>
</body>

</html>