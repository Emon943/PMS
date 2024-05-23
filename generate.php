<?php
include "config.php";
$dbObj = new DBUtility();
$id=base64_decode($_GET["id"]);

header('Content-disposition: attachment; filename='.$id.'_DSE_042.txt');
header('Content-type: text/plain');

$sql="SELECT * FROM ipo_application WHERE company_id='$id'and status=1";
$res= $dbObj->select($sql);
//print_r($res);
//$file=$inst_name.".txt";

if($res){
for($i=0; $i<count($res);$i++){
echo @$res[$i]['serial']."~".@$res[$i]['advisory_no']."~".@$res[$i]['ac_no']."~".@$res[$i]['name']."~".@$res[$i]['bo_id']."~".@$res[$i]['applicant_type']."~".@$res[$i]['currency']."~".@$res[$i]['total_amt']."~".@$res[$i]['company_id']."\r\n";
}}?>