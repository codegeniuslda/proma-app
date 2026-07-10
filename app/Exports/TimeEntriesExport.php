<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimeEntriesExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected Collection $entries
    ) {
    }

    public function collection(): Collection
    {
        return $this->entries->map(function ($entry) {
            return [
                'Data' => optional($entry->date)->format('Y-m-d'),
                'Carga Horaria' => $entry->workload_hours,
                'Estabelecimento' => $entry->establishment,
                'Colaborador' => optional($entry->collaborator)->name,
                'Entrada' => $entry->entry_time,
                'Saida' => $entry->exit_time,
                'Presenca' => $entry->presence,
                'Estado Descricao' => $entry->description_status,
                'Estado Estabelecimento' => $entry->establishment_state,
                'Descricao' => $entry->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
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
        ];
    }
}