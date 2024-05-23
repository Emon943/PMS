<?php
session_start();
if(@$_SESSION['LOGIN_USER']==false || $_SESSION['SECID']!=session_id()):
session_destroy();
header("Location: ./");
else:

require("include_file/__class_file.php");
$db_obj=new PMS;

include("config.php");
$dbObj = new DBUtility();

$mainLink=basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
//echo $mainLink;
endif;
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PMS::Protfolio Report</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />
<script type="text/javascript" src="prettify/prettify.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/detectizr.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<style>
.hidden-submit {
    border: 0 none;
    height: 0;
    width: 0;
    padding: 0;
    margin: 0;
    overflow: hidden;
}
</style>
</head>

<body>

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php
	
    require_once("include_file/leftpanel.php");
	?>
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
    	
         <!--headerpanel-->
        
        <?php
    require_once("include_file/header.php");
	?>
        
        <!--headerpanel-->
       
     
     <!-- <div class="pagetitle">
        	<h1>Dashboard</h1> <span>This is a sample description for dashboard page...</span>
        </div>-->
        
        <!--pagetitle-->
<?php

$ac_code=@$_POST["ac_code"];
$ac_code=strtoupper($ac_code);
/*sir margin loan calculation*/
 //margin Utility
 /* $db_obj->sql("SELECT * FROM tbl_margin_loan INNER JOIN investor ON investor.dp_internal_ref_number = tbl_margin_loan.ac_no where tbl_margin_loan.ac_no='$ac_code' AND tbl_margin_loan.status='1'");
 $margin_loan=$db_obj->getResult();
  //print_r($margin_loan);
  if($margin_loan){
  $loan_amt=@$margin_loan[0]['loan_amt'];
  $total_balance=@$margin_loan[0]['total_balance'];
  $loan_utilize=@round($total_balance*100/$loan_amt);
   $loan_utilize=abs($loan_utilize);*/
  /*  $db_obj->sql("SELECT * FROM loan_catagory_exposure");
   $loan_exploser=$db_obj->getResult(); 
 //print_r($loan_exploser);
 
 
	 //print_r($loan_ex);
	$exposure_from=$loan_exploser[0]['exposure_from'];
	$esposure_to=$loan_exploser[0]['esposure_to'];
	$exposure_from1=$loan_exploser[1]['exposure_from'];
	$esposure_to1=$loan_exploser[1]['esposure_to'];
	$exposure_from2=$loan_exploser[2]['exposure_from'];
	$esposure_to2=$loan_exploser[2]['esposure_to'];
	$exposure_from3=$loan_exploser[3]['exposure_from'];
	$esposure_to3=$loan_exploser[3]['esposure_to'];
	 
 if(@$loan_utilize > $exposure_from && @$loan_utilize < $esposure_to){
		 $code=$loan_exploser[0]['code'];
	 }elseif(@$loan_utilize > @$exposure_from1 && @$loan_utilize < @$esposure_to1){
		  $code=$loan_exploser[1]['code'];
	 }elseif(@$loan_utilize > $exposure_from2 && $loan_utilize < $esposure_to2){
		 $code=$loan_exploser[2]['code'];
	 }elseif(@$loan_utilize >= $exposure_from3 && $loan_utilize <= $esposure_to3){
		$code=$loan_exploser[3]['code'];
	 }
  }else{
	 $loan_utilize="0.00";
	 $code="N/A";
  } */
//margin exploser


/* Accrude fee and charge */

  $acmf_sql="SELECT SUM(acmf_interest_amt) as acmf,SUM(daily_interest) as CashEDF FROM tbl_interest_on_credit_bal WHERE ac_no='$ac_code' AND status=0";
 $acmf_fee=$dbObj->select($acmf_sql);
 if($acmf_fee){
	$Excess_Cash_management_Fee=@$acmf_fee[0]['acmf'];
    $Exce_Cash_manage=@$acmf_fee[0]['CashEDF'];	
 }else{
	$Excess_Cash_management_Fee=0;
	$Exce_Cash_manage=0;
  }
 $pm_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_code' AND status=0 AND code='mf'";
 $pm_fee=$dbObj->select($pm_sql);
 if($pm_fee){
	$Portfolio_Management_fee=@$pm_fee[0]['total_fee_amt'];
 }else{
	$Portfolio_Management_fee=0;
  }
 
 $li_sql="SELECT SUM(daily_interest)as total_fee_amt FROM tbl_interest WHERE ac_no='$ac_code' AND status=0 AND code='mi'";
 $loan_fee=$dbObj->select($li_sql);
 if($loan_fee){
	$interest_on_loan=@$loan_fee[0]['total_fee_amt'];
 }else{
	$interest_on_loan=0;
  }
 
 $accrue_charge=$Excess_Cash_management_Fee+$Portfolio_Management_fee+$interest_on_loan-$Exce_Cash_manage;
 
 /* End Accrude fee and charge */
 
