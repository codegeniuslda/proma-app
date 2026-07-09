@csrf
<div class="grid grid-2 mb-16">
    <div>
        <label for="date">Data</label>
        <input type="date" id="date" name="date"
            value="{{ old('date', isset($timeEntry) ? $timeEntry->date->format('Y-m-d') : '') }}" required>
    </div>

    <div>
        <label for="collaborator_id">Colaborador</label>
        <select id="collaborator_id" name="collaborator_id" required>
            <option value="">Selecione</option>
            @foreach($collaborators as $collaborator)
            <option value="{{ $collaborator->id }}" data-establishment="{{ $collaborator->establishment }}"
                data-workload-hours="{{ $collaborator->workload_hours }}" @selected(old('collaborator_id', $timeEntry->
                collaborator_id ?? '') == $collaborator->id)
                >
                {{ $collaborator->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-2 mb-16">
    <div>
        <label for="establishment">Estabelecimento</label>
        <input type="text" id="establishment" name="establishment"
            value="{{ old('establishment', $timeEntry->establishment ?? '') }}" required>
    </div>

    <div>
        <label for="workload_hours">Carga Horária</label>
        <input type="number" step="0.01" id="workload_hours" name="workload_hours"
            value="{{ old('workload_hours', $timeEntry->workload_hours ?? '') }}" required>
    </div>
</div>

<div class="grid grid-2 mb-16">
    <div>
        <label for="entry_time">Entrada</label>
        <input type="time" id="entry_time" name="entry_time"
            value="{{ old('entry_time', $timeEntry->entry_time ?? '') }}">
    </div>

    <div>
        <label for="exit_time">Saída</label>
        <input type="time" id="exit_time" name="exit_time" value="{{ old('exit_time', $timeEntry->exit_time ?? '') }}">
    </div>
</div>

<div class="mb-16">
    <label for="presence">Presença</label>
    <select id="presence" name="presence" required>
        <option value="Presente" @selected(old('presence', $timeEntry->presence ?? '') == 'Presente')>Presente</option>
        <option value="Nao Presente" @selected(old('presence', $timeEntry->presence ?? '') == 'Nao Presente')>Nao
            Presente</option>
    </select>
</div>

<div class="mb-16">
    <label for="establishment_state">Estado do Estabelecimento</label>
    <select id="establishment_state" name="establishment_state">
        <option value="">Selecione</option>
        <option value="Aberto" @selected(old('establishment_state', $timeEntry->establishment_state ?? '') ==
            'Aberto')>Aberto</option>
        <option value="Fechado" @selected(old('establishment_state', $timeEntry->establishment_state ?? '') ==
            'Fechado')>Fechado</option>
        <option value="Parcialmente" @selected(old('establishment_state', $timeEntry->establishment_state ?? '') ==
            'Parcialmente')>Parcialmente</option>
    </select>
</div>

<div class="mb-16">
    <label for="description">Descrição (estado do equipamento / eventos)</label>
    <textarea id="description" name="description">{{ old('description', $timeEntry->description ?? '') }}</textarea>
</div>

<div class="mb-16">
    <label for="description_status">Estado da Descrição</label>
    <select id="description_status" name="description_status">
        <option value="">Selecione o estado</option>
        <option value="critico" @selected(old('description_status', $timeEntry->description_status ?? '') ==
            'critico')>Crítico</option>
        <option value="razoavel" @selected(old('description_status', $timeEntry->description_status ?? '') ==
            'razoavel')>Razoável</option>
        <option value="bom" @selected(old('description_status', $timeEntry->description_status ?? '') == 'bom')>Bom
        </option>
    </select>
</div>

<div class="actions">
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('time-entries.index') }}">Voltar</a>
</div>

<script>
(function() {
    const collaboratorSelect = document.getElementById('collaborator_id');
    const establishmentInput = document.getElementById('establishment');
    const workloadInput = document.getElementById('workload_hours');

    function fillFromCollaborator() {
        const selected = collaboratorSelect.options[collaboratorSelect.selectedIndex];
        if (!selected || !selected.value) return;
        establishmentInput.value = selected.dataset.establishment || '';
        workloadInput.value = selected.dataset.workloadHours || '';
    }

    collaboratorSelect.addEventListener('change', fillFromCollaborator);

    if (!establishmentInput.value || !workloadInput.value) {
        fillFromCollaborator();
    }
})();
</script>