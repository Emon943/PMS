<?php
require_once("config.php");
  $dbObj = new DBUtility();
  $ac_no=$_POST['ac_no'];
  $company_id=$_POST['company_id'];
  $sqlcd="SELECT * FROM tbl_calendar WHERE status='2'";		
  $current_status = $dbObj->select($sqlcd);
  
	if($current_status){
	$status=$current_status[0]['status'];
	$edate=$current_status[0]['date'];
	
	$c_date = date('Y-m-d', strtotime($edate));
	
	}
  
  
  $sql="SELECT * FROM tbl_ipo_declaration where inst_name='$company_id'";
  $result = $dbObj->select($sql);
  $record_date=$result[0]['record_date'];
  if($record_date < $c_date){
  $sqlm="SELECT market_value FROM tbl_balance_forward where date='$record_date' AND ac_no='$ac_no'";
  $res_market_val = $dbObj->select($sqlm);
  $market_value=$res_market_val[0]['market_value'];  
  }else{
   $sqlm="SELECT SUM(market_val) as market_value FROM tbl_ipo where account_no='$ac_no'";
   $res_market_val = $dbObj->select($sqlm);
   $market_value=$res_market_val[0]['market_value'];    
  }
   
  $sql1="SELECT * FROM investor 
  INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id
  INNER JOIN investor_bank_details ON investor_bank_details.investor_id = investor.investor_id  
  where investor.dp_internal_ref_number='$ac_no' AND investor_personal.dp_internal_ref_number='$ac_no'";
  $ress = $dbObj->select($sql1);
  
  $sql2="SELECT SUM(immatured_bal) as immatured_bal FROM sale_share WHERE account_no='$ac_no' AND status='0'";
		$immatured_bal = $dbObj->select($sql2);
         $im_amount=@$immatured_bal[0]['immatured_bal'];
  
  $res=(array_merge($result,$ress));
   //print_r($res);
  
  ?>
  <?php 
  if($res){
	  $total_rate=$res[0]["face_val"]+$res[0]["premium"];
	  $bo_catagory=$res[1]["bo_catagory"];
	  $sql7="SELECT * FROM tbl_bo_cate where id='$bo_catagory'";
      $ac_type = $dbObj->select($sql7);
	  $account_type=$ac_type[0]["cate_name"];
	 
  ?>
  <div id="res"></div>
  <table>
    <tr>
      <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>IPO Application</strong></td>
     </tr>
   <tr>
    <td width="145" height="33"><strong>Account Number</strong></td>
    <td width="283"><input type="text" name="ac_no" id="ac_no" value="<?php echo $res[1]["dp_internal_ref_number"]; ?>" required /></td>
	 <td width="155" height="33"><strong>Bank Draft Reference</strong> </td>
     <td width="283"><input type="text" name="bdr" id="bdr"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Name</strong> </td>
    <td width="283"><input type="text" name="name" id="name" value="<?php echo $res[1]["investor_name"]; ?>"required=""/></td>
	<td width="155" height="33"><strong>Bank </strong> </td>
     <td width="283"><select name="bank_name" id="bank_name">
	  <option value="<?php echo $res[1]["bank_name"]; ?>"><?php echo $res[1]["bank_name"]; ?></option>
      <option value="Brack Bank">Brack Bank</option>
      <option value="UCB Bank">UCB Bank</option>
	  <option value="Union Bank">Union Bank</option>
    </select></td>
  </tr>
  
   <tr>
    <td width="145" height="33"><strong>BO Number</strong> </td>
    <td width="283"><input type="text" name="bo_id" id="bo_id" value="<?php echo $res[1]["bo_id"]; ?>" required=""/></td>
	<td width="155" height="33"><strong>Branch</strong> </td>
     <td width="283"><select name="branch" id="branch">
	  <option value="<?php echo $res[1]["branch_name"]; ?>"><?php echo $res[1]["branch_name"]; ?></option>
      <option value="Banani">Banani</option>
      <option value="Mohammadpur">Mohammadpur</option>
	  <option value="Gulshan-1">Gulshan-1</option>
    </select></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Accountss Balance</strong></td>
    <td width="283"><input type="text" name="ac_bal" id="ac_bal" value="<?php echo $res[1]["total_balance"]+$im_amount; ?>" readonly /></td>
	<td width="155" height="33"><strong>Draft Issue Date</strong></td>
     <td width="283"><input type="date" name="did" id="did"/></td>
  </tr>
    <tr>
    <td width="145" height="33"><strong>Account Type</strong></td>
    <td width="283"><input type="text" name="ac_type" id="ac_type" value="<?php echo $account_type; ?>" required /></td>
	<td width="155" height="33"><strong>Bank Draft Return</strong></td>
     <td width="283"><input type="text" name="bankdr" id="bankdr"/></td>
  </tr>
 
  <tr>
    <td height="33"><strong>Applicant Type</strong></td> <td width="283"><input type="text" name="applicant_type" id="applicant_type" value="<?php echo $res[1]["residency_flag"]; ?>" required /></td>
	
	<td width="155" height="33"><strong>Return Date</strong></td>
     <td width="283"><input type="date" name="return_date" id="return_date"/></td>
	
  </tr>
  <tr>
    <td width="155"><strong>Currency</strong></td>
    <td width="283"><select name="currency" id="currency" required="required">
      <option value="BDT">BDT</option>
      <option value="USD">USD</option>
	  <option value="EURO">EURO</option>
    </select></td>
	</tr>
	<tr>
	
    <td><input type="hidden" name="market_lot" id="market_lot" value="<?php echo $res[0]["market_lot"]; ?>" required="" readonly /></td>
	</tr>
	<tr>
    <td><input type="hidden" name="ipo_rate" id="ipo_rate" value="<?php echo $total_rate; ?>" required="" readonly /></td>
	</tr>
	<tr>
	<tr>
	
    <td><input type="hidden" name="min_investment" id="min_investment" value="<?php echo $res[0]["min_investment"]; ?>" required="" readonly /></td>
	</tr>
	<tr>
    <td><input type="hidden" name="market_value" id="market_value" value="<?php echo $market_value; ?>" required="" readonly /></td>
	</tr>
	<tr>
	<td width="155"><strong>Apply Amount</strong></td>
    <td><input type="text" name="total_amt" id="total_amt" value="<?php echo $res[0]["min_amount"]; ?>" required="" /></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="phone" id="phone" value="<?php echo $res[1]["phone"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="routing_number" id="routing_number" value="<?php echo $res[1]["routing_number"]; ?>"/></td>
	</tr>
	
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="bank_ac_no" id="bank_ac_no" value="<?php echo $res[1]["bank_ac_no"]; ?>"/></td>
	</tr>
	
    <tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="account_status" id="account_status" value="<?php echo $res[1]["account_status"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="serial" id="serial" value="<?php echo "042" ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="company_id" id="company_id" value="<?php echo $res[0]["inst_name"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="advisory_no" id="advisory_no" value="<?php echo "52900" ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="dec_date" id="dec_date" value="<?php echo $res[0]["dec_date"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="short_name" id="short_name" value="<?php echo $res[0]["short_name"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="date" id="date" value="<?php echo $c_date; ?>"/></td>
	</tr>
  <tr>
    <td height="50" colspan="4" align="right"> 
       <p class="stdformbutton">
       <input type="button" id="submitFormData" onclick="SaveFormData();" value="Save" />
        <button type="reset" class="btn">Reset Form</button>
       </p></td>
  </tr>
      
</table>

  <?php } ?>