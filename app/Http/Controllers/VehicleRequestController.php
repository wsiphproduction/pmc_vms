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
use App\VehicleRequestMessage;
use App\Department;
use App\Unit;
use App\Drivers;
use App\Destination;
use App\Dispatch;
use App\RequestOtherInfo;
use App\Downtime;
use App\VehicleRequestComments;
use App\HRISAgusanDepartment;
use App\RequestRawData;

use App\Helper\Validators;
use App\Exports\VehicleRequestsExport;
use App\RequestLogs;
use Yajra\DataTables\DataTables;

use Maatwebsite\Excel\Facades\Excel;

use Exception;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

use Illuminate\Support\Facades\Session;
use App\Services\RoleRightService;
use App\Services\ReportService;

class VehicleRequestController extends Controller
{
    public function __construct(RoleRightService $roleRightService,
    ReportService $reportService)
    {
        $this->validator = new Validators();
        $this->roleRightService = $roleRightService;
		$this->reportService = $reportService;
    }

    public function list(Request $request, $item = null)
    {
        // dd('sample');
        $rolesPermissions = $this->roleRightService->hasPermissions("Request List");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];



        $localDept = Department::get();
        $hrisDept = HRISAgusanDepartment::select(DB::raw('DISTINCT DeptDesc as name'))->orderBy('DeptDesc', 'asc')->get();
        $departments = array_merge($localDept->toArray(), $hrisDept->toArray());
        if (Auth::user()->role != 'requestor') {
            $requests = VehicleRequest::orderBy('id', 'desc')
                ->with([
                    'department',
                    'message',
                    'tripTicket',
                    'tripTicket.driver'
                ]);
        } else {

            $requests = VehicleRequest::where('dept', Auth::user()->dept)->orderBy('id', 'desc')
                ->with([
                    'department',
                    'message',
                    'tripTicket',
                    'tripTicket.driver'
                ]);
        }

