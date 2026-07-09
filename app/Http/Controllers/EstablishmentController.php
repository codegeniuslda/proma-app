<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function index()
    {
        $establishments = Establishment::orderBy('name')->paginate(25);

        return view('establishments.index', compact('establishments'));
    }

    public function create()
    {
        return view('establishments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:establishments,name'],
        ]);

        Establishment::create($validated);

        return redirect()->route('establishments.index')->with('success', 'Estabelecimento criado com sucesso.');
    }

    public function show(Establishment $establishment)
    {
        return redirect()->route('establishments.edit', $establishment);
    }

    public function edit(Establishment $establishment)
    {
        return view('establishments.edit', compact('establishment'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:establishments,name,' . $establishment->id],
        ]);

        $establishment->update($validated);

        return redirect()->route('establishments.index')->with('success', 'Estabelecimento atualizado com sucesso.');
    }

    public function destroy(Establishment $establishment)
    {
        if ($establishment->collaborators()->exists()) {
            return redirect()->route('establishments.index')->withErrors([
                'Não é possível excluir: existem colaboradores vinculados a este estabelecimento.',
            ]);
        }

        $establishment->delete();

        return redirect()->route('establishments.index')->with('success', 'Estabelecimento removido com sucesso.');
    }
}