
<?php
 require_once("../config.php");
 $dbObj = new DBUtility();
 $search_id = @$_GET["text"];
 //$id = @$_POST['s_text'];
// echo $search_id;
  //echo $id;
   ?>
 <?php
 if($search_id!=null){
	
 $sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where investor.dp_internal_ref_number='$search_id' AND investor_personal.dp_internal_ref_number='$search_id'";
  $res = $dbObj->select($sql);
  $investor_id = @$res[0]['investor_id'];
  //echo $investor_id;
  //print_r($res);
  //die();
  
  //$sqlb="SELECT deposit_amt FROM tbl_deposit_balance where account_ref='$search_id'";
  // $result = $dbObj->select($sqlb);
  
  $sqlibd="SELECT * FROM investor_bank_details where investor_id='$investor_id'";
  $ress = $dbObj->select($sqlibd);
  
 // print_r($ress);
  } ?>
  
 <?php if(@$res){ ?>

<table>
    <tr>
      <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>IPO Applications</strong></td>
     </tr>
   <tr>
    <td width="145" height="33"><strong>Account Number</strong></td>
    <td width="283"><input type="text" name="ac_no" id="ac_no" value="<?php echo $res[0]["dp_internal_ref_number"]; ?>" required=""/></td>
	 <td width="155" height="33"><strong>Bank Draft Reference</strong> </td>
     <td width="283"><input type="text" name="bdr" id="bdr"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Name</strong> </td>
    <td width="283"><input type="text" name="name" id="name" value="<?php echo $res[0]["investor_name"]; ?>"required=""/></td>
	<td width="155" height="33"><strong>Bank </strong> </td>
     <td width="283"><select name="bank" id="bank">
	  <option value=" ">Select</option>
      <option value="Brack Bank">Brack Bank</option>
      <option value="UCB Bank">UCB Bank</option>
	  <option value="Union Bank">Union Bank</option>
    </select></td>
  </tr>
  
   <tr>
    <td width="145" height="33"><strong>BO Number</strong> </td>
    <td width="283"><input type="text" name="bo_id" id="bo_id" value="<?php echo $res[0]["bo_id"]; ?>" required=""/></td>
	<td width="155" height="33"><strong>Branch</strong> </td>
     <td width="283"><select name="branch" id="branch">
	  <option value="">Select</option>
      <option value="Banani">Banani</option>
      <option value="Mohammadpur">Mohammadpur</option>
	  <option value="Gulshan-1">Gulshan-1</option>
    </select></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Account Balance</strong></td>
    <td width="283"><input type="text" name="ac_bal" id="ac_bal" value="<?php echo $res[0]["total_balance"]; ?>" required /></td>
	<td width="155" height="33"><strong>Draft Issue Date</strong></td>
     <td width="283"><input type="date" name="did" id="did"/></td>
  </tr>
    <tr>
    <td width="145" height="33"><strong>Account Type</strong></td>
    <td width="283"><input type="text" name="ac_type" id="ac_type" value="<?php echo $res[0]["bo_catagory"]; ?>" required /></td>
	<td width="155" height="33"><strong>Bank Draft Return</strong></td>
     <td width="283"><input type="text" name="bankdr" id="bankdr"/></td>
  </tr>
 
  <tr>
    <td height="33"><strong>Applicant Type</strong></td> <td width="283"><input type="text" name="applicant_type" id="applicant_type" value="<?php echo $res[0]["residency_flag"]; ?>" required /></td>
	
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
	<td width="155"><strong>Market Lot</strong></td>
    <td><input type="text" name="market_lot" id="market_lot" required=""/></td>
	</tr>
	<tr>
	<td width="155"><strong>IPO Rate</strong></td>
    <td><input type="text" name="ipo_rate" id="ipo_rate" required=""/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="phone" id="phone" value="<?php echo $res[0]["phone"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="routing_number" id="routing_number" value="<?php echo $ress[0]["routing_number"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="bank_name" id="bank_name" value="<?php echo $ress[0]["bank_name"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="bank_ac_no" id="bank_ac_no" value="<?php echo $ress[0]["bank_ac_no"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="bank_ac_no" id="bank_ac_no" value="<?php echo $ress[0]["bank_ac_no"]; ?>"/></td>
	</tr>
    <tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="account_status" id="account_status" value="<?php echo $res[0]["account_status"]; ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="serial" id="serial" value="<?php echo "042" ?>"/></td>
	</tr>
	<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="advisory_no" id="advisory_no" value="<?php echo "52900" ?>"/></td>
	</tr>
		<tr>
	<td width="155"><strong></strong></td>
    <td><input type="hidden" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"/></td>
	</tr>
  <tr>
    <td height="50" colspan="4" align="right"> 
       <p class="stdformbutton">
        <button class="btn btn-primary" id="c_button" name="submit_ins">Save</button>
        <button type="reset" class="btn">Reset Form</button>
       </p></td>
  </tr>
      
</table> 
  
     	                  
	   <?php }else{
		   echo "";
	   } ?>
	    

 