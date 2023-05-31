<?php

namespace App\Http\Controllers;

use App\Drivers;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\RoleRightService;
use App\Services\ReportService;

class VehicleReportTripTicketController extends Controller
{
    public function __construct(
		RoleRightService $roleRightService,
		ReportService $reportService
	) {
		$this->reportService = $reportService;
		$this->roleRightService = $roleRightService;
	}
    public function index(Request $request)
    {
		$rolesPermissions = $this->roleRightService->hasPermissions("Trip Tickets");
		if (!$rolesPermissions['view']) {
		    abort(401);
		}
        $drivers = Drivers::all();
        $unit = Unit::all();
        $condition = "";
        $query = "";

        if( $request->has('start'))
        {
            //in case $to is blank set date to this day
            $to = $request->query('end') != '' ? $request->query('end') : date('Y-m-d');
            $to .= ' 23:59:59.999';
            //just making sure on $from
            $from = $request->query('start') != '' ? $request->query('start') : date('Y-m-d');
            $from .= ' 00:00:00.000';


            if( $request->query('driver') != null && $request->query('unit') != null)
            {
                $condition .= " and driver_id = '" . $request->query('driver') . "' and unitId = '" . $request->query('unit') . "' ";
            }

            if( $request->has('driver') && $request->query('driver') != null)
            {
                $condition .= " and driver_id = " . $request->query('driver') . "";
            }

            if( $request->has('unit') && $request->query('unit') != null)
            {
                $condition .= " and unitId = " . $request->query('unit') . " ";
            }

            // $dispatchResult = DB::select("select * from dispatches WHERE addedDate BETWEEN '".$from."' and '".$to."' " .$condition);

            // $driverResult = array();

            // foreach($dispatchResult as $item)
            // {
            //     $driverResult[] = DB::select("select * FROM drivers WHERE id = " . $item->driver_id);
            // }

            $result = "
            select
                dispatch.tripTicket,
                drivers.driver_name,
                dispatch.type,
                dispatch.purpose,
                dispatch.Status
            from
                drivers
            join
                dispatch ON dispatch.driver_id = drivers.id
            where 
                dispatch.addedDate BETWEEN '".$from."' and '".$to."' ".$condition;

            $driverResult = DB::select($result);

            $saveLogs = $this->reportService->create("Trip Tickets", $request);
            return view('admin.requests.reports.tripticket-report', compact('drivers','unit','driverResult'));
        }

		$saveLogs = $this->reportService->create("Trip Tickets", $request);
        return view('admin.requests.reports.tripticket-report', compact('drivers','unit'));
    }
}
