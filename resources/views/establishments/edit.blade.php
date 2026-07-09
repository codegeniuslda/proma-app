@extends('layouts.app')

@section('content')
<div class="card">
    <h1 class="mb-16">Editar Estabelecimento</h1>
    <form method="POST" action="{{ route('establishments.update', $establishment) }}">
        @method('PUT')
        @include('establishments._form')
    </form>
</div>
@endsection