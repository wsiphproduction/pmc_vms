<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DowntimeChartsController extends Controller
{

    public function repairHours(Request $request)
    {

        $start = "2018-05-28";
        $end = date('Y-m-d');

        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart >= '".$start."' and dateEnd <= '".$end." 23:59:59'";

        $query = "select isScheduled, sum(trepair_hours) as total from downtime where tdowntime > 0 and active=1 ".$condition." group by isScheduled";
        $result = DB::select($query);
        
        $str = '';

        foreach($result as $value)
        {
            $str .= '
            {
                "label": "'.($value['isScheduled'] == 1 ? 'Preventive':'Breakdown').'",
                "value": "'.number_format($value['total'], 2).'"
            },';
        }
        
        if( empty($result))
        {
           
            $str .= '
            {
                "label": "N/A",
                "value": "0"
            },';
        }

        $str = rtrim($str,',');

        return view('admin.downtime.charts.repair_hours_by_category', compact('str'));
    }

    public function mtdLightVehicle(Request $request)
    {
        
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart>='".$start."' and dateEnd<= '".$end." 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            u.required_availability_hours,
            u.name,
            sum(tdowntime) as total
        from
            downtime d
            left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = " . "'" . "Light Vehicle" . "'" . $condition ." 
        group by
            u.required_availability_hours,
            u.name
        ";
        
        $result = DB::select($query);

        $str = '';

        foreach($result as $value)
        {
            $mtd = 100 - ($value['total'] / ($diff * $value['required_availability_hours']));
            $str .= '
            {
                "label": "' . $value['name'] . '",
                "value": "' . number_format($mtd, 2) . '"
            },';
        }

        $str = rtrim($str,',');
       
        return view('admin.downtime.charts.mtd_availability_due_to_breakdown_light', compact('str'));
    }

    public function mtdMediumVehicle(Request $request)
    {

        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart>='" . $start . "' and dateEnd<='" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            u.required_availability_hours,
            u.name,
            sum(tdowntime) as total
        from
            downtime d
            left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = '" . "Medium Vehicle" . "'" . $condition.  "
        group by
            u.required_availability_hours,
            u.name
        ";

        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $mtd = 100 - ($value['total'] / ($diff * $value['required_availability_hours']));
            $str .='
            {
                "label": "'.$value['name'].'",
                "value": "'.number_format($mtd,2).'"
            },
            ';
        }

        $str = rtrim($str,",");

        return view('admin.downtime.charts.mtd_availability_due_to_breakdown_medium', compact('str'));
    }

    public function repairType(Request $request)
    {
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart>='" . $start . "' and dateEnd<='" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "select repairType,sum(trepair_hours) as total from downtime where tdowntime>0 and active=1 ".$condition." group by repairType";
        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $str .='
            {
                "label": "'.$value['repairType'].'",
                "value": "'.number_format($value['total'],2).'"
            },
            ';
        }

        $str = rtrim($str,",");

        return view('admin.downtime.charts.mtd_availability_due_to_breakdown_medium', compact('str'));
    }

    public function mtdHeavyVehicle (Request $request)
    {

        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart >= '" . $start . "' and dateEnd <= '" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            u.required_availability_hours,
            u.name,
            sum(tdowntime) as total
        from
            downtime d
            left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = " . "'Heavy Equipment'" . $condition . "
        group by
            u.required_availability_hours,
            u.name
        ";
       
        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $mtd = 100 - ($value['total'] / ($diff * $value['required_availability_hours']));
            $str .= ' {
                            "label": "' . $value['name'] . '",
                            "value": "' . number_format($mtd, 2) . '"
                        },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.mtd_availability_due_to_breakdown_heavy', compact('str'));
    }

    public function manHours(Request $request)
    {
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart >= '" . $start . "' and dateEnd <= '" . $end .  " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            u.type,
            sum(man_hours) as total
        from
            downtime d
            left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            ".$condition."
        group by
            u.type
        ";
        
        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $str.=' 
            {
                "label": "'.$value['type'].'",
                "value": "'.number_format($value['total'],2).'"
            },';
        }

        $str = rtrim($str,",");

        return view('admin.downtime.charts.man_hours_distribution', compact('str'));
    }

    public function mtdMotor(Request $request)
    {
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = "and dateStart >= '" . $start . "' and dateEnd <= '" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            u.required_availability_hours,
            u.name,
            sum(tdowntime) as total
        from
            downtime d
        left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = 'Motorcycle' " . $condition ." 
        group by
            u.required_availability_hours,
            u.name
        ";

        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $mtd = 100 - ($value['total'] / ($diff * $value['required_availability_hours']));
            $str .= ' 
                    {
                        "label": "' . $value['name'] . '",
                        "value": "' . number_format($mtd, 2) . '"
                    },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.mtd_availability_due_to_breakdown_motorcycle', compact('str'));
    }

    public function rpLightVehicle(Request $request)
    {

        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = "and dateStart >= '".$start."' and dateEnd <= '".$end." 23:59:59'";

        $query = "
        select
            TOP 10
            required_availability_hours,
            u.name,
            sum(trepair_hours) as total
        from
            downtime d
        left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = 'Light Vehicle' " . $condition . "
        group by
            u.required_availability_hours,
            u.name
        ORDER by
            total desc";
       
        $result = DB::select($query);
        $str = '';
        foreach($result as $value)
        {
            $str =  '{
                        "label": "' . $value['name'] . '",
                        "value": "' . number_format($value['total'], 2) . '"
                    },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.repair_hours_light_vehicle', compact('str'));
    }

    public function rpMediumVehicle(Request $request)
    {
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart >= '" . $start . "' and dateEnd <= '" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            TOP 10
            required_availability_hours,
            u.name,
            sum(trepair_hours) as total
        from
            downtime d
            left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = 'Medium Vehicle' ".$condition."
        group by
            u.required_availability_hours,
            u.name
        ORDER by
            sum(trepair_hours) desc
        ";

        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $str .= ' 
                {
                    "label": "'.$value['name'].'",
                    "value": "'.number_format($value['total'],2).'"
                },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.repair_hours_medium_vehicle', compact('str'));
    }


    public function rpHeavyVehicle(Request $request)
    {
        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = "and dateStart >= '" . $start . "' and dateEnd <= '" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            TOP 10
            u.required_availability_hours,
            u.name,
            sum(trepair_hours) as total
        from
        downtime d
        left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = 'Heavy Equipment' ".$condition."
        group by
            u.required_availability_hours,
            u.name
        ORDER by
            sum(trepair_hours) desc
        ";

        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $str.=' {
                        "label": "'.$value['name'].'",
                        "value": "'.number_format($value['total'],2).'"
                    },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.repair_hours_heavy_vehicle', compact('str'));
    }

    public function rpMotor(Request $request)
    {

        $start = "2018-05-28";
        $end = date('Y-m-d');
        
        if(! empty($request->query('start')))
        {
            $start = $request->query('start');
        }
        if(! empty($request->query('end')))
        {
            $end = $request->query('end');
        }

        $condition = " and dateStart >= '" . $start . "' and dateEnd <= '" . $end . " 23:59:59'";
        $datediff = strtotime($end) - strtotime($start);
        $diff = floor($datediff / (60 * 60 * 24));

        $query = "
        select
            TOP 10
            u.required_availability_hours,
            u.name,
            sum(trepair_hours) as total
        from
            downtime d
        left join unit u on u.id = d.unitId
        where
            d.tdowntime > 0
            and d.active = 1
            and u.type = 'Motorcycle' ".$condition."
        group by
            u.required_availability_hours,
            u.name
        ORDER by
            sum(trepair_hours) desc
        ";

        $result = DB::select($query);
        $str = '';

        foreach($result as $value)
        {
            $str.=' {
                        "label": "'.$value['name'].'",
                        "value": "'.number_format($value['total'],2).'"
                    },';
        }

        $str = rtrim($str, ",");

        return view('admin.downtime.charts.repair_hours_motorcycle', compact('str'));
    }
}
