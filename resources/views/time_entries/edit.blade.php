@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Editar Registro de Ponto</h1>
    <form action="{{ route('time-entries.update', $timeEntry) }}" method="POST">
        @method('PUT')
        @include('time_entries._form')
    </form>
</div>
@endsection