<?php

 if(isset($_POST['submit_ins'])){
	 //$commi_charge=$_POST["commi_chaege"];
	 $stock_ex=$_POST["stock"];
	 $broker=$_POST["broker"];
	 $sql="SELECT * FROM tbl_broker_hous where trace_id='$broker'";
	 $db_obj->sql($sql);
	 $commissionss=$db_obj->getResult(); 
	 $broker_fee=@$commissionss[0]['settlement_fee'];
	 $dsc_clear_id=@$commissionss[0]['dsc_clear_id'];
	 $db_obj->sql("SELECT COUNT(`date_tread`) AS 'dateList' FROM `tread_data_list` WHERE date_tread='" . $_POST["dateMark"] . "' AND status='" . 0 . "'");
     $tread_process = $db_obj->getResult();
	 if ($tread_process[0]['dateList'] != "0") {
		 echo "<h2>Already trade proccess pandding</h2>";
		  die();
	 }
	
	 $db_obj->sql("SELECT COUNT(`date_tread`) AS 'dateList' FROM `tread_data_list` WHERE date_tread='" . $_POST["dateMark"] . "' AND bokersoftcode='" . $_POST["broker"] . "'");
     $DateCheck = $db_obj->getResult();
					
					//print_r($DateCheck);
					//die();
    if ($DateCheck[0]['dateList'] == "0") { 

     $name = $_FILES['file']['name'];
     $temp_name = $_FILES['file']['tmp_name'];  
     if(isset($name)){
        if(!empty($name)){      
            $location = 'pms_doc_upload/investot_treadfile/';
            if(move_uploaded_file($temp_name, $location.$name)){
               $content = file_get_contents($location.'/'.$name, FILE_USE_INCLUDE_PATH);
			   $TreadData=preg_split("/\s+/", $content);
	          
			    
				 foreach($TreadData as $data){ 
				  $arrM = explode('~', $data);
				     //print_r($arrM);
					 
					
				            $ai[0] = isset($arrM[0]) ? $arrM[0] : '';
                            $ai[1] = isset($arrM[1]) ? $arrM[1] : '';
                            $ai[2] = isset($arrM[2]) ? $arrM[2] : '';
                            $ai[3] = isset($arrM[3]) ? $arrM[3] : '';
                            $ai[4] = isset($arrM[4]) ? $arrM[4] : '';
                            $ai[5] = isset($arrM[5]) ? $arrM[5] : '';
                            $ai[6] = isset($arrM[6]) ? $arrM[6] : '';
                            $ai[7] = isset($arrM[7]) ? $arrM[7] : '';
                            $ai[8] = isset($arrM[8]) ? $arrM[8] : '';
							$ai[9] = isset($arrM[9]) ? $arrM[9] : '';
							$ai[10] = isset($arrM[10]) ? $arrM[10] : '';
                            $ai[13] = isset($arrM[13]) ? $arrM[13] : '';
                            $ai[14] = isset($arrM[14]) ? $arrM[14] : '';
                            $ai[15] = isset($arrM[15]) ? $arrM[15] : '';
                            $ai[16] = isset($arrM[16]) ? $arrM[16] : '';
                            $ai[17] = isset($arrM[17]) ? $arrM[17] : '';
							$ai[18] = date("Y-m-d");
							
		if($ai[4]=="S"){					
	     $sql="SELECT * FROM tbl_ipo where BO_ID='$ai[14]' AND ISIN='$ai[2]' AND BO_Ac_Status='ACTIVE'";
	     $db_obj->sql($sql);
		 $ipo_share=$db_obj->getResult();
		 $ipo_status=@$ipo_share[0]['BO_Ac_Status'];
		}else{
		$ipo_status=NULL;
		}
		
		$db_obj->sql("SELECT investor_group.amount,investor_group.ipo_charge,tbl_agency_setup.charge_amt,tbl_agency_setup.id FROM `investor_group` INNER JOIN `investor` 
        ON (`investor_group`.`investor_group_id` = `investor`.`investor_group_id`) INNER JOIN `tbl_agency_setup`
        ON (`tbl_agency_setup`.`id` = `investor`.`agency_id`) where dp_internal_ref_number='$ai[13]'");
					$investor_group=$db_obj->getResult();
					// print_r($investor_group);
					if($investor_group){
					/*ipo Commission Charge*/
					if(@$ipo_status=='ACTIVE'){
					    $inv_group_commi_fee=$investor_group[0]["ipo_charge"]; 
					 }else{
						$inv_group_commi_fee=$investor_group[0]["amount"]; 
					 }
					 $agent_commi_fee=$investor_group[0]["charge_amt"];
					 $aid=$investor_group[0]["id"];
					 //die();
							 
							$total_Amt=$ai[5]*$ai[6];
							$commission=($total_Amt*$inv_group_commi_fee/100);
							$broker_charge=($total_Amt*$broker_fee/100);
							$agency_charge=($total_Amt*$agent_commi_fee/100);
							$branch_id=$_SESSION['LOGIN_USER']['branch_id'];
							
							  if($ai[4]=="S"){
							    $net_amt=@$total_Amt-$commission;
							  }else{
								$net_amt=@$total_Amt+$commission;
							  }
				 if($ai[13]){
			     $sql_s="INSERT INTO tread_data_list (bokersoftcode, aid, stock_id, branch_id, account_no, bo_id, instrument, isin, type, OrderNo, ContractNo, market, category, time_tread, date_tread, curr_date, quantity, rate, total_amount, broker_commission, agency_comm, commission, net_amount, trader, CompulsorySpot)
				 VALUES ('$broker', '$aid', '$stock_ex', '$branch_id', '{$ai[13]}', '{$ai[14]}', '{$ai[1]}', '{$ai[2]}', '{$ai[4]}', '{$ai[0]}', '{$ai[15]}', '{$ai[9]}', '{$ai[17]}', '{$ai[8]}', '{$ai[7]}', '{$ai[18]}', '{$ai[5]}', '{$ai[6]}', '$total_Amt', '$broker_charge', '$agency_charge', '$commission', '$net_amt', '{$ai[3]}', '{$ai[16]}')";
				
				 $res= $dbObj->insert($sql_s);
				 }  
				
				
			
			//$db_obj->insert("tread_data_list",array("bokersoftcode"=>$broker,"stock_id"=>$stock_ex,"branch_id"=>$_SESSION['LOGIN_USER']['branch_id'],"account_no"=>$ai[13],"bo_id"=>$ai[14],"instrument"=>$ai[1],"isin"=>$ai[2],"type"=>$ai[4],"market"=>$ai[9],"category"=>$ai[17],"time_tread"=>$ai[8],"date_tread"=>$ai[7],"current_date"=>$current_date,"quantity"=>$ai[5],"rate"=>$ai[6],"total_amount"=>$total_Amt,"broker_commission"=>$broker_charge,"agency_comm"=>$agency_charge,"commission"=>$commission,"net_amount"=>$net_amt,"trader"=>$ai[3]));
					}else{
					 echo "<h2 style='text-align:center; color:red'>File can not read.Please check investor setup</h2>";
					  exit();
					}
			}
              echo "<h2 style='text-align:center; color:green'>Tread file Import Successfully</h2>";
				$db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=Protfolio.php?tradeHistory' />";
           exit();
            }
        }       
    }  else {
        echo 'You should select a file to upload !!';
    }
	
	}else{
		echo "<h2 style='text-align:center; color:red'>Tread file Allready Imported</h2>";
				$db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=Protfolio.php?tradeHistory' />";
           exit();
	}			  
	
}
 
?>



  <div class="contentinner content-dashboard">
 
 
  <?php
       
	   //print_r($result);

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }
          
        ?>
     <h4 class="widgettitle">Tread Import File</h4>

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                
       	
  <div align="center">
        <form action="" method="post" enctype="multipart/form-data" class="stdform">
        <table width="45%" border="1" align="center">
  <!--<tr>
    <td width="40%" height="6">&nbsp;</td>
    <td width="60%" height="6"><input name="commi_chaege" type="hidden" id="commi_chaege" value="<?php echo $commi_chaege;?>" /></td>
  </tr>-->
 <tr>
     <td width="40%" height="6">&nbsp;</td>
    <td width="60%" height="16"><input name="dateMark" type="hidden" id="dateMark" value="<?php echo date('d-m-Y');?>" /></td>
  </tr>
  <tr>
    <td height="31" width="283"><strong>Stock Exchange</strong></td>
    <td width="283"><select name="stock" id="stock" required>
   <?php
					$sql="SELECT * FROM tbl_stockexchange";
					$db_obj->sql($sql);
					$stockexchange=$db_obj->getResult();
				
					 
					if($stockexchange){
						
						foreach($stockexchange as $stock):
						?>
                       <option value="<?php echo @$stock['stock_id'];?>"><?php echo @$stock['stock_name'];?></option>
                       
                        <?php
						endforeach;
					}else{
						?>
                        <option value="">Please Insert broker name</option>
                        <?php
						}
					?>
                    
    
    </select>
    </select></td>
  </tr>
  <tr>
     <td height="34"><strong>Panel Broker</strong></td>
     <td height="34">
	 <select name="broker" id="broker" required>
    
     <?php
					 $sql="SELECT * FROM tbl_broker_hous";
					$db_obj->sql($sql);
					 $broker_house=$db_obj->getResult();
					 
		$cdbl_date=date("d-m-y");
       $db_obj->select('tbl_cdbl','*',"date='".$cdbl_date."'");
	   $result=$db_obj->numRows();
					 
					if($broker_house){
						
						foreach($broker_house as $broker_house):
						?>
                       <option value="<?php echo $broker_house['trace_id'];?>"><?php echo $broker_house['Internal_code'];?></option> 
                       
                        <?php
						endforeach;
					}else{
						?>
                        <option value="">Please Insert broker name</option>
                        <?php
						}
					?>
                    
    
    </select></td>
  </tr>
  <tr>
    <td height="34"><strong>Uploade Your Tread  File Text</strong></td>
    <td height="34"><input type="file" name="file" id="file" required /></td>
  </tr>
  <tr>
    <td height="42">&nbsp;</td>
    <td height="42">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center"><p>
	<?php if($result){ ?>
      <button class="btn btn-primary" name="submit_ins" title="Delete Data">Submit</button>
	   <button type="reset" class="btn">Reset Form</button>
	<?php }else { ?>
	  <button class="btn btn-primary" name="submit_ins" disabled >Submit</button>
      <button type="reset" class="btn">Reset Form</button>
	<?php } ?>
    </p></td>
    </tr>
        </table>
      
       </form> 
        </div>

                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
   </div><!--row-fluid-->
   
 </div>
         