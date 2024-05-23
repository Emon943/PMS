<?php
include("../config.php");
 $dbObj = new DBUtility();
 
 echo $fromdate = $_POST['fromdate'];
 echo $todate = $_POST['todate'];
 $ac_no = $_POST['ac_no'];
 $from_date = date('m-d-Y', strtotime($fromdate));
 $to_date = date('m-d-Y', strtotime($todate));
 $previous_date=date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
 //die();


?>


<div style="height: 1.32in !important; width: 9.3in;">
<img src="img/printer-green.png" height="45" width="45" onclick="print_rpt()" style="float: right; cursor: pointer;" title="Print" />
</div>

<div id="PrintArea" style="background-color: white;" >
	<style>
		.table_body  tr th{
			border: 1px solid;
			font-size: 15px;
			text-align: center;
			padding: 2px;
		}
		.table_body tbody tr td {
			border: 1px solid;
			font-size: 16px !important;
		}
	</style>
  <?php
  /* Start Balance forward*/
   $bfsql="SELECT * FROM tbl_balance_forward WHERE ac_no='$ac_no' AND `date` = '$previous_date'";
   $balace_forward= $dbObj->select($bfsql);
   if($balace_forward){
	  $bf=$balace_forward[0]['balace_forward'];
   }else{
	 $bf="0.00";
   }
   /* End Balance forward*/
   
   $dsql="SELECT * FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $dres= $dbObj->select($dsql);
   $wsql="SELECT * FROM tbl_withdraw_balance WHERE account_ref='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $wres= $dbObj->select($wsql);
   $result=(array_merge($dres,$wres));
   //$ssql="SELECT * FROM `tread_data_list` WHERE account_no='$ac_no' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
   //$BSr= $dbObj->select($ssql);
   
    $ssql="SELECT instrument,type,curr_date,SUM(quantity) as quantity,SUM(rate) as rate , SUM(commission) as commission,SUM(total_amount) as total_amount, SUM(net_amount) as net_amount FROM `tread_data_list` WHERE account_no='$ac_no' AND type='S' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY curr_date";
    $Sr= $dbObj->select($ssql);
	
	$bsql="SELECT instrument,type,curr_date,SUM(quantity) as quantity,SUM(rate) as rate , SUM(commission) as commission,SUM(total_amount) as total_amount, SUM(net_amount) as net_amount FROM `tread_data_list` WHERE account_no='$ac_no' AND type='B' AND `curr_date` BETWEEN '$fromdate' AND '$todate' GROUP BY curr_date";
    $Br= $dbObj->select($bsql);
    $BSr=(array_merge($Sr,$Br));
  //print_r($BSr);
   
	
   $sql_interest="SELECT * FROM tbl_interest_quaterly WHERE ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res_interest= $dbObj->select($sql_interest);
   
