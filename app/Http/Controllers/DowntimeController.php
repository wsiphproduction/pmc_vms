<?php

namespace App\Http\Controllers;

use App\Assigned;
use App\Downtime;
use App\Mechanic;
use App\Unit;
use App\UnitStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\RoleRightService;
use Carbon\Carbon;

class DowntimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Add downtime");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $mechanics = Mechanic::all();
        $mechanic_options = "<option value=''> - Select - </option>";
        $mechanic_option2 = '';

        foreach ($mechanics as $item) {
            $mechanic_options .= "<option value='" . $item['name'] . "'>" . $item['name'] . "</option>";
            $mechanic_option2 .= $item['name'] . ',';
        }

        $mechanic_option2 = rtrim($mechanic_option2, ',');

        $units = Unit::orderBy('type', 'ASC')
            ->orderBy('name', 'ASC')
            ->get();

        $assigned = Assigned::orderBy('name', 'ASC')
            ->get();

        $unitStatus = UnitStatus::orderBy('status', 'ASC')
            ->get();

        return view('admin.downtime.downtime_add', compact(
            'mechanic_option2',
            'mechanic_options',
            'units',
            'assigned',
            'unitStatus',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->get('act') == 'submitdowntime') {
            $mechanics = $request->input('mechanics');
            $mechanics = str_replace(",", "|", $mechanics);
            $start = str_replace("T", " ", $request->input('startd'));
            $end = str_replace("T", " ", $request->input('endd'));

            if (empty($request->input('from12'))) {
                $from12 = 0;
                $from7 = 0;
                $trepair_days = 0;
                $trepair_hours = 0;
                $shop_days = 0;
                $shop_hours = 0;
                $man_hours = 0;
                $tdowntime = 0;
                $required_daily_availability = 0;
            } else {
                $from12 = $request->input('from12');
                $from7 = $request->input('from7');
                $trepair_days = $request->input('trepair_days');
                $trepair_hours = $request->input('trepair_hours');
                $shop_days = $request->input('shop_days');
                $shop_hours = $request->input('shop_hours');
                $man_hours = $request->input('man_hours');
                $tdowntime = $request->input('tdowntime');
                $required_daily_availability = $request->input('required_daily_availability');
            }


            $repair_type = $request->input('dtype') == 1 ? $request->input('repairType1') : $request->input('repairType2');

            $addedBy = Session::get('esdvms_username');

            $downtime = new Downtime();
            $downtime->dateStart = str_replace('T', ' ', $request->input('startd'));
            $downtime->dateEnd = str_replace('T', ' ', $request->input('endd'));
            $downtime->remarks = $request->input('remarks');
            $downtime->addedBy = $addedBy;
            $downtime->addedDate = date('Y-m-d h:i:s');
            $downtime->unitId = $request->input('unit');
            $downtime->isScheduled = $request->input('dtype');
            $downtime->downtimeCategory = $request->input('dcategory');
            $downtime->workOrder = $request->input('work_order');
            $downtime->mechanics = $mechanics;
            $downtime->repairType = $repair_type;
            $downtime->workDetails = $request->input('work_details');
            $downtime->reportedDate = $request->input('reported_date');
            $downtime->status = $request->input('status');
            $downtime->from12 = $from12;
            $downtime->from7 = $from7;
            $downtime->trepair_days = $trepair_days;
            $downtime->trepair_hours = $trepair_hours;
            $downtime->shop_days = $shop_days;
            $downtime->shop_hours = $shop_hours;
            $downtime->man_hours = $man_hours;
            $downtime->required_daily_availability = $required_daily_availability;
            $downtime->tdowntime = $tdowntime;
            $downtime->assignedTo = $request->input('assignedTo');
            $downtime->active = 1;

            $downtime->save();
        }

        return redirect(route('downtime.create', ['act' => 'success']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $unit = Unit::all();

        $assigned = Assigned::all();
        $unitStatus = UnitStatus::all()->sortBy("status");
        $mechanics = Mechanic::all();

        $mechanic_options = "<option value=''> - Select -</option>";
        $mechanic_option2 = '';

        foreach ($mechanics as $item) {
            $mechanic_options .= "<option value='" . $item['name'] . "'>" . $item['name'] . "</option>";
            $mechanic_option2 .= $item['name'] . ',';
        }

        $mechanic_option2 = rtrim($mechanic_option2, ',');

        $result = Downtime::where('id', $id)
            ->get(['reportedDate as rd', 'dateStart as ds', 'dateEnd as de', 'downtime.*'])
            ->first();

        $crews = str_replace("|", ",", $result['mechanics']);
        //  dd($result);
        return view('admin.downtime.downtime_edit', compact('mechanic_option2', 'mechanic_options', 'unit', 'crews', 'assigned', 'result', 'unitStatus', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $mechanics = str_replace(",", "|", $request->input('mechanics'));
        $start = str_replace("T", " ", $request->input('startd'));
        $end = str_replace("T", " ", $request->input('endd'));
        $repair_type = $request->input('dtype') == 1 ? $request->input('repairType1') : $request->input('repairType2');
        $from12 = $request->has('from12') ? $request->input('from12') : 0;
        $from7 = $request->has('from7') ? $request->input('from7') : 0;
        $trepair_days = $request->has('trepair_days') ? $request->input('trepair_days') : 0;
        $trepair_hours = $request->has('trepair_hours') ? $request->input('trepair_hours') : 0;
        $shop_days = $request->has('shop_days') ? $request->input('shop_days') : 0;
        $shop_hours = $request->has('shop_hours') ? $request->input('shop_hours') : 0;
        $man_hours = $request->has('man_hours') ? $request->input('man_hours') : 0;
        $man_hours = $request->has('man_hours') ? $request->input('man_hours') : 0;
        $required_daily_availability = $request->has('required_daily_availability') ? $request->input('required_daily_availability') : 0;
        $downtime = $request->has('downtime') ? $request->input('downtime') : 0;


        $query = "
            update
                downtime
                set unitId = " . $request->input('unit') . ",
                dateStart = '" . $start . "',
                dateEnd = '" . $end . "',
                remarks = '" . $request->input('remarks') . "',
                workOrder =  '" . $request->input('work_order') . "',
                isScheduled = '" . $request->input('dtype') . "',
                mechanics = '" . $mechanics . "',
                repairType = '" . $repair_type . "',
                workDetails = '" . $request->input('work_details') . "',
                reportedDate = '" . $request->input('reported_date') . "',
                status = '" . $request->input('status') . "',
                from12 = '" . $from12 . "',
                from7 = '" . $from7 . "',
                trepair_days = '" . $trepair_days . "',
                trepair_hours = '" . $trepair_hours . "',
                shop_days = '" . $shop_days . "',
                shop_hours = '" . $shop_hours . "',
                man_hours = '" . $man_hours . "',
                required_daily_availability = '" . $required_daily_availability . "',
                tdowntime = '" . $downtime . "',
                assignedTo = '" . $request->input('assigned_to') . "',
                downtimeCategory = '" . $request->input('dcategory') . "'
            where 
                id = " . $id;
        DB::update($query);
        Session::flash('success', "Downtime Updated Successfully...");

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $downtime = Downtime::find($id);


        $downtime->update(['active' => 0]);

        Session::flash('success', "Downtime has been deleted... ");
        return redirect()->back();
        // return redirect()->route('form.dashboard');
    }

    public function downtimes(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Downtime List");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        if (!$request->has('startDate')) {
            $endDate = date('Y-m-d');
            $startDate = "2018-01-01";
            $query = "
            select
                d.dateStart as ds,
                d.dateEnd as de,
                d.reportedDate as reported,
                d.addedDate as added,
                d.*,
                u.name as uni,
                u.type
            from
                downtime d
            left join unit u on u.id = d.unitId
            where
            (
                (
                d.dateStart >= '" . $startDate . "'
                and d.dateEnd <= '" . $endDate . " 23:59:59'
                )
                OR (
                d.dateEnd >= '" . $startDate . "'
                and d.dateEnd <=  '" . $endDate . " 23:59:59' 
                )
            )
            and d.active = 1
            order by
            d.id desc";

            $downtimes = DB::select($query);

            return view('admin.downtime.downtimes', compact(
                'endDate',
                'startDate',
                'downtimes',
                'create',
                'edit',
                'delete',
                'print',
                'upload'
            ));
        }

        $startDate =  $request->input('startDate');
        $endDate = $request->input('endDate');
        $query = "
        select
            d.dateStart as ds,
            d.dateEnd as de,
            d.reportedDate as reported,
            d.addedDate as added,
            d.*,
            u.name as uni,
            u.type
        from
            downtime d
        left join unit u on u.id = d.unitId
        where
        (
            (
                d.dateStart >= '" . $startDate . "'
                and d.dateEnd <= '" . $endDate . " 23:59:59'
                )
                OR (
                d.dateEnd >= '" . $startDate . "'
                and d.dateEnd <=  '" . $endDate . " 23:59:59' 
                )
        )
        and d.active = 1
        order by
        d.id desc";

        $downtimes = DB::select($query);
        return view(
            'admin.downtime.downtimes',
            compact(
                'endDate',
                'startDate',
                'downtimes',
                'create',
                'edit',
                'delete',
                'print',
                'upload'
            )
        );
    }
}
