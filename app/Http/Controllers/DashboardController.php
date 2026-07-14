<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Establishment;
use App\Models\EstablishmentManagement;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'custom');

        $from = null;
        $to = null;

        if ($period === 'today') {
            $from = Carbon::today();
            $to = Carbon::today();
        } elseif ($period === 'week') {
            $from = Carbon::now()->startOfWeek();
            $to = Carbon::now()->endOfWeek();
        } elseif ($period === 'month') {
            $from = Carbon::now()->startOfMonth();
            $to = Carbon::now()->endOfMonth();
        } elseif ($period === 'custom') {
            $from = $request->filled('date_from') ? Carbon::parse($request->input('date_from')) : null;
            $to = $request->filled('date_to') ? Carbon::parse($request->input('date_to')) : null;
        }

        $statsQuery = TimeEntry::query();

        if ($from) {
            $statsQuery->whereDate('date', '>=', $from->toDateString());
        }

        if ($to) {
            $statsQuery->whereDate('date', '<=', $to->toDateString());
        }

        if ($request->filled('collaborator_id')) {
            $statsQuery->where('collaborator_id', $request->input('collaborator_id'));
        }

        if ($request->filled('presence')) {
            $statsQuery->where('presence', $request->input('presence'));
        }

        if ($request->filled('establishment')) {
            $statsQuery->where('establishment', $request->input('establishment'));
        }

        $entries = $statsQuery->get();

        $presentCount = $entries->where('presence', 'Presente')->count();
        $absentCount = $entries->where('presence', 'Ausente')->count();
        $justifiedCount = $entries->where('presence', 'Justificado')->count();
        $notMarkedCount = $entries->whereNull('entry_time')->count();

        $managementQuery = EstablishmentManagement::with(['collaborator.establishmentRelation', 'closedByCollaborator'])
            ->orderByDesc('date')
            ->orderByDesc('id');

        if ($from) {
            $managementQuery->whereDate('date', '>=', $from->toDateString());
        }

        if ($to) {
            $managementQuery->whereDate('date', '<=', $to->toDateString());
        }

        if ($request->filled('establishment')) {
            $managementQuery->whereHas('collaborator.establishmentRelation', function ($query) use ($request) {
                $query->where('name', $request->input('establishment'));
            });
        }

        $establishmentStatuses = $managementQuery
            ->get()
            ->groupBy(function ($management) {
                return optional(optional($management->collaborator)->establishmentRelation)->name ?? 'Sem estabelecimento';
            })
            ->map(function ($items, $establishmentName) {
                return [
                    'name' => $establishmentName,
                    'last_entry' => $items->first(),
                ];
            })
            ->values();

        return view('dashboard.index', [
            'period' => $period,
            'from' => $from ? $from->toDateString() : $request->input('date_from'),
            'to' => $to ? $to->toDateString() : $request->input('date_to'),
            'presenceSummary' => [
                'present' => $presentCount,
                'absent' => $absentCount,
                'justified' => $justifiedCount,
                'not_marked' => $notMarkedCount,
            ],
            'establishmentStatuses' => $establishmentStatuses,
            'collaboratorOptions' => Collaborator::orderBy('name')->get(),
            'establishmentOptions' => TimeEntry::query()
                ->select('establishment')
                ->whereNotNull('establishment')
                ->where('establishment', '!=', '')
                ->distinct()
                ->orderBy('establishment')
                ->pluck('establishment'),
            'presenceFilter' => $request->input('presence'),
            'collaboratorFilter' => $request->input('collaborator_id'),
            'establishmentFilter' => $request->input('establishment'),
        ]);
    }
}