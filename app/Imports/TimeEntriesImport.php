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
        $requiredColumns = ['Data', 'Estabelecimento', 'Colaborador', 'Entrada', 'Saida', 'Presenca', 'Descricao'];

        if ($header !== $requiredColumns) {
            $rows = $rows;
        } else {
            $rows = $rows->slice(1);
        }

        foreach ($rows as $row) {
            if (count($row) < 7) {
                continue;
            }

            $dateRaw = $row[0];
            $establishment = trim((string) $row[1]);
            $collaboratorName = trim((string) $row[2]);
            $entryTime = $row[3] ? substr((string) $row[3], 0, 5) : null;
            $exitTime = $row[4] ? substr((string) $row[4], 0, 5) : null;
            $presence = trim((string) $row[5]) === 'Presente' ? 'Presente' : 'Nao Presente';
            $description = isset($row[6]) ? (string) $row[6] : null;

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

            );

            TimeEntry::create([
                'date' => $date,
                'collaborator_id' => $collaborator->id,
                'establishment' => $establishment,
        
                'entry_time' => $entryTime,
                'exit_time' => $exitTime,
                'presence' => $presence,
                'description' => $description,
            ]);
        }
    }
}