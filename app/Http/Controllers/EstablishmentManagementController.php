<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\EstablishmentManagement;
use Illuminate\Http\Request;

class EstablishmentManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = EstablishmentManagement::with([
            'collaborator.establishmentRelation',
            'closedByCollaborator',
        ]);

        if ($request->filled('collaborator_id')) {
            $query->where('collaborator_id', $request->input('collaborator_id'));
        }

        if ($request->filled('establishment_id')) {
            $query->whereHas('collaborator', function ($q) use ($request) {
                $q->where('establishment_id', $request->input('establishment_id'));
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->input('date_to'));
        }

        $allowedPerPage = [25, 50, 100];
        $perPage = (int) $request->input('per_page', 25);
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 25;
        }

        $managements = $query->latest()->paginate($perPage)->withQueryString();
        $collaborators = Collaborator::orderBy('name')->get();
        $establishments = \App\Models\Establishment::orderBy('name')->get();

        return view('establishment_managements.index', compact('managements', 'collaborators', 'establishments'));
    }

    public function create()
    {
        $collaborators = Collaborator::orderBy('name')->get();

        return view('establishment_managements.create', compact('collaborators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'collaborator_id' => ['required', 'exists:collaborators,id'],
            'closed_by_collaborator_id' => ['nullable', 'exists:collaborators,id'],
            'opened_at' => ['nullable', 'date_format:H:i'],
            'closed_at' => ['nullable', 'date_format:H:i'],
            'establishment_state' => ['nullable', 'in:Aberto,Fechado,Parcialmente'],
            'description' => ['nullable', 'string'],
            'description_status' => ['nullable', 'in:critico,razoavel,bom'],
        ]);

        EstablishmentManagement::create($validated);

        return redirect()->route('establishment-managements.index')->with('success', 'Gestão do estabelecimento criada com sucesso.');
    }

    public function show(EstablishmentManagement $establishmentManagement)
    {
        return redirect()->route('establishment-managements.edit', $establishmentManagement);
    }

    public function edit(EstablishmentManagement $establishmentManagement)
    {
        $collaborators = Collaborator::orderBy('name')->get();

        return view('establishment_managements.edit', compact('establishmentManagement', 'collaborators'));
    }

    public function update(Request $request, EstablishmentManagement $establishmentManagement)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'collaborator_id' => ['required', 'exists:collaborators,id'],
            'closed_by_collaborator_id' => ['nullable', 'exists:collaborators,id'],
            'opened_at' => ['nullable', 'date_format:H:i'],
            'closed_at' => ['nullable', 'date_format:H:i'],
            'establishment_state' => ['nullable', 'in:Aberto,Fechado,Parcialmente'],
            'description' => ['nullable', 'string'],
            'description_status' => ['nullable', 'in:critico,razoavel,bom'],
        ]);

        $establishmentManagement->update($validated);

        return redirect()->route('establishment-managements.index')->with('success', 'Gestão do estabelecimento atualizada com sucesso.');
    }

    public function destroy(EstablishmentManagement $establishmentManagement)
    {
        $establishmentManagement->delete();

        return redirect()->route('establishment-managements.index')->with('success', 'Gestão do estabelecimento removida com sucesso.');
    }
}