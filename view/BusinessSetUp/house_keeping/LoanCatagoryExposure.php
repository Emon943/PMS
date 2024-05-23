<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $loan_catagory_exposure=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("loan_catagory_exposure", "id='$loan_catagory_exposure'");
   	
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
        <a href="?LoanCatagoryExposureNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Loan Catagory Exposure </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="52" class="head0" title="Short Name">Code</th>
                  <th width="201" class="head1" title="ISIN">Name</th>
                  <th width="227" class="head0" title="Name">Exposure From</th>
                  <th width="140" class="head1" title="Industry">Exposure To</th>
                  <th width="134" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `loan_catagory_exposure` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $loan_catagory_exposure=$db_obj->getResult();
					 
					if($loan_catagory_exposure){
						
						foreach($loan_catagory_exposure as $loan_catagory_exposure):
						
					?>
              <tr class="gradeX">
                <td><?php echo $loan_catagory_exposure['code'];?></td>
                  <td><?php echo $loan_catagory_exposure['name'];?></td>
                  <td><?php echo $loan_catagory_exposure['exposure_from'];?></td>
                  <td class="center"><?php echo $loan_catagory_exposure['esposure_to'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($loan_catagory_exposure['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         