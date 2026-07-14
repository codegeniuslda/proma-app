@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Novo Registro de Gestão do Estabelecimento</h1>
    <form action="{{ route('establishment-managements.store') }}" method="POST">
        @include('establishment_managements._form')
    </form>
</div>
@endsection