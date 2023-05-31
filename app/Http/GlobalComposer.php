<?php

namespace App\Http;

use Illuminate\View\View;

use App\Department;
use App\Destination;

class GlobalComposer{

    public function compose(View $view){
        $departments = Department::all();
        $destinations = Destination::all();

        $view->with('departments', $departments);
        $view->with('destinations', $destinations);
    }
}