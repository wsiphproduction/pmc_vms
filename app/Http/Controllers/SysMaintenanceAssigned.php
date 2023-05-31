<?php

namespace App\Http\Controllers;

use App\Assigned;
use Illuminate\Http\Request;

class SysMaintenanceAssignedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assigned = Assigned::all();
        return view('admin.maintenance.assigned',compact('assigned'));
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
        Assigned::create([
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
        $item = Assigned::find($id);
        $assigned = Assigned::all();
        
        return  view('admin.maintenance.assigned',compact('item','assigned'));
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
        $assigned = Assigned::find($id);
        $assigned->name = request()->get('name');
        $assigned->save();

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
        $assigned = Assigned::find($id);
      
        if($assigned)
        {
            Assigned::destroy($id);
        }

        return redirect()->back();
    }
}
