<?php
 include("../config.php");
 $dbObj = new DBUtility();
 
 $broker_id = $_POST['broker_id'];
 $id = $_POST['stock_id'];
 $report_id = $_POST['report_id'];
 $date = $_POST['date'];
 $date = date('d-m-Y', strtotime($date));





/* if($_POST['broker_id']!="")
{
    $brokers_id="and tread_data_list.bokersoftcode='" . $_POST['broker_id'] . "'";
}
else
{
    $brokers_id="";
}
if($_POST['stock_id']!="")
{
     $stocks_id="and tread_data_list.dsc_clear_bo='" . $_POST['stock_id'] . "'";
}
else
{
    $stocks_id="";
}
if($_POST['date']!="")
{
    $date_tread="and tread_data_list.date_tread='" . date('d-m-Y', strtotime($date)) . "'";
}
else
{
    $date_tread="";
} */


?>

<!--<h3 style="color: red">
    ** Note: Please before print setup 1. margin top 0,margin bottom 0,margin left 0,margin right 0. 2. select A4 size page then print.
	
</h3>-->
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
  if($broker_id!=3 && $report_id==1){
   $sqls="SELECT * FROM tbl_stockexchange WHERE stock_id='$id'";
   $res= $dbObj->select($sqls);
   //print_r($res);
   $sql1="SELECT name FROM tbl_broker_hous WHERE trace_id='$broker_id'";
   $result= $dbObj->select($sql1);
   //print_r($result);
   $Bsql="SELECT market,date_tread,SUM(total_amount)as tamt,SUM(broker_commission)as bch FROM tread_data_list WHERE bokersoftcode='$broker_id' AND stock_id='$id' AND date_tread='$date' AND type='B' GROUP BY type";
   $Br= $dbObj->select($Bsql);
    //print_r($Br);
	
   //die();
	$market=@$Br[0]['market'];
	$date_tread=@$Br[0]['date_tread'];
	$total_buy_amt=@$Br[0]['tamt'];
	$total_buy_amts=number_format($total_buy_amt ,2);
	  $broker_buy_charge=@$Br[0]['bch'];
	  $brokers_buy_charge=number_format($broker_buy_charge ,2);
	  $payable=($total_buy_amt+$broker_buy_charge);
	  $payable_no=number_format($payable ,2);
	
    $Ssql="SELECT market,date_tread,SUM(total_amount)as tamt,SUM(broker_commission)as bch FROM tread_data_list WHERE bokersoftcode='$broker_id' AND stock_id='$id' AND date_tread='$date' AND type='S' GROUP BY type";
    $Sr= $dbObj->select($Ssql);

	$total_sell_amt=@$Sr[0]['tamt'];
	$total_sell_amts=number_format($total_sell_amt ,2);
	$broker_sell_charge=@$Sr[0]['bch'];
	$brokers_sell_charge=number_format($broker_sell_charge ,2);
	$receivable=($total_sell_amt-$broker_sell_charge);
	$receivable_no=number_format($receivable ,2);
	$total_broker_charge=@$brokers_buy_charge+$brokers_sell_charge;
    $netted_amt=($total_buy_amt-$total_sell_amt);
	$netted_amts=number_format($netted_amt ,2);
	$net_buy_amt=($total_buy_amt+$total_broker_charge);
	
	

	//die();
	
  ?>
		<?php if($Br || $Sr){ ?>	
            <div style="height: 7.32in !important; width: 10.3in;">
                <img src="img/background.png" style=" width: 11.3in; height:7.32in; position:absolute; background-position:center;" />
                <div style="height:6.165in; z-index: 999999999999; position: relative; padding-top: 200px; width: 95%; padding-left: 85px;">
                   	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
					<h5 style="float:right;">Broker CNS</h5>
					</div>
                    <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
                        <!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
                        <!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
						<h5 style="font-size: 12px; font-weight:bold;">Payment Date: <?php echo date("d-M-Y");?></h5>
                        <h5 style="font-size: 12px; font-weight:bold;">Broker Name: <?php echo $result[0]['name'];?></h5>
                        Stock Exchange: <?php echo $res[0]['stock_name'];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    </div>
                    <div >
					    
                        <table class="table_body" border="0" width="98%">
                            <thead>
                            <tr>
                                <th>Instrument Group</th>
                                <th>Market</th>
                                <th>Trade Date</th>
                                <th>Buy Amount</th>
                                <th>Total Commision</th>
                                <th>Sell Amount</th>
								<th>Netted Amount</th>
								<th>Receivable From Broker</th>
								 <th>Payable To Broker</th>
								
                            </tr>
                            </thead>
                            <tbody>
									
                                    <tr>
                                        <td>
                                            <?php echo "ABGNZ Netted"; ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo $market;?></td>
                                        <td style="text-align: center;"><?php echo $date_tread;?></td>
                                        <td style="text-align: center;"><?php echo $total_buy_amts;?></td>
										<td style="text-align: center;"><?php echo $total_broker_charge;?></td>
                                        <td style="text-align: center;"><?php echo $total_sell_amts; ?></td>
										<td style="text-align: center;"><?php echo $netted_amts; ?></td>
										<td style="text-align: center;"><?php if($net_buy_amt< $total_sell_amt){
											  $receivable=$total_sell_amt-$net_buy_amt;
											   echo $receivable=number_format($receivable ,2);
		                                    }else{
												echo "0.00";
											} ?></td>
										   <td style="text-align: center;"><?php if($net_buy_amt > $total_sell_amt){
											  $payable=$net_buy_amt-$total_sell_amt;
											  echo $payable=number_format($payable ,2);
		                                   }else{
												echo "0.00";
											} ?></td>
                                        
                                    </tr>
									
                                    <?php
                              
                            
                            ?>
                            </tbody>
							
                        </table>
    <!--                    <h6>--><?php //echo $school_info['footer_caption'];?><!--</h6>-->
                        <div style="width: 100% ; border-top: 1px solid; border-bottom: 1px solid; ">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; Grand Total:&nbsp; &nbsp;&nbsp; <?php echo $total_buy_amts; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_broker_charge; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_sell_amts; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $netted_amts;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($net_buy_amt< $total_sell_amt){
											  $receivable=$total_sell_amt-$net_buy_amt;
											   echo $receivable=number_format($receivable ,2);
		                                    }else{
												echo "0.00";
											} ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($net_buy_amt > $total_sell_amt){
											  $payable=$net_buy_amt-$total_sell_amt;
											  echo $payable=number_format($payable ,2);
		                                   }else{
												echo "0.00";
											} ?></div>
                        <div style="padding: 5px; margin-top: 20px; ">
                      
							<div style="float: right;font-size: 12px; font-weight:bold;">Payable To Broker: <?php if($net_buy_amt > $total_sell_amt){
											  $payable=$net_buy_amt-$total_sell_amt;
											  echo $payable=number_format($payable ,2);
		                                   }else{
												echo "0.00";
											} ?></div>
                        </div>
						<div style="padding: 5px; margin-top: 20px;font-size: 12px; font-weight:bold;">
                      
							<div style="float: right;">Receivable From Broker: <?php if($net_buy_amt< $total_sell_amt){
											  $receivable=$total_sell_amt-$net_buy_amt;
											   echo $receivable=number_format($receivable ,2);
		                                    }else{
												echo "0.00";
											} ?></div>
                        </div>
						<div style="padding: 5px; margin-top: 20px; ">
                      
							<div style="float: right; border-top: 2px solid; border-top-style:solid;">-------------------------------------------------------------------</div>
                        </div>
						<div style="padding: 5px; margin-top: 20px; ">
                      
							<div style="float: right;"><?php if($net_buy_amt< $total_sell_amt){
								           
											 echo "Receivable:".$receivable;
											 }else{
											 echo "Payable: " .$payable;
											 } ?></div>
                        </div>

                    </div>
                </div>
            <?php
        }else{ ?>
		<h2 style="Color:red">Result Not Found</h2>
	<?php }
		
    }elseif($report_id==2){ 
	

  $sqls="SELECT * FROM tbl_stockexchange WHERE stock_id='$id'";
   $res= $dbObj->select($sqls);
   //print_r($res);
   $sql1="SELECT name FROM tbl_broker_hous WHERE trace_id='$broker_id'";
   $result= $dbObj->select($sql1);
   //print_r($result);
   if($result){
   $Bsql="SELECT market,date_tread,SUM(total_amount)as tamt,SUM(broker_commission)as bch,SUM(agency_comm)as ag_comm FROM tread_data_list WHERE bokersoftcode='$broker_id' AND stock_id='$id' AND date_tread='$date' AND type='B' GROUP BY type";
   $Br= $dbObj->select($Bsql);
   $broker_name=$result[0]['name'];
   }else{
	$Bsql="SELECT market,date_tread,SUM(total_amount)as tamt,SUM(broker_commission)as bch,SUM(agency_comm)as ag_comm FROM tread_data_list WHERE stock_id='$id' AND date_tread='$date' AND type='B' GROUP BY type";
    $Br= $dbObj->select($Bsql);   
   }
	$market=@$Br[0]['market'];
	$date_tread=@$Br[0]['date_tread'];
	$total_buy_amt=@$Br[0]['tamt'];
	$total_buy_amts=number_format($total_buy_amt ,2);
	  $broker_buy_charge=@$Br[0]['bch'];
	  $brokers_buy_charge=number_format($broker_buy_charge ,2);
	  $agency_buy_charge=@$Br[0]['ag_comm'];
	  $agencys_buy_charge=number_format($agency_buy_charge ,2);
	  $payable=($total_buy_amt+$broker_buy_charge+$agencys_buy_charge);
	  $payable_no=number_format($payable ,2);
	
    $Ssql="SELECT market,date_tread,SUM(total_amount)as tamt,SUM(broker_commission)as bch,SUM(agency_comm)as sag_comm FROM tread_data_list WHERE stock_id='$id' AND date_tread='$date' AND type='S' GROUP BY type";
    $Sr= $dbObj->select($Ssql);

	$total_sell_amt=@$Sr[0]['tamt'];
	$total_sell_amts=number_format($total_sell_amt ,2);
	$broker_sell_charge=@$Sr[0]['bch'];
	$brokers_sell_charge=number_format($broker_sell_charge ,2);
	$agency_sell_charge=@$Sr[0]['sag_comm'];
	$agencys_sell_charge=number_format($agency_sell_charge ,2);
	$receivable=($total_sell_amt-$broker_sell_charge-$agencys_sell_charge);
	$receivable_no=number_format($receivable ,2);
	$total_broker_charge=@$brokers_buy_charge+$brokers_sell_charge;
    $netted_amt=($total_buy_amt-$total_sell_amt);
	$netted_amts=number_format($netted_amt ,2);
	$net_buy_amt=($total_buy_amt+$total_broker_charge);
	
	
	?>
	
	<?php if($Br || $Sr){ ?>
	 <div style="height: 7.32in !important; width: 10.3in;">
                <img src="img/background.png" style=" width: 11.3in; height:7.32in; position:absolute; background-position:center;" />
                <div style="height:6.165in; z-index: 999999999999; position: relative; padding-top: 200px; width: 95%; padding-left: 85px;">
                   	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
						<h5 style="float:right;">Broker Trade Status</h5>
					</div>
                    <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
                        <!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
                        <!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
						<h5 style="font-size: 12px; font-weight:bold;">Trading Date: <?php echo date("d-M-Y");?></h5>
                        <h5 style="font-size: 12px; font-weight:bold;">Broker Name:
						<?php if(!@$broker_name){
							echo "All";
						}else{
						echo $broker_name;
						}?></h5>
                        Stock Exchange: <?php echo $res[0]['stock_name'];?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    </div>
                    <div >
					    
                        <table class="table_body" border="0" width="98%">
                            <thead>
                            <tr>
                                <th>Defferent Issue</th>
                                <th>Buy Amount</th>
                                <th>Buy Commision</th>
                                <th>Total Payable</th>
                                <th>Sell Amount</th>
								<th>Sell Commision</th>
								<th>Total Receivable</th>
								
                            </tr>
                            </thead>
                            <tbody>
									
                                    <tr>
                                        <td>
                                            <?php echo "DSE Public"; ?>
                                        </td>
                                        <td><?php echo $total_buy_amts;?></td>
                                        <td><?php echo $brokers_buy_charge;?></td>
                                        <td><?php echo $payable_no;?></td>
                                        <td><?php echo $total_sell_amts; ?></td>
										<td><?php echo $brokers_sell_charge; ?></td>
										<td><?php echo $receivable_no; ?></td>
                                        
                                    </tr>
									
                                    <?php
                              
                            
                            ?>
                            </tbody>
							
                        </table>
    <!--                    <h6>--><?php //echo $school_info['footer_caption'];?><!--</h6>-->
                        <div style="width: 100% ; border-top: 1px solid; border-bottom: 1px solid; ">&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<?php echo $total_buy_amts; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $brokers_buy_charge; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $payable_no; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $total_sell_amts;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $brokers_sell_charge; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $receivable_no; ?>
						</div>
                        
						<div style="padding: 5px; margin-top: 20px; ">
                      
							<div style="float: right; border-top: 2px solid; border-top-style:solid;">-------------------------------------------------------------------</div>
                        </div>
						
						<div style="padding: 5px; margin-top: 20px; ">
                               
							<div style="float: right;"><?php if($payable< $receivable){
								  $rece=$receivable-$payable;
								  $receivables=number_format($rece ,2);
								  echo "Receivable: ".$receivables;
							   }else{
								 $rece=$payable-$receivable;
                                 $payables=number_format($rece ,2);
                                 echo "Payable: ".$payables;
							   } ?></div>
                        </div>


                    </div>
					
                </div>	
	<?PHP }else{ ?>
		<h2 style="Color:red">Result Not Found</h2>
	<?php } ?>
	<?php }else{ ?>
		<h2 style="Color:red">Broker Panel 'All' Not Allowed For Broker CNS Report</h2>
		 
	<?php } ?>

</div>
