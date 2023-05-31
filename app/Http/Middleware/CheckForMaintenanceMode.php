<?php

namespace App\Http\Middleware;
use Illuminate\Foundation\Application;
use Closure;

// use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

// use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode //extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'adminlogin',
        'adminsubmit/*'
    ];
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && !$this->isBackendRequest($request)) {
            $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }

    private function isBackendRequest($request)
    {
        // dd($request);
        // dd($request->is('adminsubmit/*'));   
        return ($request->is('application/*') or $request->is('/*') or $request->is('adminlogin/*') or $request->is('adminsubmit/*'));
    }
}
