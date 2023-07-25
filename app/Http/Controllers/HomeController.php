<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Department;
use Illuminate\Support\Facades\DB;
use App\Services\RoleRightService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        
        $departments = Department::all();

        return view('admin.home.index', [
            'departments' => $departments
        ]);
    }

    public function dashboard(Request $request)
    {
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Downtime Dashboard");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        $query = "
        select
            d.dateStart AS ds,
            d.dateEnd AS de,
            d.*,
            u.name AS uni,
            u.type
        from
            downtime d
        left join unit u on u.id = d.unitId
            WHERE
            (
                (
                    d.dateStart >= " . "'" . $request->query("startDate") . "'" . "
                    and d.dateEnd <= " . "'" . $request->query("endDate") . " 23:59:59" . "'" . "
                )
                OR (
                    d.dateEnd >= " . "'" .  $request->query("startDate") . "'" . "
                    and d.dateEnd <= " . "'" . $request->query("endDate") . " 23:59:59" . "'" . "
                )
            )
            and d.active = 1
            order by
            d.id desc";

        $result = DB::select($query);

        return view('admin.dashboard.index', compact(
            'result',
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function maintenance()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Vehicle Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
        $print = $rolesPermissions['print'];
        $upload = $rolesPermissions['upload'];

        return view('admin.maintenance.index', compact(
            'create',
            'edit',
            'delete',
            'print',
            'upload'
        ));
    }

    public function downtime()
    {
        return redirect('/dashboard');
    }
}
