<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Application;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\System;

class ApplicationRepository implements ApplicationRepositoryInterface
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function all()
    {
        return $this->application->all();
    }

    public function create($fields)
    {
        return $this->application->create($fields);
    }

    public function update($fields, $id)
    {
        return $this->application->find($id)->update($fields);
    }

    public function destroy($id)
    {
        return $this->application->find($id)->delete();
    }

    public function getById($id)
    {
        return $this->application->find($id);
    }
    public function hasSchedule()
    {
        $from = now()->setTime(0, 0, 0)->toDateTimeString();
        $to = now()->subDays(-5)->setTime(0, 0, 0)->toDateTimeString();


        return $this->application->whereBetween('scheduled_date','>=', [$from,$to])->orderBy('scheduled_date','asc')->first();
    }
    public function updateSystem($status)
    {
        return System::find(1)->update($status);
    }
}
