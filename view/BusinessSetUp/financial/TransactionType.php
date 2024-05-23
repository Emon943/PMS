<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $transaction_type=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("transaction_type", "id='$transaction_type'");
   	
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
        <a href="?TransactionTypeNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Transaction Fee </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="114" class="head0" title="Short Name">Code</th>
                  <th width="181" class="head1" title="ISIN">Name</th>
                  <th width="394" class="head0" title="Name">Description</th>
				  <th width="394" class="head0" title="Name">Charge Amount</th>
                  <th width="157" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `transaction_type` WHERE status='Active' ORDER BY id DESC";
					 $db_obj->sql($sql);
					 $transaction_type=$db_obj->getResult();
					 
					if($transaction_type){
						
						foreach($transaction_type as $transaction_type):
						
					?>
              <tr class="gradeX">
                <td><?php echo $transaction_type['code'];?></td>
                  <td><?php echo $transaction_type['name'];?></td>
                  <td><?php echo $transaction_type['description'];?></td>
				   <td><?php echo $transaction_type['charges_amt'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($transaction_type['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         