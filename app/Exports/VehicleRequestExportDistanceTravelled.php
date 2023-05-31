<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

use App\Dispatch;

class VehicleRequestExportDistanceTravelled implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($start, $end){
        $this->start = $start;
        $this->end = $end;
    }

    public function headings(): array{
        return [
            '#',
            'Vehicle',
            'Odometer Start',
            'Odometer End',
            'Total'
        ];
    }

    public function query()
    {
        $query = [];

        if(isset($this->start) || isset($this->end)){
            $query = Dispatch::query()
            ->distanceTravelled()
            ->with(['unit'])
            ->whereBetween('addedDate', [$this->start, $this->end]);
        }
        else{
            $query = Dispatch::query()
            ->distanceTravelled()
            ->with(['unit']);
        }

        return $query;
    }

    public function map($request): array
    {
        return [
            $request->id,
            $request->unit->type,
            $request->odometer_start,
            $request->odometer_end,
            $request->distance
        ];
    }
}
