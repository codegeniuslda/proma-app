@csrf
<div class="mb-16">
    <label for="name">Nome do Estabelecimento</label>
    <input type="text" id="name" name="name" value="{{ old('name', $establishment->name ?? '') }}" required>
</div>

<div class="actions">
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('establishments.index') }}">Voltar</a>
</div>