<?php

 $sql="SELECT * FROM `tbl_purchase_power`";
					
		$db_obj->sql($sql);
		$purchase_power=$db_obj->getResult();
		//print_r($purchase_power);	
		
?>
 <form class="stdform" action="" method="post">
  <div class="">
  <div class="pull-left" style="padding-left:20px">

  <div class="form-group">
  <label for="email"><font color="red">* </font><strong>A/C Type:</strong></label>
	
    <select class="form-control" id="myselect" required />
	<option value="all">All</option>
	<option value="NDA">NDA</option> 
	<option value="IDA">IDA</option> 
	<?php
	/* echo $sql="SELECT * FROM `investor_personal`";
			$db_obj->sql($sql);
			$account_cate=$db_obj->getResult();
			print_r($account_cate);
			die();

						
	foreach($account_cate as $ac){ */
	?>
	
    <!--<option value="<?php// echo $ac['bo_catagory'];?>"><?php //echo $ac['bo_catagory']; ?></option>-->
	 <?php
	//}
	?>
	
   </select>
  </div>
  
   <div class="form-group">
  <label for="email"><font color="red">* </font><strong>Panel Broker:</strong></label>
	
    <select class="form-control" id="myselect" required />
    <option value="">Select</option>
	<?php
	 $sql="SELECT * FROM `tbl_broker_hous`";
					
					 $db_obj->sql($sql);
					 $broker_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($broker_name as $broker){
	?>
	
    <option value="<?php echo $broker['trace_id'];?>"><?php echo $broker['name']; ?></option>
	 <?php
	}
	?>
	
   </select>
  </div>
   <div class="form-group">
  <label for="email"><font color="red">* </font><strong>Stock Exchange:</strong></label>
	
    <select class="form-control" id="myselect" required /> 
	<?php
	 $sql="SELECT * FROM `tbl_stockexchange`";
					
					 $db_obj->sql($sql);
					 $stockexchange=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($stockexchange as $stock){
	?>
	
    <option value="<?php echo $stock['stock_id'];?>"><?php echo $stock['stock_name']; ?></option>
	 <?php
	}
	?>
	
   </select>
  </div>
   <div class="form-group">
   <label for="AC"><strong>Account Number:</strong></label>
	<input type="text" class="form-control" name="ac_code"  />
  </div>
  
</div>

<div class="pull-right" style="padding-top:20px">

  <div><strong>Sell Limit(%): <input type="text" name="sell_limit" value="<?php echo $purchase_power[0]['sell_limit']?>" required readonly></strong> </div>
   </br>
  <div><strong>Netting (%)  : <input type="text" name="netting" value="<?php echo $purchase_power[0]['netting']?>" required readonly ></strong> </div>
   </br>
  <div><strong>Min Equity Debt Ratio : <input type="text" name="min_ratio" value="<?php echo $purchase_power[0]['min_ratio']?>" required readonly ></strong></div></br>
  <div><strong>Purchase Power(%): <input type="text" name="purchase_limit" value="<?php echo $purchase_power[0]['purchase_limit']?>" required readonly ></strong></div>
   </br>
   </br>
   </br>
   </br>
  <div><button type="submit" name="submit_ins" class="btn btn-default">Apply</button></div>
</div>
</form>

 <div class="clearfix"></div>
