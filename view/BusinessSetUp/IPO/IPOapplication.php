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
 
 /* if(isset($_POST["submit_ins"])){
			//echo "ok";
		$ck=input_check(array('ac_no'=>$_POST['ac_no']));
			//echo $ck;
			
			if($ck=='Success'){
				
				///Insert
          $ac=$_POST['ac_no'];
		  $com_id=$_POST['company_id'];
          $sql="SELECT * FROM `ipo_application` where ac_no='$ac' AND company_id='$com_id'";
		   $res= $dbObj->select($sql);
					
		  $count=count($res);
					//echo $count;
			 //exit();
					 
           //$db_obj->select('ipo_application','*',"ac_no='".$_POST['ac_no']."'" AND "company_id='".$_POST['company_id']."'");
		 //echo $db_obj->numRows();
		  //exit();
          if($count!=0){

        echo "<h2 style='text-align:center; color:green'>Investor Already Applied </h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
           exit();  			   

        }else{
			
			$total_amt=$_POST['market_lot']*$_POST['ipo_rate'];
			
			
			//die(); 
       $ins=$db_obj->insert('ipo_application',array('ac_no'=>$_POST['ac_no'],
	    'company_id'=>$_POST['company_id'],
		'name'=>$_POST['name'],
		'bo_id'=>$_POST['bo_id'],
		'ac_bal'=>$_POST['ac_bal'],
		'ac_type'=>$_POST['ac_type'],
		'applicant_type'=>$_POST['applicant_type'],
		'currency'=>$_POST['currency'],
		'market_lot'=>$_POST['market_lot'],
		'total_amt'=>$total_amt,
		'ipo_name'=>$_POST['ipo_rate'],
		'phone'=>$_POST['phone'],
		'routing_number'=>$_POST['routing_number'],
		'bank_name'=>$_POST['bank_name'],
		'bank_ac_no'=>$_POST['bank_ac_no'],
		'account_status'=>$_POST['account_status'],
        'serial'=>$_POST['serial'],
        'advisory_no'=>$_POST['advisory_no'],
		'date'=>$_POST['date'])); 		 
		

          echo "<h2 style='text-align:center; color:green'>Investor Applied Successfully</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
           exit();  
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		} */
?>

<div>
<?php if($page['view_status']=="Active"):
					?>
  <div align="right"><a href="?ipo_apply" class="btn alert-info"><span class="icon-th-large"></span>IPO Apply</a></div>
  <?php endif;?>
  <h4 class="widgettitle">IPO Applied List Search By Company</h4>


  <form class="stdform" action="" method="post">
  <div class="form-group">
  <label for="email"><font color="red">* </font><strong>Company Name:</strong></label>
	
    <select required name="company_id" id="myselect"/>
	<option value="">SELECT</option> 
	<?php
	 $sql="SELECT * FROM `tbl_ipo_declaration` where status=0";
					
					 $db_obj->sql($sql);
					 $company_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($company_name as $com_name){
	?>
	
    <option value="<?php echo $com_name['inst_name'];?>"><?php echo $com_name['inst_name']; ?></option>
	 <?php
	}
	?>
    
   </select>
  <button type="submit" name="sub" onclick="select()" >Load</button>
  </div>
</div>
</form><br>





