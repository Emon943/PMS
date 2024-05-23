<?php
include("../config.php");
 $dbObj = new DBUtility();
 
 $fromdate = $_POST['fromdate'];
 $todate = $_POST['todate'];
 $branch_id = $_POST['branch_id'];
 $from_date = date('m-d-Y', strtotime($fromdate));
 $to_date = date('m-d-Y', strtotime($todate));
 


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
   $sqls="SELECT * FROM branch_list WHERE branch_id='$branch_id'";
   $res= $dbObj->select($sqls);
   $Bsql="SELECT * FROM `tbl_buy_sell_info` WHERE branch_id='$branch_id' AND `trade_date` BETWEEN '$from_date' AND '$to_date'";
   $Br= $dbObj->select($Bsql);
   $sqls="SELECT * FROM branch_list WHERE branch_id='$branch_id'";
   $res= $dbObj->select($sqls);
 echo '<pre>';
   print_r($Br);
   echo '</pre>';
   //die(); 
	
	//die();
	if($Br){
  ?>
			
            <div style="height: 7.32in !important; width: 10.3in;">
                <img src="img/background.png" style=" width: 11.3in; height:7.32in; position:absolute; background-position:center;" />
                <div style="height:6.165in; z-index: 999999999999; position: relative; padding-top: 200px; width: 95%; padding-left: 85px;">
                   	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
					<h5 style="float:right;">Broker Commission</h5>
					</div>
                    <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
                        <!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
                        <!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
						<p style="font-size: 12px; font-weight:bold;">FROM Date: <?php echo $from_date; ?>     &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;   To Date: <?php echo $to_date;?></p>
                 
                    </div>
                    <div >
					    
                        <table class="table_body" border="0" width="98%">
                            <thead>
                            <tr>
							 <th>Trade Date</th>
                                <th>Branch</th>
                                <th>Buy</th>
                                <th>Sell</th>
                                <th>Total Turn Over</th>
                                <th>Total Commision</th>
                                <th>Total Hawla</th>
								<th>Total Laga</th>
								<th>Tax</th>
								<th>Total Charge</th>
								 <th>Net Income</th>
								
                            </tr>
                            </thead>
                            <tbody>
									
                               <?php for($i=0;$i<count($Br);$i++){ 
							      $branch_id=$Br[$i]['branch_id'];
								  $buy=$Br[$i]['total_buy'];
								  $sell=$Br[$i]['total_sell'];
								  $total_turn_over=$Br[$i]['total_turn_over'];
								  $totals_turn_over=number_format($total_turn_over ,2);
								
							      $sqls="SELECT name FROM branch_list WHERE branch_id='$branch_id'";
                                  $res= $dbObj->select($sqls);
								  $branch_name=$res[0]['name'];
								  
							   ?>
                                      
                                    <tr>
                                         <td><?php echo @$Br[$i]['trade_date'];?>
                                        <td style="text-align: center;"><?php echo $branch_name."<br/>";  echo "Total:"?></td>
                                        <td style="text-align: center;"><?php echo $buy."<br/><br/>"; echo $buy;?></td>
                                        <td style="text-align: center;"><?php echo $sell."<br/><br/>"; echo $sell;?></td>
										<td style="text-align: center;"><?php echo $totals_turn_over."<br/><br/>"; echo $totals_turn_over;?></td>
										<td style="text-align: center;"><?php echo @$Br[$i]['total_commission']."<br/><br/>";  echo @$Br[$i]['total_commission']."<br/>";?></td>
                                        <td style="text-align: center;"><?php echo @$Br[$i]['howla']."<br/><br/>";  echo @$Br[$i]['howla'];?></td>
										<td style="text-align: center;"><?php echo @$Br[$i]['laga']."<br/><br/>";  echo @$Br[$i]['laga']; ?></td>
										<td style="text-align: center;"><?php echo @$Br[$i]['tax']."<br/><br/>";  echo @$Br[$i]['tax'];?></td>
										<td style="text-align: center;"><?php echo @$Br[$i]['total_charge']."<br/><br/>";  echo @$Br[$i]['total_charge'];?></td>
										<td style="text-align: center;"><?php echo @$Br[$i]['total_commission']."<br/><br/>";  echo @$Br[$i]['total_commission'];?></td>
                                        
                                    </tr>
									
							   <?php } ?>
                                 	
                            </tbody>
							
                        </table>
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
