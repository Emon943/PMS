<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
// echo $id;
 //die();
if($id!=null){
 $sql="SELECT * FROM bank_ac where id='$id'";
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
    <td width="145" height="33"><strong>Bank Balance:</strong></td>
	<td width="283"><?php echo number_format((float)$r['balance'], 2); ?></td>
	<input type="hidden" name="bank_bal" id="bank_bal" value="<?php echo $r['balance']; ?>" required=""/>
	<input type="hidden" name="account_number" id="account_number" value="<?php echo $r['account_number']; ?>" required=""/>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Payment Type:</strong></td>
    <td width="283"><input type="text" name="payment_type" id="payment_type" value="Cheque"required="" readonly /></td>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Bank:</strong></td>
    <td width="283"><input type="text" name="Bank" id="Bank" value="<?php echo $r['bank_name'];?>" required="" readonly /></td>
  </tr> 
  <tr>
    <td width="145" height="33"><strong>Branch:</strong></td>
    <td width="283"><input type="text" name="Branch" id="Branch" value="<?php echo $r['branch_name'];?>" required="" readonly /></td>
  </tr> 
 
 <tr>
    <td width="145" height="33"><strong>Total Amount:</strong></td>
    <td width="283"><input type="text" name="payment_amt" id="payment_amt" value="" required=""/></td>
  </tr> 
  

   </table>

<?php } } ?>