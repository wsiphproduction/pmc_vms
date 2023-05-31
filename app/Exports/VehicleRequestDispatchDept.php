<?php

namespace App\Exports;

use App\Dispatch;
use App\RequestRawData;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\DB;

class VehicleRequestDispatchDept implements WithHeadings, FromCollection, WithMapping
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
            'Departments',
            'Total',
        ];
    }

    public function collection()
    {
        $query = [];
       
        if(isset($this->start) || isset($this->end)) {

            $query = Dispatch::
            addSelect(DB::raw('COUNT(deptId) as total'))
            ->addSelect(DB::raw('deptId as label'))
            ->whereBetween('addedDate', [$this->start, $this->end])
            ->groupBy('deptId')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
        }

        else {
            
            $query = Dispatch::
            addSelect(DB::raw('COUNT(deptId) as total'))
            ->addSelect(DB::raw('deptId as label'))
            ->groupBy('deptId')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
           
            
        }

        return $query;
    }

    public function map($request): array
    {
        
        return [
            $request->label,
            $request->total,
        ];
    }
}
