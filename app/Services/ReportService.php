<?php

namespace App\Services;

use App\Repositories\Interfaces\ReportRepositoryInterface;

class ReportService
{
    protected $repository;

    public function __construct(ReportRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create($reportName, $request)
    {
        $fullReportname = array(
            "report name" => $reportName
          );
        $oldvalues = array(
            
          );
      

        $data = [
            'user_type' => "App\User",
            'user_id' => auth()->check() ? auth()->user()->id : 1,
            'event' => "Generate Report",
            'auditable_type' => "",
            'auditable_id' => 0,
            'old_values' => $oldvalues,
            'new_values' => $fullReportname,
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user-agent')
        ];
        $permission = $this->repository->create($data);
        return redirect()->back();
        // if ($permission) {
        //     return redirect()->back()->with('success', 'Logs has been added successfully!');
        // } else {
        //     return redirect()->back()->with('errors', 'Saving Logs failed.');
        // }
    }

}