<form class="stdform" action="cashlimit_generate.php" method="post">  
<div style="padding-left:20px;" class="table-responsive"> 
<h3>Trade Limit</h3> 
<table width="100%" class="table table-bordered">              
         <thead>
          <tr>
            <th width="114" class="head0" title="Short Name">Is Select</th>
			<th width="114" class="head0" title="Short Name">A/C NO</th>
			<th width="114" class="head0" title="Short Name">BO Number</th>
			<th width="114" class="head0" title="Short Name">Name</th>
			<th width="114" class="head0" title="Short Name">A/C Type</th>
			<th width="114" class="head0" title="Short Name">Ledger Balance</th>
			<th width="114" class="head0" title="Short Name">Available Balance</th>
			<th width="114" class="head0" title="Short Name">Immatured Sale</th>
			<th width="114" class="head0" title="Short Name">Accrued interest</th>
			<th width="114" class="head0" title="Short Name">Accrued fees</th>
			<th width="114" class="head0" title="Short Name">Unclear Cheque</th>
			<th width="114" class="head0" title="Short Name">Total Equity</th>
			<th width="114" class="head0" title="Short Name">Marginable Equity</th>
			<th width="114" class="head0" title="Short Name">Marginable Market Value</th>
			<th width="114" class="head0" title="Short Name">Non Marginable Market Value</th>
			<th width="114" class="head0" title="Short Name">Marginable Total Cost</th>
			<th width="114" class="head0" title="Short Name">Non Marginable Total cost</th>
			<th width="114" class="head0" title="Short Name">Allowable Margin</th>
			<th width="114" class="head0" title="Short Name">Sell Limit</th>
			<th width="114" class="head0" title="Short Name">Purchase Power</th>
			<th width="114" class="head0" title="Short Name">Margin Usage</th>
			<th width="114" class="head0" title="Short Name">Margin Ratio</th>
			<th width="114" class="head0" title="Short Name">Total Equity debtratio</th>
		 </tr>
        </thead>
		 <tbody>
	<?php 
	if(isset($_POST['submit_ins'])){
		$sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where status=0 ORDER BY investor.dp_internal_ref_number ASC";
		 $db_obj->sql($sql);
		 $investor=$db_obj->getResult();
		 //echo count($investor);
		 //print_r($investor);
		 //die();
		
	    for($i=0; $i<count($investor); $i++){
		$ac_no=$investor[$i]['dp_internal_ref_number'];
		$sql1="SELECT * FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND status='0'";
		 $db_obj->sql($sql1);
		 $unclear_check=$db_obj->getResult();
         $amount=@$unclear_check[0]['deposit_amt'];
		 //print_r($unclear_check);
		
		$sql2="SELECT * FROM sale_share WHERE account_no='$ac_no' AND status='0'";
		 $db_obj->sql($sql2);
		 $immatured_bal=$db_obj->getResult();
         $im_amount=@$immatured_bal[0]['immatured_bal'];
		 
		 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE account_no='".$db_obj->EString($ac_no)."'");
         $result=$db_obj->getResult();
		  //print_r($result);

		 $total_balance=$investor[$i]['total_balance'];
		 $total_balance =round($total_balance, 2);
		 $total_balance =  number_format($total_balance, 2, '.', ',');
		  
		
	?>
		  
		  <tr>
		  <td><input type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $ac_no;?>" checked></td>
		  <td><?php echo $investor[$i]['dp_internal_ref_number'];?></td>
		  <td><?php echo $investor[$i]['investor_ac_number'];?></td>
		  <td><?php echo $investor[$i]['investor_name'];?></td>
		  <td><?php echo $investor[$i]['bo_catagory'];?></td>
		  <td><?php echo $total_balance;?></td>
		  <td><?php echo $total_balance-$im_amount-$amount;?></td>
		  <td><?php if($im_amount){
			  echo $im_amount;
		  }else{
			  echo "0.00";
		  } ?></td>
		  <td><?php echo "0.00";?></td>
		  <td><?php echo "0.00";?></td>
		 <td><?php if($amount){
			  echo $amount;
		  }else{
			  echo "0.00";
		  } ?></td>
		  <td><?php echo $total_balance;?></td>
		  <td><?php echo $total_balance;?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo '0.00';?></td>
		  <td><?php echo $total_balance-$im_amount-$amount;?></td>
		   <td><?php echo '0.00';?></td>
			<td><?php echo '0.00';?></td>
			<td><?php echo '0.00';?></td>
		   
		  
		  </tr>
		  <?php } } ?>
		 </tbody>
   </table> 
   
  
</div>
<div><button type="submit" class="btn btn-default">MSA Plus</button></div>
</form>
</div>
 

      
