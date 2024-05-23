	<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
		$ck=input_check(array('settlement_date'=>$_POST['settlement_date'],));
			
			if($ck=='Success'){
				
				///Insert
        

          $db_obj->select('tbl_settelment','*',"settlement_date='".$_POST['settlement_date']."'");
        if($db_obj->numRows()!=0){

        $_SESSION['in_result_data']= "<h3 align='center'>Data Already Exist !<h3>";
          $db_obj->disconnect();
             
			 echo'<script>window.location="settlement.php?SettlementNew";</script>';
               exit(); 

        }else{         
       $ins=$db_obj->insert('tbl_settelment',array('settlement_date'=>$_POST['settlement_date'],
		'exchange'=>$_POST['exchange'],
		'instrument_cate'=>$_POST['instrument_cate'],
		'market_type'=>$_POST['market_type'],
		'trade_type'=>$_POST['trade_type'],
		'Tstock'=>$_POST['Tstock'],
		'Tamount'=>$_POST['Tamount'])); 
		
		//print_r($ins);
		//die();

           $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";

             $db_obj->disconnect();
			  echo'<script>window.location="settlement.php?SettlementNew";</script>';
            
               exit(); 
        }
				
				}else{
					$_SESSION['in_result_data']= "<h3 align='center'>".$ck."<h3>";

					}
			
		
		}
	?>
    
    <div class="contentinner">


     <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }



                    if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?Settlement" class="btn alert-info"><span class="icon-th-large"></span> All Settlement </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">New Settlement Setup  </h4>
                
  <div class="widgetcontent" align="center">
  
  						
  <form class="stdform" action="" method="post">
                    	

	<table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" height="33"><strong>Settlement Date</strong></td>
    <td width="283"><input type="date" name="settlement_date" id="entry_date" required /></td>
    
    <td width="155"><strong>Exchange</strong></td>
    <td width="283"><select name="exchange" id="exchange" required="required">
      <option value="dsc">DSE</option>
      <option value="cse market">CSE</option>
    </select></td>
  </tr>
  <tr>
    <td width="145" height="33"><strong>Instrument Category</strong></td>
   <td width="283"><select name="instrument_cate" id="instrument_cate" required="required">
      <option value="A">A</option>
      <option value="B">B</option>
	   <option value="N">N</option>
	    <option value="Z">Z</option>
    </select></td>
    <td width="155"><strong>Market Type</strong></td>
   <td width="283"><select name="market_type" id="market_type" required="required">
      <option value="Public Market">Public Market</option>
      <option value="Spot Market">Spot Market</option>
      <option value="Odd Market">Odd Market</option>
      <option value="Bulk Market">Bulk Market</option>
    </select></td>
  </tr>
  <tr>
    <td height="31"><strong>Trade Type</strong></td>
    <td width="283"><select name="trade_type" id="trade_type" required="required">
      <option value="Buy">Buy</option>
      <option value="Sale">Sale</option>
    </select></td>
    <td width="155"><strong>Total Stock</strong></td>
    <td><input type="text" name="Tstock" id="Tstock"/></td>
  </tr>
  <tr>
    <td height="33"><strong>Total Amount</strong></td>
    <td width="283"><input type="text" name="Tamount" id="Tamount" required=""/></td>
  </tr>
  <tr>
    <td height="42" colspan="4" align="right"> 
      <p class="stdformbutton">
        <button class="btn btn-primary" name="submit_ins">Submit</button>
        <button type="reset" class="btn">Reset Form</button>
        </p></td>
  </tr>
    </table>



                     
                    
                     
                        
                        
    </form> 
                
                     
  </div><!--widgetcontent-->
                <!--widgetcontent-->          
                  </div>
<!--contentinner-->
        