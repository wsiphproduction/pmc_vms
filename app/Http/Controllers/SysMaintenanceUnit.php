<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Department;
use App\HRISAgusanDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SysMaintenanceUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->plateno!=null || $request->plateno!='') {                
            if (Auth::user()->dept == 'TECHNICAL SERVICES GROUP' || Auth::user()->dept == 'CIVIL WORKS') {
                $units = Unit::where('isECS',null)->where('plateno',$request->plateno)->get();
            } else {
                $units = Unit::where('plateno',$request->plateno)->get();
            }            
        } else {
            if (Auth::user()->dept == 'TECHNICAL SERVICES GROUP' || Auth::user()->dept == 'CIVIL WORKS') {
                $units = Unit::where('isECS',null)->get();
            } else {
                $units = Unit::get();
            }       
        }
        $localDept = Department::get();
        $hrisDept = HRISAgusanDepartment::select(DB::raw('DISTINCT DeptDesc as name'))->orderBy('DeptDesc', 'asc')->get();
        $departments = array_merge($localDept->toArray(), $hrisDept->toArray());
        $dept = $departments;
        return view('admin.maintenance.unit',compact('units','dept'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isECS = '';
        if  (($request->department == 'CIVIL WORKS') ||
            ($request->department == 'MINE CIVIL WORKS') ||
            ($request->department == 'CIVIL WORKS & ROAD MAINTENANCE') ||
            ($request->department == 'ETS-CIVIL WORKS MAINTENANCE') ||
            ($request->department == 'ECS Admin') ||
            ($request->department == 'ECS Civil Works Office') ||
            ($request->department == "ECS Division Manager'\s Office") ||
            ($request->department == 'ECS Electrical Services Office') ||
            ($request->department == 'ECS Motor Pool Office') || 
            ($request->departmentmanual == 'CIVIL WORKS') ||
            ($request->departmentmanual == 'MINE CIVIL WORKS') ||
            ($request->departmentmanual == 'CIVIL WORKS & ROAD MAINTENANCE') ||
            ($request->departmentmanual == 'ETS-CIVIL WORKS MAINTENANCE') ||
            ($request->departmentmanual == 'ECS Admin') ||
            ($request->departmentmanual == 'ECS Civil Works Office') ||
            ($request->departmentmanual == "ECS Division Manager'\s Office") ||
            ($request->departmentmanual == 'ECS Electrical Services Office') ||
            ($request->departmentmanual == 'ECS Motor Pool Office')) {

            $isECS = null;

        } else {
            $isECS = 0;
        }
                
        Unit::create([
            'name'=> $request->get('brand'),
            'type'=> $request->get('unit_type'),
            'required_availability_hours' =>  $request->get('required_availability_hours'),
            'active'=> 1,
            'dept'=> $request->get('department') ? $request->get('department') : $request->get('departmentmanual'),
            'isECS' => $isECS,
            'model'=> $request->get('model'),
            'plateno'=> $request->get('plate_number'),
            'chassisno'=> $request->get('chassis_serial'),
            'engineno'=> $request->get('engine_serial'),
            'color'=> $request->get('color'),
            'vehicle_code'=> $request->get('vehicle_code_new'),
        ]);

        return redirect()->back();
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
    public function edit($id)
    {
        $item = Unit::find($id);
        $units = Unit::all();
        $localDept = Department::get();
        $hrisDept = HRISAgusanDepartment::select(DB::raw('DISTINCT DeptDesc as name'))->orderBy('DeptDesc', 'asc')->get();
        $departments = array_merge($localDept->toArray(), $hrisDept->toArray());
        $dept = $departments;        
        return  view('admin.maintenance.unit',compact('item','units','dept'));
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

        $unit = Unit::find($id);
        $unit->vehicle_code = request()->get('vehicle_code_new');
        $unit->name = request()->get('brand');
        $unit->model = request()->get('model');
        $unit->plateno = request()->get('plateno');
        $unit->chassisno = request()->get('chassisno');
        $unit->engineno = request()->get('engineno');
        $unit->color = request()->get('color');
        $unit->type = request()->get('type');
        $unit->required_availability_hours = request()->get('required_availability_hours');
        $unit->dept = request()->get('department');
        $unit->save();

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
        $unit = Unit::find($id);
      
        if($unit)
        {
            Unit::destroy($id);
        }

        return redirect()->back();
    }

    public function disposeVehicle($id)
    {        
        $deactivate = Unit::find($id);
        $deactivate->update(['is_dispose' => 1]);

        return redirect()->back();
    }

    public function undisposeVehicle($id)
    {
        $activate = Unit::find($id);        
        $activate->update(['is_dispose' => 0]);

        return redirect()->back();
    }
   
}
