<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

use App\VehicleRequest;

class VehicleRequestsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    // public function collection(){
    //     return VehicleRequest::all();
    // }
    public function query()
    {    
        return VehicleRequest::query()
            ->with([
                'tripTicket',
                'message'
            ]);
    }

    public function headings(): array
    {
        return [
            'Request ID',
            'Date Needed',
            'Date Requested',
            'Purpose',
            'Status',
            'Status Changed Date',
            'Last Message',
            'Trip Tickets'
        ];
    }

    public function map($request): array
    {
        $tripTickets = '';

        return [
            sprintf('WR-%06d', $request->id),
            $request->date_needed,
            $request->created_at,
            $request->purpose,
            $request->status,
            $request->lastStatusChanged,
            $request->message->message ?? null,
            $request->tripTicket->tripTicket ?? null
        ];
    }
}
