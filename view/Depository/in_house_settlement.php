<script>

  $(document).ready(function() {
    $("#datepicker").datepicker();
	 $("#enddatepicker").datepicker();
  });

  </script>
<?php
if(isset($_POST['submit'])){
    $ac_code=@$_POST["ac_code"];
	$inst_code=@$_POST["inst_code"];
    $inst_type=@$_POST["inst_type"];
	$buy=@$_POST["buy"];
	$sell=@$_POST["sell"];
    $all=@$_POST["all"];
	//echo $all;
	if($all==0){
    $sql="SELECT * FROM sale_share WHERE status='$all' AND day_count='$all'";
    $share_cate= $dbObj->select($sql);
	//print_r($share_cate);
	
	$sql1="SELECT * FROM tbl_buy_info WHERE status='$all' AND day_count='$all'";
    $share_cat= $dbObj->select($sql1);
	//print_r($share_cat);
	$Matured_share=(array_merge($share_cate,$share_cat));
	//print_r($Matured_share);
	//die();
	}
}
	// print_r($share_cate);
  ?>
 <style>
.my-custom-scrollbar {
position: relative;
height: 400px;
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
 <h4 class="widgettitle">Inhouse Settlement Search</h4>
<form class="stdform" action="" method="post">
 <label for="pwd">Account Code:</label>
 <input type="text" id="ac_code" name="ac_code"><br/><br/>
	 
  
   <label for="pwd">Instrument Code:</label>
  <input type="text" id="inst_code" name="inst_code"><br/><br/>
  
  <label for="email"><strong>Instrument Type:</strong></label>
	
    <select required name="company_id" id="myselect"/>
	<option value="1">All</option>
	<option value="2">Paper</option>
	<option value="3">Demat</option> 
	
    
   </select><br/><br/>
	

   <label for="email"><strong>  </strong></label>
   <strong>B </strong>  <input type="checkbox" name="buy" value="B" checked>
   <strong>S </strong> <input type="checkbox" name="sell" value="S" checked><br/><br/>
 
    <label for="email"><strong></strong></label>
   <input type="radio" name="all" value="0"><strong> Matured Date:</strong><input type="date" name="date" id="datepicker"/><br/><br/>
  
   <label for="email"><strong>  </strong></label>
   <strong>All </strong> <input type="radio" name="all" value="0">
 
 
   <hr>
  
   <div class="hidden-submit"><input type="submit" name="submit" tabindex="-1" style="display: none;"/></div>
  </form>
 

   <h4 class="widgettitle">Trade List</h4>
           
 
  <div class="table-wrapper-scroll-y my-custom-scrollbar">
 <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th>A/C No</th>
        <th>Instrument</th>
        <th>Tradeing Date</th>
		 <th>Matured Date</th>
		 <!--<th>Settlement Day</th>-->
		 <th>Trans Type</th>
		 <th>Share Qty</th>
		 <th>Rate</th>
		 <th>Total Amt.</th>
		 <th>Status</th>
      </tr>
    </thead>
    <tbody>
	<?php if(@$Matured_share){  ?>
	<?php foreach($Matured_share as $Mature_share){
			   ?>     
      <tr>
        <td><?php echo $Mature_share['account_no'];?></td>
        <td><?php echo $Mature_share['instrument'];?></td>
        <td><?php echo $Mature_share['trade_date'];?></td>
		<td><?php echo date("d-m-Y");?></td>
		 <td><?php echo $Mature_share['trans_type'];?></td>
		 <td><?php echo $Mature_share['qty'];?></td>
		 <td><?php echo $Mature_share['avg_rate'];?></td>
		  <td><?php echo $Mature_share['qty']*$Mature_share['avg_rate'];?></td>
		  <td><?php if(@$Mature_share['status']==0){
			      echo "Pending";
		          }else{
			       echo "Updated";
		        } ?></td>
		  <!--<td><?php //echo $Mature_share['bokersoftcode'];?></td>-->
      </tr>
       <?php
	 }
	}
		?>
    </tbody>
  </table>
  </div>
  
  <div style="float:left">
   <?php
    $day_count=@$Mature_share['day_count'];
    $number=@count($Matured_share);
	if($number > 0) {
	?> 
	<a href="Depository.php?process&&id=<?php echo base64_encode($day_count);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>Process</a>   
	 <?php }else{ ?>
	 <button type="button" class="btn" disabled><span class="icon-hand-right"></span>Process</button>
	<?php } ?>
	 
 </div>

 






