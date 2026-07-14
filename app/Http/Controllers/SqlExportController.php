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

        return view('exportar.index', compact('modules'));
    }

    public function exportFullBackup(Request $request)
    {
        $data = [
            'generatedAt' => now(),
            'collaborators' => Collaborator::with('establishmentRelation')->orderBy('name')->get(),
            'timeEntries' => TimeEntry::with('collaborator')->orderByDesc('date')->orderByDesc('id')->get(),
            'establishments' => Establishment::orderBy('name')->get(),
            'managements' => EstablishmentManagement::with(['collaborator', 'closedByCollaborator'])
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->get(),
        ];

        $fileName = 'exportacao_completa_' . now()->format('Ymd_His') . '.pdf';

        return Pdf::loadView('exportar.pdf.full', $data)->setPaper('a4', 'landscape')->download($fileName);
    }

    public function exportModule(Request $request, string $module)
    {
        $moduleMap = $this->moduleDataMap();
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

    private function moduleDataMap(): array
    {
        return [
            'collaborators' => [
                'label' => 'Colaboradores',
                'rows' => Collaborator::with('establishmentRelation')->orderBy('name')->get(),
            ],
            'time-entries' => [
                'label' => 'Registros de Ponto',
                'rows' => TimeEntry::with('collaborator')->orderByDesc('date')->orderByDesc('id')->get(),
            ],
            'establishments' => [
                'label' => 'Estabelecimentos',
                'rows' => Establishment::orderBy('name')->get(),
            ],
            'establishment-managements' => [
                'label' => 'Gestão do Estabelecimento',
                'rows' => EstablishmentManagement::with(['collaborator', 'closedByCollaborator'])
                    ->orderByDesc('date')
                    ->orderByDesc('id')
                    ->get(),
            ],
        ];
    }
}