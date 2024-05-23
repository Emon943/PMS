<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $interst_on_credit_blance_catagory=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("interst_on_credit_blance_catagory", "id='$interst_on_credit_blance_catagory'");
   	
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
        <a href="?iocbNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Interest On Credit balance Catagory </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="113" class="head0" title="Short Name">Code</th>
                  <th width="348" class="head1" title="ISIN">Description</th>
                  <th width="160" class="head0" title="Name">Charge Interest</th>
                  <th width="167" class="head1" title="Industry">Interest Preiod</th>
                  <th width="128" class="head1" title="Market Price">Interest Rate</th>
                  <th width="115" class="head1" title="Market Price">is Default</th>
                  <th width="74" class="head1" title="Market Price">Is Active</th>
                  <th width="159" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `interst_on_credit_blance_catagory` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $interst_on_credit_blance_catagory=$db_obj->getResult();
					 
					if($interst_on_credit_blance_catagory){
						
						foreach($interst_on_credit_blance_catagory as $interst_on_credit_blance_catagory):
						
					?>
              <tr class="gradeX">
                <td><?php echo $interst_on_credit_blance_catagory['code'];?></td>
                  <td><?php echo $interst_on_credit_blance_catagory['description'];?></td>
                  <td><?php echo $interst_on_credit_blance_catagory['chage_interst'];?></td>
                  <td class="center"><?php echo $interst_on_credit_blance_catagory['interest_period'];?></td>
                  <td class="center"><?php echo $interst_on_credit_blance_catagory['interest_rate'];?></td>
                  <td class="center"><?php echo $interst_on_credit_blance_catagory['is_default'];?></td>
                  <td class="center"><?php echo $interst_on_credit_blance_catagory['status'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($interst_on_credit_blance_catagory['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         