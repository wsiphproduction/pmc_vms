<?php

date_default_timezone_set('Asia/Kolkata');
$host = "localhost" ;
$user = "exportserveruser";
$pass = "IQ8Lw5UlZE7b";
$db = "exportserverdb";
$con = mysqli_connect($host,$user,$pass);
if (!$con)
{
  die('Could not connect: ' . mysqli_error());
}
$db_selected = mysqli_select_db($db, $con);
if (!$db_selected) {
    die ('Can\'t use '. $db . mysqli_error());
}
