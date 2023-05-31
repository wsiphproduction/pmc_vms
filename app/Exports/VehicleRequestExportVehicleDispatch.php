<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

use App\Unit;

class VehicleRequestExportVehicleDispatch implements FromQuery, WithHeadings, WithMapping
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
            'Vehicle',
            'Total'
        ];
    }

    public function query()
    {
        $query = [];

        if(isset($this->start) || isset($this->end)){
            $query = Unit::query()
            ->with([
                'dispatch'
            ])
            ->whereHas('dispatch', function($query){
                $query->whereBetween('addedDate', [$this->$start, $this->$end]);
            });
        }

        else{
            $query = Unit::query()
            ->with([
                'dispatch'
            ]);
        }

        return $query;
    }

    public function map($request): array
    {
        return [
            $request->type,
            count($request->dispatch)
        ];
    }
}
