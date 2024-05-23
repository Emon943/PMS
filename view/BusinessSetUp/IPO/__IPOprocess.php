<?php
 if(isset($_GET['dell']) && $page['delete_status']=="Active"){
         $ipo_id=$enc->decryptIt($_GET['dell']);
         $db_obj->delete("ipo_application", "id='$ipo_id'");
		  echo "<h2 style='text-align:center; color:green'>Delete Successfully</h2>";
                     
           $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
           exit();  	
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}
  if(isset($_POST["sub"])){
  $comp_id=@$_POST['company_id'];
   //echo $com_id;
}

if(isset($_POST['submit_ins'])){
    $name = $_FILES['file']['name'];
    $temp_name = $_FILES['file']['tmp_name'];  
    if(isset($name)){
        if(!empty($name)){      
            $location = 'pms_doc_upload/IPO_Process/';   
            if(move_uploaded_file($temp_name, $location.$name)){
               $content = file_get_contents($location.'/'.$name);
	           //print_r($content);
			    $array = explode("\n", $content);
				
			    
				 foreach($array as $cont){ 
				 $arrM = explode('~',$cont);
				//print_r($arrM);
				//die();
				 $id =@$arrM[2];
				  $short_name =@$arrM[6];
				  $refund_bal =@$arrM[12];
				 if($refund_bal==0){
				 $sql="UPDATE ipo_application SET `description`='Pandding for IPO' WHERE `ac_no`='$id' AND short_name='$short_name'";
                 $result=@mysql_query($sql);
				 }else{
				 $sql="UPDATE ipo_application SET `process_status`='1',`description`='IPO Payment' WHERE `ac_no`='$id' AND short_name='$short_name'";
                 $result=@mysql_query($sql);
				 }
				  
				 }
            }
        }       
    }  else {
        echo 'You should select a file to upload !!';
    }
	
	//$files = scandir($location.'/'.$name);
	
}
 
 
?>
<script type="text/javascript">
	   function confirmation_refund() {
      return confirm('You want to refund this?');
    }
</script>

<div class="container">
<div class="pull-left" style="padding-right:100px">
<h3>Search By</h3>
<hr>
<form class="stdform" action="" method="post">
  <div class="form-group">
  
    <label for="email"><strong>Company Name:</strong></label>
	
    <select name="company_id" id="myselect" required />
	<option value="">SELECT</option> 
	<?php
	 $sql="SELECT * FROM `tbl_ipo_declaration` where status=0";
					
		 $db_obj->sql($sql);
		 $company_name=$db_obj->getResult();

						
	foreach($company_name as $com_name){
	?>
	
    <option value="<?php echo $com_name['inst_name'];?>"><?php echo $com_name['inst_name']; ?></option>
	 <?php
	}
	?>
   </select>
  <button type="submit" name="sub" class="btn-primary" >Load</button>
  </div>
  
 </form>
</div>



<div class="pull-left" id="res">
<h3>IPO Company Details </h3>
<hr>
  <p><strong>Company Name:</strong> </p>
  <p><strong>Daclaration Date:</strong> </p>
  <p><strong>Closing Date :</strong> </p>
  <p><strong>IPO Rate:</strong> </p>
  <p><strong>Market Lot: </strong></p>
  <p><strong>Status: </strong></p>
</div>
</div>

 
<h4 class="widgettitle" style="text-align: center;">IPO Application Process List</h4>
<br>


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