$db_obj->sql("SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$ac_code' AND investor_personal.dp_internal_ref_number='$ac_code'");
$res=$db_obj->getResult();
$investor_group_id=@$res[0]['investor_group_id'];
$bo_catagory=@$res[0]['bo_catagory'];

 $db_obj->sql("SELECT * FROM tbl_bo_cate WHERE id='".$db_obj->EString($bo_catagory)."'");
 $bo_type=$db_obj->getResult();
 $cate_name=@$bo_type[0]['cate_name'];
//print_r($res);
 $bo_id=@$res[0]['investor_ac_number'];
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='".$db_obj->EString($bo_id)."'");
 $result=$db_obj->getResult();
 //print_r($result);

 $sum=0;
 $sums=0;
 for($i=0; $i<count($result); $i++){ 
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['qty']+@$result[$i]['bonus_share']+@$result[$i]['Lockin_Balance'];
			$avg_rate=$result[$i]['avg_rate'];
			$cost_per_share=$result[$i]['cost_per_share'];
			if($avg_rate==0){
			$ipo_total_cost=$total_share*$cost_per_share;
			}else{
			$ipo_total_cost=0;
			}
			$total_cost=$total_share*$avg_rate;
			$sum=@$sum+$total_cost+$ipo_total_cost;
			$market_value=@$result[$i]['market_price']*$total_share;
			$sums=@$sums+$market_value;
			$u_gain=@$sums-$sum;
		    $u_gain=number_format((float)$u_gain, 2);
			
			
	}

 //print_r($result);
 
 //Marginable stock share
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='$bo_id' AND non_marginable='FALSE'");
 $marginable= $db_obj->getResult();
   //print_r($non_margin);
   if($marginable){
	$m_sum=0;
   for($i=0; $i<count($marginable);$i++){
	$total_nonmargin_share=@$marginable[$i]['Current_Bal']+@$marginable[$i]['qty']+@$marginable[$i]['bonus_share']+@$marginable[$i]['Lockin_Balance'];
	$marginable_market_value=@$marginable[$i]['market_price']*$total_nonmargin_share;
	$m_sum=$m_sum+$marginable_market_value;
	 }
    }else{
	$m_sum=0;
	}
 
 $sqls=$db_obj->sql("SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_code' AND status=0 Group By account_no");
 $ress= $db_obj->getResult();
 $im_bal=@$ress[0]['im_bal'];
 $immatured_bal=number_format((float)$im_bal, 2);
 // echo $immatured_bal;
  
 $sqlb=$db_obj->sql("SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_code' AND status=0 Group By account_ref");
 $res_bal= $db_obj->getResult();
 $unclear_cheque=@$res_bal[0]['deposit_amt'];
 $unclear_cheque=round($unclear_cheque, 2);
 $unclear_cheque_v=number_format((float)$unclear_cheque, 2);
  //echo $unclear_cheque;
  $ledger_bal=@$res[0]['total_balance']+$unclear_cheque+$im_bal;
  $ledger_bal_v=number_format((float)$ledger_bal, 2);
  
  $total_balance=@$res[0]['total_balance'];
  $avi_bal_v=number_format((float)$total_balance, 2);
  $total_equity=$ledger_bal+$sums-$accrue_charge;
  
  
  /*loan Exproser limit*/
  if(@$total_equity > 0){
  $loans_utilize=round(@$ledger_bal/$total_equity*100,2);
  }
  if(@$loans_utilize < 0){
	$loan_utilize=abs($loans_utilize);
    $db_obj->sql("SELECT * FROM loan_catagory_exposure");
    $loan_exploser=$db_obj->getResult(); 
 //print_r($loan_exploser);
 

	$exposure_from=$loan_exploser[0]['exposure_from'];
	$esposure_to=$loan_exploser[0]['esposure_to'];
	$exposure_from1=$loan_exploser[1]['exposure_from'];
	$esposure_to1=$loan_exploser[1]['esposure_to'];
	$exposure_from2=$loan_exploser[2]['exposure_from'];
	$esposure_to2=$loan_exploser[2]['esposure_to'];
	$exposure_from3=$loan_exploser[3]['exposure_from'];
	$esposure_to3=$loan_exploser[3]['esposure_to'];
	 
 if(@$loan_utilize > $exposure_from && @$loan_utilize < $esposure_to){
		 $code=$loan_exploser[0]['code'];
	 }elseif(@$loan_utilize > @$exposure_from1 && @$loan_utilize < @$esposure_to1){
		  $code=$loan_exploser[1]['code'];
	 }elseif(@$loan_utilize > $exposure_from2 && $loan_utilize < $esposure_to2){
		 $code=$loan_exploser[2]['code'];
	 }elseif(@$loan_utilize >= $exposure_from3 && $loan_utilize <= $esposure_to3){
		$code=$loan_exploser[3]['code'];
	 }
  }else{
	 $loan_utilize="0.00";
	 $code="N/A";
  } 
	  
  /*End loan exproser*/
  
 
  $db_obj->sql("SELECT `group_name`,`loan_cat` FROM `investor_group` WHERE `investor_group_id`='$investor_group_id'");
  $rs=$db_obj->getResult();
  $group_name=@$rs[0]['group_name'];
  $loan_cat=@$rs[0]['loan_cat'];
  
 /*Start Purchase Power*/ 
  if($loan_cat){
     $db_obj->sql("SELECT * FROM `loan_catagory_margin` WHERE id='$loan_cat'");
     $margin_cat=$db_obj->getResult();

	 $margin_ratio=@$margin_cat[0]['margin_ratio'];
		
	 $purchase_power=$m_sum*$margin_ratio+$ledger_bal-$unclear_cheque;
	 //$loan_ratio=$ledger_bal/$sums;
	 //$loan_ratio=round($loan_ratio, 2);
    }else{
	  $margin_ratio="N/A";
	  $purchase_power=$total_balance;
     }
 /*End Purchase Power*/ 
