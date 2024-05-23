<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $loan_catagory_margin=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("loan_catagory_margin", "id='$loan_catagory_margin'");
   	
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
        <a href="?LoanCatagoryMarginNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Loan Catagory Margin </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="52" class="head0" title="Short Name">Code</th>
                  <th width="201" class="head1" title="ISIN">Max Loan Allocation</th>
                  <th width="227" class="head0" title="Name">Min Account Balance</th>
                  <th width="140" class="head1" title="Industry">Charge Interest</th>
                  <th width="140" class="head1" title="Market Price">InterestPeriod</th>
                  <th width="127" class="head1" title="Market Price">MarginRatio</th>
                  <th width="126" class="head1" title="Market Price">InterestRate</th>
                  <th width="113" class="head1" title="Market Price">Description</th>
                  <th width="134" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `loan_catagory_margin` ORDER BY id DESC";
					
					$db_obj->sql($sql);
					 $loan_catagory_margin=$db_obj->getResult();
					 
					if($loan_catagory_margin){
						
						foreach($loan_catagory_margin as $loan_catagory_margin):
						
					?>
              <tr class="gradeX">
                <td><?php echo $loan_catagory_margin['loan_cat_margin_code'];?></td>
                  <td><?php echo $loan_catagory_margin['max_loan_allocation'];?></td>
                  <td><?php echo $loan_catagory_margin['min_account_blance'];?></td>
                  <td class="center"><?php echo $loan_catagory_margin['charge_interest'];?></td>
                  <td class="center"><?php echo $loan_catagory_margin['interest_priod'];?></td>
                  <td class="center"><?php echo $loan_catagory_margin['margin_ratio'];?></td>
                  <td class="center"><?php echo $loan_catagory_margin['interest_rate'];?></td>
                  <td class="center"><?php echo $loan_catagory_margin['description'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                    <a href="#" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($loan_catagory_margin['id']));?>" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         