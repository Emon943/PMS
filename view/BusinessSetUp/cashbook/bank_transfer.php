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
        

        $db_obj->select('tbl_bank_transfer','*',"our_ref='".$_POST['our_ref']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="cashbook.php?bank_transfer";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_bank_transfer',array('trans_date'=>$_POST['date'],
	    'our_ref'=>$_POST['our_ref'],
		'your_ref'=>$_POST['your_ref'],
		'total_amt'=>$_POST['total_amt'],
		'your_ref'=>$_POST['your_ref'],
		'total_amt'=>$_POST['total_amt'],
		'net_amount'=>$_POST['total_amt'],
		'receipt_type'=>$_POST['receipt_type'],
		'bank_name'=>$_POST['bank_name'],
		'fbank_ac_no'=>$_POST['fbank_ac_no'],
		'tbank_ac_no'=>$_POST['tbank_ac_no'],
		'des'=>$_POST['des'],
		'log'=>$_SESSION['LOGIN_USER']['login_id'])); 
		
		

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="cashbook.php?bank_transfer";</script>';
            
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
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
          <div align="right"><a href="?bank_transfer_list" class="btn alert-info"><span class="icon-th-large"></span>Bank Transfer List</a></div>
                     <?php endif;?>
   <h4 class="widgettitle">Bank To Bank Transfer</h4>
                
  <div class="widgetcontent" align="center">
  
  					
  
 <form class="stdform" action="" method="post">
  <div class="container-fluid">
  <div class="pull-left">
  <table>
  <tr>
    <td width="145" height="33"><strong>From Bank A/C : </strong> </td>
    <td width="283"><select name="fbank" id="fbank" required="required">
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
     
    </select></td>
	
   </tr>
   </table>
  
   <div id="res"></div>
   </div>
 
 <div class="pull-right">
 <table>
  <tr>
    <td width="145" height="33"><strong>To Bank A/C : </strong></td>
    <td width="283"><select name="tbank" id="tbank" required="required">
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
    </select></td>
	
   </tr>
   </table>
  <div id="result"></div>
  
  </div>
  
  
</div>

<tr>
    <td height="50" colspan="4" align="right"> 
       <p class="stdformbutton">
        <button class="btn btn-primary" id="c_button" name="submit_ins">Save</button>
        <button type="reset" class="btn">Reset Form</button>
       </p></td>
  </tr>
                  
                        
</form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->

<script>
	$(document).ready(function(){
		
		$('#tbank').change(function(){
			var select = $("#tbank" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/to_bank.php',
		data:'s_text='+select,
		success: function (data) {
         $('#result').html(data);
        }
		});
			
		});
	
	
	 
	});
	
	</script>
	
	<script>
	$(document).ready(function(){
		
		$('#fbank').change(function(){
			var select = $("#fbank" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/from_bank.php',
		data:'s_text='+select,
		success: function (data) {
         $('#res').html(data);
        }
		});
			
		});
	
	
	 
	});
	
	</script>
        