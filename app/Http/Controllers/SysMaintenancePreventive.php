<?php

namespace App\Http\Controllers;

use App\RepairPreventive;
use Illuminate\Http\Request;

class SysMaintenancePreventiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preventive = RepairPreventive::all();
        return view('admin.maintenance.preventive',compact('preventive'));
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
        RepairPreventive::create([
            'name'=> $request->get('name'),
            'active'=> 1
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
        $item = RepairPreventive::find($id);
        $preventive = RepairPreventive::all();
        
        return  view('admin.maintenance.preventive',compact('item','preventive'));
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
        $preventive = RepairPreventive::find($id);
        $preventive->name = request()->get('name');
        $preventive->save();

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
        $preventive = RepairPreventive::find($id);
      
        if($preventive)
        {
            RepairPreventive::destroy($id);
        }

        return redirect()->back();
    }
}
