<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlsrv'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_HOST'),
        //     //'port' => env('DB_PORT'),
        //     'database' => env('DB_DATABASE'),
        //     'username' => env('DB_USERNAME'),
        //     'password' => env('DB_PASSWORD'),
        //     //'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        // ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ], 

        // 'sqlsrv_dvo_hris' => [
        //     'driver' => 'sqlsrv_dvo_hris',                    
        //     'host' => env('DB_HOST_HRIS_DVO','HOF4B7E2A32209L\INHOUSE'),
        //     'port' => env('DB_PORT_HRIS_DVO','53285'),
        //     'database' => env('DB_DATABASE_HRIS_DVO','mssqlws1ph2_dimshris'),
        //     'username' => env('DB_USERNAME_HRIS_DVO','sa'),
        //     'password' => env('DB_PASSWORD_HRIS_DVO','@Temp123!'),
        //     'charset' => 'utf8',
        //     'prefix' => '',                  
        // ],

        // 'sqlsrv_agn_hris' => [
        //     'driver' => 'sqlsrv_agn_hris',                    
        //     'host' => env('DB_HOST_HRIS_AGN','HOF4B7E2A32209L\INHOUSE'),
        //     'port' => env('DB_PORT_HRIS_AGN','53285'),
        //     'database' => env('DB_DATABASE_HRIS_AGN','mssqlws1ph2_dimshris'),
        //     'username' => env('DB_USERNAME_HRIS_AGN','sa'),
        //     'password' => env('DB_PASSWORD_HRIS_AGN','@Temp123!'),
        //     'charset' => 'utf8',
        //     'prefix' => '',            
        // ],

        'sqlsrv_dvo_hris' => [
            'driver' => 'sqlsrv',                    
            'host' => env('DB_HOST_HRIS_DVO','172.16.10.42\philsaga_db'),
            'port' => env('DB_PORT_HRIS_DVO','52928'),
            'database' => env('DB_DATABASE_HRIS_DVO','PMC-DAVAO'),
            'username' => env('DB_USERNAME_HRIS_DVO','app_user_read_only'),
            'password' => env('DB_PASSWORD_HRIS_DVO','P4TGQkPz'),
            'charset' => 'utf8',
            'prefix' => '',                  
        ],

        'sqlsrv_agn_hris' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_HRIS_AGN', '172.16.20.42\agusan_db'),
            'port' => env('DB_PORT_HRIS_AGN', '64472'),
            'database' => env('DB_DATABASE_HRIS_AGN', 'PMC-AGUSAN-NEW'),
            'username' => env('DB_USERNAME_HRIS_AGN', 'app_user_read_only'),
            'password' => env('DB_PASSWORD_HRIS_AGN', 'P4TGQkPz'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null

        ],

        'sqlsrv_contractors' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_CONTRACTORS', '127.0.0.1'),
            'port' => env('DB_PORT_CONTRACTORS', '1433'),
            'database' => env('DB_DATABASE_CONTRACTORS', 'forge'),
            'username' => env('DB_USERNAME_CONTRACTORS', 'forge'),
            'password' => env('DB_PASSWORD_CONTRACTORS', ''),
            'charset' => 'utf8',
            'prefix' => '',

        ],
         'sqlsrv_fms' => [
            'driver'    => env('DB_CONNECTION_FMS'),
            'host'      => env('DB_HOST_FMS'),
            'port'      => env('DB_PORT_FMS'),
            'database'  => env('DB_DATABASE_FMS'),
            'username'  => env('DB_USERNAME_FMS'),
            'password'  => env('DB_PASSWORD_FMS'),
            'charset'   => 'utf8',
            'prefix'    => '',
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
