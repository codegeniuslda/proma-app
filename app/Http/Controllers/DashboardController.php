<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Establishment;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', 'today');

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

        $entries = $statsQuery->get();

        $collaborators = Collaborator::orderBy('name')->get()->map(function ($collaborator) use ($entries) {
            $present = $entries->where('collaborator_id', $collaborator->id)->where('presence', 'Presente')->count();
            $absent = $entries->where('collaborator_id', $collaborator->id)->where('presence', 'Nao Presente')->count();

            return [
                'name' => $collaborator->name,
                'present' => $present,
                'absent' => $absent,
            ];
        });

        $establishmentStatuses = Establishment::with('collaborators')->orderBy('name')->get()->map(function ($establishment) {
            $collaboratorIds = $establishment->collaborators->pluck('id');
            $lastEntry = TimeEntry::whereIn('collaborator_id', $collaboratorIds)
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->first();

            return [
                'name' => $establishment->name,
                'last_entry' => $lastEntry,
            ];
        });

        return view('dashboard.index', [
            'period' => $period,
            'from' => $from ? $from->toDateString() : $request->input('date_from'),
            'to' => $to ? $to->toDateString() : $request->input('date_to'),
            'collaboratorStats' => $collaborators,
            'establishmentStatuses' => $establishmentStatuses,
        ]);
    }
}