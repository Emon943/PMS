
<h4 class="widgettitle" style="text-align: center;">All Code Deduct Charge And Fee</h4>
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

#fee option{
 height:40px;   
}
</style>
<form class="stdform" action="?annual_fee_generate" method="post">
<div class="table-wrapper-scroll-y my-custom-scrollbar">
  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th>Is Select</th>
        <th scope="col">A/C NO.</th>
        <th scope="col">Name</th>
        <th scope="col">A/C Opening Date</th>
		 <th scope="col">Investor Group</th>
		  <th scope="col">Type</th>
		   <th scope="col">A/C Blance</th>
		    <th scope="col">Amount</th>
      </tr>
    </thead>
	<?php
	 if(isset($_POST["submit_ins"])){
	  $group_id=$_POST['investor_group'];
	  if($group_id){
		 $sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id WHERE investor_group_id='$group_id' AND status=0 ORDER BY investor.dp_internal_ref_number ASC";
		 $db_obj->sql($sql);
		 $investor=@$db_obj->getResult();
		 //print_r($investor);
	   }else{
	 
        $sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where status=0 ORDER BY investor.dp_internal_ref_number ASC";
		 $db_obj->sql($sql);
		 $investor=@$db_obj->getResult();
	   }
	 }
	?>
    <tbody>
	<?php
	for($i=0; $i<count(@$investor); $i++){
	 $ac_no=$investor[$i]['dp_internal_ref_number'];
	 $investor_name=$investor[$i]['investor_name'];
	 $investor_group_id=$investor[$i]['investor_group_id'];
	 $bo_catagory=$investor[$i]['bo_catagory'];
	 $creatd_date=$investor[$i]['creatd_date'];
	 $total_balance=$investor[$i]['total_balance'];
	 $amount=0.00;
		
		?>
      <tr>
	  <td><input type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $ac_no;?>"></td>
        
        <td><?php echo $ac_no;?></td>
        <td><?php echo $investor_name;?></td>
		<td><?php echo $creatd_date;?></td>
		<td><?php echo @mysql_result(mysql_query("SELECT `group_name` FROM `investor_group` WHERE `investor_group_id`='".$investor_group_id."'"),0);?></td>
		<td><?php echo $bo_catagory;?></td>
		<td><?php echo $total_balance;?></td>
		<td><?php echo $amount;?></td>
		
      </tr>
<?php } ?>
    </tbody>
  </table>
  
  

</div><br><br>


 <div style="padding-left:10px; float:left">
 <select name="fee" id="fee" required="required">
  <option value="">Sellect Fee Type</option> 
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

</select>
</div><br><br><br><br>
 <div style="float:left;padding-left:10px" id="res"></div>
  

<br><br><br><br>
 <div style="padding-left:10px">
 <button style="padding-left:10px" type="submit" name="submit_ins" class="btn btn-default" onclick="return confirmation()">Submit</button>
 </div>
</form>

	<script>
	$(document).ready(function(){
		
		$('#fee').change(function(){
			var select = $("#fee" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/fee.php',
		data:'s_text='+select,
		success: function (data) {
         $('#res').html(data);
        }
		});
			
		});
	
	 
	});
	
	
</script>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to post this fee?');
    }
</script>