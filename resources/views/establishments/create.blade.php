@extends('layouts.app')

@section('content')
<div class="card">
    <h1 class="mb-16">Novo Estabelecimento</h1>
    <form method="POST" action="{{ route('establishments.store') }}">
        @include('establishments._form')
    </form>
</div>
@endsection