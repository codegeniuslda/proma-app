@csrf
<div class="grid grid-2 mb-16">
    <div>
        <label for="date">Data</label>
        <input type="date" id="date" name="date"
            value="{{ old('date', isset($establishmentManagement) ? $establishmentManagement->date->format('Y-m-d') : '') }}"
            required>
    </div>

    <div>
        <label for="collaborator_id">Colaborador Inicial</label>
        <select id="collaborator_id" name="collaborator_id" required>
            <option value="">Selecione</option>
            @foreach($collaborators as $collaborator)
            <option value="{{ $collaborator->id }}" @selected(old('collaborator_id', $establishmentManagement->
                collaborator_id ?? '') == $collaborator->id)>
                {{ $collaborator->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="grid grid-2 mb-16">
    <div>
        <label for="opened_at">Hora de abertura</label>
        <input type="time" id="opened_at" name="opened_at"
            value="{{ old('opened_at', isset($establishmentManagement) && $establishmentManagement->opened_at ? \Illuminate\Support\Str::of($establishmentManagement->opened_at)->substr(0, 5) : '') }}">
    </div>

    <div>
        <label for="closed_at">Hora de fechamento</label>
        <input type="time" id="closed_at" name="closed_at"
            value="{{ old('closed_at', isset($establishmentManagement) && $establishmentManagement->closed_at ? \Illuminate\Support\Str::of($establishmentManagement->closed_at)->substr(0, 5) : '') }}">
    </div>
</div>

<div class="mb-16">
    <label for="closed_by_collaborator_id">Colaborador que fechou</label>
    <select id="closed_by_collaborator_id" name="closed_by_collaborator_id">
        <option value="">Selecione</option>
        @foreach($collaborators as $collaborator)
        <option value="{{ $collaborator->id }}" @selected(old('closed_by_collaborator_id', $establishmentManagement->
            closed_by_collaborator_id ?? '') == $collaborator->id)>
            {{ $collaborator->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-16">
    <label for="establishment_state">Estado do Estabelecimento</label>
    <select id="establishment_state" name="establishment_state">
        <option value="">Selecione</option>
        <option value="Aberto" @selected(old('establishment_state', $establishmentManagement->establishment_state ?? '')
            == 'Aberto')>Aberto</option>
        <option value="Fechado" @selected(old('establishment_state', $establishmentManagement->establishment_state ??
            '') == 'Fechado')>Fechado</option>
        <option value="Parcialmente" @selected(old('establishment_state', $establishmentManagement->establishment_state
            ?? '') == 'Parcialmente')>Parcialmente</option>
    </select>
</div>

<div class="mb-16">
    <label for="description">Descrição (estado do equipamento / eventos)</label>
    <textarea id="description"
        name="description">{{ old('description', $establishmentManagement->description ?? '') }}</textarea>
</div>

<div class="mb-16">
    <label for="description_status">Estado da Descrição</label>
    <select id="description_status" name="description_status">
        <option value="">Selecione o estado</option>
        <option value="critico" @selected(old('description_status', $establishmentManagement->description_status ?? '')
            == 'critico')>Crítico</option>
        <option value="razoavel" @selected(old('description_status', $establishmentManagement->description_status ?? '')
            == 'razoavel')>Razoável</option>
        <option value="bom" @selected(old('description_status', $establishmentManagement->description_status ?? '') ==
            'bom')>Bom</option>
    </select>
</div>

<div class="actions">
    <button class="btn btn-primary" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('establishment-managements.index') }}">Voltar</a>
</div>