<?php
if(isset($_POST["submit_ins"])){
$ac_no=@$_POST["ac_no"];
$fromdate=@$_POST["fromdate"];
$todate=@$_POST["todate"];
$all=@$_POST["all"];
$Panding=@$_POST["Panding"];
$Posted=@$_POST["Posted"];

if($all){
   $sql="SELECT * FROM `tbl_interest_quaterly` where code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res= $dbObj->select($sql);
  // print_r($res);
   $sql1="SELECT SUM(total_interest_amt)as total FROM `tbl_interest_quaterly` where code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $result= $dbObj->select($sql1);
   //print_r($result);
  
}
//die();
 elseif($Panding==0){
   $sql="SELECT * FROM `tbl_interest_quaterly` where status=$Panding AND code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res= $dbObj->select($sql);
  // print_r($res);
   $sql1="SELECT SUM(total_interest_amt)as total FROM `tbl_interest_quaterly` where status=$Panding AND code='mi' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $result= $dbObj->select($sql1);
   //print_r($result);
 }
elseif($Posted==1){
   $sql="SELECT * FROM `tbl_interest_quaterly` where code='mi' AND status=$Posted AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res= $dbObj->select($sql);
    $sql1="SELECT SUM(total_interest_amt)as total FROM `tbl_interest_quaterly` where code='mi' AND status=$Posted AND `date` BETWEEN '$fromdate' AND '$todate'";
   $result= $dbObj->select($sql1);
}
else{
   $sql="SELECT * FROM `tbl_interest_quaterly` where code='mi' AND ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $res= $dbObj->select($sql);
   $sql1="SELECT SUM(total_interest_amt)as total FROM `tbl_interest_quaterly` where code='mi' AND ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   $result= $dbObj->select($sql1);
}

}


 if(isset($_POST["submit"])){
$ac_no=@$_POST["ac_no"];
$desc=@$_POST["Description"];
$ab=@$_POST["ab"];
$ibb_date=@$_POST["date"];
$sql="INSERT INTO tbl_interest(ac_no,code,type,interest_rate,amount,description,daily_interest,date)
VALUES ('$ac_no','mi','Payment','0.00','0.00','$desc','$ab','$ibb_date')";
$ress= $dbObj->insert($sql);
	echo "<h2 align='center' style='color:#000000'>Bank Interest Adjustment Successfully</h2>";
    echo "<meta http-equiv='refresh' content='1 URL=fund_management.php?InterestReceivable'>";
    exit;
}
?>
<br/>
<div class="container">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
  <div style="float:left; padding-left:20px">
    A/C Number:<input type="text" id="ac_no" name="ac_no">&nbsp;&nbsp;&nbsp;
 </div>
   <div style="float:left">
   From: <input type="date" id="fromdate" name="fromdate" required>&nbsp;&nbsp;&nbsp;
	</div>
	 <div style="float:left">
   To: <input type="date" id="todate" name="todate" required>&nbsp;&nbsp;&nbsp;
	</div>
	<br/>
	<br/>
	<br/>
	<div style="float:left; padding-left:20px">
	Status:&nbsp;&nbsp;
	 <input type="radio" name="all" value="2"> Show All&nbsp;&nbsp;&nbsp;
	 <input type="radio" name="Panding" value="0"> Panding&nbsp;&nbsp;&nbsp;
	 <input type="radio" name="Posted" value="1"> Posted&nbsp;&nbsp;&nbsp;
	  </div>
	 <div style="float:left">
	 &nbsp;&nbsp;&nbsp;  Receipt Type:
    <select name="report_id" id="report_id" requried=""/>
	<option value="">Show All</option>
	<option value="">Online Transfer</option> 
	<option value="">Cash</option>
	<option value="">Cheque</option>
	<option value="">Deposit Slip</option>
	</select>
	</div>
	<div style="float:left">
	 &nbsp;&nbsp;&nbsp; Reconciled: <input type="checkbox" name="vehicle" value="Bike">
	</div>
    <br/>
	<br/>
	<br/>
   <input type="submit" name="submit_ins" value="View">
    
  </form>
<br/>
<div align="left"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Margin Interest Adjustment</button></div>
<form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
 <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Margin Interest Adjustment</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
       <div class="form-group">
       <label for="ClientCode">A/C Number</label>
       <input type="text" class="form-control" id="ac_no" name="ac_no" placeholder="a/c no">
	   <label for="Description">Description</label>
       <input type="text" class="form-control" id="Description" name="Description" placeholder="Description">
	   <label for=">Adjustment Balance">Adjustment Balance</label>
       <input type="text" class="form-control" id="Adjustment Balance" name="ab" placeholder="Adjustment Balance">
	   <label for=">Adjustment Balance">Date</label>
       <input type="date" class="form-control" id="date" name="date">
  </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		     <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
        </div>
        
      </div>
    </div>
  </div>
  </form>
  
<div class="table-responsive"> 
<hr>
<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
             <tr>
            <th width="150" class="head0" title="Short Name">A/C Reference</th>
			<th width="150" class="head0" title="Short Name">Transaction Date</th>
			
			<th width="50" class="head0" title="Short Name">Total Amount</th>
			<th width="50" class="head0" title="Short Name">Total Vat</th>
			<th width="50" class="head0" title="Short Name">Net Amt.</th>
			<th width="50" class="head0" title="Short Name">Receipt Type</th>
			<th width="50" class="head0" title="Short Name">Bank Name</th>
            <th width="50" class="head0" title="ISIN">Status</th>
            <th width="50" class="head0" title="Name">Description</th>
             <th width="50" class="head1" title="Industry">Log</th>
            </tr>
          </thead>
		  <tbody>
		  <?php
      
          	$vat=0.00;		
           if(@$res){
					
		   foreach($res as $r){			
					?>
		  <tr>
		  <td><?php echo $r['ac_no'];?></td>
		  <td><?php echo $r['date'];?></td>
		  
		  <td><?php echo $r['total_interest_amt'];?></td>
		  <td><?php echo $vat;?></td>
		  <td><?php echo $r['total_interest_amt']+$vat;?></td>
		  <td><?php echo " ";?></td>
		  <td><?php echo " ";?></td>
		 
		  <td><?php if($r['status']==0){
			  echo "Panding";
		  }else{
			  echo "Posted";
		  } ?></td>
		  
		  <td><?php echo $r['description'];?></td>
		  <td><?php echo "User::".$_SESSION['LOGIN_USER']['login_id'];?></td>
		  
		   <td>
                            
          </td>
		  
		  
		  </tr>
		   
		   <?php
		   }

		   } ?>
		   
        </tbody>
   </table> 
   </div>
   <br/>

   <a href="?interest_payment" class="btn btn-primary"><span class="icon-plus-sign"></span>Generate</a>
  
   <div style="padding-left:200px">
		   <?php echo "Tatal Amount: ".@$result[0]['total'];?>&nbsp;&nbsp;&nbsp;
		   <?php echo "Vat Amount: ".@$vat;?>&nbsp;&nbsp;&nbsp;
		   <?php echo "Net Amount: ".@$result[0]['total']?>&nbsp;&nbsp;&nbsp;
		   
		   </div>
		  
		   
		   </div>
  
   