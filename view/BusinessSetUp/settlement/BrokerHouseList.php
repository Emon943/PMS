<?php
if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $broker=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_broker_hous", "id='$broker'");
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>
<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to delete this?');
    }
</script>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>   
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?BrokerHouse" class="btn btn-primary"><span class="icon-plus-sign"></span>New Broker House</a>

                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
            <th width="114" class="head0" title="Short Name">Internal Code</th>
             <th width="181" class="head1" title="ISIN">TREC ID</th>
              <th width="394" class="head0" title="Name">TREC Code</th>
			  <th width="394" class="head0" title="Name">Decripetion</th>
			  <th width="394" class="head0" title="Name">Settlement Fee</th>
			  <th width="394" class="head0" title="Name">Status</th>
               <th width="167" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `tbl_broker_hous` ORDER BY id DESC";
					
					 $db_obj->sql($sql);
					 $brokers_house=$db_obj->getResult();
					 
					if($brokers_house){
						
						foreach($brokers_house as $broker_house):
						
					?>
                <tr class="gradeX">
                  <td><?php echo $broker_house['Internal_code'];?></td>
                  <td><?php echo $broker_house['trace_id'];?></td>
				  <td class="center"><?php echo $broker_house['trace_code'];?></td>
				  <td class="center"><?php echo $broker_house['name'];?></td>
				  <td class="center"><?php echo $broker_house['settlement_fee'];?></td>
				  <td><?php if($broker_house['status']==1){
			       echo "Open";
		       }else{
			      echo "Close";
		         } ?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                   <a href="settlement.php?brokerEdit&getID=<?php echo urlencode($enc->encryptIt($broker_house['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($broker_house['id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
                    <?php endif;?>
                            
                </td>
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
         