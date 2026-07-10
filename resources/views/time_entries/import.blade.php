@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Importar Registros via Excel</h1>
    <p>Formato esperado das colunas: <strong>Data, Carga Horaria, Estabelecimento, Colaborador, Entrada, Saida,
            Presenca, Descricao</strong></p>

    <form action="{{ route('time-entries.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-16">
            <label for="excel_file">Arquivo Excel (.xlsx, .xls, .csv)</label>
            <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
        </div>

        <div class="actions">
            <button class="btn btn-primary" type="submit">Importar</button>
            <a class="btn btn-secondary" href="{{ route('time-entries.index') }}">Voltar</a>
        </div>
    </form>
</div>
@endsection