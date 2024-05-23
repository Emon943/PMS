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
			   <th width="201" class="head1" title="Net Amt.">Net Amt.</th>
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
					
		 $sql="SELECT * FROM `tbl_withdraw_balance` where status='1' ORDER BY id DESC";
					
					 $db_obj->sql($sql);
					 $withdraw_balance=$db_obj->getResult();
					  //print_r($deposit_balance);
					  //die();
					 
					if($withdraw_balance){
						
					foreach($withdraw_balance as $withdraw_bal):
						$id=$withdraw_bal['data_insert_id'];
				       $sql_emp="SELECT login_id FROM `employee` where id='$id'";
					
					 $db_obj->sql($sql_emp);
					 $res_emp=$db_obj->getResult();
					 $user_name=$res_emp[0]['login_id'];
					?>
               <tr class="gradeX">
                   <td><?php echo $withdraw_bal['account_ref'];?></td>
                   <td><?php echo $withdraw_bal['date'];?></td>
                   <td><?php echo $withdraw_bal['our_ref'];?></td>
                   <td><?php echo $withdraw_bal['voucher_Ref'];?></td>
				    
					<td><?php echo $withdraw_bal['withdraw_amt'];?></td>
					<td><?php echo $withdraw_bal['com_bank_ac'];?></td>
					<td><?php echo $withdraw_bal['withdraw_net_balance'];?></td>
					<td><?php echo $withdraw_bal['payment'];?></td>
					<td><?php echo $withdraw_bal['bank'];?></td>
					 
				     <td><?php echo $withdraw_bal['des'];?></td>
					 <td class="center">
					 <?php
				      if($withdraw_bal['status']==0){
					  echo "Panding"; }?></a>
					   <?php
				      if($withdraw_bal['status']==1){
					  echo "Paid"; } ?> </td>
					  <td class="center"><?php
				      echo $user_name;
				  ?></td>
				  
				  
				  <td><?php
                    if($withdraw_bal['status']==1):
					?>
					
					<a href="balance_aprove.php?WithdrawUpdate&getID=<?php echo urlencode($enc->encryptIt($withdraw_bal['id']));?>" onclick="return confirmation()" class="btn btn-danger" title="confirm Data">Aprove</a>
					
                   
                            
					<?php endif;
					
					?>
				  
                            
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
  

         