<h4 class="widgettitle" style="text-align: center;">IPO Applied List</h4>
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
            <th width="114" class="head0" title="Short Name">A/C No.</th>
			<th width="114" class="head0" title="Short Name">BO No.</th>
			<th width="114" class="head0" title="Short Name">A/C Name</th>
			<th width="114" class="head0" title="Short Name">A/C Balance</th>
			<th width="114" class="head0" title="Short Name">A/C Type</th>
			<th width="114" class="head0" title="Short Name">Applycant Cate</th>
			<th width="114" class="head0" title="Short Name">Applied Qty</th>
			<th width="114" class="head0" title="Short Name">Total Amt.</th>
			<th width="114" class="head0" title="Short Name">Investor Cate</th>
			<th width="114" class="head0" title="Short Name">Currency</th>
			<th width="114" class="head0" title="Short Name">Bank Name</th>
			
             <th width="181" class="head1" title="ISIN">Rounting No.</th>
              <th width="394" class="head0" title="Name">Bank A/C No.</th>
               <th width="225" class="head1" title="Industry">Mobile</th>
             <th width="201" class="head1" title="Market Price">Status</th>
			 <th width="201" class="head1" title="Market Price">Active</th>
               <!--<th width="157" class="head1">Action</th>-->
              </tr>
          </thead>
		  <tbody>
		   <?php
		   if(!@$comp_id){
		   $date=date("d/m/y");
		   $sql1= "SELECT * FROM ipo_application where date='$date'"; 
					
			$db_obj->sql($sql1);
			$ipo_application=$db_obj->getResult();
			$comp_name=@$ipo_application[0]['company_id'];
			
			 $sql= "SELECT sum(total_amt) as total_amt,sum(market_lot) as market_lot FROM ipo_application where date='$date'";
			 $db_obj->sql($sql);
			$total=$db_obj->getResult();
			//print_r($ipo_application);
			//die();
		   }
       if(@$comp_id){
		
		   $sql= "SELECT * FROM ipo_application where company_id='$comp_id'"; 		
			$db_obj->sql($sql);
			$ipo_application=$db_obj->getResult();
			$comp_name=@$ipo_application[0]['company_id'];
			//echo count($ipo_application);
			//print_r($ipo_application);
			//die();
			 //count totat balance
            $sql1= "SELECT sum(total_amt) as total_amt,sum(market_lot) as market_lot FROM ipo_application where company_id='$comp_id'"; 	
			$db_obj->sql($sql1);
			$total=$db_obj->getResult();
			//print_r($total);
		   }
         
			
          			
           if($ipo_application){
						
		   foreach($ipo_application as $ipo_apply){			
					?>
		  <tr>
		  <td><?php echo $ipo_apply['ac_no'];?></td>
		  <td><?php echo $ipo_apply['bo_id'];?></td>
		  <td><?php echo $ipo_apply['name'];?></td>
		  <td><?php echo $ipo_apply['ac_bal'];?></td>
		  <td><?php echo $ipo_apply['ac_type'];?></td>
		  <td><?php echo $ipo_apply['applicant_type'];?></td>
		  <td><?php echo $ipo_apply['market_lot'];?></td>
		  <td><?php echo $ipo_apply['total_amt'];?></td>
		  <td><?php echo $ipo_apply['account_status'];?></td>
		  <td><?php echo $ipo_apply['currency'];?></td>
		  <td><?php echo $ipo_apply['bank_name'];?></td>
		  <td><?php echo $ipo_apply['routing_number'];?></td>
		  <td><?php echo $ipo_apply['bank_ac_no'];?></td>
		  <td><?php echo $ipo_apply['phone'];?></td>
		  <td><?php if($ipo_apply['status']==0){
			  echo "Applied";
		  }else{
			  echo "Paid";
		  } ?></td>
		  
		   <td><?php
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($ipo_apply['id']));?>" class="btn" title="Delete Data"><span class=" icon-trash"></span></a>
                            
                    <?php endif;?>
                            
                </td>
		  
		  
		  </tr>
		   
		   <?php
		   }

		   } ?>
		   
        </tbody>
   </table> 
   <div style="padding-left:400px">
		   <?php echo "Total Receive: ".$total[0]['total_amt'];?>&nbsp;&nbsp;&nbsp;
		   <?php echo "Tatal Amount: ".$total[0]['total_amt'];?>
		   
		   </div>
   </div>
   
   <div>
   <?php
      if($page['edit_status']=="Active"):
	?>
       <a href="ipo.php?pay&status=<?php echo urlencode($enc->encryptIt($comp_name));?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>Pay</a>
	   
	   <a href="generate.php?id=<?php echo base64_encode($comp_name);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>Generate Text File</a>
	    <a href="pdf_invoice.php?id=<?php echo base64_encode($comp_name);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>PDF Details</a>
       <a href="pdf_summary.php?id=<?php echo base64_encode($comp_name);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>PDF Summary</a>  		
       <?php endif; ?> 
  
</div>
   
<script>
	$(document).ready(function(){
		
		$('#myselect').change(function(){
			var select = $("#myselect" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/ipo_aplication.php',
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
	