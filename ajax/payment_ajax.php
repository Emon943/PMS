<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
 //echo $id;
 //die();
if($id!=null){
 $sql="SELECT * FROM bank_ac where id='$id'";
  $res = $dbObj->select($sql);
  //var_dump($res);
  //die();
}

 
 ?>
 
 
<?php
foreach($res as $r){
?>
  <div><strong>Bank Name: <input type="text" name="bank_name" value="<?php echo $r['bank_name'];?>"></strong> </div>
  <div><strong>A/C Balance: <input type="text" name="balance" value="<?php echo $r['balance'];?>"></strong> </div>
  <div><strong>A/C Number: <input type="text" name="account_number" value="<?php echo $r['account_number'];?>"></strong> </div>
  <?php } ?>