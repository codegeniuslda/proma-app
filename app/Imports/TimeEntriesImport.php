<?php

namespace App\Imports;

use App\Models\Collaborator;
use App\Models\TimeEntry;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TimeEntriesImport implements ToCollection
{
    public function collection(Collection $rows): void
    {
        if ($rows->isEmpty()) {
            return;
        }

        $header = $rows->first()->map(fn ($value) => trim((string) $value))->toArray();
        $requiredColumns = ['Data', 'Carga Horaria', 'Estabelecimento', 'Colaborador', 'Entrada', 'Saida', 'Presenca', 'Descricao'];

        if ($header !== $requiredColumns) {
            $rows = $rows;
        } else {
            $rows = $rows->slice(1);
        }

        foreach ($rows as $row) {
            if (count($row) < 8) {
                continue;
            }

            $dateRaw = $row[0];
            $workloadHours = $row[1];
            $establishment = trim((string) $row[2]);
            $collaboratorName = trim((string) $row[3]);
            $entryTime = $row[4] ? substr((string) $row[4], 0, 5) : null;
            $exitTime = $row[5] ? substr((string) $row[5], 0, 5) : null;
            $presence = trim((string) $row[6]) === 'Presente' ? 'Presente' : 'Nao Presente';
            $description = isset($row[7]) ? (string) $row[7] : null;

            if ($collaboratorName === '' || $establishment === '' || $dateRaw === null) {
                continue;
            }

            try {
                $date = is_numeric($dateRaw)
                    ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateRaw))->format('Y-m-d')
                    : Carbon::parse((string) $dateRaw)->format('Y-m-d');
            } catch (\Throwable $e) {
                continue;
            }

            $collaborator = Collaborator::firstOrCreate(
                [
                    'name' => $collaboratorName,
                    'establishment' => $establishment,
                ],
                [
                    'workload_hours' => is_numeric($workloadHours) ? (float) $workloadHours : 0,
                ]
            );

            TimeEntry::create([
                'date' => $date,
                'collaborator_id' => $collaborator->id,
                'establishment' => $establishment,
                'workload_hours' => is_numeric($workloadHours) ? (float) $workloadHours : 0,
                'entry_time' => $entryTime,
                'exit_time' => $exitTime,
                'presence' => $presence,
                'description' => $description,
            ]);
        }
    }
}