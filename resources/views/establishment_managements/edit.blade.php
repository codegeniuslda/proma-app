@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Editar Gestão do Estabelecimento</h1>
    <form action="{{ route('establishment-managements.update', $establishmentManagement) }}" method="POST">
        @method('PUT')
        @include('establishment_managements._form')
    </form>
</div>
@endsection