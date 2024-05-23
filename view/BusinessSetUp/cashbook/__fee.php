	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		if(isset($_POST["submit_data"])){
		$ac_no=$_POST['ac_no'];
		$code=$_POST['code'];
		$total_balance=$_POST['total_balance'];
		$fee_amt=$_POST['fee_amt'];
		$ac_bal=$total_balance-$fee_amt;
		
		
		$ins=$db_obj->insert('tbl_charge_info',array('ac_no'=>$_POST['ac_no'],
		'code'=>$_POST['code'],
		'type'=>$_POST['tran_type'],
		'description'=>$_POST['des'],
		'total_amt'=>$_POST['fee_amt'],
		'total_balance'=>$_POST['total_balance'],
		'date'=>$_POST['date'],
        'data_insert_id'=>$_SESSION['LOGIN_USER']['id']));
		
		
		$sql="UPDATE `investor` SET `total_balance`='$ac_bal' WHERE `dp_internal_ref_number`='$ac_no'";
        $result=@mysql_query($sql);
		 
		   echo "<h2 style='text-align:center; color:green'>Charge Post Successfully</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=cashbook.php?fee' />";
           exit();  
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
                  <div align="right"><a href="?fee" class="btn alert-info"><span class="icon-th-large"></span>Investor List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">On Demand Charge and Fee</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="36"><strong>Sellect Fee Type:</strong></td>
    <td width="172"><select class="form-control" name="tran_type" id="tran_type" required>
	<option value="">SELECT</option> 
	<?php
	$sql="SELECT * FROM `transaction_type` WHERE charge_type='other' AND status='Active' ORDER BY id DESC";
					 $db_obj->sql($sql);
					 $transaction_type=$db_obj->getResult();
					 //print_r($transaction_type);
						
	foreach($transaction_type as $tran_type){
	?>
    <option value="<?php echo $tran_type['id'];?>"><?php echo $tran_type['name']; ?></option>
	 <?php
	}
	?>
    
   </select></td>
    <td width="75"><strong>A/C No:</strong></td>
    <td width="172"><input type="text" name="ac_no" id="ac_no" required></td>
  </tr>
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_ins">Load</button>
        </p></td>
  </tr>
    </table>
                 
    </form> 
	<br/>
	
<div style="border-top: 2px solid; border-top-style:solid;"></div><br/>
	<br/>
	
   <?PHP              
  if(isset($_POST["submit_ins"])){
		 $tran_id=$_POST['tran_type'];
		 $ac_no=$_POST['ac_no'];
			
		$sql="SELECT * FROM `transaction_type` WHERE id='$tran_id' ORDER BY id DESC";
		$db_obj->sql($sql);
		$result_type=$db_obj->getResult();
		// print_r($result_type);
		 $name=$result_type[0]['name'];
		 $description=$result_type[0]['description'];
		 $charges_amt=$result_type[0]['charges_amt'];
		 $trans_type=$result_type[0]['tran_type'];
		 $code=$result_type[0]['code'];
		 
		$sql="SELECT total_balance,dp_internal_ref_number FROM `investor` WHERE dp_internal_ref_number='$ac_no'";
		$db_obj->sql($sql);
		$total_balance=$db_obj->getResult();
		// print_r($total_balance);
	?>
<?php
if(@$total_balance){
	$total_bal=$total_balance[0]['total_balance'];
	$dp_internal_ref_number=$total_balance[0]['dp_internal_ref_number'];
 ?>
<form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="36"><strong>Sellect Fee Type:</strong></td>
    <td width="283"><select class="form-control" name="fee_type" id="fee_type" required=''>
    <option value="<?php echo $name;?>"><?php echo $name; ?></option>
   </select></td>
    <td width="145"><strong>A/C No:</strong></td>
    <td width="283"><input type="text" name="ac_no" id="ac_no" value="<?php echo $dp_internal_ref_number;?>"></td>
	 <td width="283"><input type="hidden" name="tran_type" id="tran_type" value="<?php echo $trans_type;?>"></td>
	 <td width="283"><input type="hidden" name="code" id="code" value="<?php echo $code;?>"></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Fee Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" required></td>
    <td width="155"><strong>Total Amount:</strong></td>
    <td><input type="text" name="total_balance" id="total_balance" value="<?php echo $total_bal;?>" required></td>
  </tr>
  <tr>
    <td height="31"><strong>Descrption:</strong></td>
    <td width="283"><input type="text" name="des" id="des" value="<?php echo $description;?>" required></td>
	<td height="31"><strong>Charge Amount:</strong></td>
    <td width="283"><input type="text" name="fee_amt" id="fee_amt" value="<?php echo $charges_amt;?>" required></td>
  </tr>
  
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_data" onclick="return confirmation()">Post</button>
        </p></td>
  </tr>
    </table>
                 
    </form> 
 <?php } 
 
 else{ ?>
	<h2 style="Color:red">Investor ID Not Valid</h2>
<?php } } ?>
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to post this?');
    }
</script>