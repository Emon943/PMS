<?php
/* if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $ipo_id=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_ipo_declaration", "id='$ipo_id'");
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}
 */
 
 if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('ac_no'=>$_POST['ac_no']));
			
			if($ck=='Success'){
				
				///Insert
        

         $db_obj->select('IPO_Application','*',"ac_no='".$_POST['ac_no']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Investor Already Applied !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="ipo.php?IPOapplication";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('IPO_Application',array('ac_no'=>$_POST['ac_no'],
		'bdr'=>$_POST['bdr'],
		'name'=>$_POST['name'],
		'bank'=>$_POST['bank'],
		'bo_id'=>$_POST['bo_id'],
		'branch'=>$_POST['branch'],
		'ac_bal'=>$_POST['ac_bal'],
		'did'=>$_POST['did'],
		'ac_type'=>$_POST['ac_type'],
		'bankdr'=>$_POST['bankdr'],
		'applicant_type'=>$_POST['applicant_type'],
		'return_date'=>$_POST['return_date'],
		'currency'=>$_POST['currency'],
		'market_lot'=>$_POST['market_lot'],
		'market_lot'=>$_POST['total_amt'],
		'market_lot'=>$_POST['ipo_name'],
		'data_insert_id'=>$_SESSION['LOGIN_USER']['id'])); 
		
		
		//$db_obj->update("bank_ac",array("balance"=>$_POST["deposit_amt"]
							 // ),"account_number=".$_POST["account_number"]."");
		
		//print_r($ins);
		//die();

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="ipo.php?IPOapplication";</script>';
            
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		}
?>

<div class="container-fluid">
<div class="pull-left" style="padding-left:20px">
<h3>Search By</h3>
<hr>
<form class="stdform" action="" method="post">
  <div class="form-group">
    <label for="email"><strong>Company Name:</strong></label>
	
    <select class="form-control" id="myselect"/>
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
	
    <option value="<?php echo $com_name['id'];?>"><?php echo $com_name['inst_name']; ?></option>
	 <?php
	}
	?>
    
   </select>
  
  </div>
  
  <div class="form-group">
    <label for="AC"><strong>Account Number:</strong></label>
    <!--<input type="text" class="form-control" id="AC" onblur="makerequest(this.value)">-->
	<input type="text" class="form-control" name="account_ref" onblur="makerequest(this.value)"required=""/>
  </div>
  <div class="form-group">
    <label for="mobile"><strong>Mobile:</strong></label>
    <input type="text" class="form-control" id="mobile">
  </div>
  <div class="form-group">
    <label for="email"><strong>Account Type:</strong></label>
    <select class="form-control" id="sel1">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
   </select>
  </div>
   <div class="form-group">
    <label for="mobile"><strong>Account Balance(greater):</strong></label>
    <input type="password" class="form-control" id="mobile">
  </div>

</div>
<?php

?>

<div class="pull-right" id="res">
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
<!--<p><span id="ipores"></span></p>-->
 
<div style="padding-left:20px;" id="ipores">

</div>
<div style="padding-left:20px;" id="ress">

</div>
</form>
<div style="padding-left:20px;" class="table-responsive"/> 
<hr>
  <table width="100%" class="table table-bordered">
                   
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
			<th width="114" class="head0" title="Short Name">Currency</th>
			<th width="114" class="head0" title="Short Name">Bank Name</th>
			
             <th width="181" class="head1" title="ISIN">Rounting No.</th>
              <th width="394" class="head0" title="Name">Bank A/C No.</th>
               <th width="225" class="head1" title="Industry">Mobile</th>
               <th width="201" class="head1" title="Market Price">Status</th>
               <!--<th width="157" class="head1">Action</th>-->
              </tr>
          </thead>
		  <tbody>
		   <?php
		  $sql= "SELECT * FROM investor
           INNER JOIN investor_bank_details ON investor.investor_id = investor_bank_details.investor_id";
					
			$db_obj->sql($sql);
			$ipo_lists=$db_obj->getResult();
			//print_r($ipo_lists);
			//die();	
           if($ipo_lists){
						
		   foreach($ipo_lists as $ipo_list){			
					?>
		  <tr>
		  <td><?php echo $ipo_list['dp_internal_ref_number'];?></td>
		  <td><?php echo $ipo_list['investor_ac_number'];?></td>
		  <td><?php echo $ipo_list['investor_name'];?></td>
		  <td>gggmmmmmm</td>
		  <td>gggmmmmm</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  <td>ggg</td>
		  </tr>
		   <?php
		   }

		   } ?>
        </tbody>
   </table> 
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
	
	$(document).ready(function(){
		
		$('#myselect').change(function(){
			var select = $("#myselect" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/ipo_aplication.php',
		data:'s_text='+select,
		success: function (data) {
         $('#ress').html(data);
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
	