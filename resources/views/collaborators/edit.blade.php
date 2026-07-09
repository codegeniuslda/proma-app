@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Editar Colaborador</h1>
    <form action="{{ route('collaborators.update', $collaborator) }}" method="POST">
        @method('PUT')
        @include('collaborators._form')
    </form>
</div>
@endsection