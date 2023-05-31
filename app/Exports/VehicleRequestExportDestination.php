<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


class VehicleRequestExportDestination implements FromCollection
{
    use Exportable;

    private $dateFrom;
    private $dateTo;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection() 
    {
        $this->dateFrom = $this->dateFrom . ' 00:00:00.000';
        $this->dateTo   = $this->dateTo . ' 23:59:59.999';

        $query = "
        SELECT 
            top 10 SUBSTRING(destination,CHARINDEX('|',destination),LEN(destination)) AS dest,
            COUNT(destination) AS total 
        FROM dispatch
        WHERE
            addedDate
        BETWEEN 
            '" . $this->dateFrom . "' AND '" . $this->dateTo . "' 
        GROUP BY 
            destination 
        ORDER BY 
            total DESC";

        return collect(DB::select($query));
    }
}