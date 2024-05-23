<?php
 include("../config.php");
 $dbObj = new DBUtility();
 $fromdate = $_POST['fromdate'];
 $todate = $_POST['todate'];
 $branch_id = $_POST['branch_id'];

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
  .box{
   
    width: 250px;
    border: 1px solid;
    padding: 10px;
    margin: 20px;
	margin-left:500px;
	text-align:right;
   }
	</style>
  <?php
  if($fromdate && $todate){
   $ISCsql="SELECT SUM(total_amt) as total_charge,description FROM tbl_charge_info WHERE code='ISC' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $ISC_Res= $dbObj->select($ISCsql);
   //print_r($ISC_Res);
   $msql="SELECT SUM(commission) as marchantbank_commission FROM tread_data_list WHERE `curr_date` BETWEEN '$fromdate' AND '$todate'";
   $M_Res= $dbObj->select($msql);
    //print_r($M_Res);
	
   $m_chage=$ISC_Res[0]['total_charge']+$M_Res[0]['marchantbank_commission'];
   $misql="SELECT SUM(total_interest_amt) as total_charge,description FROM tbl_interest_quaterly WHERE code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $mi_res= $dbObj->select($misql);
   $mfsql="SELECT SUM(total_interest_amt) as total_charge,description FROM tbl_interest_quaterly WHERE code='mf' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $mf_res= $dbObj->select($mfsql);
   $iocbsql="SELECT SUM(total_interest_amt) as total_charge,description FROM tbl_interest_quaterly WHERE code='iocb' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $iocb_res= $dbObj->select($iocbsql);
   
   
   $tsql="SELECT * FROM transaction_type where status='Active'";
   $transaction_type= $dbObj->select($tsql);
   $bsql="SELECT * FROM tbl_broker_hous where status='1'";
   $broker_house= $dbObj->select($bsql);
   
   //print_r($transaction_type);
	$total_ch=$mi_res[0]['total_charge']+$mf_res[0]['total_charge']+$iocb_res[0]['total_charge'];
	
	$sum=0;
	$sums=0;

	//die();
	
  ?>
            <div style="height: 13.32in !important; width: 10.3in;">
                <img src="img/background.png" style=" width: 10.3in; height:13.32in; position:absolute; background-position:center;" />
                <div style="height:10.165in; z-index: 999999999999; position: relative; padding-top: 200px; width: 95%; padding-left: 85px;">
                   	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
					<h5 style="float:right;font-size: 12px; font-weight:bold;">Period:<?php echo $fromdate;?> To <?php echo $todate;?></h5>
					</div>
                    <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
                        <!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
                        <!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
						<h5 style="font-size: 12px; font-weight:bold;">Branch: <?php echo $branch_id;?></h5>
                    </div>
					
                  <div>
				  <p style="border-bottom:2px solid; width:50px">Income</p>
				  </div>
				  <div>
				  <div style="float:left">
                  <p style="margin: 0 0 0px;"><?php echo $ISC_Res[0]['description'];?></p>
                  </div>
				  <div style="float:left">
                  <p style="margin-left:550px;"><?php echo $ISC_Res[0]['total_charge'];?></p>
                  </div>
				  </div>
				 <br/>
                 <div class="box"><?php echo $ISC_Res[0]['total_charge'];?></div>
                
				  <div>
				  <p>Commission Income</p>
				  </div> 
				  <div>
				  <div style="float:left">
                  <p style="margin: 0 0 0px;padding-left:20px">Merchant Bank Commission</p>
                  </div>
				  <div style="float:left">
                  <p style="margin-left:500px;"><?php echo round($M_Res[0]['marchantbank_commission'], 2);?></p>
                  </div>
				  </div>
				 <br/>
                 <div class="box"><?php echo round($M_Res[0]['marchantbank_commission'], 2);?></div>
	
	            <div>
				  <p>Other Income</p>
				 </div>
				  <div>
				  <div style="float:left">
                  <p style="margin: 0 0 0px;padding-left:40px"><?php echo $mi_res[0]['description'];?></p>
                  </div>
				  <div style="float:left">
                  <p style="margin-left:550px;"><?php echo round($mi_res[0]['total_charge'], 2);?></p>
                  </div>
				  </div>
				   <div class="clearfix"></div>
				   <div>
				  <div style="float:left">
                  <p style="margin: 0 0 0px;padding-left:20px"><?php echo $mf_res[0]['description'];?></p>
                  </div>
				  <div style="float:left">
                  <p style="margin-left:500px;"><?php echo round($mf_res[0]['total_charge'], 2);?></p>
                  </div>
				  </div>
				   <div class="clearfix"></div>
				  <div>
				  <div style="float:left">
                  <p style="margin: 0 0 0px;padding-left:20px"><?php echo $iocb_res[0]['description'];?></p>
                  </div>
				  <div style="float:left">
                  <p style="margin-left:500px;"><?php echo round($iocb_res[0]['total_charge'], 2);?></p>
                  </div>
				  </div>
				 <div class="clearfix"></div>
			<?php foreach($transaction_type as $trans_type){ 
				    $code=$trans_type['code'];
					 $name=$trans_type['name'];
				   $othersql="SELECT SUM(total_amt) as total_charge,description FROM tbl_charge_info WHERE code='$code' AND `date` BETWEEN '$fromdate' AND '$todate'";
                   $other_res= $dbObj->select($othersql);
				   $total_charge=$other_res[0]['total_charge'];
				   $sum=$sum+$total_charge;
				   
				   //print_r($other_res);
				   ?>
                 <div style="float:left">
				 <p style="margin: 0 0 0px;padding-left:20px"><?php echo $name;?></p>
				</div>
              
				  <div style="float:left">
                  <p style="margin-left:500px;"><?php echo round($other_res[0]['total_charge'], 2);?></p>
                  </div>
				  

				  <div class="clearfix"></div>
				
				  <?php } ?>	   
				
                 <div class="box"><?php echo round($sum+$total_ch, 2);?></div>
                 <div style="border-bottom:1px solid"></div><div class="clearfix"></div>
 Total Income:<p style="margin-left:600px;"><?php echo round($sum+$total_ch+$m_chage, 2);?></p>	

                 <div>
				  <p>Expenditure</p>
				 </div>
<?php foreach($broker_house as $broker_house){ 
				 $trace_id=$broker_house['trace_id'];
				 $name=$broker_house['name'];
				 $b2sql="SELECT SUM(broker_commission) as b_commission FROM tread_data_list WHERE bokersoftcode='$trace_id' AND `curr_date` BETWEEN '$fromdate' AND '$todate'";
                 $broker_res= $dbObj->select($b2sql);
				 $total_bcharge=$broker_res[0]['b_commission'];
				 $sums=$sums+$total_bcharge;
				   
				   //print_r($other_res);
				   ?>
				  
                 <div style="float:left">
				 <p style="margin: 0 0 0px;padding-left:20px"><?php echo $name;?></p>
				</div>
              
				  <div style="float:left">
                  <p style="margin-left:500px;"><?php echo round($total_bcharge, 2);?></p>
                  </div>
				 
				 
				  <div class="clearfix"></div>
				
				  <?php } ?>
                 <div class="box"><?php echo round($sums, 2);?></div>				  
</div>
</div>

  <?php } ?>
</div>