<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

use App\Department;

class VehicleRequestPerDepartment implements FromQuery, WithHeadings, WithMapping
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
            'Department',
            'Total'
        ];
    }

    public function query(){
        $query = [];

        if(isset($this->start) || isset($this->end)){
            $query = Department::query()
            ->dispatch()
            ->whereHas('dispatch', function($query1){
                $query1->whereBetween('addedDate', [$this->start, $this->end]);
            });
        }

        else{
            $query = Department::query()
            ->dispatch();
        }

        return $query;
    }

    public function map($request):array{
        return [
            $request->name,
            count($request->dispatch)
        ];
    }
    
}
