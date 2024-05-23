

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
               	      <th width="141" class="head0">Execution Date</th>
					  <th width="103" class="head0">Broker DSC ID</th>
					  <th width="103" class="head0">Broker CSE ID</th>
                      <th width="154" class="head0">A/C Number</th>
					  <th width="103" class="head0">BOID</th>
					  <th width="103" class="head0">DSC Clearing BO</th>
					  <th width="103" class="head0">CSE Clearing BO</th>
                      <th width="123" class="head0">Instrument</th>
					  <th width="123" class="head0">ISIN</th>
					  <th width="123" class="head0">Share Quantity</th>
              </tr>
          </thead>
          <tbody>
                    
            
               <?php
               $date=date("Y-m-d");
			   $sql="SELECT * FROM sale_share where trade_date='$date'";
					 $db_obj->sql($sql);
					 $sale_tread=$db_obj->getResult(); 
					// print_r($sale_tread);
			  // die();
			   if(@$sale_tread){
				   foreach($sale_tread as $t_info):
				   //print_r($t_info);
				  
			   ?>     
              <tr class="gradeX">
                <td><?php echo $t_info['trade_date'];?></td>
                <td><?php echo $t_info['broker_id'];?></td>
				<td><?php echo "0";?></td>
				<td><?php echo $t_info['account_no'];?></td>
                <td><?php echo $t_info['bo_id'];?></td>
				<td><?php echo $t_info['stock_id'];?></td>
				<td><?php echo "0";?></td>
				<td><?php echo $t_info['instrument'];?></td>
				<td><?php echo $t_info['isin'];?></td>
				<td><?php echo $t_info['qty'];?></td>
                 
              </tr>
             <?php
			 endforeach;
			  } ?>
                        
          </tbody>
      </table>
	  
	  </div>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
 <div style="float:right">
	 
	  <?php
      if(@$t_info['trade_date']==$date){
	  ?> 
	 <a href="payin_generate.php?date=<?php echo base64_encode($date);?>" class="btn" title="Update Data"><span class="icon-hand-right"></span>Generate</a>
    <?php } ?>
 </div>
 </div>
         