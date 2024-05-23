<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $investor_group_id=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("investor_group", "investor_group_id='$investor_group_id'");
   	
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
        <a href="?InvestorGroup_New" class="btn btn-primary"><span class="icon-plus-sign"></span>Investor Group New </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="113" class="head0" title="Short Name">Code</th>
				  <th width="180" class="head1" title="ISIN">Name</th>
				  <th width="180" class="head1" title="ISIN">Charge Rate %</th>
                  <th width="180" class="head1" title="ISIN">Description</th>
                  <th width="167" class="head1" title="Industry">margin Ratio</th>
                  <th width="159" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `investor_group` ORDER BY investor_group_id DESC";
					
					$db_obj->sql($sql);
					 $investor_group=$db_obj->getResult();
					 
					if($investor_group){
						
						foreach($investor_group as $inv_group):
						
					?>
              <tr class="gradeX">
                <td><?php echo $inv_group['code'];?></td>
                <td><?php echo $inv_group['group_name'];?></td>
				   <td><?php echo $inv_group['amount'];?></td>
				<td><?php echo $inv_group['description'];?></td> 
				 <td><?php echo @mysql_result(mysql_query("SELECT `margin_ratio` FROM `loan_catagory_margin` WHERE `id`='".$inv_group['loan_cat']."'"),0);?></td>
                  <!--<td class="center"><?php //echo $margin_fee_catagory['interest_rate'];?></td>
                  <td class="center"><?php //echo $margin_fee_catagory['is_default'];?></td>
                  <td class="center"><?php //echo $margin_fee_catagory['status'];?></td>-->
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($inv_group['investor_group_id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         