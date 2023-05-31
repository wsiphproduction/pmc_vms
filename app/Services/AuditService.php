<?php

namespace App\Services;

use App\Repositories\Interfaces\AuditRepositoryInterface;

class AuditService
{
    protected $repository;

    public function __construct(AuditRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create($request, $action, $event)
    {
        $actionArr = array(
            "action" => $action
          );
        $oldvalues = array(
            
          );
      

        $data = [
            'user_type' => "App\User",
            'user_id' => auth()->check() ? auth()->user()->id : 1,
            'event' => $event,
            'auditable_type' => "",
            'auditable_id' => 0,
            'old_values' => $oldvalues,
            'new_values' => $actionArr,
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
