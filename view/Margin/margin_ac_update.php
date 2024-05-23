
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$margin_ac=$enc->decryptIt($_GET["getID"]);
	
				$db_obj->sql("SELECT * FROM tbl_margin_loan WHERE ac_no='".$db_obj->EString($margin_ac)."'");
			    $margin_ac_res=$db_obj->getResult();
				//print_r($margin_ac_res);
				$margin_id=$margin_ac_res[0]['margin_id'];
				
				
			  if(!$margin_ac_res){
				   echo "<h2>Margin Category Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Modify this?');
    }
</script>
<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?margin_account_list" class="btn alert-info"><span class="icon-th-large"></span>Margin A/C List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
				 $user_id=$_SESSION['LOGIN_USER']['id'];
				 $update_date=date("Y-m-d h:i:sa");
				 $bal=$_POST['total_balance'];
		         $ratio=$_POST['margin_ratio'];
				 $interest=$_POST['interest_rate'];
				 $ac_number=$_POST['ac_no'];
				 $m_id=$_POST['margin_id'];
		        $loan_amount=$bal*$ratio;
				$investor_group_id=$_POST['investor_group_id'];
				
				
				
				$sql="UPDATE `tbl_margin_loan` SET `margin_id`='$m_id',`total_equity_balance`='$bal',`margin_ratio`='$ratio',`loan_amt`='$loan_amount',`interest_rate`='$interest',`date`='$update_date',`data_insert_id`='$user_id' WHERE `ac_no`='$ac_number'";
				$result=@mysql_query($sql);
				
				echo $sql_investor="UPDATE `investor` SET `investor_group_id`='$investor_group_id' WHERE `dp_internal_ref_number`='$ac_number'";
				//die();
				$result=@mysql_query($sql_investor);
			
		      echo "<h2 style='text-align:center; color:green'>Margin Loan Update Successfully</h2>";
                     
                 $db_obj->disconnect();
		    echo "<meta http-equiv='refresh' content='1; URL=Margin.php?margin_account_list'/>";
            exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
       <form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100" height="36"><strong>A/C No:</strong></td>
    <td width="172"><select class="form-control" name="ac_no" id="ac_no" required>
	<option value="<?php echo $margin_ac;?>"><?php echo $margin_ac;?></option> 
    
   </select></td>
   
   <td width="100" height="36"><strong>Margin Category:</strong></td>
    <td width="172"><select class="form-control" name="margin_cat" id="margin_cat" required>
	
	 <?php
                      $lsql="SELECT * FROM `loan_catagory_margin`";
                       $db_obj->sql($lsql);
					   $loan_catagory_res=$db_obj->getResult();
						//print_r($loan_catagory_res);
                        for ($i = 0; $i < count($loan_catagory_res); $i++){
							//echo $loan_catagory_res[$i]["id"];
                            if ($margin_id == $loan_catagory_res[$i]["id"]){
                                $margin = "selected";
                            }else{
                                $margin = "";
								}
                            ?>
                            <option <?php echo $margin;?> value="<?php echo $loan_catagory_res[$i]["id"]; ?>">
                                <?php echo $loan_catagory_res[$i]["description"]; ?></option>
                        <?php } ?>
    
   </select></td>
   
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
		$ac_no=$_POST['ac_no'];
		$margin_cat=$_POST['margin_cat'];
		
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
	
		
		$sql2="SELECT * FROM `loan_catagory_margin` WHERE id='$margin_cat'";
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
	
	$db_obj->sql("SELECT * FROM investor_group WHERE loan_cat='".$db_obj->EString($margin_id)."'");
   $investor_group=$db_obj->getResult();
   echo $investor_group_id=$investor_group[0]['investor_group_id'];
   
				
	//print_r($investor_group);

 ?>
<form class="stdform" action="" method="post">
                    	
	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td width="283"><input type="hidden" name="total_balance" id="total_balance" value="<?php echo $total_equity;?>"></td>
	<td width="283"><input type="hidden" name="name" id="name" value="<?php echo $investor_name;?>"></td>
	 <td width="283"><input type="hidden" name="margin_id" id="margin_id" value="<?php echo $margin_id;?>"></td>
	 <td width="283"><input type="hidden" name="investor_group_id" id="investor_group_id" value="<?php echo $investor_group_id;?>"></td>
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
        <button class="btn btn-primary" name="updateInv" onclick="return confirmation()">Update</button>
        </p></td>
  </tr>
    </table>
                 
    </form> 
 <?php 
 } }
 ?>
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         