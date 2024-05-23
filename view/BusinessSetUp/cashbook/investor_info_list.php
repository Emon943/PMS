<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $fee_id=$enc->decryptIt($_GET['dell']);
  
    $db_obj->delete("tbl_charge_info", "id='$fee_id'");
   	
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
        <a href="?fee" class="btn btn-primary"><span class="icon-plus-sign"></span>Investor Fee</a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="114" class="head0" title="Short Name">A/C No</th>
                  <th width="181" class="head1" title="ISIN">Name</th>
                  <th width="394" class="head0" title="Name">A/C Opening Date</th>
                  <th width="201" class="head1" title="Market Price">Branch Name</th>
				  <th width="225" class="head1" title="Industry">Type</th>
				  <th width="225" class="head1" title="Industry">A/C Balance</th>
				  <th width="225" class="head1" title="Industry">Amount</th>
                  <th width="157" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
			$db_obj->sql("SELECT * FROM tbl_charge_info INNER JOIN investor ON investor.dp_internal_ref_number = tbl_charge_info.ac_no");
            $result=$db_obj->getResult();
			 //print_r($res);
			 //die();
					 
					if($result){
						
						foreach($result as $res):
						 //print_r($res);
						// die();
					?>
              <tr class="gradeX">
                <td><?php echo $res['ac_no'];?></td>
                  <td><?php echo $res['investor_name'];?></td>
                  <td><?php echo $res['creatd_date'];?></td>
                  <td class="center"><?php echo $res['branch_id'];?></td>
				   <td class="center"><?php echo $res['account_status'];?></td>
                  <td class="center"><?php echo $res['total_balance'];?></td>
				  <td class="center"><?php echo $res['total_amt'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($res['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         