	<?php 
	
	$db_obj->sql("SELECT investor.dp_internal_ref_number,investor.total_balance,loan_catagory_margin.interest_rate,investor_group.loan_applicable
           FROM loan_catagory_margin
           INNER JOIN investor_group ON loan_catagory_margin.id = investor_group.loan_cat
           INNER JOIN investor ON investor.investor_group_id = investor_group.investor_group_id");
		   $interest_credit=$db_obj->getResult();
			 echo count($interest_credit);
			 print_r($interest_credit);
			 //die();
			 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		if(isset($_POST["submit_data"])){
			
			//$ck=input_check(array('instrument_id'=>$_POST['instrument_id']));
			$ck=input_check(array('ac_no'=>$_POST['ac_no']));
			
			if($ck=='Success'){
				
				///Insert
        

         $db_obj->select('tbl_margin_loan','*',"ac_no='".$_POST['ac_no']."'");
         if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
            // header("Location: house_keeping.php?InstrumentNew");
		echo'<script>window.location="Margin.php?MarginAccounts";</script>';
               exit(); 
			   
		 }else{  	   
		$balance=$_POST['total_balance'];
		$margin_ratio=$_POST['margin_ratio'];
		$loan_amount=$balance*$margin_ratio;
		
		$ins=$db_obj->insert('tbl_margin_loan',array('ac_no'=>$_POST['ac_no'],
		'margin_id'=>$_POST['margin_id'],
		'name'=>$_POST['name'],
		'total_equity_balance'=>$_POST['total_balance'],
		'margin_ratio'=>$_POST['margin_ratio'],
		'loan_amt'=>$loan_amount,
		'interest_rate'=>$_POST['interest_rate'],
        'data_insert_id'=>$_SESSION['LOGIN_USER']['id']));
		
		 $_SESSION['in_result_data']="<h3 align='center'>Data Save Success Full...<h3>";

             $db_obj->disconnect();
             //header("Location: house_keeping.php?InstrumentNew");
			   echo'<script>window.location="Margin.php?MarginAccounts";</script>';
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
                  <div align="right"><a href="?margin_account_list" class="btn alert-info"><span class="icon-th-large"></span>Margin Account List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">On Demand Charge and Fee</h4>
                
  <div class="widgetcontent" align="center">
  
  						
  
    <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="36"><strong>A/C No:</strong></td>
    <td width="172">
	<select class="form-control" name="ac_no" id="ac_no" required>
	
	<?php
	$db_obj->sql("SELECT * FROM investor_group INNER JOIN investor ON investor.investor_group_id = investor_group.investor_group_id");
     $transaction_type=$db_obj->getResult();
	 echo count($transaction_type);
	 //print_r($transaction_type);
	
	 //die();
						
	 for($i=0;$i<count($transaction_type);$i++){
       $loan_applicable=$transaction_type[$i]['loan_applicable'];
	   $ac_no=$transaction_type[$i]['dp_internal_ref_number'];
	 
	 ?>
	 <?php 

 if($loan_applicable=="Yes"){ ?>
    <option value="<?php echo $ac_no;?>"><?php echo $ac_no; ?></option>
	 <?php } }?>
    
   </select></td>
   
   <!--<td width="100" height="36"><strong>Margin Category:</strong></td>
    <td width="172"><select class="form-control" name="margin_cat" id="margin_cat" required>
	<option value="">SELECT</option> 
	<?php
	/* $sql="SELECT * FROM `loan_catagory_margin`";
					 $db_obj->sql($sql);
					 $Margin_type=$db_obj->getResult();
					 //print_r($transaction_type);
						
	foreach($Margin_type as $Margin){ */
	?>
    <option value="<?php //echo $Margin['id'];?>"><?php //echo $Margin['description']; ?></option>
	 <?php
	//}
	?>
    
   </select></td>-->
   
  </tr>
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" type="submit" name="submit_ins">Load</button>
        </p></td>
  </tr>
    </table>
                 
    </form> 
	<br/>
	
<div style="border-top: 2px solid; border-top-style:solid;"></div><br/>
	<br/>
	
   <?PHP              
  if(isset($_POST["submit_ins"])){
		$ac_no=$_POST['ac_no'];
		
 $db_obj->sql("SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$ac_no' AND investor_personal.dp_internal_ref_number='$ac_no'");
 $res=$db_obj->getResult();
//print_r($res);
 $ac_balance=$res[0]['total_balance'];
 $dp_internal_ref_number=$res[0]['dp_internal_ref_number'];
 $investor_name=$res[0]['investor_name'];
 $investor_group_id=$res[0]['investor_group_id'];

 $bo_id=@$res[0]['investor_ac_number'];
 $db_obj->sql("SELECT * FROM tbl_ipo INNER JOIN instrument ON tbl_ipo.ISIN=instrument.isin WHERE BO_ID='".$db_obj->EString($bo_id)."'");
 $result=$db_obj->getResult();
 //print_r($result);
 $sum=0;
 $sums=0;
 for($i=0; $i<count($result); $i++){ 
		    $total_share=@$result[$i]['Current_Bal']+@$result[$i]['qty']+@$result[$i]['bonus_share']+@$result[$i]['Lockin_Balance'];
			$avg_rate=$result[$i]['avg_rate'];
			$cost_per_share=$result[$i]['cost_per_share'];
			if($avg_rate==0){
			$ipo_total_cost=$total_share*$cost_per_share;
			}else{
			$ipo_total_cost=0;
			}
			$total_cost=$total_share*$avg_rate;
			$sum=$sum+$total_cost+$ipo_total_cost;
			$market_value=@$result[$i]['market_price']*$total_share;
			$sums=$sums+$market_value;
			$u_gain=$sums-$sum; 
			
	}
		
 $sqls=$db_obj->sql("SELECT SUM(immatured_bal) as im_bal FROM sale_share WHERE account_no='$ac_no' AND status=0 Group By account_no");
 $ress= $db_obj->getResult();
 $im_bal=@$ress[0]['im_bal'];
 $immatured_bal=round($im_bal, 2);
 // echo $immatured_bal;
  
 $sqlb=$db_obj->sql("SELECT SUM(deposit_amt) as deposit_amt FROM tbl_deposit_balance WHERE account_ref='$ac_no' AND status=0 Group By account_ref");
 $res_bal= $db_obj->getResult();
 $unclear_cheque=@$res_bal[0]['deposit_amt'];
 $unclear_cheque=round($unclear_cheque, 2);
  //echo $unclear_cheque;
  $ledger_bal=@$res[0]['total_balance']+$unclear_cheque+$immatured_bal;
  $ledger_bal=round($ledger_bal, 2);
  $total_balance=round(@$res[0]['total_balance'], 2);
  $total_equity=$ledger_bal+$sums;
  
  
  $sql3="SELECT loan_cat FROM `investor_group` WHERE investor_group_id='$investor_group_id'";
		$db_obj->sql($sql3);
		$investor_group=$db_obj->getResult();
		$loan_cat=$investor_group[0]['loan_cat'];
		//print_r($investor_group);
		//die();
	
		
		$sql2="SELECT * FROM `loan_catagory_margin` WHERE id='$loan_cat'";
		$db_obj->sql($sql2);
		$margin_cat=$db_obj->getResult();
		//print_r($margin_cat);
		//die();
	?>
<?php
if(@$margin_cat){
	$margin_id=$margin_cat[0]['id'];
	$interest_rate=$margin_cat[0]['interest_rate'];
	$margin_ratio=$margin_cat[0]['margin_ratio'];
	$max_loan_allocation=$margin_cat[0]['max_loan_allocation'];
	$min_account_blance=$margin_cat[0]['min_account_blance'];
	$description=$margin_cat[0]['description'];

 ?>
<form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td width="283"><input type="hidden" name="total_balance" id="total_balance" value="<?php echo $total_equity;?>"></td>
	<td width="283"><input type="hidden" name="name" id="name" value="<?php echo $investor_name;?>"></td>
	 <td width="283"><input type="hidden" name="margin_id" id="margin_id" value="<?php echo $margin_id;?>"></td>
	</tr>
  <tr>
    <td width="145"><strong>A/C No:</strong></td>
    <td width="283"><input type="text" name="ac_no" id="ac_no" value="<?php echo $dp_internal_ref_number;?>" readonly="readonly"></td>
    <td width="145"><strong>Name:</strong></td>
    <td width="283"><?php echo $investor_name;?></td>
	
  </tr>
  <tr>
    <td width="155"><strong>Account Balance:</strong></td>
   <td><?php echo $ac_balance;?></td>
    <td width="155"><strong>Margin Category:</strong></td>
    <td><input type="text" name="margin_cat" id="margin_cat" value="<?php echo $description;?>" readonly="readonly" required></td>
  </tr>
  <tr>
    <td width="283"><strong>Margin Ratio:</strong></td>
    <td width="283"> 1:<input type="text" name="margin_ratio" id="margin_ratio" value="<?php echo $margin_ratio;?>" readonly="readonly" required></td>
	<td height="31"><strong>Interest Rate:</strong></td>
    <td width="283"><input type="text" name="interest_rate" id="interest_rate" value="<?php echo $interest_rate;?>" readonly="readonly" required>%</td>
  </tr>
  
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_data" onclick="return confirmation()">Save</button>
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
      return confirm('Are you sure you want to save this?');
    }
</script>