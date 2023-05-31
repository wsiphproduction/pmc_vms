<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $group = array(
        // Role
        array(
            'interface' => 'App\Repositories\Interfaces\RoleRepositoryInterface',
            'repository' => 'App\Repositories\RoleRepository',
            'service' => 'App\Services\RoleService',
            'model' => [
                'App\Role',
            ],
        ),

        // users
        array(
            'interface' => 'App\Repositories\Interfaces\UserRepositoryInterface',
            'repository' => 'App\Repositories\UserRepository',
            'service' => 'App\Services\UserService',
            'model' => [
                'App\User'
            ],
        ),

        // Permission
        array(
            'interface' => 'App\Repositories\Interfaces\PermissionRepositoryInterface',
            'repository' => 'App\Repositories\PermissionRepository',
            'service' => 'App\Services\PermissionService',
            'model' => [
                'App\Permission',
            ],
        ),
        // Audit
        array(
            'interface' => 'App\Repositories\Interfaces\AuditRepositoryInterface',
            'repository' => 'App\Repositories\AuditRepository',
            'service' => 'App\Services\AuditService',
            'model' => [
                '\OwenIt\Auditing\Models\Audit',
            ],
        ),
        
        // Role Access Rights
        array(
            'interface' => 'App\Repositories\Interfaces\RoleRightRepositoryInterface',
            'repository' => 'App\Repositories\RoleRightRepository',
            'service' => 'App\Services\RoleRightService',
            'model' => [
                'App\RolesPermissions',
            ],
        ),
        // User Access Rights
        array(
            'interface' => 'App\Repositories\Interfaces\UserRightRepositoryInterface',
            'repository' => 'App\Repositories\UserRightRepository',
            'service' => 'App\Services\UserRightService',
            'model' => [
                'App\UsersPermissions',
            ],
        ),    
        // applications
        array(
            'interface' => 'App\Repositories\Interfaces\ApplicationRepositoryInterface',
            'repository' => 'App\Repositories\ApplicationRepository',
            'service' => 'App\Services\ApplicationService',
            'model' => [
                'App\Application',
            ],
        ),                                   
        // Report
        array(
            'interface' => 'App\Repositories\Interfaces\ReportRepositoryInterface',
            'repository' => 'App\Repositories\ReportRepository',
            'service' => 'App\Services\ReportService',
            'model' => [
                '\OwenIt\Auditing\Models\Audit',
            ],
        ),     
         // Audit 
         array(
            'interface' => 'App\Repositories\Interfaces\AuditRepositoryInterface',
            'repository' => 'App\Repositories\AuditRepository',
            'service' => 'App\Services\AuditService',
            'model' => [
                '\OwenIt\Auditing\Models\Audit',
            ],
        ),   
    );
    public function register()
    {
        foreach ($this->group as $key => $item) {
            $this->app->bind($item['interface'], function ($app) use ($item) {
                if (is_array($item['model'])) {
                    $models = [];
                    foreach ($item['model'] as $model) {
                        $models[] = new $model();
                    }
                    return new $item['repository'](...$models);
                } else {
                    return new $item['repository'](new $item['model']());
                }
            });
            $this->app->bind($item['service'], function ($app) use ($item) {
                return new $item['service'](
                    $app->make($item['interface'])
                );
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
