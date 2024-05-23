<?php

if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $instrument=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("instrument", "instrument_id='$instrument'");
   	
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
      return confirm('Are you sure you want to delete this?');
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
        <a href="?InstrumentNew" class="btn btn-primary"><span class="icon-plus-sign"></span> New Instrument </a>
                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="100" class="head1" title="Short Name">S.Name</th>
                  <th width="38" class="head1" title="ISIN">ISIN</th>
                  <th width="56" class="head1" title="Industry">Industry</th>
                  <th width="54" class="head1" title="Market Price">M.Price</th>
                  <th width="62" class="head1" title="Market Catagory">Catagory</th>
                  <th width="52" class="head1" title="Non Marginable">N.M</th>
                  <th width="47" class="head1" title="Industry Type">Type</th>
                  <th width="37" class="head1" title="PE Ratio">Ratio</th>
                  <th width="42" class="head1" title="Latest EPS">L.EPS</th>
                  <th width="34" class="head1" title="NAV">NAV</th>
                  <th width="159" class="head1" title="Declaraction Date">D.Date</th>
                  <th width="97" class="head1" title="Last Updated">L.Updated</th>
                  <th width="42" class="head1">Status</th>
                  <th width="50" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
     $sql="SELECT
    `instrument`.`instrument_id`,`instrument`.`entry_date`, `instrument`.`ins_name`, `instrumentcategory`.`code`
    , `instrument`.`market_price`, `instrument`.`net_asset_value`, `instrument`.`instrument_type`
    , `instrument`.`pe_ratio`, `instrument`.`enjoy_netting` , `instrument`.`total_share` , `instrument`.`last_up_date`
    , `instrument`.`isin`, `instrument`.`declaraction_date` , `instrument`.`short_name`, `instrument`.`face_value`
    , `instrument`.`cost_per_share`, `instrument`.`premium`, `instrument`.`non_marginable` , `instrument`.`latest_eps`
    , `instrument`.`public_share` , `instrument_catgory_pd`.`catagory_name` , `instrument`.`status`

FROM `instrument` INNER JOIN `instrumentcategory` ON (`instrument`.`ins_cat_id` = `instrumentcategory`.`code`) LEFT JOIN 
`instrument_catgory_pd`  ON (`instrument`.`catagory` = `instrument_catgory_pd`.`id`)";
					
					$db_obj->sql($sql);
					 $instrument=$db_obj->getResult();
					 
					if($instrument){
						
						foreach($instrument as $instrument):
						//print_r($instrument);
						//die();
					?>
              <tr class="gradeX">
                <td><?php echo $instrument['short_name'];?></td>
                  <td><?php echo $instrument['isin'];?></td>
                  
                  <td class="center"><?php echo @$instrument['catagory_name'];?></td>
                  <td class="center"><?php echo $instrument['market_price'];?></td>
                  <td class="center"> <?php echo $instrument['code'];?> </td>
                  <td class="center"><?php echo $instrument['non_marginable'];?> </td>
                  <td class="center"><?php echo $instrument['instrument_type'];?> </td>
                  <td><?php echo $instrument['pe_ratio'];?></td>
                  <td><?php echo $instrument['latest_eps'];?></td>
                  <td><?php echo $instrument['net_asset_value'];?></td>
                  <td><?php echo $instrument['declaraction_date'];?></td>
                  <td><?php echo $instrument['last_up_date'];?></td>
                  <td><?php echo $instrument['status'];?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>

                    <a href="house_keeping.php?Instrument_update&getID=<?php echo urlencode($enc->encryptIt($instrument['short_name']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($instrument['instrument_id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
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
         