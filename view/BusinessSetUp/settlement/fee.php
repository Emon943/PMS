<?php
if(isset($_POST["submit_ins"])){
$ac_no=@$_POST["ac_no"];
$ac_no=strtoupper($ac_no);
$fromdate=@$_POST["fromdate"];
$todate=@$_POST["todate"];
$type=@$_POST["type"];

if($type=='iocb'){
   $sql="SELECT * FROM `tbl_interest_on_credit_bal` where code='$type' AND ac_no='$ac_no' AND status=0 AND `date` BETWEEN '$fromdate' AND '$todate' ORDER BY id";
   $res= $dbObj->select($sql);
  //$sql="SELECT ac_no,date,code,SUM(amount) as amount,interest_rate,type,SUM(daily_interest)as total_interest_amt,description,status FROM `tbl_interest` where code='mf' AND status='0' AND `date` BETWEEN '$fromdate' AND '$todate' AND ac_no='$ac_no'";
  //$res= $dbObj->select($sql);
}
else{
   $sql="SELECT * FROM `tbl_interest` where code='$type' AND ac_no='$ac_no' AND `date` BETWEEN '$fromdate' AND '$todate' ORDER BY id";
   $res= $dbObj->select($sql);
 //$sql="SELECT * FROM `tbl_interest` where code='$type' AND status='0' AND `date` BETWEEN '$fromdate' AND '$todate' GROUP BY ac_no";
  //$res= $dbObj->select($sql);
}

}
 
?>
<br/>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to Delete?');
    }
</script>
<div class="">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   <div style="float:left">
   From: <input type="date" id="fromdate" name="fromdate" required>&nbsp;&nbsp;&nbsp;
	</div>
	 <div style="float:left">
   To: <input type="date" id="todate" name="todate" required>&nbsp;&nbsp;&nbsp;
	</div><br>
	<div style="float:left">
  <td width="145" height="33"><strong>Charge Type: </strong> </td>
    <td width="283"><select name="type" id="type" required="required">
      <!--<option value="mf">Management Fee</option>-->
      <!--<option value="mi">Bank Interest Fee</option>-->
	  <option value="iocb">CMF Fee</option>
    </select></td>
 </div>
  <div style="float:left">
    A/C Number:<input type="text" id="ac_no" name="ac_no">&nbsp;&nbsp;&nbsp;
 </div>
	
<div style="float:left">
   <input type="submit" name="submit_ins" value="Apply">
  </div>  
  </form>
  </div><br><br><br><br>
  
 
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>   

<div class="row-fluid">           
                
  
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
     
      <?php endif;?>
	  <form class="stdform" action="?delete_entry" method="post">
                                   
       	<table width="100%" class="table table-bordered">
                   
          <thead>
              <tr>
			 <th>Is Select</th>
			 <th width="14" class="head0" title="Short Name">ID</th>
             <th width="114" class="head0" title="Short Name">A/C No</th>
			 <th width="114" class="head0" title="Short Name">Code</th>
             <th width="181" class="head1" title="ISIN">Nav Value</th>
             <th width="394" class="head0" title="Name">Rate(%)</th>
             <th width="225" class="head1" title="Voucher Ref">Charge Amount</th>
			  <th width="225" class="head1" title="Voucher Ref">Action</th>
               
              </tr>
          </thead>
          <tbody>
                    
            <?php
	
			if(@$res){
						
				foreach($res as $r):
						
					?>
               <tr class="gradeX">
			    <td><input checked='true' type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $r['id'].";".$r['code'];?>"></td>
			       <td><?php echo $r['id'];?></td>
                   <td><?php echo $r['ac_no'];?></td>
                   <td><?php echo $r['code'];?></td>
                   <td><?php echo $r['date'];?></td>
                   <td><?php echo $r['interest_rate'];?></td>
				   <td><?php echo $r['daily_interest'];?></td>
				   <td><?php
                    if($page['edit_status']=="Active"):
					?>
                   <a href="settlement.php?fee_Edit&getID=<?php echo urlencode($enc->encryptIt($r['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                   <!-- <a href="<?php //echo $_SERVER['REQUEST_URI']?>&dell=<?php //echo urlencode($enc->encryptIt($broker_house['id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>-->
                            
                    <?php endif;?>
                            
                </td>
				    
				 </tr>
				 
              <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table><br>
                           
                
    <!--span8-->  
            
  <div style="padding-left:10px">
 <button style="padding-left:10px" type="submit" name="submit_ins" class="btn btn-default" onclick="return confirmation()">Submit</button>
 </div>
</form>
  </div><!--row-fluid-->
  
