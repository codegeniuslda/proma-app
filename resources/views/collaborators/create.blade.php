@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Novo Colaborador</h1>
    <form action="{{ route('collaborators.store') }}" method="POST">
        @include('collaborators._form')
    </form>
</div>
@endsection