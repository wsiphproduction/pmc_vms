<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

use App\Drivers;

class DriversExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function headings(): array{
        return [
            'Driver Name',
            'Type', 
            'Is Active'
        ];
    }

    public function query(){
        return Drivers::query();
    }

    public function map($request):array{
        if($request->isActive == 1){
            $request->isActive = 'active';
        } else{
            $request->isActive = 'disabled';
        }

        return [
            $request->driver_name,
            $request->type,
            $request->isActive
        ];
    }
}