        $page = $request->get('page');
        if (isset($page)) {
            $requests = $requests->paginate(10);
        } else {
            // $requests = $requests->get();
            $requests = $requests->paginate(10);
        }
        // dd($requests);
        return view('admin.requests.request_list2', [
            'route' => 'vehicle.request.all',
            'dept' => $departments,
            'page_module' => 'ECS Vehicle Request',
            'requests' => $requests,
            'page' => $page,
            'isAdd' => $item,
            'create' => $create,
            'edit' => $edit,
            'delete' => $delete,
            'print' => $print,
            'upload' => $upload
        ]);
    }

    public function changeStatus(Request $request)
    {
        try {
            
            $vehicle_request = VehicleRequest::findOrFail($request->get('cs_id'));
            $vehicle_request->status = $request->get('cs_status');
            $vehicle_request->lastStatusChangedBy = Session::get('esdvms_username');
            $vehicle_request->lastStatusChanged = date('Y-m-d H:i:s');
            $vehicle_request->updated_at = date('Y-m-d H:i:s');
            $vehicle_request->updated_by = Session::get('esdvms_username');

            if ($request->get('cs_id') == 'Cancelled') {
                $vehicle_request->isNotEditable = 1;
            }

            $vehicle_request->save();

            return response()->json([
                'message' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Vehicle Request not found'
            ], 404);
        }
    }

    public function getComments(Request $request)
    {
        $id = $request->get('id');

        $query = VehicleRequestComments::selectRaw(' username, comment, AddedAt as Added')
            ->where('request_id', $id)
            ->orderBy('AddedAt', 'desc')
            ->get();

        $comments = '
            <h3 class="list-heading" id="msg_refcode">' . $this->makeRefCode($id) . '</h3>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <textarea name="msg_chat" id="msg_chat" class="form-control margin-bottom-10" placeholder="New Message" cols="30" rows="5"></textarea>
                    <span class="label label-sm label-danger " id="msg_error"></span>
                    <a href="#" class="btn green btn-sm pull-right" onclick=\'send_comment($("#msg_chat").val(), ' . $id . ');\'>Send Message</a>
                </div>
            </div>
            
            <ul class="feeds list-items">
        ';

        foreach ($query as $comment) {

            $comments .= '
            <li>
                <div class="col1">                    
                    <div class="desc">
                        <span class="label label-sm label-danger ">' . $comment->username . ' - ' . $this->time_elapsed_string($comment->Added) . '</span>
                        ' . $comment->comment . '
                    </div>                       
                </div>                
            </li>
        ';
        }

        return response($comments);
    }

    public function commentChat(Request $request)
    {
        $id = $request->get('id');

        $comments = '<h3 class="list-heading" id="msg_refcode">' . $this->makeRefCode($id) . '</h3>
        <input type="hidden" name="msg_id" id="msg_id">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <textarea name="msg_chat" id="msg_chat" class="form-control margin-bottom-10" placeholder="New Message" cols="30" rows="5"></textarea>
                <span class="label label-sm label-danger " id="msg_error"></span>
                <a href="#" class="btn green btn-sm pull-right" onclick=\'send_comment($("#msg_chat").val(), ' . $id . ');\'>Send Message</a>
            </div>
        </div>';

        return response($comments);
    }

    public function commentSave(Request $request)
    {
        $username = Session::get('esdvms_username');
        $requestor_username = Session::get('esdvms_requestor_username');

        $user = (isset($username) ? $username : $requestor_username);
        $comment = new VehicleRequestComments();
        $comment->request_id = $request->get('id');
        $comment->username = $user;
        $comment->AddedAt = Carbon::now();
        $comment->comment = $request->get('txt');
        $comment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment saved'
        ]);
    }

    public function commentLast(Request $request)
    {
        $id = $request->get('id');

        $query = VehicleRequestComments::where('request_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        return response($query->comment);
    }

    public function vehicleRequestRawData(Request $request)
    {

        //$raw = [];

        // $requests = null;

        // $start = $request->has('start');
        // $end = $request->has('end');

        // if( $start || $end) {
        //   $requests = VehicleRequest::orderBy('id', 'desc')
        // ->with([
        //  'tripTicket',
        // 'tripTicket.driver'
        //  ])
        //   ->whereBetween('created_at', [$start, $end])
        //  ->get();
        //  }

        // else{
        //     $requests = VehicleRequest::orderBy('id', 'desc')
        //    ->with([
        //  'tripTicket',
        // 'tripTicket.driver:id',
        //  'tripTicket.unit:id,type'
        // ])
        //  ->get();
        //  }

        // return response()->json($requests);
        // if(!$requests->isEmpty()){
        //   $requests->each(function($data){

        // $data->date_needed = Carbon::parse($data->date_needed)->format('m/d/Y');
        //$data->date_needed_time = Carbon::parse($data->date_needed)->format('h:i A');   

        // if(isset($data->tripTicket)){
        //$data->tripTicket->dateStart_time = isset($data->tripTicket->dateStart) ? Carbon::parse($data->tripTicket->dateStart)->format('h:i A') : '';
        // $data->tripTicket->dateStart = isset($data->tripTicket->dateStart) ? Carbon::parse($data->tripTicket->dateStart)->format('m/d/Y') : '';

        //           $data->tripTicket->dateEnd_time = isset($data->tripTicket->dateEnd) ? Carbon::parse($data->tripTicket->dateEnd)->format('h:i A') : '';
        //          $data->tripTicket->dateEnd = isset($data->tripTicket->dateEnd) ? Carbon::parse($data->tripTicket->dateEnd)->format('m/d/Y') : '';
        //       }
        //    });
        // }
        
		$rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Request Raw Data");
		if (!$rolesPermissions['view']) {
		    abort(401);
		}
        $raw = [];

        $requests = null;

        $start = $request->input('start');
        $end = $request->input('end');



        if ($start || $end) {
            $requests = RequestRawData::where('dateStart', '>', $start . ' 00:00:00.000')->where('dateStart', '<',  $end . ' 23:59:59.999')->get();
        } else {
            $requests = RequestRawData::get();
        }

        $saveLogs = $this->reportService->create("Vehicle Request Raw Data", $request);
        return view('admin.requests.reports.requests_raw_data', compact('requests', 'start', 'end'));
    }

    public function tripTicket($id, Request $request)
    {
     
        // dd($request);
        $vehicle_request = VehicleRequest::where('id', $id)
            ->with(['department', 'requestOtherInfo'])
            ->first();
        
        $fuel_types = FuelTypes::all();
        $units = Unit::all();
        $drivers = Drivers::where('isActive', '<>', '1')->Orwhere('isActive', null)->get()->sortBy('driver_name');

        // $drivers = Drivers::all();

        $available_units = '<option selected="selected">-- Select Vehicle --</option>';
        $unavailable_units = '';

        if (strlen($vehicle_request->date_needed) <= 14) { //example when '2020-11-01.000' this would cause Failed to parse time string
            $date_needed = explode(".", $vehicle_request->date_needed);
            $date_needed = Carbon::parse($date_needed[0])->format('Y-m-d 00:00:10');
        } else {
            $date_needed = Carbon::parse($vehicle_request->date_needed)->format('Y-m-d h:i:s');
        }
        
        foreach ($units as $item) {

            $query = "SELECT * FROM downtime WHERE status <> 'Cancelled' AND unitId = " . $item->id . " and '" . $date_needed . "' BETWEEN dateStart AND dateEnd";
            $result = DB::select($query);

            if ($result) {
                // $unavailable_units .= "<option disabled value=".$item->id."|".$item->name.">".$item->name." - ".$result['repairType']."</option>";
                $unavailable_units .= "<option disabled value='" . $item->id . "|" . $item->name . "'>" . $item->name . " - " . $result['repairType'] . "</option>";
            } else {
                // $available_units .= "<option value=".$item->id."|".$item->name."|".$item->vehicle_code.">".$item->name."</option>";
                $available_units .= "<option value='" . $item->id . "|" . $item->name . "|" . $item->vehicle_code . "'>" . $item->name . "</option>";
            }
            // return redirect()->route('vehicle.request.list');
        }

        return view('admin.requests.trip_ticket.dispatch_add', [
            'page_module' => 'ECS Vehicle Requests',
            'id' => sprintf('WR-%06d', $id),
            'request' => $vehicle_request,
            'fuel_types' => $fuel_types,
            'units' => $units,
            'drivers' => $drivers,
            // 'destination' => $destination,
            'status' => $vehicle_request->status,
            'unavailable_units' => $unavailable_units,
            'available_units' => $available_units
        ]);
    }

    public function get($id, Request $request)
    {
        $vehicleRequest = VehicleRequest::where('id', $id)
            ->with([
                'requestOtherInfo'
            ])
            ->first();

            

        $dispatch = DB::select("select d.*,u.type,u.name as vehicle,dr.driver_name,CONVERT(VARCHAR(19),d.dateStart) as datestarted from dispatch d left join unit u on u.id=d.unitId left join drivers dr on dr.id=d.driver_id where d.request_id=" . $id);
        $color = "";
        if ($dispatch) {
            if ($dispatch[0]->Status == 'Completed' || $dispatch[0]->Status == 'Cancelled') {
                if ($dispatch[0]->Status == 'Completed') {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
            } else {
                if ($dispatch[0]->Status == 'Closed') {
                    $color = 'red';
                } else {
                    if ($dispatch[0]->isPrinted == 1) {
                        $color = 'yellow';
                    } else {
                        $color = 'blue';
                    }
                }
            }
        }

        $comments = FacadesDB::table('vehicle_request_comments')
            ->select('AddedAt as added')
            ->where('vehicle_request_comments.request_id', $id)
            ->orderBy('AddedAt', 'DESC')
            ->get();

        // select * from request_logs where request_id='".$_GET['id']."' order by id desc

        $logs = RequestLogs::where('request_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        if (isset($vehicleRequest)) {
            return view('admin.requests.request_review', compact('vehicleRequest', 'dispatch', 'comments', 'logs', 'color'));
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Vehicle Request not found'
        ], 404);
    }

    public function create(Request $request)
    {
        $inputs = $request->only([
            'dept',
            'date_needed',
            'purpose',
            'costCode'
        ]);

        try { // Validate inputs using static variable rules
            $this->validator->validateInputs($inputs, VehicleRequest::$rules_create, 'VehicleRequest');
        } catch (Exception $e) { // Validation error will be caught then turned to ajax response
            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage()
            ], 400);
        }

        if (isset($request->new_dept)) {
            $department = new Department();
            $department->name = $request->new_dept;
            $department->save();

            $inputs['dept'] = $request->new_dept;
        }
        
        $vehicleR = VehicleRequest::create($inputs);
        $vehicleR->dept = (strlen($request->get('dept')) > 0 ? $request->get('dept') : $request->get('new_dept'));
        $vehicleR->dept_id = 0;
        $vehicleR->status = VehicleRequestStatusEnum::NEW_REQUEST;
        //$vehicleR->lastStatusChanged = Carbon::now();
        // $vehicleR->lastStatusChanged = date('Y-m-d H:i:s');
        $vehicleR->lastStatusChanged = date('Y-m-d');
        $vehicleR->save();

        return redirect()->route('vehicle.request.list');
    }   

    public function createWithDestination(Request $request)
    {
    
        $vehicle_request = new VehicleRequest();
        $vehicle_request->name = Auth::user()->domain;
        $vehicle_request->dept = (strlen($request->get('dept_input')) > 0 ? $request->get('dept_input') : $request->get('dept_select')); 
        $vehicle_request->date_needed = date('Y-m-d', strtotime($request->get('date_needed'))). ' 00:00:10';
        // $vehicle_request->date_needed = Carbon::parse($request->get('date_needed'))->toDateTimeString();
        // dd($vehicle_request);1
        $vehicle_request->purpose = $request->get('purpose');
        $vehicle_request->costcode = $request->get('costcode');
        $vehicle_request->addedBy = Auth::user()->domain;
        $vehicle_request->addedAt = date('Y-m-d');
        $vehicle_request->status = 'New Request';
        $vehicle_request->lastStatusChanged = date('Y-m-d');
        $vehicle_request->lastStatusChangedBy = Auth::user()->domain;
        $vehicle_request->dept_id = 0;
        $vehicle_request->save();

        if ($request->get('dept_input') && !$request->get('dept_select')) {
            $count = Department::where('name', $request->get('dept_input'))->count();
            if ($count <= 0) {
                $deptTbl = new Department();
                $deptTbl->name = $request->get('dept_input');
                $deptTbl->save();
                
            }
        }
        
        if ($request->get('di_deliverysite') == 'Other') {
            $destination = new Destination();
            $destination->name = $request->get('di_otherd');
        }

        $others = new RequestOtherInfo();
        $others->request_id = $vehicle_request->id;
        $others->contact_person = $request->get('di_contactperson');
        $others->contact_person = $request->get('fullname');
        $others->designation = $request->get('di_designation');
        $others->designation = $request->get('position');
        $others->dept = $request->get('di_dept');
        $others->dept = $request->get('department');
        $others->contact_no = $request->get('di_contactno');
        $others->delivery_site = $request->get('di_deliverysite');
        $others->other_instructions = $request->get('di_instruction');
        $others->pickup_dept = $request->get('pi_dept');
        $others->pickup_location = $request->get('pi_location');
        $others->save();

        $vehicle_request->refcode = $this->makeRefCode($vehicle_request->id);
        $vehicle_request->save();

       
        return redirect()->route('vehicle.request.list');
    }
    
    public function update(Request $request)
    {
        \Log::info(json_encode($request->all()));
        
        // dd($request);
        $vehicle_request = VehicleRequest::where('id', $request->id_edit)->with([
                'requestOtherInfo'
            ])->first();
            // dd($request->date_needed_edit);
        if (isset($vehicle_request)) {
            $vehicle_request->dept = $request->dept_select_edit;
            $vehicle_request->date_needed = $request->date_needed_edit;
            $vehicle_request->purpose = $request->purpose_edit;
            $vehicle_request->costcode = $request->costcode_edit;
            $vehicle_request->save();

            $vehicle_request->requestOtherInfo->contact_person = $request->di_contactperson_editq;
            $vehicle_request->requestOtherInfo->contact_person = $request->e_fullname;
            $vehicle_request->requestOtherInfo->contact_no = $request->di_contactno_edit;
            // $vehicle_request->requestOtherInfo->designation = $request->di_designation_edit;
            $vehicle_request->requestOtherInfo->designation = $request->e_position;
            // $vehicle_request->requestOtherInfo->dept = $request->di_dept_edit;
            $vehicle_request->requestOtherInfo->dept = $request->e_department;
            $vehicle_request->requestOtherInfo->delivery_site = $request->di_deliverysite_edit;
            $vehicle_request->requestOtherInfo->other_instructions = $request->di_instruction_edit;
            $vehicle_request->requestOtherInfo->pickup_dept = $request->pi_dept_edit;
            $vehicle_request->requestOtherInfo->pickup_location = $request->pi_location_edit;
            $vehicle_request->requestOtherInfo->save();

            DB::commit();
            return redirect()->to('/vehicle/request/list');
        } else {
            return redirect()->to('/vehicle/request/list?error=true');
        }
    }


    public function getRequests(Request $request)
    {
        $requests = VehicleRequest::orderBy('id', 'desc')->with([
                'department',
                'message',
                'tripTicket'
            ]);

        // return Datatables::of($requests)
        //     ->editColumn('id', function($request){
        //         return sprintf('WR-%06d', $request->id);
        //     })
        //     ->addColumn('last_message', function($request){
        //         return $request->message->message ?? '';
        //     })
        //     ->addColumn('action', function($request){
        //         $actions = '';

        //         if($request->status == VehicleRequestStatusEnum::NEW_REQUEST){
        //             $actions = '<a value='.$request->id.' href="#" class="btn yellow btn-xs edit-btn"><i class="fa fa-edit"></i></a>
        //                     <a value='.$request->id.' href='.route("vehicle.request.cancel", $request->id).' class="btn red btn-xs"><i class="fa fa-minus-circle"></i></a>
        //                     <a value='.$request->id.' href='.route("vehicle.request.dispatch", $request->id).' class="btn green btn-xs"><i class="fa fa-plus-square"></i></a>
        //                     <a value='.$request->id.' href="#" class="btn purple btn-xs comment-action-btn"><i class="fa fa-comments-o"></i></a>';
        //         }

        //         elseif($request->status == VehicleRequestStatusEnum::SCHEDULED){
        //             $actions = '<a value='.$request->id.' href='.route("vehicle.request.dispatch", $request->id).' class="btn green btn-xs"><i class="fa fa-plus-square"></i></a>
        //                     <a value='.$request->id.' href="#" class="btn purple btn-xs comment-action-btn"><i class="fa fa-comments-o"></i></a>';
        //         }

        //         elseif($request->status == VehicleRequestStatusEnum::CANCELLED){
        //             $actions = '<a value='.$request->id.' href="#" class="btn purple btn-xs comment-action-btn"><i class="fa fa-comments-o"></i></a>';
        //         }

        //         return $actions;
        //     })
        //     ->addColumn('tripTicket', function($request){
        //         $ticket_el = '';
        //         $ticket = $request->tripTicket;

        //         if(isset($ticket)){
        //             if($ticket->Status == DispatchStatusEnum::NEW_TICKET){
        //                 $ticket_el.= '<button class="btn btn-info btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::TICKET_PRINTED){
        //                 $ticket_el.= '<button class="btn btn-warning btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::COMPLETE){
        //                 $ticket_el.= '<button class="btn btn-success btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::CANCELLED){
        //                 $ticket_el.= '<button class="btn btn-danger btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //         }

        //         return $ticket_el;
        //     })
        // ->addColumn('tripTicket', function($request){
        //     $tickets = $request->tripTicket;
        //     $ticket_el = '';

        //     // dd($request->tripTicket);
        //     if(!is_null($tickets)){
        //         foreach($tickets as $ticket){
        //             if($ticket->Status == DispatchStatusEnum::NEW_TICKET){
        //                 $ticket_el.= '<button class="btn btn-info btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::TICKET_PRINTED){
        //                 $ticket_el.= '<button class="btn btn-warning btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::COMPLETE){
        //                 $ticket_el.= '<button class="btn btn-success btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }

        //             elseif($ticket->Status == DispatchStatusEnum::CANCELLED){
        //                 $ticket_el.= '<button class="btn btn-danger btn-sm uk-margin-small-left">'.$ticket->tripTicket.'</button>';
        //             }
        //         }
        //     }

        //     return $ticket_el;
        // })
        // ->make(true);
    }

    public function createMessage($id, Request $request)
    {
        $msg = $request->message;

        $message = new VehicleRequestMessage();
        $message->vehicle_request_id = $id;
        $message->message = $msg;
        $message->save();

        return redirect()->to('/vehicle/request/list');
    }
    
    public function cancelRequest($id, Request $request)
    {
      
        $vehicle_request = VehicleRequest::where('id', $id)->first();
        
        $vehicle_request->status = VehicleRequestStatusEnum::CANCELLED;
       
        $vehicle_request->save();

       
        $tripticket_request = Dispatch::where('request_id', $vehicle_request->id)->update([
            'status' => 'Cancelled',
            'Cancelled_by' => Auth::user()->domain,
            'Cancelled_at' => date('m/d/Y h:i:s a')
        ]);
        
        return redirect()->to('/vehicle/request/list');
    }

    public function exportRequests()
    {
        return (new VehicleRequestsExport)->download('vehicle_request.xlsx');
    }



    private function makeRefCode($id)
    {
        $r = '';
        for ($i = 1; $i <= (6 - strlen($id)); $i++) {
            $r .= "0";
        }

        return "WR-" . $r . $id;
    }

    private function time_elapsed_string($datetime, $full = false)
    {
        date_default_timezone_set("Asia/Manila");
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function tripcompleted($id)
    {

        $dispatch = Dispatch::where('tripTicket', $id)->first();
        $vehicle_request = VehicleRequest::where('id', $dispatch->request_id)->first();
        $unit = Unit::where('id', $dispatch->unitId)->first();
        $driver = Drivers::where('id', $dispatch->driver_id)->first();
        
        if ($dispatch->fuel_added_qty == null || $dispatch->fuel_added_qty == 0) {
            $dispatch->fuel_added_qty = 1;
        }

        $total = ($dispatch->odometer_end - $dispatch->odometer_start) / $dispatch->fuel_added_qty;
        $total = number_format((float) $total, 4, '.', '') . ' Km per Liter';

        return view('admin.requests.trip_completed', compact('dispatch', 'vehicle_request', 'unit', 'driver', 'id', 'total'));
    }
    public function tripcompleted_addDispatch($id)
    {

        $dispatch = Dispatch::where('request_id', $id)->first();
        $vehicle_request = VehicleRequest::where('id', $dispatch->request_id)->first();
        $unit = Unit::where('id', $dispatch->unitId)->first();
        $driver = Drivers::where('id', $dispatch->driver_id)->first();  
        if ($dispatch->fuel_added_qty == null || $dispatch->fuel_added_qty == 0) {
            $dispatch->fuel_added_qty = 1;
        }

        $total = ($dispatch->odometer_end - $dispatch->odometer_start) / $dispatch->fuel_added_qty;
        $total = number_format((float) $total, 4, '.', '') . ' Km per Liter';

        return view('admin.requests.trip_completed', compact('dispatch', 'vehicle_request', 'unit', 'driver', 'id', 'total'));
    }

    
    public function dispatchDetails($id, Request $request)
    {
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Request List");

        if (!$rolesPermissions['edit']) {   
            abort(401);
        }
        $dispatch = Dispatch::where('tripTicket', $id)->first();
        $drivers = Drivers::where('id', $dispatch['driver_id'])->first();

        $origin = "";
        $destination = "";
        
        if ($dispatch->destination) {
            if (strpos($dispatch->destination, '|') !== false) {
                $travel = explode('|', $dispatch->destination);
                $origin = $travel[1];
                $destination = $travel[1];
            } else { //if one either array 1 or array 2 is empty. set both destination and origin to same value
                $origin = ($destination) ? $destination : $origin;
                $destination = ($origin) ? $origin : $destination; 
            }
        } else {
            $origin = "";
            $destination = "";
        
        }

        $passengers = explode('|', $dispatch->passengers);

        $cancelled = ($dispatch->Status == 'Cancelled' || $dispatch->Status == 'Closed') ? 'none;' : '';

        return view('admin.requests.dispatch.dispatch_details', compact('dispatch', 'drivers', 'origin', 'destination', 'passengers', 'id', 'cancelled'));
    }

    public function cancelDispatchDetails(Request $request)
    {
        
        $tinId = $request->input('tid');
        $date_cancelled = date('Y-m-d h:i:s a');
        $dispatch = Dispatch::where('tripTicket', $tinId)->update([
            'Status' => 'Cancelled',
            'Cancelled_by' => Session::get('esdvms_username'),
            'Cancelled_at' => $date_cancelled,
        ]);

        if ($dispatch) {
            Session::flash('success', 'Trip Ticket Succesfully <b>Cancelled</b>...');
        }

        if (!$dispatch) {
            Session::flash('error', 'Trip Ticket <b>Cancellation</b> Failed...');
        }


        return redirect()->back();
    }

    public function editDispatchDetails($id, Request $request)
    {
        return view('admin.requests.dispatch.dispatch_edit', compact('id'));
    }

    public function updateDispatchDetails($id, Request $request)
    {
        try {

            if ($request->has('dispatch_edit')) {
                $unit = null;
                $type = null;

                $ticket = $request->input('ticket_no') ?? null;
                $department = $request->input('department') ?? null;
                $v_type = $request->input('vehicle') ?? null;

                if ($v_type) {
                    $ex = explode('|', $v_type);
                    $unit = trim($ex[0], ' ');
                    $type = $ex[1];
                }

                $vcode = $request->input('cost_code') ?? null;
                $app_date = $request->input('app_date') ?? null;
                $origin = $request->input('origin') ?? null;
                $destination = $request->input('destination') ?? null;
                $dest = $origin . '|' . $destination;
                $purpose = $request->input('purpose') ?? null;
                $pass = '';
                //$driverId = $request->input('driver') ?? null;

                if ($request->has('passengers')) {
                    $p = '';
                    $passengers = $request->input('passengers');

                    foreach ($passengers as $item) {
                        $p .= strtoupper($item . "|");
                        $pass = rtrim($p, '|');
                    }
                }

                $odom_s = $request->input('odom_start') ?? null;

                $result = DB::table('dispatch')->where('tripTicket', $ticket)->update([
                    'odometer_start' => $odom_s,
                    'deptId' => $department,
                    'type' => $type,
                    'destination' => $dest,
                    'purpose' => $purpose,
                    'passengers' => $pass,
                    'dateStart' => $app_date,
                    'vehicle_cost_code' => $vcode,
                    'unitId' => $unit,
                    //'driver_id' => $driverId
                ]);

                if ($result) {
                    Session::flash('success', "Success!</strong> Dispatch details <b>Updated</b>...");
                } else {
                    Session::flash('error', "Error!</strong> Dispatch <b>Updation</b> Failed...");
                }

                return redirect()->back();
            } elseif ($request->has('return_edit')) {

                $request_id = $request->input('request_id') ?? null;
                $odom_e = $request->input('odom_end') ?? null;
                $odom_s = $request->input('odom_startn') ?? null;
                $ticket = $request->input('ticket_no') ?? null;

                $return_dt = null;
                if ($request->input('return_date')) {
                    $rdate = explode(' ', $request->input('return_date'));
                    $return = $rdate[0] . ' ' . $request->input('return_time');
                    $return_dt = date('Y-m-d H:i', strtotime($return));
                }

                $numberOfTrips = $request->input('numberOfTrips') ?? null;
                $close = Session::get('esdvms_username');
                $closed_at = date('Y-m-d h:i:s a') ?? null;

                $result = DB::table('dispatch')->where('tripTicket', $ticket)->update([
                    'odometer_end'      => $odom_e,
                    'odometer_start'    => $odom_s,
                    'dateEnd'           => $return_dt,
                    'Closed_by'         => $close,
                    'Closed_at'         => $closed_at,
                    'numberOfTrips'     => $numberOfTrips
                ]);

                if ($result) {
                    DB::table('dispatch')->where('tripTicket', $id)->update([
                        'Status' => 'Completed'
                    ]);

                    $resultCount1 = DB::table('dispatch')->where('request_id', $request_id)->count();
                    //$resultCount2 = DB::table('dispatch')->where('request_id', $request_id)->where('Status','Closed')->count();
                    $resultCount2 = DB::table('dispatch')->where('request_id', $request_id)->where('Status', 'Completed')->count();

                    if ($resultCount1 == $resultCount2) {
                        DB::table('vehicle_request')->where('id', $request_id)->update([
                            'Status'    => 'Closed', 'lastStatusChanged' => date('Y-m-d H:i:s')
                        ]);
                    }
                }

                return redirect()->back();
            }
        } catch (\Exception $e) {
            $message['error'] = $e->getMessage();
            $message['line'] = $e->getLine();
            dd($message);
        }
    }

    /**
     * 
     * Added Try catch for easier debug
     */

    public function editDispatchDetailsForm($id, Request $request)
    {
        $i = 0;
        try {

            $origin = "";
            $destination = "";

            $dispatch = Dispatch::where('tripTicket', $id)->first();
            $vehicleRequest = VehicleRequest::where('id', $dispatch['request_id'])->first();
            $drivers = Drivers::where('id', $dispatch['driver_id'])->first();
            $activeDrivers = Drivers::where('isActive', null)->orWhere('isActive', 1)->orderBy('type')->get();
            $passengers = explode('|', $dispatch['passengers']);

            if ($dispatch['destination'] && strpos($dispatch['destination'], '|') !== false) {
                $travel = explode('|', $dispatch['destination']);
                $origin = $travel[0];
                $destination = $travel[1];
            }

            $isReadOnly = ($dispatch['isPrinted'] == 1) ? 'readonly' : '';
            $isPrinted = ($dispatch['isPrinted'] == 1) ? '' : 'readonly';

            $history = Dispatch::where('unitId', $dispatch['unitId'])
                ->where('Status', 'Completed')
                ->orderBy('id', 'DESC')
                ->first();

            $available_units = "<option value=" . $dispatch['id'] . "|" . $dispatch['type'] . ">" . $dispatch['type'] . "</option>";
            $unavailable_units = '';
            $in_used_units = '';
            $units = Unit::all();

            foreach ($units as $item) {
                $i++; //debugging

                $downtimeQuery = "SELECT * FROM DOWNTIME WHERE Status != 'CANCELLED' AND unitId=" . $item->id . " AND " . "'" . Carbon::parse($vehicleRequest['date_needed'])->format('Y-m-d h:i:s') . "'" . " between dateStart AND dateEnd";

                $check_if_down = DB::select($downtimeQuery);

                if ($check_if_down) {
                    $unavailable_units .= "<option disabled value=" . $item->id . "|" . $item->name . ">" . $item->name . " - " . $check_if_down['repairType'] . "</option>";
                } else {
                    $query = "SELECT * FROM DISPATCH WHERE STATUS NOT IN ('Cancelled','Completed','Closed') AND unitId=" . $item->id . " AND " . "'" . Carbon::parse($vehicleRequest['date_needed'])->format('Y-m-d h:i:s') . "'" . " BETWEEN dateStart AND ISNULL(dateEnd,DATEADD(hour,5,dateStart));";

                    $check_if_no_booking = DB::select($query);

                    if ($check_if_no_booking) {
                        $in_used_units .= "<option disabled value=" . $item->id . "|" . $item->name . ">" . $item->name . '(' . $check_if_no_booking[0]->tripTicket . ')</option>';
                    } else {
                        $hquery = "SELECT TOP 1 odometer_end FROM dispatch WHERE unitId=" . $item->id . " and id <> " . $dispatch['id'] . " and Status <> " . "'" . "Cancelled" . "'" . " ORDER BY odometer_end DESC";
                        $odometer_end = DB::select($hquery);
                        if (isset($odometer_end[0])) {
                            $available_units .= '<option value="' . $item->id . '|' . $item->name . '|' . $item->vehicle_code . '" title="' . $odometer_end[0]->odometer_end . '">' . $item->name . '</option>';
                        }
                    }
                }
            }

            return view(
                'admin.requests.dispatch.dispatch_edit_form',
                compact('id', 'history', 'destination', 'origin', 'isReadOnly', 'isPrinted', 'dispatch', 'vehicleRequest', 'drivers', 'activeDrivers', 'passengers', 'in_used_units', 'unavailable_units', 'available_units')
            );
        } catch (\Exception $e) {
            $message['error'] = $e->getMessage();
            $message['line'] = $e->getLine();
            $message['unitloop'] = $i;
            // dd($message);
        }
    }

    public function requestDetails(Request $request, $id)
    {
        $vehicle_request_query = 'SELECT *,CONVERT(nvarchar(MAX), date_needed, 20) AS need FROM vehicle_request WHERE id=' . $id;
        $request_other_info_query = 'SELECT * FROM request_other_info WHERE request_id=' . $id;
        
        $vehicle_request = DB::select($vehicle_request_query);
       
        $request_other_info = DB::select($request_other_info_query);

        if ($vehicle_request) {
            $vehicle_request[0]->request_id = $request_other_info[0]->request_id;
            $vehicle_request[0]->contact_person = $request_other_info[0]->contact_person;
            $vehicle_request[0]->designation = $request_other_info[0]->designation;
            $vehicle_request[0]->depti = $request_other_info[0]->dept;
            $vehicle_request[0]->contact_no = $request_other_info[0]->contact_no;
            $vehicle_request[0]->delivery_site = $request_other_info[0]->delivery_site;
            $vehicle_request[0]->other_instructions = $request_other_info[0]->other_instructions;
            $vehicle_request[0]->pickup_dept = $request_other_info[0]->pickup_dept;
            $vehicle_request[0]->pickup_location = $request_other_info[0]->pickup_location;
            $vehicle_request[0]->need = date('Y-m-d H:i', strtotime($vehicle_request[0]->need));
        }

        return $vehicle_request;
    }

    public function dispatchPrintout(Request $request, $id)
    {
        
        
        $query1 = "SELECT di.*, dr.driver_name FROM dispatch AS di LEFT JOIN drivers AS dr ON di.driver_id = dr.id WHERE tripTicket = '" . $id . "'";
        $dispatch = DB::select($query1);

        $query2 = "UPDATE dispatch SET isPrinted = 1 WHERE tripTicket = '" . $dispatch[0]->tripTicket . "'";
        DB::statement($query2);

        $query3 = "SELECT * FROM unit WHERE id = " . $dispatch[0]->unitId;
        $unit = DB::select($query3);

        $query4 = "SELECT * FROM vehicle_request WHERE id = " . $dispatch[0]->request_id;
        $vehicle_request = DB::select($query4);

        $query5 = "SELECT * FROM request_other_info WHERE request_id = " . $vehicle_request[0]->id;
        $request_other_info = DB::select($query5);

        $query6 = "SELECT fullname FROM users WHERE domain = '" . Session::get('esdvms_username') . "'";
        $users = DB::select($query6);

        $date_needed = '';
        $date_start = '';

        if ($vehicle_request[0]->date_needed) {
            $date_needed = Carbon::parse($vehicle_request[0]->date_needed)->format('Y-m-d');
        } else {
            $date_needed = '';
        }
        if ($dispatch[0]->dateStart && strlen($dispatch[0]->dateStart) >= 14) {
            $date_start = Carbon::parse($dispatch[0]->dateStart)->format('Y-m-d');
        } else {
            $date_start = '';
        }

        $return_date = $dispatch[0]->dateEnd == NULL ? '____________________________' :  Carbon::parse($dispatch[0]->dateEnd)->format('Y-m-d');
        // dd($odo_end);
        $odo_end = $dispatch[0]->odometer_end == NULL ? '____________________________' : $dispatch[0]->odometer_end;

        return view('admin.requests.dispatch.dispatch_printout', compact('id', 'return_date', 'odo_end', 'date_needed', 'date_start', 'dispatch', 'unit', 'vehicle_request', 'request_other_info', 'users'));
    }
}
