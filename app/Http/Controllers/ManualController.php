<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleRightService;

class ManualController extends Controller
{
    public function __construct(
		RoleRightService $roleRightService
	) {
		$this->roleRightService = $roleRightService;
	}
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("User manual");

        if (!$rolesPermissions['view']) {
            abort(401);
        }
        return view('admin.manual.approver.WelcometoVehicleMonitoringSystem');
    }
}
