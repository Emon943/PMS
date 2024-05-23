<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $bank_ac=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("bank_ac", "id='$bank_ac'");
   	
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
        <a href="?BankAccountNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Bank Account </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="114" class="head0" title="Short Name">Account Type</th>
                  <th width="181" class="head1" title="ISIN">Account Number</th>
                  <th width="394" class="head0" title="Name">Bank Account Name</th>
                  <th width="225" class="head1" title="Industry">Bank Name</th>
                  <th width="201" class="head1" title="Market Price">Branch</th>
                  <th width="157" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `bank_ac` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $bank_ac=$db_obj->getResult();
					 
					if($bank_ac){
						
						foreach($bank_ac as $bank_ac):
						
					?>
              <tr class="gradeX">
                <td><?php echo $bank_ac['account_type'];?></td>
                  <td><?php echo $bank_ac['account_number'];?></td>
                  <td><?php echo $bank_ac['bank_account_name'];?></td>
                  <td class="center"><?php echo $bank_ac['bank_name'];?></td>
                  <td class="center"><?php echo $bank_ac['branch_name'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($bank_ac['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         