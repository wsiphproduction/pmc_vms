<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DriversExport;
use App\Drivers;

class DriversController extends Controller
{
    public function index(){
        $drivers = Drivers::get();
        $drivers = $drivers->each(function($data){
            $action = '';
            $action.= '<a href="#" class="btn btn-xs green" onclick="edit('.$data->id.')">Edit</a>';
            $action.= '<input type="hidden" name="driver'.$data->id.'" id="driver'.$data->id.'" value="'.$data->id.'|'.$data->driver_name.'|'.$data->type.'">';
            if($data->isActive == 1){
                $action.= '<a href="javascript:void(0)" class="btn btn-xs red" onclick="disable_driver('.$data->id.')">Disable</a>';
            }
            else{
                $action.= '<a class="btn btn-xs blue" href="/drivers/'.$data->id.'/active?active=1">Enable</a>'; 
            }

            $data->actions = $action;
        });

        $types = ['GSD Driver', 'Motor Pool Driver', 'Mine Driver'];
        
        return view('admin.drivers.index', compact('drivers', 'types'));
    }

    public function create(Request $request){
        $driver = new Drivers();
        $driver->driver_name = $request->get('dname');
        $driver->isActive = 1;

        if($request->get('dtype2') != null){
            $driver->type = $request->get('dtype2');
        }
        else{
            $driver->type = $request->get('dtype');
        }

        $driver->save();

        return redirect()->route('driver.index', ['status' => 'created']);
    }

    public function edit($id, Request $request){
        $driver = Drivers::findOrFail($id);
        $driver->driver_name = $request->get('edname');

        if($request->get('edtype2') != null){
            $driver->type = $request->get('edtype2');
        }
        else{
            $driver->type = $request->get('edtype');
        }

        $driver->save();



        return redirect()->route('driver.index', ['status' => 'updated']);
    }

    public function updateActive($id, Request $request){
        $driver = Drivers::findOrFail($id);
        $driver->isActive = $request->get('active');
        $driver->save();

        $status = '';

        if($driver->isActive == 1){
            $status = 'enabled';
        } else{
            $status = 'disabled';
        }

        return redirect()->route('driver.index', ['status' => $status]);
    }

    public function export(){
        return (new DriversExport())->download('Drivers ' . date('Y-m-d h-i-s') . '.xlsx');
    }
}