?>
      
      
 <form class="stdform" action="" method="post">    
 <div class="form-group" style="padding-top:20px">   
        
    <label for="AC"><strong>Account Code:</strong></label>
	<input type="text" class="form-control" name="ac_code"/>
	 <!--<label for="AC"><strong>BO Number:</strong></label>
	<input type="text" class="form-control" name="account_ref" onblur="makerequest(this.value)"/>-->
	<div class="hidden-submit"><input type="submit" name="submit_data" tabindex="-1" /></div>
</div>
</form>
<hr>
<div class="form-group">  
<div style="float:left; padding-left:10px">
	<h3>Investor</h3>
<hr>
  <p><strong>A/C NO : </strong><?php echo @$res[0]['dp_internal_ref_number'] ?></p>
  <p><strong>Name : </strong><?php echo @$res[0]['investor_name'] ?> </p>
  <p><strong>Category : </strong><?php echo @$res[0]['account_status'] ?> </p>
  <p><strong>Status: </strong><?php if(@$result[0]['status']==0){
	echo "Active"; 
  }else{
	 echo "Inactive";
  } ?></p>
  </div>
  
 <div style="float:left; padding-left:50px">
<h3>Investor Information</h3>
<hr>
  <p><strong>Name: </strong><?php echo @$res[0]['investor_name'] ?> </p>
  <p><strong>A/C Type: </strong><?php echo $cate_name ?> </p>
  <p><strong>Ledger Balance: </strong><?php echo $ledger_bal_v ?> </p>
  <p><strong>Ava. Balance: </strong><?php echo $avi_bal_v;?> </p>
  <p><strong>Contact: </strong><?php echo @$res[0]['phone'] ?></p>
    <p><strong>Scheme: </strong><?php echo $group_name;?></p>
  <p><strong>BO Number: </strong><?php echo @$res[0]['investor_ac_number'] ?></p>
