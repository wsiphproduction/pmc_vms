<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\VehicleRequestExportDestination;
use App\Exports\VehicleRequestExportTrip;
use App\Exports\VehicleRequestExportDistanceTravelled;
use App\Exports\VehicleRequestExportVehicleDispatch;
use App\Exports\VehicleRequestPerDepartment;
use App\Exports\VehicleRequestRawExport;
use App\Exports\DriversExport;

class ExcelExportController extends Controller
{

    public function export(Request $request)
    {
        
        if( $request->has('frequent_dest'))
        {
            //in case date is blank
            $date_fr = $request->input('date_fr') ? $request->input('date_fr') : "2000-05-05";
            $date_to = $request->input('date_to') ? $request->input('date_to') : "2030-05-05";
            
            return (new VehicleRequestExportDestination($date_fr,$date_to))->download('Frequent Destination ' . date('Y-m-d h-i-s') . '.xlsx');
        }

        if( $request->has('trip_tickets'))
        {
            //in case date is blank
            $date_fr = $request->input('date_from') ? $request->input('date_from') : "2000-05-05";
            $date_to = $request->input('date_to') ? $request->input('date_to') : "2030-05-05";
            $driver = $request->input('driver') ? $request->input('driver') : '';
            $unit = $request->input('unit') ? $request->input('unit') : '';
            
            return (new VehicleRequestExportTrip($date_fr,$date_to,$driver,$unit))->download('Trip Tickets ' . date('Y-m-d h-i-s') . '.xlsx');
        }

        if( $request->has('distance_travel'))
        {
            $date_fr = $request->input('date_fr') ? $request->input('date_fr') : null;
            $date_to = $request->input('date_to') ? $request->input('date_to') : null;

            return (new VehicleRequestExportDistanceTravelled($date_fr,$date_to))->download('Distance Travelled ' . date('Y-m-d h-i-s') . '.xlsx');
        }

        if($request->has('no_dispatches')){
            $date_fr = $request->input('date_fr') ? $request->input('date_fr') : null;
            $date_to = $request->input('date_to') ? $request->input('date_to') : null;

            return (new VehicleRequestExportVehicleDispatch($date_fr,$date_to))->download('Vehicles per Dispatch ' . date('Y-m-d h-i-s') . '.xlsx');
        }

     if($request->has('vehicle_request_raw_data')){
		 $date_fr = $request->input('date_from') ? $request->input('date_from') : null;
		 $date_to = $request->input('date_to') ? $request->input('date_to') : null;
		 
			return (new VehicleRequestRawExport($date_fr,$date_to))->download('Vehicle Request Raw Data ' . date('Y-m-d h-i-s') . '.xlsx');
}

    }
}
