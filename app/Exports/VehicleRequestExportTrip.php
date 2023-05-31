<?php

namespace App\Exports;

use App\Dispatch;
use App\Drivers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class VehicleRequestExportTrip implements FromCollection, WithHeadings
{
    use Exportable;

    private $fileName = 'Trip Tickets.xlsx';

    private $dateFrom;
    private $dateTo;
    private $driver;
    private $unit;

    public function __construct(string $dateFrom, string $dateTo, string $driver, string $unit)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->driver = $driver;
        $this->unit = $unit;
    }

    public function headings(): array
    {
        return [
            '#',
            'Driver Name',
            'Type',
            'Active',
            'Created at',
            'Updated at'
        ];
    }

    public function collection() 
    {
        $this->dateFrom = $this->dateFrom . ' 00:00:00.000';
        $this->dateTo   = $this->dateTo . ' 23:59:59.999';

        if( $this->driver == '' && $this->unit == '')
        {
            $result = Dispatch::whereBetween('addedDate', [$this->dateFrom, $this->dateTo]);
        }

        else
        {
            if( $this->driver > 0 && $this->unit > 0)
            {
                $result = Dispatch::whereBetween('addedDate', [$this->dateFrom, $this->dateTo])
                                ->where('unitId', $this->unit)
                                ->where('driver_id', $this->driver);
            } 

            if( $this->driver > 0)
            {
                $result = Dispatch::whereBetween('addedDate', [$this->dateFrom, $this->dateTo])
                                ->where('driver_id', $this->driver);
            }

            if( $this->unit > 0)
            {
                $result = Dispatch::whereBetween('addedDate', [$this->dateFrom, $this->dateTo])
                                ->where('unitId', $this->unit);
            }
        }
        
        $query = $result->pluck('driver_id');
        
        return Drivers::whereIn('id', $query)->get();
    }
}