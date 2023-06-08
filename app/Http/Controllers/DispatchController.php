<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\VehicleReqRequest;
use App\Enums\VehicleRequestStatusEnum;
use App\Enums\DispatchStatusEnum;

use App\VehicleRequest;
use App\FuelTypes;
use App\Dispatch;
use App\Department;
use App\Unit;
use App\Drivers;
use App\FMSIssuanceRequest;
use App\Services\ReportService;
use App\Services\RoleRightService;

use App\Helper\Validators;

use Exception;
use Carbon\Carbon;
use DB;

class DispatchController extends Controller
{
    public function __construct(
        RoleRightService $roleRightService,
        ReportService $reportService
    ) {
        $this->reportService = $reportService;
        $this->roleRightService = $roleRightService;
    }
    public function tripTicket(Request $request)
    {
        // dd($cancel_id = $request);
        $cancel_id = $request->get('cancel_tid');
        $query = Dispatch::where('tripTicket', $request->get('id'))->first();

        $driver = Drivers::where('id', $query->driver_id);
        $dest = $query->destination;
        $ex = explode('|', $dest);
        $origin = $ex[0];
        $destination = $ex[1];

        $cancelled = ($query->Status == 'Cancelled' || $query->Status == 'Closed') ? 'none;' : '';

        if (isset($cancel_id)) {
            $date_cancelled = date('Y-m-d');
            
            $dispatch = Dispatch::where('tripTicket', $request->get('tid'))->first();
            $dispatch->Status = 'Cancelled';
            $dispatch->CancelledBy = \Session::get('esdvms_username');
            $dispatch->Cancelled_at = $date_cancelled;

            if ($dispatch) {
                $successMSG = 'Trip Ticket Succesfully <b>Cancelled</b>...';
            } else {
                $errorMSG = 'Trip Ticket <b>Cancellation</b> Failed...';
            }

            return view('admin.requests.trip_ticket.dispatch_details', [
                'dispatch' => $query,
                'driver' => $driver,
                'destination' => $destination,
                'successMSG' => $successMSG,
                'errorMSG' => $errorMSG
            ]);
        } else {
            return view('admin.requests.trip_ticket.dispatch_details', [
                'dispatch' => $query,
                'driver' => $driver,
                'destination' => $destination
            ]);
        }
    }


