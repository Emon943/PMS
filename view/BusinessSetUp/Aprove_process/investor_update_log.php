
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="102" class="head0">Client Code </th>
                  <th width="126" class="head1">Investor Group</th>
                  <th width="142" class="head0">Investor Status</th>
                  <th width="54" class="head0">User ID</th>
                  <th width="128" class="head0">Date</th>
              </tr>
          </thead>
          <tbody>
                    
            
                   <?php
					
					 $sql="SELECT * FROM investor_group_log";
					
					$db_obj->sql($sql);
					 $investor=$db_obj->getResult();
					 
					if($investor){
						
						foreach($investor as $investor):
						
					?>  
              <tr class="gradeX">
                <td><?php echo $investor['client_code'];?></td>
                 <td><?php echo @mysql_result(mysql_query("SELECT `group_name` FROM `investor_group` WHERE `investor_group_id`='".$investor['investor_group_id']."'"),0);?></td>
				   <td><?php if($investor['client_status']==0){
					   echo "Active";
				   }else{
					   echo "Closed";
				   } ?></td>
   
                  <td><?php echo @mysql_result(mysql_query("SELECT `login_id` FROM `employee` WHERE `id`='".$investor['user_id']."'"),0);?></td>
                 <td><?php echo $investor['date'];?></td>
              </tr>
             <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
         