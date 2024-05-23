<?php
include "config.php";
$dbObj = new DBUtility();
$date=base64_decode($_GET["date"]);
$newDate = date("dmY", strtotime($date));
$file="01052900".$newDate.".01";
header('Content-Disposition: attachment; filename="'.$file.'"');
header('Content-type: text/plain');

$sql="SELECT * FROM sale_share WHERE trade_date='$date'";
$res= $dbObj->select($sql);
$sql1="SELECT SUM(qty) as total_qty FROM sale_share WHERE trade_date='$date'";
$result= $dbObj->select($sql1);
$total_qty=str_pad(@$result[0]['total_qty'],13,"0",STR_PAD_LEFT);
if($res){

$total_row=str_pad(count($res),7,"0",STR_PAD_LEFT);

echo $total_row."".$total_qty." "."admin05290010"."\r\n";

for($i=0; $i<count($res); $i++){
$serial=str_pad($i+1,12,"0",STR_PAD_LEFT);
$newDate = date("dmY", strtotime($res[$i]['trade_date']));
$qty=str_pad(@$res[$i]['qty']."I",13,"0",STR_PAD_LEFT);
$broker_id=str_pad(@$res[$i]['broker_id'],6,"0",STR_PAD_LEFT);
echo $newDate."".@$res[$i]['bo_id']."".@$res[$i]['stock_id']."".$broker_id."".@$res[$i]['isin']."".$qty."".@$res[$i]['account_no']."          ".$serial."\r\n";
}
}?>