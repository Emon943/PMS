
<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
// echo $id;
 //die();
if($id!=null){
 $sql="SELECT * FROM tbl_broker_hous where trace_id='$id'";
 $res = $dbObj->select($sql);
 //print_r($res);
  
}

 
 ?>
 
 
<?php
if(@$res){
 foreach($res as $r){
?>
<table>
  <tr>
    <td width="145" height="33"><strong>Nominal Balance:</strong></td>
    <td width="283"><?php echo number_format((float)$r['payable'], 2) ; ?></td>
	<input type="hidden" name="nominal_bal" id="nominal_bal" value="<?php echo $r['payable']; ?>" required=""/>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Our Referece:</strong></td>
    <td width="283">Auto Number<input type="hidden" name="our_ref" id="our_ref" value="<?php echo "BH-PAY".rand(1000,9999999999); ?>"required=""/></td>
  </tr>
  
   <tr>
    <td width="145" height="33"><strong>Cheque:</strong></td>
    <td width="283"><input type="text" name="cheque" id="cheque" value=""required=""/></td>
  </tr>
   
   <tr>
    <td width="145" height="33"><strong>Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" value=""required=""/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Your Ref:</strong></td>
    <td width="283"><input type="text" name="your_ref" id="your_ref" value=""required=""/></td>
  </tr>
   <tr>
    <td><strong>Description:</strong></td>
    <td><textarea rows="40" cols="50" type="text" name="des" id="des" required="">Brokerage House Bank Payment</textarea></td>
  </tr>

   </table>

  <?php } 
  }else{ ?>
 <table>
  <tr>
    <td width="145" height="33"><strong>Nominal Balance:</strong></td>
    <td width="283"><?php echo '0.00'; ?></td>
	<input type="hidden" name="nominal_bal" id="nominal_bal" value="<?php echo '0.00'; ?>" required=""/>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Our Referece:</strong></td>
    <td width="283">Auto Number<input type="hidden" name="our_ref" id="our_ref" value="<?php echo "BC-PAY".rand(1000,9999999999); ?>"required=""/></td>
  </tr>
  
   <tr>
    <td width="145" height="33"><strong>Cheque:</strong></td>
    <td width="283"><input type="text" name="cheque" id="cheque" value=""required=""/></td>
  </tr>
   
   <tr>
    <td width="145" height="33"><strong>Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" value=""required=""/></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Your Ref:</strong></td>
    <td width="283"><input type="text" name="your_ref" id="your_ref" value=""required=""/></td>
  </tr>
   <tr>
    <td><strong>Description:</strong></td>
    <td><textarea rows="40" cols="50" type="text" name="des" id="des" required="">Bank Charge Payment</textarea></td>
  </tr>

   </table> 
	  
 <?php } ?>