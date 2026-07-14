<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Establishment;
use App\Models\EstablishmentManagement;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SqlExportController extends Controller
{
    public function index()
    {
        $modules = [
            'collaborators' => 'Colaboradores',
            'time-entries' => 'Registros de Ponto',
            'establishments' => 'Estabelecimentos',
            'establishment-managements' => 'Gestão do Estabelecimento',
        ];

        $collaborators = Collaborator::orderBy('name')->get();
        $establishments = Establishment::orderBy('name')->get();

        return view('exportar.index', compact('modules', 'collaborators', 'establishments'));
    }

    public function exportFullBackup(Request $request)
    {
        $data = [
            'generatedAt' => now(),
            'collaborators' => $this->buildCollaboratorsQuery($request)->get(),
            'timeEntries' => $this->buildTimeEntriesQuery($request)->get(),
            'establishments' => $this->buildEstablishmentsQuery($request)->get(),
            'managements' => $this->buildEstablishmentManagementsQuery($request)->get(),
        ];

        $fileName = 'exportacao_completa_' . now()->format('Ymd_His') . '.pdf';

        return Pdf::loadView('exportar.pdf.full', $data)->setPaper('a4', 'landscape')->download($fileName);
    }

    public function exportModule(Request $request, string $module)
    {
        $moduleMap = $this->moduleDataMap($request);
        $item = $moduleMap[$module] ?? null;

        if ($item === null) {
            return back()->withErrors(['Módulo inválido para exportação.']);
        }

        $fileName = 'exportacao_' . str_replace('-', '_', $module) . '_' . now()->format('Ymd_His') . '.pdf';

        return Pdf::loadView('exportar.pdf.module', [
            'generatedAt' => now(),
            'moduleKey' => $module,
            'moduleLabel' => $item['label'],
            'rows' => $item['rows'],
        ])->setPaper('a4', 'landscape')->download($fileName);
    }

    private function moduleDataMap(Request $request): array
    {
        return [
            'collaborators' => [
                'label' => 'Colaboradores',
                'rows' => $this->buildCollaboratorsQuery($request)->get(),
            ],
            'time-entries' => [
                'label' => 'Registros de Ponto',
                'rows' => $this->buildTimeEntriesQuery($request)->get(),
            ],
            'establishments' => [
                'label' => 'Estabelecimentos',
                'rows' => $this->buildEstablishmentsQuery($request)->get(),
            ],
            'establishment-managements' => [
                'label' => 'Gestão do Estabelecimento',
                'rows' => $this->buildEstablishmentManagementsQuery($request)->get(),
            ],
        ];
    }

    private function buildCollaboratorsQuery(Request $request)
    {
        $query = Collaborator::with('establishmentRelation');

        if ($request->filled('establishment_id')) {
            $query->where('establishment_id', $request->input('establishment_id'));
        }

        $allowedSortBy = ['name', 'worker_code', 'establishment_name'];
        $sortBy = (string) $request->input('sort_by', 'name');
        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'name';
        }

        $sortDir = strtolower((string) $request->input('sort_dir', 'asc'));
        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'asc';
        }

        if ($sortBy === 'establishment_name') {
            return $query
                ->leftJoin('establishments', 'collaborators.establishment_id', '=', 'establishments.id')
                ->orderBy('establishments.name', $sortDir)
                ->select('collaborators.*');
        }

        return $query->orderBy($sortBy, $sortDir);
    }

    private function buildTimeEntriesQuery(Request $request)
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

        $allowedSortBy = ['entry_time', 'exit_time', 'presence', 'collaborator_name', 'date'];
        $sortBy = (string) $request->input('sort_by', 'date');
        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'date';
        }

        $sortDir = strtolower((string) $request->input('sort_dir', 'desc'));
        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        if ($sortBy === 'collaborator_name') {
            return $query
                ->leftJoin('collaborators', 'time_entries.collaborator_id', '=', 'collaborators.id')
                ->orderBy('collaborators.name', $sortDir)
                ->select('time_entries.*');
        }

        return $query->orderBy($sortBy, $sortDir);
    }

    private function buildEstablishmentsQuery(Request $request)
    {
        $query = Establishment::query();

        $sortDir = strtolower((string) $request->input('sort_dir', 'asc'));
        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'asc';
        }

        return $query->orderBy('name', $sortDir);
    }

    private function buildEstablishmentManagementsQuery(Request $request)
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

        $allowedSortBy = [
            'opened_at',
            'closed_at',
            'collaborator_name',
            'description_status',
            'establishment_state',
            'date',
        ];
        $sortBy = (string) $request->input('sort_by', 'date');
        if (!in_array($sortBy, $allowedSortBy, true)) {
            $sortBy = 'date';
        }

        $sortDir = strtolower((string) $request->input('sort_dir', 'desc'));
        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        if ($sortBy === 'collaborator_name') {
            return $query
                ->leftJoin('collaborators', 'establishment_managements.collaborator_id', '=', 'collaborators.id')
                ->orderBy('collaborators.name', $sortDir)
                ->select('establishment_managements.*');
        }

        return $query->orderBy($sortBy, $sortDir);
    }
}