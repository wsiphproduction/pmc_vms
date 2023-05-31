<?php

namespace App\Http\Controllers;

use App\RepairBreakdown;
use Illuminate\Http\Request;

class SysMaintenanceBreakdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breakdown = RepairBreakdown::all();
        return view('admin.maintenance.breakdown',compact('breakdown'));
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
        RepairBreakdown::create([
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
        $item = RepairBreakdown::find($id);
        $breakdown = RepairBreakdown::all();
        
        return  view('admin.maintenance.breakdown',compact('item','breakdown'));
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
        $breakdown = RepairBreakdown::find($id);
        $breakdown->name = request()->get('name');
        $breakdown->save();

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
        $breakdown = RepairBreakdown::find($id);
      
        if($breakdown)
        {
            RepairBreakdown::destroy($id);
        }

        return redirect()->back();
    }
}
