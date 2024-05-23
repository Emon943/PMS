
<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
// echo $id;
 //die();
    $sql1="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where status=0 ORDER BY investor.dp_internal_ref_number ASC";
	$investor=$dbObj->select($sql1);
	$t=(count($investor));
         

if($id!=null){
 $sql="SELECT * FROM transaction_type where id='$id'";
 $result_type = $dbObj->select($sql);

 $name=$result_type[0]['name'];
 $description=$result_type[0]['description'];
 $fee=$result_type[0]['charges_amt'];
 $trans_type=$result_type[0]['tran_type'];
 $code=$result_type[0]['code'];
 //print_r($res);
  $total_amt=$fee*$t;
}

 
 ?>

<table>
  <tr>
  <td width="100" height="33"><strong>Fee Amount:</strong></td>
  <td width="283"><input type="text" name="fee" id="fee" value="<?php echo $fee; ?>" required=""/></td>

	<td width="100" height="33"><strong>Total Amount:</strong></td>
	<td width="283"><?php echo $total_amt; ?>TK.</td>
	<input type="hidden" name="tran_type" id="tran_type" value="<?php echo $trans_type;?>">
	<input type="hidden" name="code" id="code" value="<?php echo $code;?>">
	<input type="hidden" name="des" id="des" value="<?php echo $description;?>">
	
  </tr>

   </table>
