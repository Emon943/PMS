
<?php
if(isset($_POST['submit_data'])){
$ac_code=@$_POST["ac_code"];


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
   }
 /*End Purchase Power*/ 
 
 
 if(isset($_POST['edit'])){
	$id=@$_POST['id'];
	$av_rate=@$_POST['avg_rate'];
	$saleable=@$_POST['saleable'];
	$non_saleable=@$_POST['non_saleable'];
	$bonus_share=@$_POST['bonus_share'];
	
	$sql_ups="update tbl_ipo set Current_Bal='$saleable',qty='$non_saleable',avg_rate='$av_rate',bonus_share='$bonus_share' WHERE id='$id'";
	$res=$dbObj->update($sql_ups);
	if($res){
		echo "successfully";
	}else{
		echo "unsuccessfully";
	}
	
	
 }
?>
      
      
 <form class="stdform" action="" method="post">    
 <div class="form-group" style="padding-top:20px">   
        
    <label for="AC"><strong>Account Code:</strong></label>
	<input type="text" class="form-control" name="ac_code"/>
	 <!--<label for="AC"><strong>BO Number:</strong></label>
	<input type="text" class="form-control" name="account_ref" onblur="makerequest(this.value)"/>-->
	<!--<div class="hidden-submit"><input type="submit" name="submit_data" value='Load' tabindex="-1" /></div>-->
	<button class="btn btn-primary" type="submit" name="submit_data">Load</button>
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
  <p><strong>A/C Type: </strong><?php echo @$cate_name ?> </p>
  <p><strong>Ledger Balance: </strong><?php echo @$ledger_bal_v ?> </p>
  <p><strong>Ava. Balance: </strong><?php echo @$avi_bal_v;?> </p>
  <p><strong>Contact: </strong><?php echo @$res[0]['phone'] ?></p>
    <p><strong>Scheme: </strong><?php echo @$group_name;?></p>
  <p><strong>BO Number: </strong><?php echo @$res[0]['investor_ac_number'] ?></p>
</div>

<div style="float:left; padding-left:150px">
<h3>Investor Status</h3>
<hr>
  <p><strong>Unclear cheque: </strong><?php echo @$unclear_cheque_v;?> </p>
  <p><strong>Immatured Sale: </strong><?php echo @$immatured_bal;?></p>
  <p><strong>Unrealized G/L: </strong><?php echo @$u_gain;?></p>
  <p><strong>Market Value: </strong><?php echo @$sums;?> </p>
  <p><strong>Total Equity: </strong><?php echo @$total_equity;?></p>
  <p><strong> Exposeure Status: </strong><?php echo @$code;?></p>
  <p><strong> Loan Utilization: </strong><?php echo @$loan_utilize."%";?></p>
  <p><strong> Margin Ratio: </strong><?php echo @$margin_ratio;?></p>
  <p><strong> Purchase Power: </strong><?php echo @$purchase_power;?></p>
</div>
</div>

 <div class="clearfix"></div>

 <div class="form-group">   

<h3>Stock Ledger</h3> 
<div class="table-wrapper-scroll-y my-custom-scrollbar">
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
		  <?php for($i=0; $i<count(@$result); $i++){ 
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
		  <td><?php echo $total_share;?></td>
		  <td><?php echo @$result[$i]['Current_Bal'];?></td>
		  <td><?php if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			  echo $cost_per_share;
		  }else{
			  echo $avg_rate;
		  } ?></td>
		  <td><?php if($BO_Ac_Status=='ACTIVE' AND $avg_rate==0){
			  echo $ipo_total_cost;
		  }else{
			  echo $total_cost;
		  }?></td>
		  <td><?php echo @$result[$i]['market_price'];?></td>
		  <td><?php echo $market_value;?></td>
		  <td><?php echo @$result[$i]['realize_gain'];?></td>
		  <td><?php if($avg_rate==0){
			  echo round($market_value-$ipo_total_cost, 2);
		  }else{
			  echo round($market_value-$total_cost, 2);
		  }?></td>
		  <td> 
		  <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit<?php echo $result[$i]['id']; ?>"> <i class="fa fa-edit"></i> Edit</a>
		 </td>
		 
		  <div class="modal fade" id="edit<?php echo $result[$i]['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h3 class="modal-title" id="myModalLabel">Edit Investor Account</h3>
											  </div>
											  
											  <div class="modal-body">
											  
											  
											  
												<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
												     <div class="form-group">
												      <input type="hidden" value="<?php echo $result[$i]["id"] ?>" name="id">
													 </div>
													 <div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Non Saleable Qty</label>
														<div class="col-sm-10">
														  <input type="text" name="non_saleable" class="form-control" value="<?php echo $result[$i]["qty"]; ?>" required>
														</div>
													  </div>
													  
													  
													
													  <div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Saleable Qty</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control" name="saleable"  value="<?php echo $result[$i]["Current_Bal"]; ?>" required>
														</div>
													  </div>
													  
													  
													  <div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Avg Rate</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control" name="avg_rate" value="<?php echo $result[$i]["avg_rate"]; ?>" required>
														</div>
													  </div>
													  
													  <div class="form-group">
														<label for="inputEmail3" class="col-sm-2 control-label">Bonus Share</label>
														<div class="col-sm-10">
														  <input type="text" class="form-control" name="bonus_share" value="<?php echo $result[$i]["bonus_share"]; ?>" required>
														</div>
													  </div>
													  
													   
												 													
											  </div>
											  
											  <div class="modal-footer">
												<input type="submit" name="edit" class="btn btn-primary" value="Save Change">
												</form>
											  </div>
											</div>
										  </div>
										</div>
		<?php } ?>
		
		  </tr>
		  
		  <?php } ?>
		 </tbody>
   </table> 
</div>
 </div>    								
											
    
    <div class="clearfix"></div>
 