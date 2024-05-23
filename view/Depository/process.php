<?php
$dbObj = new DBUtility();
$daily_count=base64_decode($_GET["id"]);
//echo $daily_count;



 $sql="SELECT * FROM sale_share WHERE status='$daily_count' AND day_count='$daily_count'";
 $result= $dbObj->select($sql);
 $sqlq="SELECT * FROM tbl_buy_info WHERE status='$daily_count' AND day_count='$daily_count'";
  $resipo= $dbObj->select($sqlq);
  
 //$matured_date=date("Y-m-d");
 if(@$result){
 for ($i = 0; $i < count($result); $i++){
	$ac_no=@$result[$i]["account_no"];
	$bo_id=@$result[$i]["bo_id"];
	$immatured_bal=@$result[$i]["immatured_bal"];

	
	$sql="SELECT total_balance FROM investor WHERE dp_internal_ref_number='$ac_no'";
    $res= $dbObj->select($sql);
	$total_balance =$res[0]["total_balance"];
	$total = $total_balance+$immatured_bal;
	// echo $total;
	
		   
    $sql2 = "update sale_share set status='1',day_count='matured' where account_no ='$ac_no' AND status='0' AND day_count='0'";
    $dbObj->update($sql2);
	//die();	
	$sql1 = "update investor set total_balance='$total' where dp_internal_ref_number ='$ac_no'";
    $dbObj->update($sql1);
	
   }
 }
	
  if(@$resipo){ 
   //echo count($resipo);
  for ($i = 0; $i < count($resipo); $i++){
	$id=@$resipo[$i]["id"];
	$ac_no=@$resipo[$i]["account_no"];
	$bo_id=@$resipo[$i]["BO_ID"];
	$isin=@$resipo[$i]["ISIN"];
	$qty=@$resipo[$i]["qty"];
	$Current_Bal=@$resipo[$i]["Current_Bal"];
	$total_share=@$qty+$Current_Bal;
	
	$sql_buy = "SELECT * FROM tbl_ipo WHERE BO_ID='$bo_id' AND ISIN='$isin'";
    $buy_share_check= $dbObj->select($sql_buy);
     //print_r($buy_share_check);
	//die();
	if($buy_share_check){
		 $Check_qty =@$buy_share_check[0]["qty"];
		 $Check_Current_Bal =@$buy_share_check[0]["Current_Bal"];
		 $update_current_bal=$Check_Current_Bal+$qty;
		 $update_qty=$Check_qty-$qty;
		 
		 $sql_update_share = "update tbl_ipo set qty='$update_qty',Current_Bal='$update_current_bal' where BO_ID ='$bo_id' AND ISIN='$isin'";
         $dbObj->update($sql_update_share);
	
        $sql3 = "update tbl_buy_info set status='1',day_count='matured',Current_Bal='$total_share',qty='0' where id ='$id' AND status='0' AND ISIN='$isin'";
        $dbObj->update($sql3);
	}
   }
}

echo "<h2 align='center' style='color:#000000'>Successfully Share Matured Process</h2>";
       echo "<meta http-equiv='refresh' content='1 URL=Depository.php?in_house_settlement'>";
       exit;
?>