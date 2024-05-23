<?php
require_once("../config.php");
$dbObj = new DBUtility();
$id = $_POST['s_text'];
 //echo $id;
 //die();
if($id!=null){
 $sql="SELECT * FROM tbl_ipo_declaration where inst_name='$id'";
  $res = $dbObj->select($sql);
  //var_dump($res);
  //die();
}

 
 ?>

<?php
foreach($res as $r){
?>
<h3>IPO Company Details </h3>
<hr>
  <p><strong>Company Name:</strong><?php echo $r['inst_name'];?> </p>
  <p><strong>Daclaration Date: </strong><?php echo $r['dec_date'];?> </p>
  <p><strong>Closing Date : </strong><?php echo $r['close_date'];?> </p>
  <p><strong>IPO Rate: </strong><?php echo $r['face_val'];?> </p>
  <p><strong>Market Lot: </strong><?php echo $r['market_lot'];?></p>
  <p><strong>Status: </strong>
  <?php
  if($r['status']==0){
    echo "Pandding";
  }else{
	  echo "Colsed";
  }
  ?>
  </p>
  <?php } ?>
