<?php

namespace App\Exports;

use App\RequestRawData;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

use App\VehicleRequest;
use Carbon\Carbon;
class VehicleRequestRawExport implements FromQuery, WithHeadings, WithMapping
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
            'Request No.',
            'Vehicle Cost Code',
            'Cost Code',
            'Dept',
            'Date Needed',
            'Time Needed',
            'Date Requested',
            'Time Requested',
            'Purpose',
            'Trip Ticket',
            'Status',
            'Vehicle',
            'Fuel Added Qty',
            'Driver',
            'Passengers',
            'Contact Person',
            'Vehicle Date Out',
            'Time Out',
			'Vehicle Date Return',
            'Time Returned',
            'Distance Travelled',
            'Odometer Start',
            'Odometer End',
            'Ave. Fuel Consumed'
        ];
    }

    public function query()
    {
        $query = [];

        if(isset($this->start) || isset($this->end)) {
            // $query = VehicleRequest::orderBy('id', 'desc')
            // ->with([
            //     'tripTicket',
            //     'tripTicket.driver',
            //     'tripTicket.unit:id,type'
            // ])
            // ->whereBetween('created_at', [$this->start, $this->end]);

		$query = RequestRawData::orderBy('id','desc')->where('dateStart', '>', $this->start.' 00:00:00.000')->where('dateStart', '<', $this->end.' 23:59:59.999');
        }

        else {
            // $query = VehicleRequest::orderBy('id', 'desc')
            // ->with([
            //     'tripTicket',
            //     'tripTicket.driver:id',
            //     'tripTicket.unit:id,type'
            // ]);

            $query = RequestRawData::orderBy('id','desc');
        }

        return $query;
    }

    public function map($request): array
    {
        $vehicle_out_date = '';
        $vehicle_out_time = '';
        $vehicle_return_date = '';
        $vehicle_return_time = '';
        $distance_travelled = '';
        $ave_fuel_cons = '';
        
        $dateStart = isset($request->dateStart) ? Carbon::parse($request->dateStart)->format('m/d/Y') : '';
        $dateStart_time = isset($request->dateStart) ? Carbon::parse($request->dateStart)->format('h:i A') : '';
        
        $addedAt = isset($request->addedAt) ? Carbon::parse($request->addedAt)->format('m/d/Y') : '';
        $addedAt_time = isset($request->addedAt) ? Carbon::parse($request->addedAt)->format('h:i A') : '';


        if(isset($request->tripTicket)){
            $vehicle_out_date = $this->vehicleOut($request, $dateStart);
            $vehicle_out_time = $this->vehicleOut($request, $dateStart_time);

            $vehicle_return_date = $this->vehicleReturn($request, $addedAt, 'N/A', 'NOT YET RETURNED');
            $vehicle_return_time = $this->vehicleReturn($request, $addedAt_time, 'N/A', '');

            $distance_travelled = $this->distanceTravelled($request, $request->odometer_start, $request->odometer_end);
            $ave_fuel_cons = $this->ave_fuel_cons($request);
        }

        return [
            $request->refcode,
            $request->vehicle_cost_code,
            $request->costcode,
            $request->dept,
            $dateStart,
            $dateStart_time,
            $addedAt,
            $addedAt_time,
            $request->purpose,
            isset($request->tripTicket) ? $request->tripTicket : '',
            isset($request->Status) ? $request->Status : '',
            isset($request->type) ? $request->type : '',
            $request->fuel_added_qty == '.00' ? '': round($request->fuel_added_qty).' L' ,
            isset($request->driver_name) ? $request->driver_name: '',
			isset($request->passengers) ? $request->passengers : '',
			isset($request->contact_person) ? $request->contact_person : '',
            $vehicle_out_date,
            $vehicle_out_time,
            $vehicle_return_date,
            $vehicle_return_time,
            $distance_travelled,
            isset($request->odometer_start) ? $request->odometer_start : '',
            isset($request->odometer_end) ? $request->odometer_end : '',
            $ave_fuel_cons
        ];
    }

    private function vehicleOut($item, $dateStart){
        if(isset($item->Status)){
            if($item->Status == 'Cancelled'){
                return 'CANCELLED';
            }
                
            else{
                return $dateStart;
            }
        }
        return '';
    }

    private function vehicleReturn($item, $dateEnd, $status1, $status2){
        if(isset($item->Status)){
            if($item->Status == 'Cancelled'){
                return $status1;
            }

            else{
                if($item->dateEnd == ''){
                    return $status2;
                }

                else{
                    return $dateEnd;
                }
            }
        }
        return '';
    }

    private function distanceTravelled($item, $odometer_start, $odometer_end){
        if(isset($item->Status)){
            if($item->Status == 'Cancelled'){
                return 'CANCELLED';
            }

            else{
                return number_format((float) $odometer_end - $odometer_start, 4, '.', ''). 'KM';
            }
        }
        return '';
    }

    private function ave_fuel_cons($item){
        if(isset($item->Status)){
            if($item->odometer_start == '' || $item->odometer_end == ''){
                return '';
            }
        }

        else{
            if(($item->odometer_end - $item->odometer_start) == '0.0000'){
                return '';
            }
            else{
                if($item->fuel_added_qty == '0.00'){
                    return '';
                }
                else{
                    return number_format((float) ($item->odometer_end - $item->odometer_start) / $item->fuel_added_qty, 4, '.', ''). ' Km/Liter';
                }
            }
        }
    }


}
