<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
$sql1="SELECT * FROM tbl_bank_transfer ORDER BY id DESC  LIMIT 1";
$result = $dbObj->select($sql1);
if($result){
$tid=$result[0]['id']+1;
}else{
$tid=1;	
}
$BAT="BAT-".$tid;
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
	<input type="hidden" name="fbank_bal" id="fbank_bal" value="<?php echo $r['balance']; ?>" required=""/>
	<input type="hidden" name="fbank_ac_no" id="fbank_ac_no" value="<?php echo $r['account_number']; ?>" required=""/>
	<input type="hidden" name="your_ref" id="your_ref" value="<?php echo rand(1000,9999999999); ?>"required=""/>
	<input type="hidden" name="bank_name" id="bank_name" value="<?php echo $r['bank_name']; ?>"required=""/>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Our reference:</strong></td>
    <td width="283"><?php echo $BAT; ?>
	<input type="hidden" name="our_ref" id="our_ref" value="<?php echo $BAT; ?>" required="" />
	</td>
  </tr> 
  
  <tr>
    <td width="145" height="33"><strong>Date:</strong></td>
    <td width="283"><input type="date" name="date" id="date" value="<?php echo date("Y-m-d");?>" required=""/></td>
  </tr> 
  <tr>
    <td width="145" height="33"><strong>period/Yr:</strong></td>
    <td width="283"> <?php echo date("m-Y");?></td>
	<input type="hidden" name="pdate" id="pdate" value="<?php echo date("m-Y");?>" required=""/>
  </tr> 
 
 <tr>
    <td width="145" height="33"><strong>Description:</strong></td>
    <td width="283"><input type="text" name="des" id="des" value="" required=""/></td>
  </tr> 
  

   </table>

<?php } } ?>