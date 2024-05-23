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
		 
	    $sql_b="SELECT account_number,balance FROM `bank_ac` where account_number='$bank'";			
	    $db_obj->sql($sql_b);
	    $bank_name_bal=$db_obj->getResult();
		$account_number = $bank_name_bal[0]['account_number'];
		$balance = $bank_name_bal[0]['balance'];
		 
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
		if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('our_ref'=>$_POST['our_ref']));
			
			if($ck=='Success'){
				
				///Insert
        

        $db_obj->select('tbl_bank_receipt','*',"our_ref='".$_POST['our_ref']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
        $db_obj->disconnect();
             
			 echo'<script>window.location="cashbook.php?bank_receipt";</script>';
             exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_bank_receipt',array('trans_date'=>$_POST['date'],
	    'bank_id'=>$_POST['myselect'],
		'nominal_id'=>$_POST['Nominal'],
		'our_ref'=>$_POST['our_ref'],
		'your_ref'=>$_POST['your_ref'],
		'total_amt'=>$_POST['nominal_bal'],
		'receipt_amt'=>$_POST['receipt_amt'],
		'receipt_type'=>$_POST['receipt_type'],
		'bank_name'=>$_POST['Bank'],
		'des'=>$_POST['des'],
		'log'=>$_SESSION['LOGIN_USER']['login_id'])); 
		
		

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="cashbook.php?bank_receipt";</script>';
            
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
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
      
    </div>
 <p><strong>A/C No : </strong><?php echo @$account_number; ?></p>
 <p><strong>Opening Balance : </strong><?php echo @$balance; ?></p>
  
  <button type="submit" name="submit" class="btn btn-default">Apply</button>
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
		  echo $res['deposit_amt'];
		}else{
		  echo '0.00';
		}
		?>
		</td>
		<td>
		<?php if($res['type']=='Payment'){
		  echo $res['deposit_amt'];
		}else{
		 echo '0.00';
		}
		?>
		</td>
		<td><?php echo $res['deposit_amt'];?></td>
		
      </tr>
	  <?php
	}
	}
	?>
    </tbody>
  </table>

</div>
<button style="padding-left:10px" type="submit" name="submit" class="btn btn-default" onclick="return confirmation()">Reconciliation</button>
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
        