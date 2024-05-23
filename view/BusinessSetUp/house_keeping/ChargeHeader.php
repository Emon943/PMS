<?php

if(isset($_GET['dell'])){
    $Chargeheader=$enc->decryptIt($_GET['dell']);
    if($Chargeheader!=1) {
        $db_obj->delete("charge_header", "id='$Chargeheader'");
    }
   if(isset($_SERVER['HTTP_REFERER'])){
	   
	    echo("<script>location.href = '".$_SERVER['HTTP_REFERER']."';</script>");
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
	  exit(0);
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit(0);

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
        <a href="?ChargeHeaderNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Charge Header</a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="40" class="head0">Code</th>
                  <th width="71" class="head1">Name</th>
                  <th width="108" class="head0">Charge Type</th>
                  <th width="113" class="head1">Amount in Percentage</th>
                  <th width="43" class="head1">Status</th>
                  <th width="78" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM charge_header";
					
					$db_obj->sql($sql);
					 $charge_header=$db_obj->getResult();
					 
					if($charge_header){
						
						foreach($charge_header as $charge_header):
						
					?>
                    
              <tr class="gradeX">
                <td><?php echo $charge_header['code'];?></td>
                  <td><?php echo $charge_header['name'];?></td>
                  <td><?php echo $charge_header['charge_type'];?></td>
                  <td class="center"><?=$charge_header['is_percentage'];?></td>
                  <td class="center">
                    <?=$charge_header['is_active'];?>
                   </td>
                  <td class="center"><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="house_keeping.php?ChargeHeaderUpdate&getID=<?php echo urlencode($enc->encryptIt($charge_header['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($charge_header['id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         