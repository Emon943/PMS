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
    <td width="145" height="33"><strong>Net Balance:</strong></td>
	<td width="283"><?php echo $r['balance']; ?></td>
	<input type="hidden" name="tbank_bal" id="tbank_bal" value="<?php echo $r['balance']; ?>" required=""/>
	<input type="hidden" name="tbank_ac_no" id="tbank_ac_no" value="<?php echo $r['account_number']; ?>" required=""/>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Cheque NO:</strong></td>
    <td width="283"><input type="text" name="receipt_type" id="receipt_type" required="" /></td>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Amount:</strong></td>
    <td width="283"><input type="text" name="total_amt" id="total_amt" required=""/></td>
  </tr> 

   </table>

<?php } } ?>