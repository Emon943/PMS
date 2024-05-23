<?php
if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $id=$enc->decryptIt($_GET['dell']);
    $db_obj->delete("tbl_bank_transfer", "id='$id'");
	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();
}

if(isset($_GET['cancel'])){
$id=$enc->decryptIt($_GET['cancel']);
$db_obj->sql("SELECT * FROM  tbl_bank_transfer WHERE id='".$db_obj->EString($id)."'");
	    $bank_trans_info=$db_obj->getResult();
		//print_r($bank_trans_info);
		
		
		$from_bank=$bank_trans_info[0]['fbank_ac_no'];
		$to_bank=$bank_trans_info[0]['tbank_ac_no'];
		$total_amt=$bank_trans_info[0]['total_amt'];
		
		 $sql1="SELECT * FROM `bank_ac`where account_number='$from_bank'";
		 $db_obj->sql($sql1);
		 $from_bank_info=$db_obj->getResult();
		 //print_r($from_bank_info);
		 //die();
		 if($from_bank_info){
		 $fbank_bal=$from_bank_info[0]['balance'];
		 $f_update_bal=$fbank_bal+$total_amt;
		 }
        $db_obj->update("bank_ac",array("balance"=>$f_update_bal),"account_number=".$from_bank."");
		$db_obj->update("tbl_bank_transfer",array("status"=>'2'),"id=".$id."");
          echo "<h2 style='text-align:center; color:green'>Bank Transfer Reject Successfully</h2>";
          $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=cashbook.php?bank_transfer_list' />";
          exit();		
   }

if(isset($_POST["submit"])){
		 $fdate=$_POST['fdate'];
		 $tdate=$_POST['tdate'];
		 $status=$_POST['status'];
		 if($status==2){
	     $sql="SELECT * FROM `tbl_bank_transfer` where `trans_date` BETWEEN '$fdate' AND '$tdate'";
		 $db_obj->sql($sql);
	     $bank_transfer=$db_obj->getResult();
		 }elseif($status==1){
			$sql="SELECT * FROM `tbl_bank_transfer` where status='1' AND `trans_date` BETWEEN '$fdate' AND '$tdate'";
		    $db_obj->sql($sql);
		    $bank_transfer=$db_obj->getResult();
		 }else{
			$sql="SELECT * FROM `tbl_bank_transfer` where status='0' AND `trans_date` BETWEEN '$fdate' AND '$tdate'";
		    $db_obj->sql($sql);
		    $bank_transfer=$db_obj->getResult(); 
		 }
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
    <a href="?bank_transfer" class="btn btn-primary"><span class="icon-plus-sign"></span>Bank Transfer</a></div>
	 <h4 class="widgettitle">Bank Transaction List</h4>
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
      <label for="sel1">Bank Transfer Status:</label>
      <select class="form-control" name="status" required="required">
       <option value="">SELECT</option>
	   <option value="2">All</option>
		<option value="1">Post</option>
		 <option value="0">Panding</option>

      </select>
      
    </div>
 
  
  <button type="submit" name="submit" class="btn btn-default">Apply</button>
</form>
<h4 class="widgettitle" style="text-align: center;">Bank Transfer List</h4>
<br>          
 
      <?php endif;?>
                                   
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
             <th width="181" class="head1" title="ISIN">Transaction date</th>
              <th width="394" class="head0" title="Name">Our Ref</th>
               <th width="225" class="head1" title="Voucher Ref">Your Ref</th>
               <th width="201" class="head1" title="Total Amt.">Total Amt.</th>
			    <th width="201" class="head1" title="Total Amt.">Total vat.</th>
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
					 
					if(@$bank_transfer){
						
				    foreach($bank_transfer as $bank_trans):
						
					?>
               <tr class="gradeX">
                   <td><?php echo $bank_trans['trans_date'];?></td>
                   <td><?php echo $bank_trans['our_ref'];?></td>
                   <td><?php echo $bank_trans['your_ref'];?></td>
					<td><?php echo $bank_trans['total_amt'];?></td>
					<td><?php echo $bank_trans['total_vat'];?></td>
					<td><?php echo $bank_trans['receipt_type'];?></td>
					<td><?php echo $bank_trans['bank_name'];?></td>
				    <td><?php echo $bank_trans['des'];?></td>
					 <td class="center"><?php
				      if($bank_trans['status']==0){
					  echo "Panding"; }?>
					   <?php
				      if($bank_trans['status']==1){
					  echo "Post"; } ?> 
					   <?php
				      if($bank_trans['status']==2){
					  echo "Reject"; } ?>
					  </td>
					  <td class="center">User:<?php echo $bank_trans['log']; ?></td>
								
                 
                  <td><?php
                    if($bank_trans['status']==0){
					?>

					<a href="cashbook.php?Update_bank&getID=<?php echo urlencode($enc->encryptIt($bank_trans['id']));?>" onclick="return confirmation()" class="btn" title="confirm Data">&#10003;</a>
					 <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($bank_trans['id']));?>"onclick="return confirmation_delete()" class="btn" title="Delete Data"><span class="icon-trash"></span></a>
                     
					<?php }elseif($bank_trans['status']==1 AND $bank_trans['recon_status']==0){ ?>
					 <a href="<?php echo $_SERVER['REQUEST_URI']?>&cancel=<?php echo urlencode($enc->encryptIt($bank_trans['id']));?>"onclick="return confirmation_delete()" class="btn" title="Delete Data">Cancel</a>
				
					<?php }else{ ?>
						<button type="button" class="btn">Closed</button>
					<?php } ?>
								
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
  

         