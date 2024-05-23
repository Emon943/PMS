<?php

if(isset($_GET['dell'])){
    $instrumentcategory=$enc->decryptIt($_GET['dell']);
    if($instrumentcategory!=1) {
        $db_obj->delete("instrumentcategory", "id='$instrumentcategory'");
    }
   if(isset($_SERVER['HTTP_REFERER'])){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
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
      <div align="left">
      <span class="btn" style="background-color:#003;"> stock Blance</span>
                     
      </div>
      <?php endif;?>
                     
                     
       	<table class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
               	  <th width="141" class="head0">Instrument Name</th>
                  <th width="154" class="head1">Last Market Price</th>
                  <th width="123" class="head0">Current Balance</th>
                  <th width="103" class="head0">Free Blance</th>
              </tr>
          </thead>
          <tbody>
                    
            
               <?php
             
			   $db_obj->sql("SELECT DISTINCT `instrument_id` FROM `market_price_dse`");
			   $instrumentNamae=$db_obj->getResult();
			   
			   if(@$instrumentNamae){
				   foreach($instrumentNamae as $insName):
				   
				   $db_obj->sql("SELECT `close` AS 'currentBlance' FROM `market_price_dse` WHERE `instrument_id`='".$insName['instrument_id']."' ORDER BY  `date_pricedate`DESC  LIMIT 0,1");
				   $lastPrice=$db_obj->getResult();
			   ?>     
              <tr class="gradeX">
                <td><?php echo $insName['instrument_id'];?></td>
                  <td><?php echo $lastPrice[0]['currentBlance'];?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
              </tr>
             <?php
			 endforeach;
			  }?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
         