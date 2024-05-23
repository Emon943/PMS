<?php
if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $id=$enc->decryptIt($_GET['dell']);
	$db_obj->sql("SELECT * FROM  tbl_bank_receipt WHERE id='".$db_obj->EString($id)."'");
	$receipt_info=$db_obj->getResult();
		
		$nominal_id=$receipt_info[0]['nominal_id'];
		$receipt_amt=$receipt_info[0]['receipt_amt'];
		
		$sql1="SELECT * FROM `tbl_broker_hous`where trace_id='$nominal_id'";
		$db_obj->sql($sql1);
		$broker_receiable=$db_obj->getResult();
		$broker_receiable_bal=@$broker_receiable[0]['receivable'];
		$update_nominal_bal=$broker_receiable_bal+$receipt_amt;
		$res=$db_obj->update("tbl_broker_hous",array("receivable"=>$update_nominal_bal),"trace_id=".$nominal_id."");
        if($res){
        $db_obj->delete("tbl_bank_receipt", "id='$id'");
		 }
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>


<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Confirmed this?');
    }
</script>

<script type="text/javascript">
    function confirmation_delete() {
      return confirm('Are you sure you want to Delete this?');
    }
</script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>   
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?bank_receipt" class="btn btn-primary"><span class="icon-plus-sign"></span>Bank Receipt</a>

                    
                     
      </div>
      <?php endif;?>
                                   
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
             <th width="181" class="head1" title="ISIN">Transaction date</th>
              <th width="394" class="head0" title="Name">Our Ref</th>
               <th width="225" class="head1" title="Voucher Ref">Your Ref</th>
               <th width="201" class="head1" title="Total Amt.">Total Amt.</th>
			   <th width="201" class="head1" title="Receipt Type">Receipt Amount</th>
			   <th width="201" class="head1" title="Receipt Type">Receipt Type</th>
			   <th width="201" class="head1" title="Bank Name">Bank Name</th>
			   <th width="201" class="head1" title="Description">Description</th>
			   <th width="201" class="head1" title="Status">Status</th>
			   <th width="201" class="head1" title="Log">Log</th>
               <th width="157" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
		 $sql="SELECT * FROM `tbl_bank_receipt` where recon_status='0' ORDER BY id DESC";
					
					 $db_obj->sql($sql);
					 $payment_balance=$db_obj->getResult();
					// print_r($payment_balance);
					// die();
					 
					if($payment_balance){
						
				    foreach($payment_balance as $payment_bal):
						
					?>
               <tr class="gradeX">
                   <td><?php echo $payment_bal['trans_date'];?></td>
                   <td><?php echo $payment_bal['our_ref'];?></td>
                   <td><?php echo $payment_bal['your_ref'];?></td>
				    
					<td><?php echo number_format((float)$payment_bal['total_amt'], 2);?></td>
					<td><?php echo number_format((float)$payment_bal['receipt_amt'], 2);?></td>
					<td><?php echo $payment_bal['receipt_type'];?></td>
					<td><?php echo $payment_bal['bank_name'];?></td>
					 
				     <td><?php echo $payment_bal['des'];?></td>
					 <td class="center"><?php
				      if($payment_bal['status']==0){
					  echo "Panding"; }?></a>
					   <?php
				      if($payment_bal['status']==1){
					  echo "Post"; } ?> </td>
					  <td class="center">User:<?php echo $payment_bal['data_insert_id']; ?></td>
								
                 
                  <td><?php
                    if($payment_bal['status']==0):
					?>

					<a href="cashbook.php?Update_ledger_receipt&getID=<?php echo urlencode($enc->encryptIt($payment_bal['id']));?>" onclick="return confirmation()" class="btn btn-danger" title="confirm Data">Confirm</a>
                    <!--<a href="<?php// echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($payment_bal['id']));?>"onclick="return confirmation_delete()" class="btn" title="Delete Data"><span class="icon-trash"></span></a>-->
                            
					<?php endif;
					 if($payment_bal['status']==1 AND $payment_bal['recon_status']==0):
					?>
                      <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($payment_bal['id']));?>"onclick="return confirmation_delete()" class="btn btn-danger" title="Delete Data">Cancel</a>
					<?php endif; ?>
                	</td>
				
				
              </tr>
              <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
  
 </div>
  

         