$sql_ipo="SELECT * FROM ipo_application WHERE ac_no='$ac_no' AND status=1 AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res_sql_ipo= $dbObj->select($sql_ipo);
   //print_r ($res_sql_ipo);
   
    $sql_charge="SELECT * FROM tbl_charge_info WHERE ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
    $res_charge= $dbObj->select($sql_charge);
    $res_com=(array_merge($res_sql_ipo,$res_charge));
   echo '<pre>';
    //print_r ($res_com);
   echo '</pre>';
 // die();
  
	
  ?>
			
            <div style="height: 12.32in !important; width: 10.3in;">
                <img src="img/background.png" style=" width: 10.3in; height:12.32in; position:absolute; background-position:center;" />
                <div style="height:7.165in; z-index: 999999999999; position: relative; padding-top: 200px; width: 90%; padding-left: 75px;">
                   	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
					<h5 style="float:right;">Client Ledger Statement</h5>
					</div>
                    <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
                        <!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
                        <!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
						<p style="font-size: 12px; font-weight:bold;">From Date: <?php echo $from_date; ?>     &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;   To Date: <?php echo $to_date;?></p>
                 
                    </div>
					
					<div>
					<h5 style="float:right;"><strong>Balance Forward :</strong><?php echo $bf;?></h5>
					</div>
					
                    <div>
					
                        <table class="table_body" border="0" width="100%">
                            <thead>
                            <tr>
							    <th width="100px">Date</th>
                                <th width="80px">Type</th>
                                <th width="350px">Description</th>
                                <th>Quantity</th>
                                <th>Rate(TK)</th>
                                <th>Amount(TK)</th>
                                <th>Comm(TK)</th>
								<th>Debit(TK)</th>
								<th>Credit(TK)</th>
								<th>Balance(TK)</th>
								
                            </tr>
                            </thead>
                           
                           
							
                        </table>
						
						 <?php 
					if($BSr || $result || $res_com || $res_interest ){
						 $sum=0.00;
						 $sum=$sum+$bf;
						 for($i=0;$i<count($BSr);$i++){
                         $total_comm=$BSr[$i]['commission'];
						 $total_commi=number_format($total_comm ,2);
						 $date=$BSr[$i]['curr_date'];
						 $total_amount=$BSr[$i]['total_amount'];
						 $quantity=$BSr[$i]['quantity'];
						 $rate=$total_amount/$quantity;
						 $avg_rate=number_format($rate ,2);
						 $type=$BSr[$i]['type'];
						 $net_amount=$BSr[$i]['net_amount'];
						 $instrument=$BSr[$i]['instrument'];
                         $l=strlen($instrument);
                         $fix_num=30-$l;
                         
                          echo str_repeat("&nbsp;" ,$fix_num);
						
						 if($type=="B"){
						 $sum=($sum-$net_amount);
						 }else{
						  $sum=($sum+$net_amount);
						 }
						 ?>
						 
		                <p style="margin: 0 0 0px;"><?php echo $date;?> &nbsp;&nbsp;&nbsp; <?php echo $BSr[$i]['type'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BSr[$i]['instrument'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BSr[$i]['quantity'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $avg_rate;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BSr[$i]['total_amount'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_commi;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($BSr[$i]['type']=="B"){ echo $BSr[$i]['net_amount'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($BSr[$i]['type']=="S"){ echo $BSr[$i]['net_amount'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum;?></p>
						 <p style="margin: 0 0 0px;">...........................................................................................................................................................................................................................................................................................</p> 
						 
						  <?php } ?>
						 
						 <?php for($i=0;$i<count($result);$i++){
						  $type=@$result[$i]['type'];
                          $withdraw_amt=@$result[$i]['withdraw_amt'];
                          $deposit_amt=@$result[$i]['deposit_amt'];	
                          							  
						   if($type=="Payment"){
						 $sum=($sum-$withdraw_amt);
						 }else{
						  $sum=($sum+$deposit_amt);
						 }
						   ?>
						  <p style="margin: 0 0 0px;"><?php echo $result[$i]['date'];?> &nbsp;&nbsp;<?php echo $result[$i]['type'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result[$i]['des'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<?php if($result[$i]['type']=="Payment"){ echo $result[$i]['withdraw_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($result[$i]['type']=="Receipt"){ echo $result[$i]['deposit_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum;?></p>
						  
						 <p style="margin: 0 0 0px;">.........................................................................................................................................................................................................................................
						 <?php } ?>
						 
						 
						 <?php for($i=0;$i<count($res_interest);$i++){
						  $type=@$res_interest[$i]['type'];
						   $daily_interest=@$res_interest[$i]['total_interest_amt'];
                          							  
						 if($type=="Payment"){
						 $sum=($sum-$daily_interest);
						 }else{
						  $sum=($sum+$daily_interest);
						 }
						   ?>
						  <p style="margin: 0 0 0px;"><?php echo $res_interest[$i]['date'];?> &nbsp;&nbsp;&nbsp; <?php echo $res_interest[$i]['type'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $res_interest[$i]['description'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($res_interest[$i]['type']=="Payment"){ echo $res_interest[$i]['total_interest_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($res_interest[$i]['type']=="Receipt"){ echo $res_interest[$i]['total_interest_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum;?></p>
						  
						 <p style="margin: 0 0 0px;">.........................................................................................................................................................................................................................................						 <?php } ?>
						 
						 
						 
						 <?php for($i=0;$i<count($res_com);$i++){
						  $type=@$res_com[$i]['type'];
						  $short_name=@$res_com[$i]['short_name'];
						  $total_amt=@$res_com[$i]['total_amt'];
						  $description=@$res_com[$i]['description'];
						  $des=$description." ".$short_name;					  
						   if($type=="Payment"){
						 $sum=($sum-$total_amt);
						 }else{
						  $sum=($sum+$total_amt);
						 }
						   ?>
						  <p style="margin: 0 0 0px;"><?php echo $res_com[$i]['date'];?> &nbsp;&nbsp;&nbsp; <?php echo $res_com[$i]['type'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $des;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo "0.00";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($res_com[$i]['type']=="Payment"){ echo $res_com[$i]['total_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($res_com[$i]['type']=="Receipt"){ echo $res_com[$i]['total_amt'];}else{ echo "0.00";}?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum;?></p>
						  
						  <p style="margin: 0 0 0px;">.........................................................................................................................................................................................................................................
						 <?php } ?>
						   
						   
    <!--                    <h6>--><?php //echo $school_info['footer_caption'];?><!--</h6>-->
                        <div style="width: 100% ; border-top: 1px solid; border-bottom: 1px solid; "></div>
                        <div style="padding: 5px; margin-top: 20px; ">
                      
							<div style="float: right;font-size: 12px; font-weight:bold;"></div>
                        </div>
						
					
						

                    </div>
                </div>
            
		
	<?php }else{ ?>
		<h2 style="Color:red">Result Not Found</h2>
		 
	<?php } ?>

</div>
