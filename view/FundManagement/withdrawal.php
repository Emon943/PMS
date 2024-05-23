<?php
if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $id=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_withdraw_balance", "id='$id'");
   	
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

<script type="text/javascript">
	   function confirmation_cancel() {
      return confirm('This is panding for bank reconcilation.You want to Delete this?');
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
        <a href="?withdrawNew" class="btn btn-primary"><span class="icon-plus-sign"></span>Fund Withdrawal</a>

                    
                     
      </div>
      <?php endif;?>
                                   
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
            <th width="114" class="head0" title="Short Name">A/C Reference</th>
             <th width="181" class="head1" title="ISIN">Transaction date</th>
              <th width="394" class="head0" title="Name">Our Ref</th>
               <th width="225" class="head1" title="Voucher Ref">Voucher Ref</th>
               <th width="201" class="head1" title="Total Amt.">Total Amt.</th>
			   <th width="201" class="head1" title="Total Vat">Bank A/C No</th>
			   <!--<th width="201" class="head1" title="Net Amt.">Net Amt.</th>-->
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
					
		 $sql="SELECT * FROM `tbl_withdraw_balance` where `recon_status`='0' ORDER BY id DESC";
			 $db_obj->sql($sql);
			 $withdraw_balance=$db_obj->getResult();
					  //print_r($withdraw_balance);
					  //die();
					 
					if($withdraw_balance){
						
					foreach($withdraw_balance as $withdraw_bal):
						
					$id=$withdraw_bal['data_insert_id'];
				    $sql_emp="SELECT login_id FROM `employee` where id='$id'";
					
					 $db_obj->sql($sql_emp);
					 $res_emp=$db_obj->getResult();
					 $user_name=@$res_emp[0]['login_id'];
						
					?>
               <tr class="gradeX">
                   <td><?php echo $withdraw_bal['account_ref'];?></td>
                   <td><?php echo $withdraw_bal['date'];?></td>
                   <td><?php echo $withdraw_bal['our_ref'];?></td>
                   <td><?php echo $withdraw_bal['voucher_Ref'];?></td>
					<td><?php echo number_format((float)$withdraw_bal['withdraw_amt'], 2);?></td>
					<td><?php echo $withdraw_bal['com_bank_ac'];?></td>
					<!--<td><?php //echo $withdraw_bal['withdraw_net_balance'];?></td>-->
					<td><?php echo $withdraw_bal['payment'];?></td>
					<td><?php echo $withdraw_bal['bank'];?></td>
				     <td><?php echo $withdraw_bal['des'];?></td>
					 <td class="center">
					 <?php
				      if($withdraw_bal['status']==0 || $withdraw_bal['status']==1){
					  echo "Panding"; }?></a>
					   <?php
				      if($withdraw_bal['status']==2){
					  echo "Post"; } ?> </td>
					  <td class="center"><?php
				      echo $user_name;
				   
				  ?></td>
				
				<td><?php
                    if($withdraw_bal['status']==0):
					?>
                   <a href="fund_management.php?WithdrawUpdate&getID=<?php echo urlencode($enc->encryptIt($withdraw_bal['id']));?>" onclick="return confirmation()" class="btn" title="confirm Data"><span>&#10003;</span></a>
				   <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($withdraw_bal['id']));?>"onclick="return confirmation_delete()" title="Delete Data"><span class="icon-trash"></span></a>
                            
					<?php endif;
					if($withdraw_bal['status']==2 AND $withdraw_bal['recon_status']==0):
					?>
                    <a href="fund_management.php?WithdrawCancel&getID=<?php echo urlencode($enc->encryptIt($withdraw_bal['id']));?>"onclick="return confirmation_cancel()" class="btn btn-danger" title="Delete Data">Cancel</a>
                 <?php endif; 
				 if($withdraw_bal['status']==1 AND $withdraw_bal['recon_status']==0):
				 ?>
				  <button type="button" class="btn btn-warning">Aprove Panding</button>
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
  

         