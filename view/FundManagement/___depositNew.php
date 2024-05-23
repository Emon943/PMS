	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('our_ref'=>$_POST['our_ref']));
			
			if($ck=='Success'){
				
				///Insert
        

        $db_obj->select('tbl_deposit_balance','*',"our_ref='".$_POST['our_ref']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="fund_management.php?deposit";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_deposit_balance',array('our_ref'=>$_POST['our_ref'],
		'account_ref'=>$_POST['account_ref'],
		'receipt'=>$_POST['receipt'],
		'investor_name'=>$_POST['investor_name'],
		'cheque'=>$_POST['cheque'],
		'date'=>$_POST['date'],
		'voucher_Ref'=>$_POST['voucher_Ref'],
		'bank'=>$_POST['bank'],
		'des'=>$_POST['des'],
		'branch'=>$_POST['branch'],
		'deposit_amt'=>$_POST['deposit_amt'],
		'com_bank_ac'=>$_POST['account_number'],
		'freeze'=>$_POST['freeze'],
		'batch'=>$_POST['batch'],
		'data_insert_id'=>$_SESSION['LOGIN_USER']['id'])); 
		
		
		//$db_obj->update("bank_ac",array("balance"=>$_POST["deposit_amt"]
							 // ),"account_number=".$_POST["account_number"]."");
		
		//print_r($ins);
		//die();

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="fund_management.php?depositNew";</script>';
            
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		}
	?>
<script>
	function makerequest(account_ref) {
  var xhttp;
  if (account_ref.length == 0) { 
    document.getElementById("res").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	  //alert(xhttp.readyState);
	  //alert(xhttp.status);
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("res").innerHTML = xhttp.responseText;
	  
	  if(xhttp.responseText=='Avaiable'){
		 document.getElementById('c_button').disabled=true; 
	  }
	  if(xhttp.responseText=='Account Ref does not match'){
		 document.getElementById('c_button').disabled=true; 
	  }
    }
  }
   testAjax='ajax/deposit_check.php?text='+account_ref;
	xhttp.open("GET",testAjax);
    xhttp.send();    
}
</script>
    
    <div class="contentinner">


     <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }



           if($page['view_status']=="Active"):
					?>
          <div align="right"><a href="?deposit" class="btn alert-info"><span class="icon-th-large"></span> All Deposit</a></div>
                     <?php endif;?>
   <h4 class="widgettitle">Fund To</h4>
                
  <div class="widgetcontent" align="center">
  
  					
  
 <form class="stdform" action="" method="post">
  <div class="container-fluid">
  <div class="pull-left" style="padding-left:20px">

  <div class="form-group">
  <label for="email"><strong>Cashbook A/C:</strong></label>
	
    <select class="form-control" id="myselect" required="required" />
	<option value="">SELECT</option> 
	<?php
	 $sql="SELECT * FROM `bank_ac`";
					
					 $db_obj->sql($sql);
					 $bank_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($bank_name as $bank){
	?>
	
    <option value="<?php echo $bank['id'];?>"><?php echo $bank['id'].":".$bank['bank_name']."(".$bank['account_number'].")"; ?></option>
	 <?php
	}
	?>
    
   </select>
  
  </div>
  
</div>
<?php

?>

<div class="pull-right" id="result">

  <div><strong>Bank Name: <input type="text" name="bank_name"></strong> </div>
  <div><strong>A/C Balance: <input type="text" name="bank_name"></strong> </div>
  <div><strong>A/C Number: <input type="text" name="bank_name"></strong> </div>
 
</div>
</div>
</br>
<div id="res">
<table width="783" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
    <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>Fund Deposit</strong></td>
   </tr>         
  <tr>
    <td width="145" height="33"><strong>Our Referece:</strong></td>
    <td width="283">Auto Number<input type="hidden" name="our_ref" id="our_ref" value="<?php echo rand(1000,9999999999); ?>"required=""/></td>
	 <td width="155" height="33"><strong>Account Ref: </strong> </td>
     <td width="283"><input type="text" name="account_ref" onblur="makerequest(this.value)"required=""/>
	 <!--<span id="res" style="color:red"></span>--></td>
	
  </tr>
  <tr>
    <td width="145" height="33"><strong>Receipt Type: </strong> </td>
    <td width="283"><select name="receipt" id="receipt" required="required">
      <option value="Cheque">Cheque</option>
      <option value="nline Transfer">Online Transfer</option>
	  <option value="Cash">Cash</option>
	  <option value="Deposit Slip">Deposit Slip</option>
    </select></td>
	<td width="155" height="33"><strong>Investor Name: </strong> </td>
     <td width="283"><span  style="color:red"><input type="hidden" name="investor_name" id="investor_name" required=""/></td>
   </tr>
  <tr>
    <td width="145" height="33"><strong>Cheque/TT Ref:</strong> </td>
    <td width="283"><input type="text" name="cheque" id="cheque" /></td>
	<td width="155" height="33"><strong>Avaiable Balance: </strong> </td>
     <td width="283"><input type="text" name="avaiable_bal" id="avaiable_bal"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" required /></td>
	<td width="155" height="33"><strong>Ledger Balance:</strong></td>
     <td width="283"><input type="text" name="ledger_bal" id="ledger_bal"/></td>
  </tr>
    <tr>
    <td width="145" height="33"><strong>Your Voucher Ref:</strong></td>
    <td width="283"><input type="text" name="voucher_Ref" id="voucher_Ref" /></td>
	<td width="155" height="33"><strong>Bank:</strong></td>
    <td width="283">
	<select name="bank" id="bank" required="required">
      <option value="City Bank">City Bank</option>
      <option value="Union Bank">Union Bank</option>
	  <option value="Dutch Bangla Ban">Dutch Bangla Bank</option>
	  <option value="Trust Bank">Trust Bank</option>
    </select>
	</td>
  </tr>
 
  <tr>
    <td width="155" height="33"><strong>Description:</strong></td>
    <td width="283"><textarea name="des" rows="2" id="des">Fund Deposit</textarea></td>
	
	<td width="155" height="33"><strong>Branch:</strong></td>
      <td width="283">
	 <select name="branch" id="branch" required="required">
      <option value="BD">Banani</option>
      <option value="USD">Gulshan-1</option>
	  <option value="EURO">Gulshan-2</option>
	  <option value="EURO">Mohmmandpur</option>
    </select></td>
	
  </tr>
  <tr>
	
	<td width="155" height="33"><strong>Deposit Amt.:</strong></td>
     <td width="283"><input type="text" name="deposit_amt" id="deposit_amt" required=""/></td>
	
  </tr>
  <tr>
   <td><label><input type="checkbox" name="freeze" value="1">Freeze Amt.</label></td>
   <td><label><input type="checkbox" name="batch" value="2">Batch Posting</label></td>
  </tr>
  
  <tr>
    <td height="50" colspan="4" align="right"> 
       <p class="stdformbutton">
        <button class="btn btn-primary" id="c_button" name="submit_ins">Save</button>
        <button type="reset" class="btn">Reset Form</button>
       </p></td>
  </tr>
    </table>


</div>
                     
                    
                     
                        
                        
    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->

<script>
	$(document).ready(function(){
		
		$('#myselect').change(function(){
			var select = $("#myselect" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/deposit.php',
		data:'s_text='+select,
		success: function (data) {
         $('#result').html(data);
        }
		});
			
		});
	
	
	 
	});
	</script>
        