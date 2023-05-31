<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApplicationService;
use App\Role;
use App\Services\RoleRightService;
use Notification;
use App\Application;
use App\Notifications\EmailNofication;
use App\Notifications\ShutdownNotification;
use App\User;
use App\Events\ScheduleShutdown;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class ApplicationController extends Controller
{
    private $applicationService;
    private $roleRightService;

    public function __construct(
        ApplicationService $applicationService,
        RoleRightService $roleRightService
    ) {
        $this->applicationService = $applicationService;
        $this->roleRightService = $roleRightService;
    }

    public function index(Request $request)
    {
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $delete = $rolesPermissions['delete'];
      

        $applications = $request->has('id') ? Application::find($request->input('id')) : null;
        $applicationList = Application::orderBy('scheduled_date','desc')->get();
        
        return view('admin.application', compact('applicationList','applications', 'create', 'edit'));
        
    }

    public function updateApplication(Request $request) 
    {

        if( $request->has('a_application'))
        {                        
            $request->validate([
                'scheduled_date' => 'required',
                'scheduled_time' => 'required',
                'reason' => 'required',
            ]);

            $scheduled_date = $request->input('scheduled_date');
            $scheduled_time = $request->input('scheduled_time');
            $reason = $request->input('reason');
            
            $id = $request->query('id');
           
            $role = Application::create([
                'scheduled_date' => $scheduled_date,
                'scheduled_time' => $scheduled_time,
                'reason' => $reason
            ]);

            Session::flash('success',"A scheduled shutdown is added.");
            return redirect()->back();
        }


        if( $request->has('e_application'))
        {            
            $scheduled_date = $request->input('scheduled_date');
            $scheduled_time = $request->input('scheduled_time');
            $reason = $request->input('reason');

            $id = $request->query('id')?? $request->id;
            $application = Application::find($id);
    
            if(! $application)
            {
                Session::flash('error',"Scheduled Maintenance Update Failed...");
                return redirect()->back();
            }
            
            Application::find($id)->update([
                'scheduled_date' => $scheduled_date,
                'scheduled_time' => $scheduled_time,
                'reason' => $reason
            ]);

            return redirect()->route('maintenance.application.index')->with('success', 'A Scheduled Shutdown is updated.');
        }        

    }    



    public function store(Request $request)
    {
        $result = $this->applicationService->create($request);
        return $result;
    }
    public function edit(Request $request)
    {
        return response()->json($this->applicationService->getById($request->id));
    }

    public function update(Request $request)
    {
        return $this->applicationService->update($request);
    }

    public function destroy($id)
    {
        return $this->applicationService->destroy($id);
    }
    public function notifications()
    {
        return Application::orderBy('id', 'desc')->first()->toArray();
    }
    public function systemDown()
    {
        $sessions = glob(storage_path("framework/sessions/*"));
        foreach($sessions as $file){
          if(is_file($file))
            unlink($file);
        }
        Artisan::call('down');
        return redirect()->back()->with('down', 'System is in Maintenance Mode!');
    }
    public function systemUp()
    {
        Artisan::call('up');
        return redirect()->back()->with('success', 'System back Online!');
    }
  
    public function create_indexing()
    {
        $application = DB::update('EXEC runScheduledIndexing');

        if ($application) 
        {
            return redirect()->back()->with('success', 'Reindex Application Database Successful!');
        } 
        else 
        {
            return redirect()->back()->with('errors', 'Reindex Application Database Failed.');
        }
    }
    public function search(Request $request)
    {

        $pagename = 'Application';
        
        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];

        $q = $request->get('q');

        $applications = Application::where('reason', 'LIKE', '%' . $q . '%')
            ->orWhere('scheduled_date', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $applications->appends(array(
            'q' => $request->get('q')
        ));

        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];

        return view('maintenance.application',compact('pagename', 'applications', 'create', 'edit'));
    }
}
