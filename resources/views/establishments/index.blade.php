@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;" class="mb-16">
        <h1>Estabelecimentos</h1>
        <a class="btn btn-primary" href="{{ route('establishments.create') }}">Novo Estabelecimento</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($establishments as $establishment)
            <tr>
                <td>{{ $establishment->name }}</td>
                <td>
                    <div class="actions">
                        <a class="btn btn-secondary"
                            href="{{ route('establishments.edit', $establishment) }}">Editar</a>
                        <form action="{{ route('establishments.destroy', $establishment) }}" method="POST"
                            onsubmit="return confirm('Remover estabelecimento?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2">Nenhum estabelecimento cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 12px;">
        {{ $establishments->links() }}
    </div>
</div>
@endsection