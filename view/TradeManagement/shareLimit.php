
<form class="stdform" action="sharelimit_generate.php" method="post">
  <div class="container-fluid">
  <div class="pull-left" style="padding-left:10px">

  <div class="form-group">
  <label for="email"><font color="red">* </font><strong>A/C Type:</strong></label>
	
    <select class="form-control" id="myselect" required />
	<option value="all">All</option> 
	<?php
	 $sql="SELECT * FROM `investor_personal`";
					
					 $db_obj->sql($sql);
					 $account_cate=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($account_cate as $ac){
	?>
	
    <option value="<?php echo $ac['bo_catagory'];?>"><?php echo $ac['bo_catagory']; ?></option>
	 <?php
	}
	?>
	
   </select>
  </div>
  
   <div class="form-group">
  <label for="email"><font color="red">* </font><strong>Panel Broker:</strong></label>
	
    <select class="form-control" id="myselect" required />
	<option value=""></option> 
	<?php
	 $sql="SELECT * FROM `tbl_broker_hous`";
					
					 $db_obj->sql($sql);
					 $broker_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($broker_name as $broker){
	?>
	
    <option value="<?php echo $broker['trace_id'];?>"><?php echo $broker['name']; ?></option>
	 <?php
	}
	?>
	
   </select>
  </div>
   <div class="form-group">
  <label for="email"><font color="red">* </font><strong>Stock Exchange:</strong></label>
	
    <select class="form-control" id="myselect" required /> 
	<option value="1">DSC</option> 
	<option value="2">CSE</option>
	
   </select>
  </div>
   <div class="form-group">
   <label for="AC"><strong>Account Number:</strong></label>
	<input type="text" class="form-control" name="ac_code"/>
  </div>
  
</div>

</form>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="left">
      <span class="btn" style="background-color:  #d4e6f1  ;">Tread Limit</span>
                     
      </div>
      <?php endif;?>
                     
  <form class="stdform" action="sharelimit_generate.php" method="post">              
  <div style="padding-left:10px;" class="table-responsive"> 
  <hr>
  
  <table width="100%" class="table table-bordered">
                   
          <thead>
              <tr>
               	      <th width="141" class="head0">Is SELECT</th>
					  <th width="103" class="head0">A/C Number</th>
					  <th width="103" class="head0">BO Number</th>
                      <th width="154" class="head0">Name</th>
					  <th width="103" class="head0">ISIN</th>
					  <th width="103" class="head0">Short Name</th>
					  <th width="103" class="head0">Net Balance</th>
                      <th width="123" class="head0">Free Balance</th>
					  
              </tr>
          </thead>
          <tbody>
                    
            
               <?php
			   $sql="SELECT * FROM tbl_ipo INNER JOIN investor ON tbl_ipo.account_no = investor.dp_internal_ref_number";
	
					 $db_obj->sql($sql);
					 $share_tread=$db_obj->getResult(); 
				    // print_r($share_tread);
			           //die();
			   if(@$share_tread){
				  foreach($share_tread as $share_info):
				  $total=$share_info['qty']+$share_info['Current_Bal'];
				   //print_r($t_info);
				 if($total > 0){
			   ?>
			   
              <tr class="gradeX">
			   <td><input type="checkbox" name="check[ ]"  multiple="multiple" value="<?php echo $share_info['id'];?>" checked></td>
                <td><?php echo $share_info['account_no'];?></td>
                <td><?php echo $share_info['BO_ID'];?></td>
				<td><?php echo $share_info['investor_name'];?></td>
				<td><?php echo $share_info['ISIN'];?></td>
                <td><?php echo $share_info['instrument'];?></td>
				<td><?php echo $share_info['Current_Bal'];?></td>
				<td><?php echo $share_info['qty']+$share_info['Current_Bal'];?></td>
				
                 
              </tr>
             <?php
			 }
			 endforeach;
			   }  ?>
                        
          </tbody>
      </table>
	  
	  </div>
	  <div><button type="submit"  style="background-color:  #d4e6f1  ;class="btn btn-default">MSA Plus</button></div>
      </form>                 
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
 
	 
	 
 </div>
 </div>
         