<?php
include("config.php");
include("functions.php");
session_start();
if(!isset($_GET['act'])){
	echo "die";
	die();
}

function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set("Asia/Manila");
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function get_login(){
    $to = '1042';
    if(isset($_SESSION['esdvms_requestor_erole'])){
        if( $_SESSION['esdvms_requestor_erole'] == 'requestor'){
            $to = $_SESSION['esdvms_requestor_username'];
        }
    }

    return $to;
}

function format_notification($msg,$title){
    $data = array();
    if($title == 'Updated Request'){
        $json = explode("|", $msg);
        $json['message'] = $json[1];
        $data['id'] = str_replace("id:", "", $json[0]);
        $data['refcode'] = request_refcode(str_replace("id:", "", $json[0]));
        $data['message'] = $json['message']; 
    }
    elseif($title == 'Created New Request'){
        $json = json_decode($msg, true); 
        $data['id'] = $json['id'];
        $data['refcode'] = request_refcode($json['id']);
        $data['message'] = "";       
    }
    elseif($title == 'New Message'){
        $json = json_decode($msg, true); 
        $data['id'] = $json['request_id'];
        $data['refcode'] = request_refcode($json['request_id']);
        $data['message'] = $json['message'];        

    }

    return $data;
}

if($_GET['act']=="update_request_status"){
  $new_status = $_POST['cs_status'];
  $id = $_POST['cs_id'];
  $not_editable = 1;
  if($new_status == 'New Request'){
    $not_editable = 0;
  }
  $update = sqlsrv_query($conn,"update vehicle_request set 
            status='".$new_status."',             
            updated_by='".$_SESSION['esdvms_username']."',
            updated_at='".date('Y-m-d H:i:s')."',
            lastStatusChanged='".date('Y-m-d H:i:s')."',
            lastStatusChangedBy='".$_SESSION['esdvms_username']."',
            isNotEditable='".$not_editable."' where id = '".$id."'");
  $logs = add_history($id,$_SESSION['esdvms_username']." Updated this request<br> &nbsp;&nbsp;&nbsp;&nbsp; STATUS to: <b>".strtoupper($new_status)."</b><br>");
}
if($_GET['act']=="checkinput"){
	$ck=sqlsrv_fetch_array(sqlsrv_query($conn,"select * from downtime where
		unitId='".$_POST['unit']."' and (dateStart<='".$_POST['endd']."' AND dateEnd>='".$_POST['startd']."')"));
	if($ck['id']){
		echo "<div class='alert alert-danger'>
								<strong>Error!</strong> There is already an existing downtime record for these dates.
							</div>";		
	}
	else{
		echo "";
	}	

}

if($_GET['act']=="get_request_details"){
  $r = sqlsrv_fetch_array(sqlsrv_query($conn,"select *,convert(nvarchar(MAX), date_needed, 20) as need from vehicle_request where id='".$_POST['id']."'"));
  $i = sqlsrv_fetch_array(sqlsrv_query($conn,"select * from request_other_info where request_id='".$_POST['id']."'"));
	$r['request_id'] = $i['request_id'];
	$r['contact_person'] = $i['contact_person'];
	$r['designation'] = $i['designation'];
	$r['depti'] = $i['dept'];
	$r['contact_no'] = $i['contact_no'];
	$r['delivery_site'] = $i['delivery_site'];
	$r['other_instructions'] = $i['other_instructions'];
	$r['pickup_dept'] = $i['pickup_dept'];
	$r['pickup_location'] = $i['pickup_location'];
  $r['need'] = date('Y-m-d H:i',strtotime($r['need']));
  echo json_encode($r);
}

if($_GET['act']=="edit_request_status"){
 

}

function refcode($x){
    $r = 'TN-';
    for($i = 1; $i<=(6 - strlen($x)); $i++){
        $r .= "0";
    }
    return $r.$x;
}

if($_GET['act']=="notifications_show"){
    $to = get_login();    
    $ck=sqlsrv_query($conn,"select *,convert(nvarchar(MAX), addedDate, 20) as Added from notifications where [to]='".$to."' and message like '%|%' and isNotified=0 ORDER BY addedDate DESC");
    $result['qqq'] = "select *,convert(nvarchar(MAX), addedDate, 20) as Added from notifications where [to]='".$to."' and message like '%|%' and isNotified=0 ORDER BY addedDate DESC";
    $notification_content='';
    $counter = 0;
    while($r = sqlsrv_fetch_array($ck)){
        $counter++;
        $icon = '<span class="label label-sm label-icon label-success"><i class="fa fa-pencil-square-o"></i></span>';
        if($r['title']=='New Message'){
            $icon = '<span class="label label-sm label-icon label-success"><i class="fa fa-comments"></i></span>';
        }
        $msg = format_notification($r['message'],$r['title']);
        $notification_content.='            
            <li>
                <span class="photo"> '.$icon.' </span>
                <span class="subject">
                    <span class="from"> '.$r['from'].' </span>
                    <span class="time"> '.time_elapsed_string($r['Added']).' </span>
                </span>
                <span class="message"> <a href="#" onclick="toggle_comments('.$msg['id'].')" id="'.$msg['id'].'">'.$r['title'].' - '.$msg['refcode'].' </a> </span>  
            </li>
        ';
    }
    $result['notification'] = ' 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-bell"></i>
            <span class="badge badge-default" id="notification_total">
            '.$counter.' </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <p>
                         You have '.$counter.' new notifications
                    </p>
                </li>
                <li>
                    <ul class="dropdown-menu-list scroller" style="height: 300px;">
                        '.$notification_content.'            
                    </ul>
                </li>
                
            </ul>
 
    ';
    $result['notification'].='</ul>';
    $to = get_login();    
    $n = sqlsrv_fetch_array(sqlsrv_query($conn,"select top 1 * from notifications where isNotified = '0' and [to]='".$to."' order by id"));
    if($n['id']){
        $not = format_notification($n['message'],$n['title']);
        $result['noti_msg']=$n['title'];
        $result['noti_refcode']=$not['refcode'];
        $result['noti_from']=$n['from'];
        $result['id'] = $not['id'];
        $result['has_noti']=1;
        $closed_noti = sqlsrv_query($conn,"WAITFOR DELAY '00:00:03'; update notifications set isNotified=1 where id='".$n['id']."'");
    }
    else{
        $result['has_noti']=0;
    }
    
    echo json_encode($result);
   

}


if($_GET['act']=="comments_show"){
    $id = $_POST['id'];

    $ck=sqlsrv_query($conn,"select *,convert(nvarchar(MAX), AddedAt, 20) as Added from vehicle_request_comments where
        request_id='".$id."' ORDER BY AddedAt DESC");
    $comments = '
    <h3 class="list-heading" id="msg_refcode">'.request_refcode($id).'</h3>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <textarea name="msg_chat" id="msg_chat" class="form-control margin-bottom-10" placeholder="New Message" cols="30" rows="5"></textarea>
            <span class="label label-sm label-danger " id="msg_error"></span>
            <a href="#" class="btn green btn-sm pull-right" onclick=\'send_comment($("#msg_chat").val(), '.$id.');\'>Send Message</a>
        </div>
    </div>
    
    <ul class="feeds list-items">
    ';
    while($r = sqlsrv_fetch_array($ck)){
        //$upd = sqlsrv_query($conn,"update notifications where ");
        $comments.='
            <li>
                <div class="col1">                    
                    <div class="desc">
                        <span class="label label-sm label-danger ">'.$r['username'].' - '.time_elapsed_string($r['Added']).'</span>
                        '.$r['comment'].'
                    </div>                       
                </div>                
            </li>
        ';
    }
    echo $comments.'</ul>';

}

if($_GET['act']=="comments_show_chatarea"){
    $id = $_POST['id'];
    $comments = '
    <h3 class="list-heading" id="msg_refcode">'.refcode($id).'</h3>
    <input type="hidden" name="msg_id" id="msg_id">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <textarea name="msg_chat" id="msg_chat" class="form-control margin-bottom-10" placeholder="New Message" cols="30" rows="5"></textarea>
            <span class="label label-sm label-danger " id="msg_error"></span>
            <a href="#" class="btn green btn-sm pull-right" onclick=\'send_comment($("#msg_chat").val(), '.$id.');\'>Send Message</a>
        </div>
    </div>';
    
    echo $comments;

}

if($_GET['act']=="comments_save"){

    $user = (isset($_SESSION['esdvms_username']) ? $_SESSION['esdvms_username'] : $_SESSION['esdvms_requestor_username']);
    $insert=sqlsrv_query($conn,"INSERT INTO vehicle_request_comments([request_id]
    ,[username]
    ,[AddedAt]
    ,[comment])
    VALUES('".strtoupper($_POST['id'])."','".$user."',GETDATE(),'".$_POST['txt']."')");
}

if($_GET['act']=="comments_last_record"){

     $r=sqlsrv_fetch_array(sqlsrv_query($conn,"select top 1 * from vehicle_request_comments where request_id='".$_POST['id']."' order by id desc"));
     echo $r['comment'];
}



if($_GET['act']=="changefilters"){
	$conditions='';
	if($_POST['s_equipment']<>''){
		$conditions.=" and equipment='".$_POST['s_equipment']."'";
	}
	if($_POST['s_type']<>''){
		$conditions.=" and type='".$_POST['s_type']."'";
	}
	$data='<option value="" selected="selected"> - Select Unit -';
	$uq=sqlsrv_query($conn,"select distinct id,brand,model,plateNo,location from unit where id>0 ".$conditions." order by brand,model,plateNo,location");
	while($u=sqlsrv_fetch_array($uq)){				
		$data.='<option value="'.$u['id'].'"  >'.$u['brand'].' '.$u['model'].' '.$u['plateNo'].' '.$u['location'];
	}
	echo '<select class="form-control input-sm" name="s_id" id="s_id">'.$data.'</select>';
}

if($_GET['act']=="changefilterstype"){
	$data='<option value="" selected="selected"> - Select Type -';
	$conditions='';
	if($_POST['s_equipment']<>''){
		$conditions.=" and equipment='".$_POST['s_equipment']."'";
	}
	 $uq=sqlsrv_query($conn,"select distinct type from unit where id>0 ".$conditions." order by type");
     while($u=sqlsrv_fetch_array($uq)){     	
     	$data.='<option value="'.$u['type'].'">'.$u['type'];
     }
	echo '<select class="form-control input-sm" name="s_type" id="s_type">'.$data.'</select>';
}

if($_GET['act']=="dis_dept"){
	$data='<div class="portlet box green-haze">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-bars"></i>Detail
                </div>
                <div class="actions">
                      <a href="javascript:;" class="btn btn-sm btn-success" onclick=\'exportexcel("jtable2");\'><i class="fa fa-file-excel-o"></i> Export </a>
                </div>
              </div>
              <div class="portlet-body">
                 <table class="table" id="jtable2" style="font-size:12px;font-family:arial;">
                    <thead>
                       <tr>
                          <th>Seq</th>
                          <th>Unit</th>
                          <th>Dept</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>Hrs</th>                         
                          <th>Remarks</th>
                       </tr>
                    </thead>
                    <tbody>
                      
                   ';
	$q = sqlsrv_query($conn,"select de.name as dept,CONVERT(VARCHAR(19),d.dateStart) as ds,CONVERT(VARCHAR(19),d.dateEnd) as de,d.*,u.equipment as uni,u.brand,u.model, 
                                          	u.plateNo,u.avNo from  dispatch d 
                                 right join department de on de.id=d.deptId                               
                                 left join unit u on u.id=d.unitId
                                 where d.deptId='".$_POST['id']."' and (dateStart>='".$_POST['start']."' OR dateEnd<='".$_POST['end']."')");

	$seq = 0;
  $totalh = 0;
	while($l=sqlsrv_fetch_array($q)){
		$seq++;
    $intervalss  = abs(strtotime($l['ds']) - strtotime($l['de']));
    $minuted   = round($intervalss / 60);
    $houred = $minuted / 60;
    $totalh += $houred;
		$data.='<tr>
					<td>'.$seq.'</td>
					<td>'.$l['uni'].' '.$l['brand'].' '.$l['model'].' '.$l['avNo'].'</td>
                   	<td>'.$l['dept'].'</td>
          			<td>'.$l['ds'].'</td>
          			<td>'.$l['de'].'</td>
                <td>'.number_format($houred,2).'</td>
          			<td>'.$l['purpose'].'</td>
				</tr>';
	}
	$data.=' <tr style="font-size:15px;color:blue;font-weight:bold;"><td>Total:</td><td colspan="5" align="right">'.number_format($totalh,2).'</td><td>&nbsp;</td></tr>
                  </tbody>
                 </table>
              </div>
            </div>';
    echo $data;
}
if($_GET['act']=="dis_vehicle"){
	$data='<div class="portlet box green-haze">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-bars"></i>Detail
                </div>
                <div class="actions">
                      <a href="javascript:;" class="btn btn-sm btn-success" onclick=\'exportexcel("jtable2");\'><i class="fa fa-file-excel-o"></i> Export </a>
                </div>
              </div>
              <div class="portlet-body">
                 <table class="table" id="jtable2" style="font-size:12px;font-family:arial;">
                    <thead>
                       <tr>
                          <th>Seq</th>
                          <th>Unit</th>
                          <th>Dept</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>Hrs</th>
                          <th>Remarks</th>
                       </tr>
                    </thead>
                    <tbody>
                      
                   ';
	$q = sqlsrv_query($conn,"select de.name as dept,CONVERT(VARCHAR(19),d.dateStart) as ds,CONVERT(VARCHAR(19),d.dateEnd) as de,d.*,u.equipment as uni,u.brand,u.model, 
                                          	u.plateNo,u.avNo from  dispatch d 
                                 right join department de on de.id=d.deptId                               
                                 left join unit u on u.id=d.unitId
                                 where d.unitId='".$_POST['id']."' and (dateStart>='".$_POST['start']."' OR dateEnd<='".$_POST['end']."')");

	$seq = 0;
  $totalh = 0;
	while($l=sqlsrv_fetch_array($q)){
		$seq++;
    $intervalss  = abs(strtotime($l['ds']) - strtotime($l['de']));
    $minuted   = round($intervalss / 60);
    $houred = $minuted / 60;
    $totalh += $houred;
		$data.='<tr>
					<td>'.$seq.'</td>
					<td>'.$l['uni'].' '.$l['brand'].' '.$l['model'].' '.$l['avNo'].'</td>
                   	<td>'.$l['dept'].'</td>
          			<td>'.$l['ds'].'</td>
          			<td>'.$l['de'].'</td>
                <td>'.number_format($houred,2).'</td>
          			<td>'.$l['purpose'].'</td>
				</tr>';
	}
	$data.=' <tr style="font-size:15px;color:blue;font-weight:bold;"><td>Total:</td><td colspan="5" align="right">'.number_format($totalh,2).'</td><td>&nbsp;</td></tr>
  </tbody>
                 </table>
              </div>
            </div>';
    echo $data;
}
if($_GET['act']=="dis_type"){
	$data='<div class="portlet box green-haze">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-bars"></i>Detail
                </div>
                <div class="actions">
                      <a href="javascript:;" class="btn btn-sm btn-success" onclick=\'exportexcel("jtable2");\'><i class="fa fa-file-excel-o"></i> Export </a>
                </div>
              </div>
              <div class="portlet-body">
                 <table class="table" id="jtable2" style="font-size:12px;font-family:arial;">
                    <thead>
                       <tr>
                          <th>Seq</th>
                          <th>Type</th>
                          <th>Unit</th>
                          <th>Dept</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>Hrs</th>
                          <th>Remarks</th>
                       </tr>
                    </thead>
                    <tbody>
                      
                   ';
	$q = sqlsrv_query($conn,"select de.name as dept,CONVERT(VARCHAR(19),d.dateStart) as ds,CONVERT(VARCHAR(19),d.dateEnd) as de,d.*,u.equipment as uni,u.brand,u.model, 
                                          	u.plateNo,u.avNo,u.type from  dispatch d 
                                 right join department de on de.id=d.deptId                               
                                 left join unit u on u.id=d.unitId
                                 where d.unitId='".$_POST['id']."' and (dateStart>='".$_POST['start']."' OR dateEnd<='".$_POST['end']."')");

	$seq = 0;
  $totalh = 0;
  $houred = 0;
	while($l=sqlsrv_fetch_array($q)){
		$seq++;
    $intervalss  = abs(strtotime($l['ds']) - strtotime($l['de']));
    $minuted   = round($intervalss / 60);
    $houred = $minuted / 60;
    $totalh += $houred;
		$data.='<tr>
					<td>'.$seq.'</td>
					<td>'.$l['type'].'</td>
					<td>'.$l['uni'].' '.$l['brand'].' '.$l['model'].' '.$l['avNo'].'</td>
                   	<td>'.$l['dept'].'</td>
          			<td>'.$l['ds'].'</td>
          			<td>'.$l['de'].'</td>
                <td>'.number_format($houred,2).'</td>
          			<td>'.$l['purpose'].'</td>
				</tr>';
	}
	$data.=' <tr style="font-size:15px;color:blue;font-weight:bold;"><td>Total:</td><td colspan="6" align="right">'.number_format($totalh,2).'</td><td>&nbsp;</td></tr>
  </tbody>
                 </table>
              </div>
            </div>';
    echo $data;
}

if($_GET['act']=="calculate"){
  
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

  $u = sqlsrv_fetch_array(sqlsrv_query($conn,"select * from unit where id='".$_POST['unit']."'"));

  $required_daily_availability=$u['required_availability_hours'];

  $from12 = number_format(abs(strtotime($_POST['endd']) - strtotime( date('Y-m-d',strtotime($_POST['endd'])).' 00:00:00') )/3600,2);

  $from7 = number_format(abs(strtotime($_POST['endd']) - strtotime( date('Y-m-d',strtotime($_POST['endd'])).' 07:00:00') )/3600,2);
  if(date('H',strtotime($_POST['endd'])) < 7){ // If Before 7am
    $from7=0;
  }

  $trepair_days =  (strtotime($_POST['endd']) - strtotime($_POST['startd']) ) / (60 * 60 * 24);

  $trepair_hours =  ($trepair_days * 8) + $from7;

  $shop_days = (strtotime($_POST['endd']) - strtotime($_POST['reported_date']." ".date('H:i:s',strtotime($_POST['startd']))) ) / (60 * 60 * 24);

  $shop_hours = ($shop_days * 24) + $from12;
  
  $mechanics = ($_POST['mechanics']<>'' ? count(explode(",", $_POST['mechanics'])):0 );
  $man_hours = $trepair_hours * $mechanics;

  $downtime = ($shop_days * $required_daily_availability) + $from7; 

  //echo $downtime." * xxx";
  echo '<br>
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

?>