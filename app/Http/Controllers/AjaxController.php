<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    public function index(Request $request)
    {

        if($request->has('act'))
        {
            switch($request->get('act')) {
                case "notifications_show" :
                    return $this->notifications_show();     
                    break;
                case "calculate":
                    return $this->calculate();
                    break;
            }
        }

        return;
    }


    public function calculate()
    {
        $required_daily_availability=0;
        $from12 = 0;
        $from7 = 0;
        $trepair_days = 0;
        $trepair_hours = 0;
        $shop_days = 0;
        $shop_hours = 0;
        $man_hours = 0;  
        $downtime=0;
        $ytd_annual=0;
        $ytd_quarter=0;
        $ytd_month=0;
        $ytd_day=0;

        $unit = Unit::where('id',request()->get('unit'))->firstOrFail();

        $required_daily_availability = $unit['required_availability_hours'];
        $from12 = number_format(abs(strtotime(request()->input('endd')) - strtotime( date('Y-m-d',strtotime(request()->input('endd'))).' 00:00:00') )/3600,2);
        $from7 = number_format(abs(strtotime(request()->input('endd')) - strtotime( date('Y-m-d',strtotime(request()->input('endd'))).' 07:00:00') )/3600,2);
        
        if( date( 'H', strtotime(request()->input('endd')) ) < 7){ // If Before 7am
            $from7 = 0;
        }

        $trepair_days =  (strtotime( request()->input('endd') ) - strtotime( request()->input('startd') ) ) / (60 * 60 * 24);
        $trepair_hours =  ($trepair_days * 8) + $from7;
        $shop_days = (strtotime( request()->input('endd') ) - strtotime( request()->input('reported_date') ." ".date('H:i:s',strtotime( request()->input('startd') ))) ) / (60 * 60 * 24);
        $shop_hours = ($shop_days * 24) + $from12;
        $mechanics = ( request()->input('mechanics') <> '' ? count(explode(",", request()->input('mechanics') )):0 );
        $man_hours = $trepair_hours * $mechanics;
        $downtime = ($shop_days * $required_daily_availability) + $from7;

        return '<br>
                <input type="hidden" name="from12" id="from12" value="'.$from12.'">
                <input type="hidden" name="from7" id="from7" value="'.$from7.'">
                <input type="hidden" name="trepair_days" id="trepair_days" value="'.$trepair_days.'">
                <input type="hidden" name="trepair_hours" id="trepair_hours" value="'.$trepair_hours.'">
                <input type="hidden" name="shop_days" id="shop_days" value="'.$shop_days.'">
                <input type="hidden" name="shop_hours" id="shop_hours" value="'.$shop_hours.'">
                <input type="hidden" name="man_hours" id="man_hours" value="'.$man_hours.'">
                <input type="hidden" name="required_daily_availability" id="required_daily_availability" value="'.$required_daily_availability.'">
                <input type="hidden" name="downtime" id="downtime" value="'.$downtime.'">

                <div class="portlet box red">
                    <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-excel-o"></i>Calculation
                    </div>
                    </div>
                    <div class="portlet-body">
                    <table class="table table-bordered">
                        <tr><td>Hrs from 12AM</td><td align="right">'.$from12.'</td></tr>
                        <tr><td>Hrs from 7AM</td><td align="right">'.$from7.'</td></tr>
                        <tr><td>Repair Days</td><td align="right">'.$trepair_days.'</td></tr>
                        <tr><td>Repair Hours</td><td align="right">'.$trepair_hours.'</td></tr>
                        <tr><td>Shop Days</td><td align="right">'.$shop_days.'</td></tr>
                        <tr><td>Shop Hrs</td><td align="right">'.$shop_hours.'</td></tr>
                        <tr><td>Man Hrs</td><td align="right">'.$man_hours.'</td></tr>
                        <tr><td>Required Daily Availability</td><td align="right">'.$required_daily_availability.'</td></tr>
                        <tr><td>Downtime Calculation</td><td align="right">'.$downtime.'</td></tr>
                    </table>
                    </div>
                </div>
                ';

        
    }

    public function notifications_show()
    {
        $to = $this->get_login();

        $query = "select *, convert(nvarchar(MAX), addedDate, 20) as Added FROM notifications WHERE [to] = '".$to."' AND message LIKE '%|%' AND isNotified=0 ORDER BY addedDate DESC";
        $notifications = DB::select($query);
        $notification_content = "";
        $counter = 0;
        $icon = "";
        
        foreach($notifications as $value)
        {

            $counter++;
            $icon = '<span class="label label-sm label-icon label-success"><i class="fa fa-pencil-square-o"></i></span>';

            if($value['title'] == "New Message")
            {
                $icon = '<span class="label label-sm label-icon label-success"><i class="fa fa-comments"></i></span>';
            }

            $message = $this->format_notification($value['message'], $value['title']);
            $notification_content .= 
            '<li>
                <span class="photo"> ' . $icon . ' </span>
                <span class="subject">
                    <span class="from"> ' . $value['from'] . ' </span>
                    <span class="time"> ' . time_elapsed_string($value['Added']) . ' </span>
                </span>
                <span class="message"> <a href="#" onclick="toggle_comments(' . $message['id'] . ')" id="' . $message['id'] . '">' . $value['title'] . ' - ' . $message['refcode'] . ' </a> </span>  
            </li>';
        }


        $result['notification'] = 
        ' 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-bell"></i>
            <span class="badge badge-default" id="notification_total">
            ' . $counter . ' </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <p>
                         You have ' . $counter . ' new notifications
                    </p>
                </li>
                <li>
                    <ul class="dropdown-menu-list scroller" style="height: 300px;">
                        ' . $notification_content . '            
                    </ul>
                </li>
            </ul>';

        $result['notification'] .= '</ul>';
        $to = $this->get_login();

        $query = "select TOP 1 notifications.* from notifications where isNotified = 0 and [to]= '".$to."' order by id";
        $result_ = DB::select($query);

        if(! empty($result_['id']))
        {
            $not = $this->format_notification($result_['message'], $result_['title']);
            $result['noti_msg'] = $result_['title'];
            $result['noti_refcode'] = $not['refcode'];
            $result['noti_from'] = $result_['from'];
            $result['id'] = $not['id'];
            $result['has_noti'] = 1;
            $closed_noti = DB::select('update notifications set isNotified=1 where id="'.$result_['id'].'" ');
        }
        else 
        {
            $result['has_noti'] = 0;
        }

        return  $result;
    }


    //PRIVATE FUNCTIONS
    public function format_notification($message,$title)
    {
        $data = array();

        if ( $title == 'Updated Request')
        {
            $json = explode("|", $message);
            $json['message'] = $json[1];
            $data['id'] = str_replace("id:", "", $json[0]);
            $data['refcode'] = $this->request_refcode(str_replace("id:", "", $json[0]));
            $data['message'] = $json['message'];
        }
        elseif ($title == 'Created New Request')
        {
            $json = json_decode($message, true);
            $data['id'] = $json['id'];
            $data['refcode'] = $this->request_refcode($json['id']);
            $data['message'] = "";
        }
        elseif ($title == 'New Message') {
            // $json = json_decode($message, true);
            $json = $message;
            $data['id'] = $json['request_id'];
            $data['refcode'] = $this->request_refcode($json['request_id']);
            $data['message'] = $json['message'];
        }

        return $data;
    }

    public function request_refcode($x)
    {
        $r = '';
        for ($i = 1; $i <= (6 - strlen($x)); $i++) {
            $r .= "0";
    }

        return "WR-" . $r . $x;
    }

    public function get_login()
    {

        $to = '1042';

        if( Session::has('esdvms_requestor_erole'))
        {
            if( Session::get('esdvms_requestor_erole') == "requestor")
            {
                $to = Session::get('esdvms_requestor_username');
            }
        }

        return $to;
    }

    //PRIVATE FUNCTIONS
}
