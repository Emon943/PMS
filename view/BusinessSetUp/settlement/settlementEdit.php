
<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$settlement_id=$enc->decryptIt($_GET["getID"]);
	
	
				$db_obj->sql("SELECT * FROM tbl_settelment WHERE id='".$db_obj->EString($settlement_id)."'");
			    $settlement=$db_obj->getResult();
				//print_r($settlement);
				//die();
			  if(!$settlement){
				   echo "<h2>Investor Not Founded...........</h2>";
						exit();
				  }
					 
	
	}else{
		echo "<h2>Messing GET URL...........</h2>";
		exit();
		}
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?Settlement" class="btn alert-info"><span class="icon-th-large"></span> All Settlement </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle"></h4>

<div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
     <?php
                
				if(isset($_POST["updateInv"])){
					
			$db_obj->update('tbl_settelment',array('settlement_date'=>$_POST["settlement_date"],'exchange'=>$_POST["exchange"],
         					 'instrument_cate'=>$_POST["instrument_cate"],
							 'market_type'=>$_POST["market_type"],
							 'trade_type'=>$_POST["trade_type"],
							 'Tstock'=>$_POST["Tstock"],
							 'Tamount'=>$_POST["Tamount"]),
							 "id=".$_POST["settlement_id"].""); 
					  
							 
					$_SESSION['in_result_data']="<h3 align='center'>Data Update Success Full...<h3>";

                      $db_obj->disconnect();
			             echo'<script>window.location="settlement.php?SettlementNew";</script>';
            
               exit(); 
							  
					
					}
				?>
                                     
       	
        <div align="center">
        
        <form action="" method="post" enctype="multipart/form-data">
          <table width="80%" border="0" cellpadding="0" cellspacing="5">
            <tr>
              <td height="24" colspan="2" align="center" valign="top"  style="background-color:#CCC;"><strong>SETTLEMENT DETAILS</strong></td>
            </tr>
            <tr>
              <td width="49%"><strong>
                <input name="settlement_id" type="hidden" id="investorIDHe" value="<?php echo $settlement_id;?>" />
              <strong>Settlement Date</strong><br/></td>
              <td width="51%" align="center"><strong>
              <input name="settlement_date" type="text" id="dp_internal_ref_number" value="<?php echo $settlement[0]['settlement_date']?>" />
              </strong></td>
            </tr>
           <tr>
              <td><strong>Exchange</strong><br/></td>
              <td align="center"><strong>
              <select name="exchange" id="account_status" required="required">
              <option value="<?php echo $settlement[0]['exchange']?>"><?php echo $settlement[0]['exchange']?></option>
                  <option value="dse">DSE</option>
                  <option value="cse">CSE</option>
                </select>
              </strong></td>
            </tr>
            <tr>
              <td><strong>Instrument Cate</strong><br/></td>
              <td align="center"><strong>
              <select name="instrument_cate" id="account_status" required="required">
              <option value="<?php echo $settlement[0]['instrument_cate']?>"><?php echo $settlement[0]['instrument_cate']?></option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="N">N</option>
				   <option value="Z">Z</option>
                </select>
              
              
              </strong></td>
            </tr>
			
			<tr>
              <td><strong>Market Type</strong><br/></td>
              <td align="center"><strong>
              <select name="market_type" id="account_status" required="required">
              <option value="<?php echo $settlement[0]['market_type']?>"><?php echo $settlement[0]['market_type']?></option>
                  <option value="Public Market">Public Market</option>
                  <option value="Spot Market">Spot Market</option>
                  <option value="Odd Market">Odd Market</option>
				   <option value="Bulk Market">Bulk Market</option>
                </select>
              
              
              </strong></td>
            </tr>
			<tr>
			<td><strong>Trade Type</strong><br/></td>
              <td align="center"><strong>
              <select name="trade_type" id="account_status" required="required">
              <option value="<?php echo $settlement[0]['trade_type']?>"><?php echo $settlement[0]['trade_type']?></option>
                  <option value="Buy">Buy</option>
                  <option value="Sale">Sale</option>
                  
                </select>
              </strong></td>
            </tr>
			
			<tr>
              <td><strong>Total Stock</strong><br /></td>
              <td align="center"><strong>
                <input name="Tstock" type="text" id="investor_ac_number" value="<?php echo $settlement[0]['Tstock']?>"/>
              </strong></td>
            </tr>
			
			<tr>
              <td><strong>Total Amount</strong><br /></td>
              <td align="center"><strong>
                <input name="Tamount" type="text" id="investor_ac_number" value="<?php echo $settlement[0]['Tamount']?>" />
              </strong></td>
            </tr>
            <br/>
            <tr>
              <td height="-5" valign="top"  ></td>
              <td height="-5" align="right" valign="top"  ><input type="submit" name="updateInv" id="updateInv" value="Update Settlement"/></td>
            </tr>
          </table>
          </form> 
        </div>

                
                  
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
           
         