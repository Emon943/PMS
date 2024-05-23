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
        

        $db_obj->select('tbl_bank_receipt','*',"our_ref='".$_POST['our_ref']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="cashbook.php?bank_receipt";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_bank_receipt',array('trans_date'=>$_POST['date'],
	    'bank_id'=>$_POST['account_number'],
		'nominal_id'=>$_POST['Nominal1'],
		'our_ref'=>$_POST['our_ref'],
		'your_ref'=>$_POST['your_ref'],
		'total_amt'=>$_POST['nominal_bal'],
		'receipt_amt'=>$_POST['receipt_amt'],
		'receipt_type'=>$_POST['receipt_type'],
		'bank_name'=>$_POST['Bank'],
		'des'=>$_POST['des'],
		'data_insert_id'=>$_SESSION['LOGIN_USER']['login_id'])); 
		
		

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="cashbook.php?bank_receipt";</script>';
            
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
          <div align="right"><a href="?receipt_list" class="btn alert-info"><span class="icon-th-large"></span>Receipt List</a></div>
                     <?php endif;?>
   <h4 class="widgettitle">House Bank Receipt</h4>
                
  <div class="widgetcontent" align="center">
  
  					
  
 <form class="stdform" action="" method="post">
  <div class="container-fluid">
  <div class="pull-left">
  <table>
  <tr>
    <td width="145" height="33"><strong>Select Nominal: </strong> </td>
    <td width="283"><select name="Nominal1" id="Nominal1" required="required">
	<option value="">SELECT</option>
    <?php
	 $sqlw="SELECT * FROM `tbl_broker_hous`";
					
					 $db_obj->sql($sqlw);
					 $broker_house=$db_obj->getResult();
					 //print_r($broker_house);
					//die();
  //if($company_name){
						
	foreach($broker_house as $broker){
	?>
	
    <option value="<?php echo $broker['trace_id'];?>"><?php echo $broker['trace_id']."-".$broker['Internal_code']." ". "Receiable"; ?></option>
	 <?php
	}
	?> 	
    <option value="2818">Bank Interest Receipt</option>
    </select></td>
	
   </tr>
   </table>
  
   <div id="resss"></div>
   </div>
 
 <div class="pull-right">
 <table>
  <tr>
    <td width="145" height="33"><strong>Select Bank: </strong></td>
    <td width="283"><select name="myselect" id="myselect" required="required">
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
		
		$('#myselect').change(function(){
			var select = $("#myselect" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/receipt.php',
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
		
		$('#Nominal1').change(function(){
			var select = $("#Nominal1" ).val();
			 //alert(select);
			$.ajax({
		type:'post',
		url:'ajax/nominal_receipt.php',
		data:'s_text='+select,
		success: function (data) {
         $('#resss').html(data);
        }
		});
			
		});
	
	
	 
	});
	
	</script>
        