<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Location;
use App\Contractor;
use App\Transaction;
use App\TransactionDetail;
use App\Exports\Issuance;
use Excel;
use Maatwebsite\Excel\Concerns\FromView;
use App\Services\ReportService;
use App\Services\UserService;
use \OwenIt\Auditing\Models\Audit;
use App\Services\RoleRightService;
use App\Log;

class ReportsController extends Controller
{

	public function __construct(
		RoleRightService $roleRightService,
		ReportService $reportService,
		UserService $userService
	) {
		$this->reportService = $reportService;
		$this->roleRightService = $roleRightService;
		$this->userService = $userService;
	}

	public function auditLogs(Request $request)
	{
		$rolesPermissions = $this->roleRightService->hasPermissions("Audit Logs");
		if (!$rolesPermissions['view']) {
		    abort(401);
		}
		$dateFrom = now()->toDateString();
		$dateTo = now()->toDateString();
		$userid = 0;
		if (isset($request->dateFrom)) {
			$dateFrom = $request->dateFrom;
		}
		if (isset($request->dateTo)) {
			$dateTo = $request->dateTo;
		}
		if (isset($request->userid)) {
			$userid = $request->userid;
		}

		$users =  $this->userService->all()->where('active', 1)->where('username', '<>', '')->sortBy('username');


		$audits = Audit::when(isset($dateTo), function ($q) use ($dateFrom, $dateTo) {
			$q->whereBetween('created_at',  [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
		})
			->when(!isset($dateTo), function ($q) use ($dateFrom) {
				$q->whereDate('created_at', $dateFrom);
			})
			->when($userid != 0, function ($q) use ($userid) {
				$q->where('user_id', $userid);
			})
			->orderBy('created_at','desc')->get();

		$saveLogs = $this->reportService->create("Audit Logs", $request);
		return view('admin.reports.audits', [
			'audits' => $audits,
			'users' => $users
		]);
	}
	public function errorLogs(Request $request)
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Error Logs");

        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $dateFrom = now()->toDateString();
        $dateTo = now()->toDateString();
        if (isset($request->dateFrom)) {
            $dateFrom = $request->dateFrom;
        }
        if (isset($request->dateTo)) {
            $dateTo = $request->dateTo;
        }

        $error_list = Log::when(isset($dateTo), function($q) use($dateFrom, $dateTo){
            $q->whereBetween('created_at', [$dateFrom.' 00:00:00', $dateTo.' 23:59:59']);
        })
       ->when(!isset($dateTo), function($q) use($dateFrom){
            $q->whereDate('created_at', $dateFrom);
        })
        ->orderBy('created_at','desc')->get();
        $saveLogs = $this->reportService->create("Error Logs", $request);;
        return view('admin.reports.error', ['error_list' => $error_list]);
    }
}
