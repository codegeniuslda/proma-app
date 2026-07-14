<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Establishment;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = Collaborator::with('establishmentRelation')->orderBy('name')->paginate(25);

        return view('collaborators.index', compact('collaborators'));
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