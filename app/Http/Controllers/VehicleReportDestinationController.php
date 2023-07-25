<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\RoleRightService;
use App\Services\ReportService;
use App\Http\Controllers\Controller;

class VehicleReportDestinationController extends Controller
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
		$rolesPermissions = $this->roleRightService->hasPermissions("Top Frequent Destinations");
		if (!$rolesPermissions['view']) {
		    abort(401);
		}

        $start = $request->has('start');
        $end = $request->has('end');

        if( $start || $end) {

            $start = $request->query('start'); // or request->start
            $end = $request->query('end'); //or request->end

            $jsondata = array(
                "chart" => array(
                    "caption" => "MOST FREQUENT DESTINATIONS TRAVELLED",
                    "xAxisName" => "",
                    "showValues" => "1",
                    "theme" => "fusion"
                )
            );

            $jsondata["data"] = array();

            $from = "'". $start . " 00:00:00.000'";
            $to = "'". $end . " 23:59:59.999'";

            $query = "
            SELECT
                TOP 10
                SUBSTRING(destination,CHARINDEX('|',destination),LEN(destination)) AS dest,
                COUNT(destination) AS total
            FROM
                dispatch
            WHERE
                addedDate BETWEEN " . $from . "
                AND " . $to . "
            GROUP BY
                destination
            ORDER BY
                total DESC
            ";

            $destinationTbl = DB::select($query);
            $destinationTbl = (array) $destinationTbl;

            foreach ($destinationTbl as $value) {
                array_push($jsondata["data"], array(
                    "label" => strtoupper($value->dest),
                    "value" => str_replace('-', ' ', $value->total)
                ));
            }
            
		$saveLogs = $this->reportService->create("Top Frequent Destinations", $request);
            return view('admin.requests.reports.destinations-report', compact('start','end','destinationTbl','jsondata'));
        }

		$saveLogs = $this->reportService->create("Dispatch Distribution per Department", $request);
        return view('admin.requests.reports.destinations-report');
    }
}
