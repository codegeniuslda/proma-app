<?php

namespace App\Http\Controllers;

use App\Imports\TimeEntriesImport;
use App\Models\Collaborator;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TimeEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = TimeEntry::with('collaborator');

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

        $timeEntries = $query->latest()->paginate($perPage)->withQueryString();
        $collaborators = Collaborator::orderBy('name')->get();
        $establishments = \App\Models\Establishment::orderBy('name')->get();

        return view('time_entries.index', compact('timeEntries', 'collaborators', 'establishments'));
    }

    public function create()
    {
        $collaborators = Collaborator::orderBy('name')->get();

        return view('time_entries.create', compact('collaborators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'collaborator_id' => ['required', 'exists:collaborators,id'],
            'establishment' => ['required', 'string', 'max:255'],
            'entry_time' => ['nullable', 'date_format:H:i'],
            'exit_time' => ['nullable', 'date_format:H:i'],
            'presence' => ['required', 'in:Presente,Ausente,Justificado'],
            'description' => ['nullable', 'string'],
        ]);

        TimeEntry::create($validated);

        return redirect()->route('time-entries.index')->with('success', 'Registro criado com sucesso.');
    }

    public function show(TimeEntry $timeEntry)
    {
        return redirect()->route('time-entries.edit', $timeEntry);
    }

    public function edit(TimeEntry $timeEntry)
    {
        $collaborators = Collaborator::orderBy('name')->get();

        return view('time_entries.edit', compact('timeEntry', 'collaborators'));
    }

    public function update(Request $request, TimeEntry $timeEntry)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'collaborator_id' => ['required', 'exists:collaborators,id'],
            'establishment' => ['required', 'string', 'max:255'],
            'entry_time' => ['nullable', 'date_format:H:i'],
            'exit_time' => ['nullable', 'date_format:H:i'],
            'presence' => ['required', 'in:Presente,Ausente,Justificado'],
            'description' => ['nullable', 'string'],
        ]);

        $timeEntry->update($validated);

        return redirect()->route('time-entries.index')->with('success', 'Registro atualizado com sucesso.');
    }

    public function destroy(TimeEntry $timeEntry)
    {
        $timeEntry->delete();

        return redirect()->route('time-entries.index')->with('success', 'Registro removido com sucesso.');
    }

    public function importForm()
    {
        return view('time_entries.import');
    }

    public function importStore(Request $request)
    {
        $validated = $request->validate([
            'excel_file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $path = $request->file('excel_file')->store('imports');

        Excel::import(new TimeEntriesImport(), storage_path('app/' . $path));

        return redirect()->route('time-entries.index')->with('success', 'Arquivo importado com sucesso.');
    }
}