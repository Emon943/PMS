<?php
if(isset($_POST["submit_ins"])){
$ac_no=@$_POST["ac_no"];
$ac_no=strtoupper($ac_no);
$fromdate=@$_POST["fromdate"];
$todate=@$_POST["todate"];

if($ac_no){
   //$sql="SELECT * FROM `tbl_interest` where code='mf' AND ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate'";
   //$res= $dbObj->select($sql);
  $sql="SELECT ac_no,date,code,amount,interest_rate,type,SUM(daily_interest)as total_interest_amt,acmf_rate,SUM(acmf_interest_amt)as total_acmf_amt,description,status FROM `tbl_interest_on_credit_bal` where code='iocb' AND status='0' AND `date` BETWEEN '$fromdate' AND '$todate' AND ac_no='$ac_no'";
  $res= $dbObj->select($sql);
 
}
else{
  
  $sql="SELECT ac_no,date,code,amount,interest_rate,type,SUM(daily_interest)as total_interest_amt,acmf_rate,SUM(acmf_interest_amt)as total_acmf_amt,description,status FROM `tbl_interest_on_credit_bal` where code='iocb' AND status='0' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY ac_no";
  $res= $dbObj->select($sql);
  
}

}
 
?>
<br/>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to post Excess Cash Management Fee?');
    }
</script>
<div>
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   <div style="float:left">
   From: <input type="date" id="fromdate" name="fromdate" required>&nbsp;&nbsp;&nbsp;
	</div>
	 <div style="float:left">
   To: <input type="date" id="todate" name="todate" required>&nbsp;&nbsp;&nbsp;
	</div>
  <div style="float:left">
    A/C Number:<input type="text" id="ac_no" name="ac_no">&nbsp;&nbsp;&nbsp;
 </div>
	
<div style="float:left">
   <input type="submit" name="submit_ins" value="Apply">
  </div>  
  </form>
  </div><br><br>
  <hr>
  
 
<!--<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>-->   

<div class="row-fluid">           
                
   	<div>
	<form action="?ExcessCash_Accrued" method="post">  
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
     
      <?php endif;?>
                                   
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
			 <th width="14" class="head0" title="Short Name">Select</th>
             <th width="114" class="head0" title="Short Name">A/C No</th>
			 <!--<th width="114" class="head0" title="Short Name">Name</th>-->
             <th width="181" class="head1" title="ISIN">Ledger Balance</th>
             <th width="114" class="head0" title="Name">Interest Rate(%)</th>
             <th width="114" class="head1" title="Voucher Ref">Interest Amount</th>
			 <th width="114" class="head1" title="Voucher Ref">Acc Mgt. Rate(%</th>
			 <th width="114" class="head1" title="Voucher Ref">Acc Mgt. Amount</th>
			 
			  
               
              </tr>
          </thead>
          <tbody>
                    
            <?php
	
			if(@$res){
						
				foreach($res as $r):
						
					?>
               <tr class="gradeX">
			    <td><input type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $r['ac_no'];?>" checked>
		        <input type="hidden" name="fromdate" value="<?php echo $fromdate;?>">
		        <input type="hidden" name="todate" value="<?php echo $todate;?>">
		      </td>
                   <td><?php echo $r['ac_no'];?></td>
                   <td><?php echo $r['amount'];?></td>
                   <td><?php echo $r['interest_rate'];?></td>
				    <td><?php echo $r['total_interest_amt'];?></td>
					 <td><?php echo $r['acmf_rate'];?></td>
					  <td><?php echo $r['total_acmf_amt'];?></td>
				    
              </tr>
              <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
	 <div> &nbsp;&nbsp;Payment Date:<input type="date" name="payment_date" value="<?php echo date("Y-m-d");?>"></div>&nbsp;&nbsp;
	 <div> &nbsp;&nbsp;Description:<input type="text" name="des" value="<?php echo "Excess Cash Management Fee";?>"></div><br/>&nbsp;&nbsp
	
   <div><button type="submit" name="submit" class="btn btn-default" onclick="return confirmation()">Post</button></div>
</form>	             
                
    <!--span8-->  
            
  
  </div><!--row-fluid-->
  

  