</div>

<div style="float:left; padding-left:150px">
<h3>Investor Status</h3>
<hr>
  <p><strong>Unclear cheque: </strong><?php echo $unclear_cheque_v;?> </p>
  <p><strong>Immatured Sale: </strong><?php echo $immatured_bal;?></p>
  <p><strong>Unrealized G/L: </strong><?php echo @$u_gain;?></p>
  <p><strong>Market Value: </strong><?php echo $sums;?> </p>
  <p><strong>Total Equity: </strong><?php echo $total_equity;?></p>
  <p><strong> Exposeure Status: </strong><?php echo @$code;?></p>
  <p><strong> Loan Utilization: </strong><?php echo @$loan_utilize."%";?></p>
  <p><strong> Margin Ratio: </strong><?php echo $margin_ratio;?></p>
  <p><strong> Purchase Power: </strong><?php echo $purchase_power;?></p>
</div>
</div>

 <div class="clearfix"></div>

 <div class="form-group">   
<a href="pdf_protfolio_report.php?id=<?php echo base64_encode($ac_code);?> " target="_blank" class="btn" title="Update Data"><span class="icon-hand-right"></span>Print</a> 
<h3>Stock Ledger</h3> 
<table width="100%" class="table table-bordered">              
         <thead>
          <tr>
            <th width="114" class="head0" title="Short Name">Instrument</th>
			<th width="114" class="head0" title="Short Name">Total</th>
			<th width="114" class="head0" title="Short Name">Saleable</th>
			<th width="114" class="head0" title="Short Name">Avg. Cost</th>
			<th width="114" class="head0" title="Short Name">Total Cost</th>
			<th width="114" class="head0" title="Short Name">Market Rate</th>
			<th width="114" class="head0" title="Short Name">Market value</th>
			<th width="114" class="head0" title="Short Name">Realized Gain</th>
			<th width="114" class="head0" title="Short Name">Unrealized Gain</th>
		 </tr>
        </thead>
		 <tbody>
		  <?php for($i=0; $i<count($result); $i++){ 
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['qty']+@$result[$i]['bonus_share']+$result[$i]['Lockin_Balance'];
			$avg_rate=$result[$i]['avg_rate'];
			$BO_Ac_Status=$result[$i]['BO_Ac_Status'];
			$cost_per_share=$result[$i]['cost_per_share'];
			$total_cost=$total_share*$avg_rate;
			$ipo_total_cost=$total_share*$cost_per_share;
			$market_value=@$result[$i]['market_price']*$total_share;
		  ?>
		  
		  <tr>
		<?php if($total_share!=0){ ?>
		  <td><?php echo @$result[$i]['instrument'];?></td>
		  <td><?php echo number_format((float)@$total_share, 2);?></td>
		  <td><?php echo number_format((float)@$result[$i]['Current_Bal'], 2);?></td>
		  <td><?php if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			  echo $cost_per_share;
		  }else{
			  echo $avg_rate;
		  } ?></td>
		  <td><?php if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			  echo number_format((float)$ipo_total_cost, 2);
		  }else{
			  echo number_format((float)$total_cost, 2);
		  }?></td>
		  <td><?php echo @$result[$i]['market_price'];?></td>
		  <td><?php echo number_format((float)$market_value, 2);?></td>
		  <td><?php echo @$result[$i]['realize_gain'];?></td>
		  <td><?php if($avg_rate==0){
			  echo round($market_value-$ipo_total_cost, 2);
		  }else{
			  echo round($market_value-$total_cost, 2);
		  }?></td>
		<?php } ?>
		  </tr>
		  <?php } ?>
		 </tbody>
   </table> 
</div>
      
</div><!--mainright-->


    <!-- END OF RIGHT PANEL -->
	
    
    <div class="clearfix"></div>
    
  <?php include("include_file/footer.php");
  
  $db_obj->disconnect();
  ?>
    
    <!--footer-->
    
</div><!--mainwrapper-->

</body>
</html>
