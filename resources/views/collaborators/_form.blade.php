@csrf
<div class="grid grid-2 mb-16">
    <div>
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" value="{{ old('name', $collaborator->name ?? '') }}" required>
    </div>
    <div>
        <label for="workload_hours">Carga Horária</label>
        <input type="number" step="0.01" id="workload_hours" name="workload_hours"
            value="{{ old('workload_hours', $collaborator->workload_hours ?? '') }}" required>
    </div>
</div>

<div class="mb-16">
    <label for="establishment_id">Estabelecimento</label>
    <select id="establishment_id" name="establishment_id" required>
        <option value="">Selecione...</option>
        @foreach($establishments as $establishment)
        <option value="{{ $establishment->id }}" @selected((string) old('establishment_id', $collaborator->
            establishment_id ?? '') === (string) $establishment->id)>
            {{ $establishment->name }}
        </option>
        @endforeach
    </select>
    @error('establishment_id')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="actions">
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('collaborators.index') }}">Voltar</a>
</div>