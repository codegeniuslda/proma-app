<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Establishment;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function index(Request $request)
    {
        $query = Collaborator::with('establishmentRelation');

        if ($request->filled('establishment_id')) {
            $query->where('establishment_id', $request->input('establishment_id'));
        }

        $allowedPerPage = [25, 50, 100];
        $perPage = (int) $request->input('per_page', 25);
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 25;
        }

        $collaborators = $query->orderBy('name')->paginate($perPage)->withQueryString();
        $establishments = Establishment::orderBy('name')->get();

        return view('collaborators.index', compact('collaborators', 'establishments'));
    }

    public function create()
    {
        $establishments = Establishment::orderBy('name')->get();

        return view('collaborators.create', compact('establishments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'worker_code' => ['required', 'string', 'max:50', 'unique:collaborators,worker_code'],
            'establishment_id' => ['required', 'exists:establishments,id'],
        ]);

        $establishment = Establishment::findOrFail($validated['establishment_id']);
        $validated['establishment'] = $establishment->name;

        Collaborator::create($validated);

        return redirect()->route('collaborators.index')->with('success', 'Colaborador criado com sucesso.');
    }

    public function show(Collaborator $collaborator)
    {
        return redirect()->route('collaborators.edit', $collaborator);
    }

    public function edit(Collaborator $collaborator)
    {
        $establishments = Establishment::orderBy('name')->get();

        return view('collaborators.edit', compact('collaborator', 'establishments'));
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'worker_code' => ['required', 'string', 'max:50', 'unique:collaborators,worker_code,' . $collaborator->id],
            'establishment_id' => ['required', 'exists:establishments,id'],
        ]);

        $establishment = Establishment::findOrFail($validated['establishment_id']);
        $validated['establishment'] = $establishment->name;

        $collaborator->update($validated);

        return redirect()->route('collaborators.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Collaborator $collaborator)
    {
        $collaborator->delete();

        return redirect()->route('collaborators.index')->with('success', 'Colaborador removido com sucesso.!');
    }
}