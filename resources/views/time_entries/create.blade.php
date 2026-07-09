@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Novo Registro de Ponto</h1>
    <form action="{{ route('time-entries.store') }}" method="POST">
        @include('time_entries._form')
    </form>
</div>
@endsection