    public function vehiclesTotalDispatchReport(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Top Vehicles by number of Dispatches");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $reports = [];
        $vehicles = [];

        $start = $request->input('start');
        $end = $request->input('end');

        $vehicles = Dispatch::addSelect(DB::raw('TOP(10) type'))
            ->addSelect(DB::raw('COUNT(type) as total'))
            ->where('addedDate', '>', $start)
            ->where('addedDate', '<', $end)
            ->groupBy('type')
            ->orderBy('total', 'desc')
            ->get();

        foreach ($vehicles as $vehicle) {
            $object = new \stdClass();
            $object->label = $vehicle->type;
            $object->value = $vehicle->total;

            array_push($reports, $object);
        }

        return view('admin.requests.reports.vehicle_total_dispatch', [
            'vehicles' => $reports,
            'start' => $start,
            'end' => $end
        ]);
    }
    public function vehiclesTotalDistance(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Top Vehicles by Distance Travelled");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $reports = [];
        $dispatches = null;

        $start = $request->has('start');
        $end = $request->has('end');

        if ($start || $end) {

            $start = $request->query('start'); // or request->start
            $end = $request->query('end'); //or request->end

            $dispatches = Dispatch::distanceTravelled()
                ->whereBetween('addedDate', [$start, $end])
                ->get();
        } else {
            $dispatches = Dispatch::distanceTravelled()
                ->get();
        }

        foreach ($dispatches as $dispatch) {
            $reportObject = new \stdClass;
            $reportObject->label = $dispatch->unit->type;
            $reportObject->odometer_start = $dispatch->odometer_start;
            $reportObject->odometer_end = $dispatch->odometer_end;
            $reportObject->no_kim = $dispatch->odometer_start - $dispatch->odometer_end;
            $reportObject->value = $reportObject->no_kim;

            array_push($reports, $reportObject);
        }

        $saveLogs = $this->reportService->create("Top Vehicles by Distance Travelled", $request);
        return view('admin.requests.reports.vehicle_total_distance', [
            'items' => $reports,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function create(Request $request)
    {

        
        $passengers = '';
        $passenger = '';
        $app_date = '';
        $destination = '';

        if (strpos($request->vehicles, 'Select Vehicle') !== false) { //No vehicle selected
            $unitId = "";
            $type = "";
        } else {
            $vehicles = explode('|', $request->vehicles);
            $unitId = $vehicles[0];
            $type = $vehicles[1];
        }

        foreach ($request->passenger as $p) {
            $passengers .= strtoupper($p . '|');
            $passenger = rtrim($passengers, '|');
        }

        if (strlen($request->app_date) <= 14) {
            $app_date = explode(".", $request->app_date);
            $app_date = Carbon::parse($app_date[0])->format('Y-m-d 00:00:10');
        } else {
            // $app_date =  date ('Y-m-d',strtotime(substr($request->app_date,0,10)));
            $app_date = Carbon::parse($request->app_date)->format('Y-m-d h:i:s');
            // {{ date('Y-m-d',strtotime(substr($request->date_needed,0,10))) }}
            // dd($app_date);
        }
            
         {
            $destination = $request->origin . '|' . $request->destination;
        }
        // dd($request->driver);
        // dd($destination);
        $dispatch = Dispatch::create([
            // 'date_out' => $request->date_out,
            'do' =>!is_null($request->do) ? $request->do : $request->date_out,
            'dateStart' => !is_null($request->date_out) ? $request->date_out : $request->do,
            // 'dateStart' => $request->date_out,
            'unitId' => $unitId,
            'addedBy' => \Session::get('esdvms_username'),
            'type' => $type,
            'app_date' => $app_date,
            'destination' => $destination,
            'origin' => $request->origin,
            'odometer_start' => $request->odom_start,
            'purpose' => $request->purpose,
            'addedDate' => $app_date,
            'vehicle_cost_code' => $request->cost_code,
            'RQ' => $request->rq_num,
            'itemCode' => $request->item_code,
            'fuel_added_qty' => $request->req_qty,
            'uom' => $request->uom,
            'driver_id' => $request->driver,
            'passengers' => $passenger
        ]);
        // dd($dispatch);
        $dispatch->deptId = $request->get('deptId');
        $dispatch->request_id = $request->rid;
        $dispatch->Status = DispatchStatusEnum::NEW_TICKET;
        $dispatch->save();
        
        $dispatch->tripTicket = sprintf('TN-%06d', $dispatch->id);
        $dispatch->save();
       
        $vehicle_request = VehicleRequest::findOrFail($request->rid);
        $vehicle_request->status = VehicleRequestStatusEnum::SCHEDULED;
        $vehicle_request->save();
        
        return redirect()->route('vehicle.request.list');
    }

    public function dispatchesPerDepartmentReport(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Dispatch Distribution per Department");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $jsonDispatches = [];
        $start = $request->input('start');
        $end = $request->input('end');
        $departments = null;

        if ($start || $end) {

            $query = "SELECT top(10) deptId,count(deptId) AS total FROM dispatch
                    WHERE addedDate BETWEEN '" . $start . "' AND '" . $end . "' GROUP BY deptId ORDER BY total DESC";

            $departments = DB::select($query);
        } else {
            $query = "SELECT top(10) deptId,count(deptId) AS total FROM dispatch
                    GROUP BY deptId ORDER BY total DESC";

            $departments = DB::select($query);
        }

        foreach ($departments as $department) {
            $object = new \stdClass();
            $object->label = $department->deptId;
            $object->value = $department->total;

            array_push($jsonDispatches, $object);
        }

        $saveLogs = $this->reportService->create("Dispatch Distribution per Department", $request);
        return view('admin.requests.reports.dispatch_per_dept', [
            'items' => $jsonDispatches,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function dispatchesPerDepartment(Request $request)
    {
        $jsonDispatches = [];

        $departments = Department::dispatches()
            ->get();
        // ->each(function($data){
        //     $data->label = $data->name;
        //     $data->value = count($data->dispatch);
        // });
        foreach ($departments as $department) {
            $object = new \stdClass();
            $object->label = $department->name;
            $object->value = count($department->dispatch);

            array_push($jsonDispatches, $object);
        }

        $saveLogs = $this->reportService->create("Top Vehicles by number of Dispatches", $request);
        return response()->json($jsonDispatches);
    }

    public function vehiclesTotalDispatches()
    {
        $report = [];

        $vehicles = Unit::with([
            'dispatches'
        ])
            ->get();

        foreach ($vehicles as $vehicle) {
            $object = new \stdClass();
            $object->label = $vehicle->type;
            $object->value = count($vehicle->dispatches);

            array_push($report, $object);
        }

        $saveLogs = $this->reportService->create("Top Vehicles by number of Dispatches", $request);
        return response()->json($report);
    }

    public function vehicleDistanceTravelled()
    {
        $reports = [];

        $dispatches = Dispatch::selectRaw('odometer_start - odometer_end as distance, dispatch.id, dispatch.unitId')
            ->where('status', DispatchStatusEnum::COMPLETE)
            ->with(['unit:id,type'])
            ->groupBy('unitId')
            ->get();

        foreach ($dispatches as $dispatch) {
            $reportObject = new \stdClass;
            $reportObject->label = $dispatch->unit->type;
            $reportObject->value = $dispatch->distance;

            array_push($reports, $reportObject);
        }

        return response()->json($reports);
    }
    public function weekly(Request $request, $week = null)
    {
        // dd($request);

        $rolesPermissions = $this->roleRightService->hasPermissions("Weekly");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $unit = Unit::all();
        $startDate = '2021-01-01';
        $endDate = strtotime('2021-12-31');
        $weeks = '';
        $n = 0;
        for ($i = strtotime('Monday', strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i)) {
            $n++;
            $weeks .= '<option value="' . $n . '|' . date('Y-m-d', $i) . '|' . date('Y-m-d', strtotime('+6 days', $i)) . '">Week ' . $n . ' (' . date('Y-m-d', $i) . ' to ' . date('Y-m-d', strtotime('+6 days', $i)) . ')</option>';
        }
        $isMotor = true;
        if ($request->from !== null && $request->to !== null) { {
                if ($request->unit !== null) {

                    if ($request->unit != 'motor') {
                        $isMotor = false;
                        $v_id = explode('|', $request->unit);

                        if ($v_id[1] == null || $v_id[1] == '') {
                            $v_id[1] = 0;
                        }
                    }
                    // $result = "
                    //     select
                    //         d.tripTicket,
                    //         d.unitId,                    
                    //         d.type,
                    //         d.purpose,
                    //         d.Status,
                    //         r.refcode,
                    //         r.date_needed,
                    //         u.name,
                    //         u.plateno,
                    //         u.crossref_vid,
                    //         d.dateStart from
                    //         dispatch d left join vehicle_request as r on r.id=d.request_id
                    //         left join unit u on u.id=d.unitId
                    //     where 
                    //         d.dateStart>='".$request->from." 00:00:01' and d.dateStart<='".$request->to." 23:59:59' and u.id=".$request->unit; 
                    if ($request->unit != 'motor') {
                        $result = "
                    select
                        d.tripTicket,
                        d.unitId,                    
                        d.type,
                        d.purpose,
                        d.Status,
                        r.refcode,
                        r.date_needed,
                        u.name,
                        u.plateno,
                        u.crossref_vid,
                        d.dateStart from
                        dispatch d left join vehicle_request as r on r.id=d.request_id
                        left join unit u on u.id=d.unitId
                    where 
                        d.dateStart>='" . $request->from . " 00:00:01' and d.dateStart<='" . $request->to . " 23:59:59' and (u.id=" . $v_id[0] . " or u.id=" . $v_id[1] . ")";
                    } else {
                        //      $result = "
                        // select
                        //     d.tripTicket,
                        //     d.unitId,                    
                        //     d.type,
                        //     d.purpose,
                        //     d.Status,
                        //     r.refcode,
                        //     r.date_needed,
                        //     u.name,
                        //     u.plateno,
                        //     u.crossref_vid,
                        //     u.type,
                        //     d.dateStart from
                        //     dispatch d left join vehicle_request as r on r.id=d.request_id
                        //     left join unit u on u.id=d.unitId
                        // where 
                        //     d.dateStart>='".$request->from." 00:00:01' and d.dateStart<='".$request->to." 23:59:59' and u.type='".$request->unit."'"; 
                        $result = "select * from unit where type like '%" . $request->unit . "%'";
                    }


                    // $fresult= "select d.RQ, d.created_at, d.tripTicket, d.type, d.fuel_requested_qty, d.fuel_added_qty, d.purpose, d.unitId from dispatch d left join vehicle_request as r on r.id=d.request_id where d.dateStart>='".$request->from." 00:00:00' and d.dateStart<='".$request->to." 23:59:59' and d.unitId=".$request->unit;

                    // $fresult = "select * from issuance_request_tbl where processed_at>='".$request->from." 00:00:01' and processed_at<='".$request->to." 23:59:59' and vehicle_id=".$request->unit;   

                    // $frs = DB::select($fresult);            
                    // $fresult = FMSIssuanceRequest::where('processed_at','>=',$request->from.' 00:00:01')->where('processed_at','<=',$request->to.' 23:59:59')->where('vehicle_id','=',$v_id[0])->SWhere('vehicle_id','=',$v_id[1])->get();  

                    if ($request->unit != 'motor') {

                        $c = $v_id[0];
                        $d = $v_id[1];

                        $rs = DB::select($result);

                        $fresult = FMSIssuanceRequest::where('created_at', '>=', $request->from . ' 00:00:01')->where('created_at', '<=', $request->to . ' 23:59:59')->where(function ($query) use ($c, $d) {
                            $query->where('vehicle_id', '=', $c)
                                ->orWhere('vehicle_id', '=', $d);
                        })->get();
                    } else {

                        $rs = DB::select($result);

                        // dd(collect($rs)->pluck('id'));

                        // dd($rs->pluck('id'));

                        $data = array();

                        foreach ($rs as $r) {
                            $data[] = $r->id;
                        }

                        // dd($data);     

                        $fresult = FMSIssuanceRequest::whereIn('vehicle_id', $data)->where('created_at', '>=', $request->from . ' 00:00:01')->where('created_at', '<=', $request->to . ' 23:59:59')->get();
                    }

                    $weeknum = $request->weeknum;

                    $saveLogs = $this->reportService->create("Weekly", $request);
                    return view('admin.requests.reports.weekly-report', compact('weeks', 'unit', 'rs', 'weeknum', 'request', 'fresult', 'isMotor'));
                } else {
                    $result = "
                    select
                        d.tripTicket,
                        d.unitId,
                        d.type,
                        d.purpose,
                        d.Status,
                        r.refcode,
                        r.date_needed,
                        u.name,
                        u.plateno,
                        d.dateStart from
                        dispatch d left join vehicle_request as r on r.id=d.request_id
                        left join unit u on u.id=d.unitId
                    where 
                        d.dateStart>='" . $request->from . " 00:00:01' and d.dateStart<='" . $request->to . " 23:59:59'";
                    $rs = DB::select($result);

                    // $fresult= "select d.RQ, d.created_at, d.tripTicket, d.type, d.fuel_requested_qty, d.fuel_added_qty, d.purpose, d.unitId from dispatch d left join vehicle_request as r on r.id=d.request_id where d.dateStart>='".$request->from." 00:00:01' and d.dateStart<='".$request->to." 23:59:59'";

                    // $frs = DB::select($fresult);

                    $fresult = FMSIssuanceRequest::where('created_at', '>=', $request->from . ' 00:00:01')->where('created_at', '<=', $request->to . ' 23:59:59')->get();

                    $weeknum = $request->weeknum;
                    $saveLogs = $this->reportService->create("Weekly", $request);
                    return view('admin.requests.reports.weekly-report', compact('weeks', 'unit', 'rs', 'weeknum', 'request', 'fresult', 'isMotor'));
                }
            }
        } else {
            return view('admin.requests.reports.weekly-report', compact('weeks', 'unit', 'request', 'isMotor'));
        }
    }
    public function daily($dyt = null, Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Daily");
        if (!$rolesPermissions['view']) {
            abort(401);
        }
        if (!$dyt)
            $dyt = date('Y-m-d');
        $result = "
            select
            d.tripTicket,
            d.type,
            d.purpose,
            d.Status,
            r.refcode,
            r.date_needed,
            u.name,
            u.plateno,
            d.dateStart from
            dispatch d left join vehicle_request as r on r.id=d.request_id
            left join unit u on u.id=d.unitId
            where
        d.dateStart>='" . $dyt . " 00:00:00' and d.dateStart<='" . $dyt . " 23:59:59'";
        // dd($result);
        $rs = DB::select($result);
        $saveLogs = $this->reportService->create("Daily", $request);
        return view('admin.requests.reports.daily-report', compact('dyt', 'rs'));
    }
}
