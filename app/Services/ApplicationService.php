<?php

namespace App\Services;

use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    protected $repository;

    public function __construct(ApplicationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $applications = $this->repository->all();

        $data = collect();
        foreach ($applications as $application) {
            $data->push([
                'id' => $application->id,
                'scheduled_date' => $application->scheduled_date,
                'scheduled_time' => $application->scheduled_time,
                'reason' => $application->reason,
                'posted_date' => $application->posted_date,
                'posted_time' => $application->posted_time,
            ]);
        }
        return $data;
    }

    public function create($fields)
    {
        $data = [
            'scheduled_date' => $fields->scheduled_date,
            'scheduled_time' => $fields->scheduled_time,
            'reason' => $fields->reason,
        ];

        $application = $this->repository->create($data);

        if ($application) {
            return redirect()->back()->with('success', 'Scheduled Maintenance has been added successfully!');
        } else {
            return redirect()->back()->with('errors', 'Adding Scheduled Maintenance failed.');
        }
    }

    public function update($fields)
    {
        $data = [
            'scheduled_date' => $fields->scheduled_date,
            'scheduled_time' => $fields->scheduled_time,
            'reason' => $fields->reason,
        ];


        $application = $this->repository->update($data, $fields->id);

        if ($application) {
            return redirect()->back()->with('success', 'Scheduled Maintenance has been updated successfull!');
        } else {
            return redirect()->back()->with('errors', 'Updating Scheduled Maintenance failed.');
        }
    }

    public function getById($id)
    {
        $application = $this->repository->getById($id);

        $data = [
            'id' => $application->id,
            'scheduled_date' => $application->scheduled_date,
            'scheduled_time' => $application->scheduled_time,
            'reason' => $application->reason,
        ];

        return $data;
    }

    public function destroy($id)
    {
        $application = $this->repository->destroy($id);

        if ($application) {
            return redirect()->back()->with('success', 'Scheduled Maintenance has been removed successfully!');
        } else {
            return redirect()->back()->with('success', 'Failed removing Scheduled Maintenance!');
        }
    }
    public function hasSchedule()
    {
        $application = $this->repository->hasSchedule();
        $data = collect();
            $data->push([
                'id' => $application->id,
                'scheduled_date' => $application->scheduled_date,
                'scheduled_time' => $application->scheduled_time,
                'reason' => $application->reason,
                'posted_date' => $application->posted_date,
                'posted_time' => $application->posted_time,
            ]);

        return $data;
    }
    public function updateSystem($status)
    {
        
        $data = [
            'down' => $status
        ];


        $application = $this->repository->updateSystem($data);

        if ($application) {
            if($status)
            {
                return redirect()->back()->with('down', 'System is in Maintenance Mode!');
            }
            else
            {
                return redirect()->back()->with('success', 'System back Online!');
            }
        } else {
            return redirect()->back()->with('errors', 'Updating System Status failed.');
        }
    }
}
