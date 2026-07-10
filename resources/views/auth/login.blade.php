@extends('layouts.app')

@section('content')
<div class="card" style="max-width:420px;margin:40px auto;">
    <h1 class="mb-16">Login</h1>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="mb-16">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-16">
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-16">
            <label style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" value="1">
                Lembrar-me
            </label>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Entrar</button>
        </div>
    </form>
</div>
@endsection