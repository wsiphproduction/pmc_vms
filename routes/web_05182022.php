<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Generate Dummy account
Route::get('/genAccDummy', 'AuthController@genAccDummy');


Route::get('logout', 'Auth\LoginController@logout');
Route::get('/', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.submit'); // login submit


Route::get('adminlogin/admin', 'Auth\LoginController@adminLogin')->name('login.adminLogin'); // login
Route::post('adminsubmit/admin', 'Auth\LoginController@adminSubmit')->name('login.adminsubmit'); // login submit
Route::middleware('auth')->group(function () {

    Route::post('/search-hris-employee', 'SearchController@search_hris_employee')->name('search.hris.employee');

    Route::post('/e-search-hris-employee', 'SearchController@e_search_hris_employee')->name('e_search.e_hris.e_employee');

    Route::post('/search-hris-department', 'SearchController@search_department')->name('search.hris.department');

    Route::post('/e-search-hris-department', 'SearchController@e_search_department')->name('e_search.e_hris.e_department');

    // Route::get('/change-password', function () {

    //     $id = \Auth::user()->id;

    //     return view('auth.passwords.change', compact('id'));
    // })->name('change-pass');
    Route::get('/change-password', 'LoginUserController@changePassword')->name('change-pass');
    Route::patch('/change-password', 'LoginUserController@updatePassword')->name('updatePassword');

    //Put all forms here  
    Route::get('/home', 'HomeController@index')->name('form.home');

    //Dashboard
    Route::get('/dashboard', 'HomeController@dashboard')->name('form.dashboard');

    //Maintenance
    Route::get('/maintenance', 'HomeController@maintenance')->name('form.maintenance');

    //Admin only page
    // Route::middleware('permission')->group(function() {
    //     Route::prefix('maintenance')->group(function () {

    Route::name('maintenance.')->group(function () {
        Route::resource('/unit', 'SysMaintenanceUnitController');
        Route::resource('/status', 'SysMaintenanceStatusController');
        Route::resource('/mechanic', 'SysMaintenanceMechanicController');
        Route::resource('/assigned', 'SysMaintenanceAssignedController');
        Route::resource('/breakdown', 'SysMaintenanceBreakdownController');
        Route::resource('/preventive', 'SysMaintenancePreventiveController');

        Route::get('/user-maintenance', 'UserMaintenanceController@index')->name('user');
        Route::post('/user-maintenance', 'UserMaintenanceController@updateUser')->name('user.update');

        Route::get('/department-maintenance', 'DepartmentMaintenanceController@index')->name('dept');
        Route::post('/department-maintenance', 'DepartmentMaintenanceController@updateDept')->name('dept.update');

        Route::get('/export/{type}', 'SysMaintenanceExportController@export')->name('export'); //maintenance.export

        Route::get('maintenance/unit/{id}/dispose', 'SysMaintenanceUnitController@disposeVehicle');
        Route::get('maintenance/unit/{id}/undispose', 'SysMaintenanceUnitController@undisposeVehicle');

        //Role Route
        Route::get('/role-maintenance', 'RoleMaintenanceController@index')->name('role');
        Route::post('/role-maintenance', 'RoleMaintenanceController@updateRole')->name('role.update');

        //Permission Route
        Route::get('/permission-maintenance', 'PermissionMaintenanceController@index')->name('permission');
        Route::post('/permission-maintenance', 'PermissionMaintenanceController@updatePermission')->name('permission.update');

        //Role Access right routes
        Route::group(['prefix' => 'roleaccessrights'], function () {
            Route::get('/', 'RoleRightController@index')->name('roleaccessrights.index');
            Route::post('store', 'RoleRightController@store')->name('roleaccessrights.store');
            Route::get('store', 'RoleRightController@store')->name('roleaccessrights.store');
        });

        //User Access right routes
        Route::group(['prefix' => 'useraccessrights'], function () {
            Route::get('/', 'UserRightController@index')->name('useraccessrights.index');
            Route::post('store', 'UserRightController@store')->name('useraccessrights.store');
            Route::get('store', 'UserRightController@store')->name('useraccessrights.store');
        });

        // Application routes
        Route::group(['prefix' => 'application/maintenance'], function () {
            Route::get('/', 'ApplicationController@index')->name('application.index');
            Route::post('/application-maintenance', 'ApplicationController@updateApplication')->name('application.update');
            Route::delete('{id}/destroy', 'ApplicationController@destroy')->name('application.destroy');

            //Route::post('store', 'ApplicationController@store')->name('application.store');
            //Route::post('edit', 'ApplicationController@edit')->name('application.edit');                                    
            //Route::put('update', 'ApplicationController@update')->name('application.update');

            //Route::any('/search', 'ApplicationController@search')->name('application.search');
            //Route::get('{id}/destroy', 'ApplicationController@destroy')->name('application.destroy');
            Route::get('systemDown', 'ApplicationController@systemDown')->name('application.systemDown');
            Route::get('systemUp', 'ApplicationController@systemUp')->name('application.systemUp');
            Route::get('create_indexing', 'ApplicationController@create_indexing')->name('application.create_indexing');
        });
    });
    //});
    //});


    //Downtime
    // Route::get('/downtime', 'DowntimeController@downtime')->name('form.downtimes');
    // Route::get('/downtimes', 'DowntimeController@getDowntime')->name('get.downtime');
    // Route::get('/downtime/add', 'DowntimeController@downtime_add')->name('form.downtime_add');
    // Route::post('/downtime/add', 'DowntimeController@create')->name('form.downtime.create');

    Route::prefix('downtime')->group(function () {

        Route::resource('/downtime', 'DowntimeController');

        Route::name('downtime.')->group(function () {
            Route::get('/list', 'DowntimeController@downtimes')->name('downtimes');
            Route::get('/repair_hours_by_category', 'DowntimeChartsController@repairHours')->name('repairhours');
            Route::get('/mtd_availability_due_to_breakdown_light', 'DowntimeChartsController@mtdLightVehicle')->name('mtdLightVehicle');
            Route::get('/mtd_availability_due_to_breakdown_medium', 'DowntimeChartsController@mtdMediumVehicle')->name('mtdMediumVehicle');
            Route::get('/mtd_availability_due_to_breakdown_heavy', 'DowntimeChartsController@mtdHeavyVehicle')->name('mtdHeavyVehicle');
            Route::get('/man_hours_distribution', 'DowntimeChartsController@manHours')->name('manhours');
            Route::get('/mtd_availability_due_to_breakdown_motorcycle', 'DowntimeChartsController@mtdMotor')->name('mtdMotor');
            Route::get('/repair_hours_by_repair_type', 'DowntimeChartsController@repairType')->name('repairtype');
            Route::get('/repair_hours_light_vehicle', 'DowntimeChartsController@rpLightVehicle')->name('rpLightVehicle');
            Route::get('/repair_hours_medium_vehicle', 'DowntimeChartsController@rpMediumVehicle')->name('rpMediumVehicle');
            Route::get('/repair_hours_heavy_vehicle', 'DowntimeChartsController@rpHeavyVehicle')->name('rpHeavyVehicle');
            Route::get('/repair_hours_motorcycle', 'DowntimeChartsController@rpMotor')->name('rpMotor');

            Route::get('{id}/edit','DowntimeController@edit')->name('downtime_edit');
            Route::patch('{downtime}/update','DowntimeController@update')->name('downtime_update');
            Route::delete('{id}/destroy','DowntimeController@destroy')->name('downtime_destroy');
        });
    });

    // Route::prefix('downtime')->group(function () {
    //     Route::name('downtime.')->group(function () {
    //         Route::get('/repair_hours_by_category', 'DowntimeChartsController@repairHours')->name('repairhours');
    //         Route::get('/mtd_availability_due_to_breakdown_light', 'DowntimeChartsController@mtdLightVehicle')->name('mtdLightVehicle');
    //         Route::get('/mtd_availability_due_to_breakdown_medium', 'DowntimeChartsController@mtdMediumVehicle')->name('mtdMediumVehicle');
    //         Route::get('/mtd_availability_due_to_breakdown_heavy', 'DowntimeChartsController@mtdHeavyVehicle')->name('mtdHeavyVehicle');
    //         Route::get('/man_hours_distribution', 'DowntimeChartsController@manHours')->name('manhours');
    //         Route::get('/mtd_availability_due_to_breakdown_motorcycle', 'DowntimeChartsController@mtdMotor')->name('mtdMotor');
    //         Route::get('/repair_hours_by_repair_type', 'DowntimeChartsController@repairType')->name('repairtype');
    //         Route::get('/repair_hours_light_vehicle', 'DowntimeChartsController@rpLightVehicle')->name('rpLightVehicle');
    //         Route::get('/repair_hours_medium_vehicle', 'DowntimeChartsController@rpMediumVehicle')->name('rpMediumVehicle');
    //         Route::get('/repair_hours_heavy_vehicle', 'DowntimeChartsController@rpHeavyVehicle')->name('rpHeavyVehicle');
    //         Route::get('/repair_hours_motorcycle', 'DowntimeChartsController@rpMotor')->name('rpMotor');
    //     });
    // });

    //Vehicle Request
    Route::prefix('vehicle')->group(function () {
        Route::name('vehicle.')->group(function () {

            Route::post('/request/add', 'VehicleRequestController@create')->name('request.create');
            Route::post('/request/add/destination', 'VehicleRequestController@createWithDestination')->name('request.create.destination');
            Route::post('/request/update', 'VehicleRequestController@update')->name('request.update');
            Route::post('/request/status', 'VehicleRequestController@changeStatus')->name('request.change.status');
            Route::get('/dispatch/{id}/create/', 'VehicleRequestController@tripTicket')->name('request.dispatch');
            Route::get('/request/list/{item?}', 'VehicleRequestController@list')->name('request.list');
            Route::get('/request/all', 'VehicleRequestController@getRequests')->name('request.all');
            Route::post('/{id}/cancel', 'VehicleRequestController@cancelRequest')->name('request.cancel');
            Route::get('/request/{id}', 'VehicleRequestController@get')->name('request.get');
            Route::get('/request/export', 'VehicleRequestController@exportRequests')->name('request.export');
            Route::post('/request/{id}/message', 'VehicleRequestController@createMessage')->name('request.message');
            Route::get('/drivers', 'VehicleRequestDriverController@drivers')->name('drivers');
            Route::post('/drivers/submit', 'VehicleRequestDriverController@submitdrivers')->name('drivers.submit');
            Route::post('/request/trip_completed/{id}', 'VehicleRequestController@tripcompleted')->name('request.trip_completed');
            Route::post('/request/trip_completed_addDispatch/{id}', 'VehicleRequestController@tripcompleted_addDispatch')->name('request.trip_completed_addDispatch');
            Route::get('/request/dispatch_details/{id}', 'VehicleRequestController@dispatchDetails')->name('request.dispatch_details');
            Route::post('/request/dispatch_details', 'VehicleRequestController@cancelDispatchDetails')->name('request.cancel.dispatch_details');
            Route::get('/request/dispatch_details/{id}/edit', 'VehicleRequestController@editDispatchDetails')->name('request.edit.dispatch_details');
            Route::post('/request/dispatch_details/{id}', 'VehicleRequestController@updateDispatchDetails')->name('request.update.dispatch_details');
            Route::get('/request/dispatch_details_form/{id}', 'VehicleRequestController@editDispatchDetailsForm')->name('request.edit.dispatch_details_form');
            Route::get('/request/{id}/details', 'VehicleRequestController@requestDetails')->name('request.details');
            Route::get('/request/dispatch_printout/{id}', 'VehicleRequestController@dispatchPrintout')->name('request.dispatch_printout');
            // Route::get('/request/dispatch_details_form/{id}','VehicleRequestController@dispatch_edit_form');

            // Comment
            Route::post('/request/comment', 'VehicleRequestController@commentSave')->name('request.comment');
            Route::post('/request/comment/area', 'VehicleRequestController@commentChat')->name('request.comment.area');
            Route::post('/request/comment/all', 'vehicleRequestController@getComments')->name('request.comment.all');
            Route::post('/request/comment/last', 'VehicleRequestController@commentLast')->name('request.comment.last');

            //Dispatch 
            Route::post('/dispatch/create', 'DispatchController@create')->name('dispatch.create');

            //Report
            Route::prefix('report')->group(function () {
                Route::name('report.')->group(function () {

                    Route::get('/dispatchdepartment', 'DispatchController@dispatchesPerDepartmentReport')->name('dipstachdepartment');
                    Route::get('/dispatchdepartment/all', 'DispatchController@dispatchesPerDepartment')->name('dispatchdepartment.all');
                    Route::get('/topdestination', 'VehicleReportDestinationController@index')->name('topdestination');
                    Route::post('/topdestination', 'VehicleReportDestinationController@update')->name('topdestination.create');
                    Route::get('/triptickets', 'VehicleReportTripTicketController@index')->name('trip');
                    Route::get('/totalvehicledispatch/all', 'DispatchController@vehiclesTotalDispatches')->name('total.dispatches.all');
                    Route::get('/totalvehicledispatch', 'DispatchController@vehiclesTotalDispatchReport')->name('total.dispatch');
                    Route::get('/totalvehicledistance/all', 'DispatchController@vehicleDistanceTravelled')->name('total.distance.all');
                    Route::get('/totalvehicledistance', 'DispatchController@vehiclesTotalDistance')->name('total.distance');
                    Route::get('/requestrawdata', 'VehicleRequestController@vehicleRequestRawData')->name('request.raw');

                    //Excel Export
                    Route::post('/exportExcel', 'ExcelExportController@export')->name('exportToExcel');

                    //Weekly
                    Route::get('/weekly/{week?}', 'DispatchController@weekly')->name('dispatch_weekly');
                    Route::get('/daily/{dyt?}', 'DispatchController@daily')->name('dispatch_daily');

                    //Vehicle List Reports
                    Route::get('/fms-vehicles-all', 'SysMaintenanceUnitsController@fms_index')->name('fms_vehicles');
                    Route::get('/fms-vehicles-department', 'SysMaintenanceUnitsController@fms_vehicles')->name('fms_vehicles_department');
                    Route::get('/vms-vehicles', 'SysMaintenanceUnitsController@vms_vehicles')->name('vms_vehicles');


                });
            });
        });
    });

    Route::prefix('drivers')->group(function () {
        Route::name('driver.')->group(function () {
            Route::get('/list', 'DriversController@index')->name('index');
            Route::post('/create', 'DriversController@create')->name('create');
            Route::post('{id}/update', 'DriversController@edit')->name('edit');
            Route::get('{id}/active', 'DriversController@updateActive')->name('active');
            Route::get('/export', 'DriversController@export')->name('export');
        });
    });

    Route::prefix('utilization')->group(function () {
        Route::name('utilization.')->group(function () {

            Route::get('/', 'UtilizationController@dashboard')->name('dashboard');
            Route::get('frequent-destination', 'UtilizationController@frequentDestination')->name('frequent-destination');
            Route::get('distance-travelled', 'UtilizationController@vehicleDistance')->name('distance-travelled');
            Route::get('dispatches-department', 'UtilizationController@dispatchesDepartment')->name('dispatches-department');
            Route::get('vehicle-dispatches', 'UtilizationController@dispatchesVehicle')->name('dispatches-vehicle');
        });
    });

    Route::prefix('manual')->group(function () {
        Route::name('manual.')->group(function () {
            Route::prefix('approver')->group(function () {
                Route::name('approver.')->group(function () {

                    Route::get('/WelcometoVehicleMonitoringSystem', 'ManualController@index')->name('index');
                });
            });
        });
    });

    Route::post('/ajax', 'AjaxController@index')->name('ajax');
    Route::post('/search-hris-dept', 'DeptController@index')->name('searchdept');
    Route::post('/contact-person', 'DeptController@contact')->name('contact-person');
    Route::get('logout', 'AuthController@Logout')->name('logout');
    
    Route::get('audit-logs', 'ReportsController@auditLogs')->name('audit-logs');
    Route::get('error-logs', 'ReportsController@errorLogs')->name('error-logs');
});

Route::middleware('guest')->group(function () {
    Route::get('/', 'AuthController@index')->name('login');
    Route::post('/landing', 'AuthController@login')->name('admin.login');

    Route::get('/request', 'AuthController@requestorIndex')->name('rlogin');
    Route::post('/request', 'AuthController@requestorLogin')->name('requestor.login');
});
