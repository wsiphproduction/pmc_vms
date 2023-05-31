<?php
$serverName = "172.16.20.28";
$connectionInfo = array( "Database"=>"vmsdb20200718", "UID"=>"sa", "PWD"=>"password" );
$conn = sqlsrv_connect($serverName, $connectionInfo);

/*$serverName = "172.16.20.43";
$connectionInfo = array( "Database"=>"vms_test", "UID"=>"sa", "PWD"=>"@Temp123!" );
$conn = sqlsrv_connect($serverName, $connectionInfo);*/

date_default_timezone_set("Asia/Manila");

$hour_allowance = 5;
function request_refcode($x){
      $r = '';
      for($i = 1; $i<=(6 - strlen($x)); $i++){
         $r .= "0";
      }

      return "WR-".$r.$x;
   }
?>
