<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $margin_fee_catagory=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("margin_fee_catagory", "id='$margin_fee_catagory'");
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to delete this?');
    }
</script>   
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?ManagementFeeNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Management Fee </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="113" class="head0" title="Short Name">Code</th>
                  <th width="180" class="head1" title="ISIN">Description</th>
                  <th width="328" class="head0" title="Name">Charge Interest</th>
                  <th width="167" class="head1" title="Industry">Interest Preiod</th>
                  <th width="128" class="head1" title="Market Price">Interest Rate</th>
                  <th width="115" class="head1" title="Market Price">is Default</th>
                  <th width="74" class="head1" title="Market Price">Is Active</th>
                  <th width="159" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `margin_fee_catagory` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $margin_fee_catagory=$db_obj->getResult();
					 
					if($margin_fee_catagory){
						
						foreach($margin_fee_catagory as $margin_fee_catagory):
						
					?>
              <tr class="gradeX">
                <td><?php echo $margin_fee_catagory['code'];?></td>
                  <td><?php echo $margin_fee_catagory['description'];?></td>
                  <td><?php echo $margin_fee_catagory['charge_interest'];?></td>
                  <td class="center"><?php echo $margin_fee_catagory['interest_preiod'];?></td>
                  <td class="center"><?php echo $margin_fee_catagory['interest_rate'];?></td>
                  <td class="center"><?php echo $margin_fee_catagory['is_default'];?></td>
                  <td class="center"><?php echo $margin_fee_catagory['status'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($margin_fee_catagory['id']));?>" class="btn" onclick="return confirmation()" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         