<div class="table-wrapper-scroll-y my-custom-scrollbar">
<table class="table table-bordered table-striped mb-0">
                   
          <thead>
              <tr>
			<th width="114" class="head0" title="Short Name">Application Date</th>
            <th width="114" class="head0" title="Short Name">A/C No.</th>
			<th width="114" class="head0" title="Short Name">BO No.</th>
			<th width="114" class="head0" title="Short Name">A/C Name</th>
			<th width="114" class="head0" title="Short Name">A/C Type</th>
			<th width="114" class="head0" title="Short Name">Applycant Cate</th>
			<th width="114" class="head0" title="Short Name">A/C Balance</th>
			<th width="114" class="head0" title="Short Name">Market Lot</th>
			<th width="114" class="head0" title="Short Name">Allocated Share</th>
			<th width="114" class="head0" title="Short Name">Total Amt.</th>
			
			<th width="114" class="head0" title="Short Name">Fine Amount</th>
			<th width="114" class="head0" title="Short Name">Net Fund Amt.</th>
			
             <th width="181" class="head1" title="ISIN">Status</th>
              <th width="394" class="head0" title="Name">Remark</th>
              </tr>
          </thead>
		  <tbody>
		   <?php
		  
       if(@$comp_id){
		
		$sql= "SELECT * FROM ipo_application where company_id='$comp_id'"; 
					
			$db_obj->sql($sql);
			$ipo_application=$db_obj->getResult();
			$comp_name=@$ipo_application[0]['company_id'];
			//echo count($ipo_application);
			//print_r($ipo_application);
			//die();
		   }					   
           if(@$ipo_application){
						
		   foreach($ipo_application as $ipo_apply){			
					?>
		  <tr>
		  <td><?php echo $ipo_apply['date'];?></td>
		  <td><?php echo $ipo_apply['ac_no'];?></td>
		  <td><?php echo $ipo_apply['bo_id'];?></td>
		  <td><?php echo $ipo_apply['name'];?></td>
		  <td><?php echo $ipo_apply['ac_type'];?></td>
		  <td><?php echo $ipo_apply['applicant_type'];?></td>
		  <td><?php echo $ipo_apply['ac_bal'];?></td>
		  <td><?php echo $ipo_apply['market_lot'];?></td>
		  <td><?php echo "0.0";?></td>
		  <td><?php echo $ipo_apply['total_amt'];?></td>
		  <td><?php echo "0.0";?></td>
		  <td><?php echo $ipo_apply['total_amt'];?></td>
		  <td><?php if($ipo_apply['process_status']==0){
			  echo "Active";
		  }elseif($ipo_apply['process_status']==1){
			  echo "Reject";
		  }else{
			  echo "Refund";
		  } ?></td>
		  <td><?php //echo $ipo_apply['phone'];?></td>
		  
		  </tr>
		   <?php
		   }

		   } ?>
        </tbody>
   </table> 
   </div>
   
   <div>
   <?php
      if($page['edit_status']=="Active"):
	?>
       
	   
	    <form class="stdform" action="" method="post" enctype="multipart/form-data">
		<input type="file" name="file" value="fileupload" id="file"> <label for="fileupload"> Import Result file</label> 
		<button class="btn btn-primary" name="submit_ins">Submit</button></form>	
       <?php endif; ?> 
  
</div>

<div style="float:right">
   <?php
      if($page['edit_status']=="Active"):
	?>
       
	   
	   <a href="refund.php?id=<?php echo base64_encode($comp_name);?>" class="btn btn-primary" onclick="return confirmation_refund()"><span class="icon-hand-right"></span><strong>Refund</strong></a>
	   
       <?php endif; ?> 
  
</div>
   
<script>
	$(document).ready(function(){
		
		$('#myselect').change(function(){
			var select = $("#myselect" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/ipoAjax.php',
		data:'s_text='+select,
		success: function (data) {
         $('#res').html(data);
        }
		});
			
		});
	
	
	 
	});
	
	
	</script>
	
	<script>
	function makerequest(account_ref) {
  var xhttp;
  if (account_ref.length == 0) { 
    document.getElementById("ipores").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	  //alert(xhttp.readyState);
	  //alert(xhttp.status);
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("ipores").innerHTML = xhttp.responseText;
	  
	  if(xhttp.responseText=='Avaiable'){
		 document.getElementById('c_button').disabled=true; 
	  }
	  if(xhttp.responseText=='Account Ref does not match'){
		 document.getElementById('c_button').disabled=true; 
	  }
    }
  }
   testAjax='ajax/ipo_aplication.php?text='+account_ref;
	xhttp.open("GET",testAjax);
    xhttp.send();    
}
</script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	