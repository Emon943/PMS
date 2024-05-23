<?php
 require_once("../config.php");
 $dbObj = new DBUtility();
 $search_id = $_GET["text"];
 $search_id=strtoupper($search_id);
 
 //echo $search_id;
//die(); 
 if($search_id!=null){
  //$sql="SELECT * FROM investor where dp_internal_ref_number='$search_id'";
  //$res = $dbObj->select($sql);
  $sql="SELECT * FROM investor INNER JOIN investor_bank_details ON investor_bank_details.investor_id = investor.investor_id where investor.dp_internal_ref_number='$search_id' AND status=0";
  $res= $dbObj->select($sql);
  //$sql1="SELECT * FROM tbl_deposit_balance where account_ref='$search_id'";
  //$result = $dbObj->select($sql1);
 //var_dump($res);
  //die();
  }
  if($res){ ?>
 
 <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td height="25" colspan="4" align="center" valign="top"  style=  "background-color:#CCC;"><strong>Fund Deposit</strong></td>
   </tr>         
  <tr>
    <td width="145" height="33"><strong>Our Referece:</strong></td>
    <td width="283">Auto Number<input type="hidden" name="our_ref" id="our_ref" value="<?php echo rand(1000,9999999999); ?>"required=""/></td>
	 <td width="155" height="33"><strong>Account Ref: </strong> </td>
     <td width="283"><input type="text" name="account_ref" value="<?php echo $res[0]["dp_internal_ref_number"]; ?>"required=""/>
	 <!--<span id="res" style="color:red"></span>--></td>
	
  </tr>
  <tr>
    <td width="145" height="33"><strong>Receipt Type: </strong> </td>
    <td width="283"><select name="receipt" id="receipt" required="required">
      <option value="Cheque">Cheque</option>
      <option value="online Transfer">Online Transfer</option>
	  <option value="Cash">Cash</option>
	  <option value="Deposit Slip">Deposit Slip</option>
	  <option value="BEFTN">BEFTN</option>
    </select></td>
	<td width="155" height="33"><strong>Investor Name: </strong> </td>
     <td width="283"><input type="text" name="investor_name" id="investor_name"value="<?php echo $res[0]["investor_name"]; ?>" required=""/></td>
   </tr>
  <tr>
    <td width="145" height="33"><strong>Cheque/TT Ref:</strong> </td>
    <td width="283"><input type="text" name="cheque" id="cheque"/></td>
	<td width="155" height="33"><strong>Avaiable Balance: </strong> </td>
     <td width="283"><input type="text" name="avaiable_bal" id="avaiable_bal" value="<?php echo number_format((float)$res[0]["total_balance"], 2); ?>"/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" required /></td>
	<td width="155" height="33"><strong>Ledger Balance:</strong></td>
     <td width="283"><input type="text" name="ledger_bal" id="ledger_bal" value="<?php echo number_format((float)$res[0]["total_balance"], 2); ?>"/></td>
  </tr>
    <tr>
    <td width="145" height="33"><strong>Your Voucher Ref:</strong></td>
    <td width="283"><input type="text" name="voucher_Ref" id="voucher_Ref"/></td>
	<td width="155" height="33"><strong>Bank Name:</strong></td>
    <td width="283"><select name="bank_id" id="bank_id" required="required">
	<option value="<?php echo $res[0]["bank_name"];?>"> <?php echo $res[0]["bank_name"];?></option>
    
    </select></td>
  </tr>
 
  <tr>
    <td width="155" height="33"><strong>Description:</strong></td>
    <td width="283"><textarea name="des" rows="2" id="des">Fund Deposit By A/C: <?php echo $res[0]["dp_internal_ref_number"];?></textarea></td>
	
	<td width="155" height="33"><strong>Branch:</strong></td>
    <td width="283">
	 <select id="branch" name="branch">
    <option value="<?php echo $res[0]["branch_name"];?>"> <?php echo $res[0]["branch_name"];?></option>

    </select>
     </select>
    </td>
	
  </tr>
  <tr>
	<td width="155" height="33"><strong>Deposit Amt.:</strong></td>
     <td width="283"><input type="text" name="deposit_amt" onkeypress="return CheckNumeric()" id="deposit_amt" onkeyup="word.innerHTML=FormatCurrency(this.value); FormatComma(this)" required=""/></td>
	 
    <td width="145" height="33"><strong>In Word:</strong></td>
    <td><p id="word"></p></td>
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
	   <?php }else{
		   echo "Account Does Not Exist";
	   } ?>

