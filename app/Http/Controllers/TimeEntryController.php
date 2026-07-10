<?php

namespace App\Http\Controllers;

use App\Imports\TimeEntriesImport;
use App\Models\Collaborator;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TimeEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = TimeEntry::with('collaborator');
        $this->applyFilters($query, $request);

        $allowedPerPage = [25, 50, 100];
        $perPage = (int) $request->input('per_page', 25);
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 25;
        }

        $timeEntries = $query->latest()->paginate($perPage)->withQueryString();
        $collaborators = Collaborator::orderBy('name')->get();

        return view('time_entries.index', compact('timeEntries', 'collaborators'));
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
            'workload_hours' => ['required', 'numeric', 'min:0'],
            'entry_time' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'exit_time' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'presence' => ['required', 'in:Presente,Nao Presente'],
            'establishment_state' => ['nullable', 'in:Aberto,Fechado,Parcialmente'],
            'description' => ['nullable', 'string'],
            'description_status' => ['nullable', 'in:critico,razoavel,bom'],
        ]);

        if (!empty($validated['entry_time'])) {
            $validated['entry_time'] = substr($validated['entry_time'], 0, 5);
        }
        if (!empty($validated['exit_time'])) {
            $validated['exit_time'] = substr($validated['exit_time'], 0, 5);
        }

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
            'workload_hours' => ['required', 'numeric', 'min:0'],
            'entry_time' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'exit_time' => ['nullable', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'presence' => ['required', 'in:Presente,Nao Presente'],
            'establishment_state' => ['nullable', 'in:Aberto,Fechado,Parcialmente'],
            'description' => ['nullable', 'string'],
            'description_status' => ['nullable', 'in:critico,razoavel,bom'],
        ]);

        if (!empty($validated['entry_time'])) {
            $validated['entry_time'] = substr($validated['entry_time'], 0, 5);
        }
        if (!empty($validated['exit_time'])) {
            $validated['exit_time'] = substr($validated['exit_time'], 0, 5);
        }

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

        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            \Maatwebsite\Excel\Facades\Excel::import(new TimeEntriesImport(), storage_path('app/' . $path));
            return redirect()->route('time-entries.index')->with('success', 'Arquivo importado com sucesso.');
        }

        return redirect()->route('time-entries.index')->with('error', 'Importação via Excel indisponível no momento. Instale maatwebsite/excel.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = TimeEntry::with('collaborator');
        $this->applyFilters($query, $request);

        $entries = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="registros_ponto.csv"',
        ];

        return response()->streamDownload(function () use ($entries) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Data',
                'Carga Horaria',
                'Estabelecimento',
                'Colaborador',
                'Entrada',
                'Saida',
                'Presenca',
                'Estado Descricao',
                'Estado Estabelecimento',
                'Descricao',
            ], ';');

            foreach ($entries as $entry) {
                fputcsv($handle, [
                    optional($entry->date)->format('Y-m-d'),
                    $entry->workload_hours,
                    $entry->establishment,
                    optional($entry->collaborator)->name,
                    $entry->entry_time,
                    $entry->exit_time,
                    $entry->presence,
                    $entry->description_status,
                    $entry->establishment_state,
                    $entry->description,
                ], ';');
            }

            fclose($handle);
        }, 'registros_ponto.csv', $headers);
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('collaborator_id')) {
            $query->where('collaborator_id', $request->input('collaborator_id'));
        }

        if ($request->filled('establishment')) {
            $query->where('establishment', 'like', '%' . $request->input('establishment') . '%');
        }

        if ($request->filled('description_status')) {
            $query->where('description_status', $request->input('description_status'));
        }

        $presences = (array) $request->input('presences', []);
        if (!empty($presences)) {
            if ($request->input('presence_mode', 'include') === 'exclude') {
                $query->whereNotIn('presence', $presences);
            } else {
                $query->whereIn('presence', $presences);
            }
        }

        $states = (array) $request->input('establishment_states', []);
        if (!empty($states)) {
            if ($request->input('establishment_state_mode', 'include') === 'exclude') {
                $query->whereNotIn('establishment_state', $states);
            } else {
                $query->whereIn('establishment_state', $states);
            }
        }

        $period = $request->input('period', 'all');

        if ($period === 'day' && $request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        } elseif ($period === 'week') {
            $base = $request->filled('date') ? Carbon::parse($request->input('date')) : now();
            $query->whereBetween('date', [$base->copy()->startOfWeek(), $base->copy()->endOfWeek()]);
        } elseif ($period === 'month') {
            $base = $request->filled('date') ? Carbon::parse($request->input('date')) : now();
            $query->whereYear('date', $base->year)->whereMonth('date', $base->month);
        } elseif ($period === 'custom') {
            if ($request->filled('date_from')) {
                $query->whereDate('date', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->whereDate('date', '<=', $request->input('date_to'));
            }
        } else {
            if ($request->filled('date_from')) {
                $query->whereDate('date', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->whereDate('date', '<=', $request->input('date_to'));
            }
        }
    }
}