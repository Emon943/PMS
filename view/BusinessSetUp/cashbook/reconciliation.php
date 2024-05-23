  <?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		if(isset($_POST["submit"])){
		 $fdate=$_POST['fdate'];
		 $tdate=$_POST['tdate'];
		 $bank=$_POST['bank'];
		 $cdate=date("Y-m-d");
		 $previous_date=date('Y-m-d', strtotime('-1 day', strtotime($cdate)));
		 
	    $bsql="SELECT * FROM bank_forward_balance where account_number='$bank' AND date='$previous_date'";
        $bank_bal_res= $dbObj->select($bsql);
		$opening_bal=$bank_bal_res[0]['balance'];
		
	    $sql_b="SELECT account_number,balance FROM `bank_ac` where account_number='$bank'";			
	    $db_obj->sql($sql_b);
	    $bank_name_bal=$db_obj->getResult();
		$account_number = $bank_name_bal[0]['account_number'];
		$cloing_bal = $bank_name_bal[0]['balance'];
		 
		 $sqld="SELECT * FROM `tbl_deposit_balance` where com_bank_ac='$bank' AND status='2' AND recon_status='0' AND `date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sqld);
		 $deposit_re_bal=$db_obj->getResult();
		 
		 $sqlw="SELECT id,code,date,type,des,com_bank_ac,payment as receipt,withdraw_amt as deposit_amt FROM `tbl_withdraw_balance` where com_bank_ac='$bank' AND status='2' AND recon_status='0' AND `date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sqlw);
		 $withdraw_re_bal=$db_obj->getResult();
		 $sqlbp="SELECT id,code,trans_date as date,type,des,bank_id as com_bank_ac,receipt_type as receipt,payment_amt as deposit_amt FROM `tbl_bank_payment` where bank_id='$bank' AND status='1' AND recon_status='0' AND `trans_date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sqlbp);
		 $broker_pay=$db_obj->getResult();
		 
		 $sqlbr="SELECT id,code,trans_date as date,type,des,bank_id as com_bank_ac,receipt_type as receipt,receipt_amt as deposit_amt FROM `tbl_bank_receipt` where bank_id='$bank' AND status='1' AND recon_status='0' AND `trans_date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sqlbr);
		 $broker_rec=$db_obj->getResult();
		 
		 $sqlbank="SELECT id,code,trans_date as date,type,des,tbank_ac_no as com_bank_ac,receipt_type as receipt,total_amt as deposit_amt FROM `tbl_bank_transfer` where tbank_ac_no='$bank' AND status='1' AND recon_status='0' AND `trans_date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sqlbank);
		 $bank_to_bank=$db_obj->getResult();
		
		  $result=(array_merge($deposit_re_bal,$withdraw_re_bal,$broker_pay,$broker_rec,$bank_to_bank));
		  // print_r($result);
		}
		?>

    
    <div class="contentinner">


     <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }



           if($page['view_status']=="Active"):
					?>
          <div align="right"><a href="?reconciled_list" class="btn alert-info"><span class="icon-th-large"></span>Reconciled Transaction</a></div>
                     <?php endif;?>
   <h4 class="widgettitle">Pandding Reconciliation List</h4>
                
  
   <form class="form-inline" action="" method="post">
   <div class="form-group">
    <label for="email">From: </label>
    <input type="date" id="fdate" name="fdate" required />
  </div>
  <div class="form-group">
    <label for="pwd">To: </label>
    <input type="date" id="tdate" name="tdate" required />
  </div>
  <div class="form-group">
      <label for="sel1">Cashbook A/C:</label>
      <select class="form-control" name="bank" required="required">
        <option value="">SELECT</option>
         <?php
	 $sql="SELECT * FROM `bank_ac`";
					
					 $db_obj->sql($sql);
					 $bank_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($bank_name as $bank){
	?>
	 <option value="<?php echo $bank['account_number'];?>"><?php echo $bank['id'].":".$bank['bank_name']."(".$bank['account_number'].")"; ?></option>
	<?php } ?>
      </select>
      
    </div></br>
	
  <div>
  <button type="submit" name="submit" class="btn btn-default">Apply</button>
  </div>
  <hr>
  <div class="form-group">
    <label for="email">A/C No : <?php echo @$account_number; ?></label>
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div class="form-group">
    <label for="email">FROM Date :   <?php echo @$fdate; ?></label>
	
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div class="form-group">
    <label for="email">To Date :  <?php echo @$tdate; ?></label>
    </div></br></br>
	
	<div class="form-group">
    <label for="email">Opening Balance  :   <?php echo number_format((float)@$opening_bal, 2); ?></label>
	
    </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div class="form-group">
    <label><strong>Closing Balance  :</strong>   <?php echo number_format((float)@$cloing_bal, 2); ?></label>
    </div>
</form>

<h4 class="widgettitle" style="text-align: center;">Bank Reconciliation</h4>
<br>


<style>
.my-custom-scrollbar {
position: relative;
height: 300px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

/* The container must be positioned relative: */
.custom-select {
  position: relative;
  font-family: Arial;
}

#fee{
 height:40px;   
}
</style>
<form class="stdform" action="?reconcilation_process" method="post">
<div class="table-wrapper-scroll-y my-custom-scrollbar">
  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th>Is Select</th>
        <th scope="col">Date</th>
        <th scope="col">Type</th>
        <th scope="col">Description</th>
		 <th scope="col">Pay/Rec Type</th>
		  <th scope="col">Debit</th>
		   <th scope="col">Credit</th>
		    <th scope="col">Balance</th>
      </tr>
    </thead>
	
    <tbody>
	<?php
	if(@$result){
	foreach(@$result as $res){
		//print_r($res);
	?>
      <tr>
	  <td><input type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $res['deposit_amt'].";".$res['id'].";".$res['code'].";".$res['com_bank_ac'].";".$res['type'].";".$res['des'].";".$res['date'];?>" ></td>
        
        <td><?php echo $res['date'];?></td>
        <td><?php echo $res['code'];?></td>
		<td><?php echo $res['des'];?></td>
		<td><?php echo $res['receipt'];?></td>
		<td>
		<?php if($res['type']=='Receipt'){
		  echo number_format((float)$res['deposit_amt'], 2);
		}else{
		  echo '0.00';
		}
		?>
		</td>
		<td>
		<?php if($res['type']=='Payment'){
		  echo number_format((float)$res['deposit_amt'], 2);
		}else{
		 echo '0.00';
		}
		?>
		</td>
		<td><?php echo number_format((float)$res['deposit_amt'], 2);?></td>
		
      </tr>
	  <?php
	}
	}
	?>
    </tbody>
  </table>
<button style="padding-left:10px" type="submit" name="submit" class="btn btn-default" onclick="return confirmation()">Reconciliation</button>
</div>

</form>
  

              
                     
 
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to reconcilation process?');
    }
</script>

<script type="text/javascript">
    function cancel() {
      return confirm('Are you sure you want to cancel this?');
    }
</script>
        