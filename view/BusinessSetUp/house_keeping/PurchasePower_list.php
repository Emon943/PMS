<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $margin_fee_catagory=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_purchase_power", "id='$margin_fee_catagory'");
   	
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
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?PurchasePower" class="btn btn-primary"><span class="icon-plus-sign"></span> New Purchase Power</a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="113" class="head0" title="Sell Limit">Sell Limit</th>
                  <th width="180" class="head1" title="Purchase Limit">Purchase Limit</th>
                  <th width="328" class="head0" title="Netting">Netting</th>
                  <th width="167" class="head1" title="Min debt Equity Ratio">Min debt Equity Ratio</th>
                  <th width="128" class="head1" title="Update">Update</th>
                  <th width="115" class="head1" title="User ID">User ID</th>
                  <th width="159" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `tbl_purchase_power` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $purchaser_power=$db_obj->getResult();
					 
					if($purchaser_power){
						
						foreach($purchaser_power as $purchase_power):
						
					?>
              <tr class="gradeX">
                  <td><?php echo $purchase_power['sell_limit'];?></td>
                  <td><?php echo $purchase_power['purchase_limit'];?></td>
                  <td><?php echo $purchase_power['netting'];?></td>
                  <td class="center"><?php echo $purchase_power['min_ratio'];?></td>
                  <td class="center"><?php echo $purchase_power['update_date'];?></td>
                  <td class="center"><?php echo $purchase_power['insert_id'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                   <a href="house_keeping.php?PurchasePower_Update&getID=<?php echo urlencode($enc->encryptIt($purchase_power['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($purchase_power['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         