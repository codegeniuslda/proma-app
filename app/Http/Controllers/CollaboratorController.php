<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = Collaborator::orderBy('name')->paginate(10);

        return view('collaborators.index', compact('collaborators'));
    }

    public function create()
    {
        return view('collaborators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'workload_hours' => ['required', 'numeric', 'min:0'],
            'establishment' => ['required', 'string', 'max:255'],
        ]);

        Collaborator::create($validated);

        return redirect()->route('collaborators.index')->with('success', 'Colaborador criado com sucesso.');
    }

    public function show(Collaborator $collaborator)
    {
        return redirect()->route('collaborators.edit', $collaborator);
    }

    public function edit(Collaborator $collaborator)
    {
        return view('collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'workload_hours' => ['required', 'numeric', 'min:0'],
            'establishment' => ['required', 'string', 'max:255'],
        ]);

        $collaborator->update($validated);

        return redirect()->route('collaborators.index')->with('success', 'Colaborador atualizado com sucesso.');
    }

    public function destroy(Collaborator $collaborator)
    {
        $collaborator->delete();

        return redirect()->route('collaborators.index')->with('success', 'Colaborador removido com sucesso.');
    }
}