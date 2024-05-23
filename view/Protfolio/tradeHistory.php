

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="left">
      <span class="btn" style="background-color:white;">Tread List</span>
                     
      </div>
      <?php endif;?>
                     
                     
  <div style="padding-left:10px;" class="table-responsive"/> 
  <hr>
  <table width="100%" class="table table-bordered">
                   
          <thead>
              <tr>
               	    <th width="141" class="head0">Panel broker</th>
                    <th width="154" class="head1">A/C Code</th>
                     <th width="123" class="head0">Instrument</th>
                     <th width="103" class="head0">Market</th>
				     <th width="103" class="head0">Category</th>
				      <th width="103" class="head0">Trans Type</th>
				      <th width="103" class="head0">Trans Time</th>
					   <th width="103" class="head0">Share Quantity</th>
					   <th width="103" class="head0">Rate</th>
					   <th width="103" class="head0">Total Amount</th>
					   <th width="103" class="head0">Broker Commision</th>
					    <th width="103" class="head0">Agency Commision</th>
					   <th width="103" class="head0">Commision</th>
						<th width="103" class="head0">Net Amt</th>
						<th width="103" class="head0">Trader</th>
						<th width="103" class="head0">Status</th>
              </tr>
          </thead>
          <tbody>
                    
            
               <?php
              $date=date("d-m-Y");
			   //$db_obj->select('tread_data_list','*',"date_tread='$date'");
			   $sql="SELECT * FROM tread_data_list WHERE date_tread='$date'";
			   $db_obj->sql($sql);
			   $tread_data_info=$db_obj->getResult();
			   $total_no=count($tread_data_info);
			   echo "Total Number: ".$total_no;
				//die();
			   
				   foreach(@$tread_data_info as $t_info){
				  //print_r($t_info);  
			   ?>     
              <tr class="gradeX">
                <td><?php echo @$t_info['bokersoftcode'];?></td>
                <td><?php echo $t_info['account_no'];?></td>
				<td><?php echo $t_info['instrument'];?></td>
                <td><?php echo $t_info['market'];?></td>
				<td><?php echo $t_info['category'];?></td>
				<td><?php echo $t_info['type'];?></td>
				<td><?php echo $t_info['time_tread'];?></td>
				<td><?php echo $t_info['quantity'];?></td>
				<td><?php echo $t_info['rate'];?></td>
				<td><?php echo $t_info['total_amount'];?></td>
				<td><?php echo $t_info['broker_commission'];?></td>
				<td><?php echo $t_info['agency_comm'];?></td>
				<td><?php echo $t_info['commission'];?></td>
				<td><?php echo $t_info['net_amount'];?></td>
				<td><?php echo $t_info['trader'];?></td>
				<td><?php if($t_info['status']==0){
			      echo "Processed";
		          }else{
			       echo "Posted";
		        } ?></td>
                 
              </tr>
             <?php
			  }
			  ?>
                        
          </tbody>
      </table>
	  
	  </div>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
  <div style="float:right">
   <?php
      if(@$t_info['status']==1){
	?> 
	<button type="button" disabled>Trade Process</button>
	   
	 <?php } ?>
	 
	  <?php
      if(@$t_info['status']==0){
	 ?> 
	 <a href="Protfolio.php?trade_process&&id=<?php echo base64_encode($date);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>Process Trade</a>
    <?php } ?>
 </div>
  </div>
         