<?php
 include("../config.php");
 $dbObj = new DBUtility();
 //$date = $_POST['cdate'];
 $bo_cate = $_POST['bo_cate'];
 
 
   $bc = "select * from tbl_bo_cate WHERE id='$bo_cate'";
   $cate_name_res= $dbObj->select($bc);
   $cate_name=$cate_name_res[0]['cate_name'];
  

?>


<div style="height: 1.32in !important; width: 9.3in;">
<img src="img/printer-green.png" height="45" width="45" onclick="print_rpt()" style="float: right; cursor: pointer;" title="Print" />
</div>

<div id="PrintArea" style="background-color: white;" >
	<style>
		.table_body  tr th{
			border: 1px solid;
			font-size: 15px;
			text-align: center;
			padding: 2px;
		}
		.table_body tbody tr td {
			border: 1px solid;
			font-size: 16px !important;
		}
  .box{
   
    width: 250px;
    border: 1px solid;
    padding: 10px;
    margin: 20px;
	margin-left:500px;
	text-align:right;
   }
	</style>
  <?php
  if($bo_cate){
   
   $sql="SELECT investor.dp_internal_ref_number,investor.investor_name,investor.total_balance,investor_personal.bo_catagory as bo_cat FROM `investor_personal` INNER JOIN `investor` 
        ON (investor_personal.investor_id = investor.investor_id) WHERE bo_catagory=$bo_cate";
    $PMDA_investor_bal = $dbObj->select($sql);
     //print_r($PMDA_investor_bal);
   
    $sql1="SELECT * FROM bank_ac WHERE account_use=$bo_cate";
    $PMDA_bank_bal= $dbObj->select($sql1);
   //print_r($PMDA_bank_bal);
  }
  ?>
            <div style="height: auto !important; width: 10.3in;">
               
                <div style="height:auto; z-index: 999999999999; position: relative; padding-top: 200px; width: 95%; padding-left: 85px;">
				<div style="border-bottom: 2px solid; border-bottom-style:solid;">
				<h5 style="float:right;font-size: 12px; font-weight:bold;">Date: <?php echo date("Y-m-d");?></h5>
				<h3>Investor Category: <?php echo $cate_name; ?></h3>
				</div>
				
				<div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
					<!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
					<!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
					<h3>Total Balance For <?php echo $cate_name; ?> Investor</h3>
				</div>
				
			  <div>
			  <table class="table">
    <thead>
      <tr>
        <th>A/C No :</th>
        <th>Investor Name :</th>
        <th>Total Balance :</th>
      </tr>
    </thead>
	
    <tbody>
	<?php 
	$sums=0;
	for($i=0; $i<=count($PMDA_investor_bal); $i++){
		$balance=@$PMDA_investor_bal[$i]['total_balance'];
		$sums=$sums+$balance;
	?>
      <tr>
        <td><?php echo @$PMDA_investor_bal[$i]['dp_internal_ref_number'];?></td>
        <td><?php echo @$PMDA_investor_bal[$i]['investor_name'];?></td>
        <td><?php echo @$PMDA_investor_bal[$i]['total_balance'];?></td>
      </tr>
	  <?php } ?>
    </tbody>
	<tr>
	  <td>Total Amount</td>
	   <td></td>
	    <td><?php echo $sums;?></td>
	  </tr>
  </table>
  </div>
			  
			  <br>
			  <div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
					<!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
					<!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
					<h3>Total Balance For <?php echo $cate_name; ?> Bank</h3>
			  </div>
				
	<div>
	<table class="table">
    <thead>
      <tr>
        <th>Bank Name</th>
        <th>A/C No :</th>
        <th>Total Balance :</th>
      </tr>
    </thead>
	
    <tbody>
	<?php 
	$sum=0;
	for($i=0; $i<=count($PMDA_bank_bal); $i++){
		$bal=@$PMDA_bank_bal[$i]['balance'];
		$sum=$sum+$bal;
	?>
      <tr>
        <td><?php echo @$PMDA_bank_bal[$i]['bank_name'];?></td>
        <td><?php echo @$PMDA_bank_bal[$i]['account_number'];?></td>
        <td><?php echo @$PMDA_bank_bal[$i]['balance'];?></td>
      </tr>
	  <?php } ?>
    </tbody>
	<tr>
	  <td>Total Amount</td>
	   <td></td>
	    <td><?php echo $sum;?></td>
	  </tr>
  </table>
</div>

</div>
<div class="clearfix"></div>

                 		  
</div>
</div>

  
</div>