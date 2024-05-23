<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
   $ac_number=$enc->decryptIt($_GET['dell']);
   $sql="UPDATE `tbl_margin_loan` SET `status`='0' WHERE `ac_no`='$ac_number'";
   $result=@mysql_query($sql);
   
    $sql1="UPDATE `investor` SET `investor_group_id`='1' WHERE `dp_internal_ref_number`='$ac_number'";
    $result1=@mysql_query($sql1);
   	
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
      return confirm('Are you sure you want to Cancel this?');
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
        <a href="?MarginAccounts" class="btn btn-primary"><span class="icon-plus-sign"></span> New Margin Accounts </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="71" class="head0" title="A/C No">A/C No</th>
                  <th width="38" class="head1" title="Name">Name</th>
                  <th width="56" class="head1" title="A/C Opening Date">A/C Opening Date</th>
                  <th width="54" class="head1" title="Margin Activation Date">Margin Activation Date</th>
                  <th width="47" class="head1" title="Type">Type</th>
                  <th width="37" class="head1" title="A/C Balance">A/C Balance</th>
                  <th width="204" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
    $db_obj->sql("SELECT investor.dp_internal_ref_number,investor.investor_group_id,investor.total_balance,investor.creatd_date,tbl_margin_loan.name,tbl_margin_loan.date FROM investor INNER JOIN  tbl_margin_loan ON tbl_margin_loan.ac_no = investor.dp_internal_ref_number where tbl_margin_loan.status=1");
    $result=$db_obj->getResult();
	//print_r($result);
	//die();
					 
					if($result){
						
						foreach($result as $res):
						
					?>
              <tr class="gradeX">
                <td><?php echo $res['dp_internal_ref_number'];?></td>
                  <td><?php echo $res['name'];?></td>
                  
                  <td class="center"><?php echo @$res['creatd_date'];?></td>
                  <td class="center"><?php echo $res['date'];?></td>
				  <td><?php echo @mysql_result(mysql_query("SELECT `group_name` FROM `investor_group` WHERE `investor_group_id`='".$res['investor_group_id']."'"),0);?></td>
                  <td class="center"><?php echo $res['total_balance'];?> </td>
                  
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="Margin.php?margin_ac_update&getID=<?php echo urlencode($enc->encryptIt($res['dp_internal_ref_number']));?>" class="btn" title="Update Data">Margin Update</a>
                            
					<?php endif;
					
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($res['dp_internal_ref_number']));?>" onclick="return confirmation()" class="btn" title="Delete Data">Margin Cancel</a>
                            
                    <?php endif;
					
					?>
                            
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
         