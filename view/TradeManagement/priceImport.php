
<?php



function ImportPriceList($repFileLOC,$DateChek,$live=false){
	
						$datSendArray=array();		 
				
						if($live){
							
								$file = file_get_contents($repFileLOC);
								
								$dateLID=preg_split("/\\r\\n|\\r|\\n/", $file);
								
								$dateTimeLL=explode(':',$dateLID[2]);
								
								
				                $filePath="./pms_doc_upload/market_price/".$dateTimeLL[1].".txt";
								file_put_contents($filePath, $file);
								
								  $readData= file_get_contents($filePath, FILE_USE_INCLUDE_PATH);
								  $priceData=preg_split("/\\r\\n|\\r|\\n/", $readData);
								  $DateChek=$dateTimeLL[1];
								
							}else{	
								  $readData= file_get_contents($repFileLOC, FILE_USE_INCLUDE_PATH);
								  $priceData=preg_split("/\\r\\n|\\r|\\n/", $readData);
								  $DateChek=$DateChek;
										
								}
								
								
								$priceAllData="";
								
								foreach($priceData as $lky=>$value){
									
									
									 $output = preg_replace('!\s+!', ' ', $value);
									 $teeadDataEx=str_replace(' ',"#",$output);
								    $countsl=explode("#",$teeadDataEx);
									$checkFLOaT1=@(float) $countsl[1];
									$checkFLOaT2=@(float) $countsl[2];
									$checkFLOaT3=@(float) $countsl[3];
									$checkFLOaT4=@(float) $countsl[4];
									$checkFLOaT5=@(float) $countsl[5];
									$checkFLOaT6=@(float) $countsl[6];
											  
											   if(count($countsl)==9 && $checkFLOaT1!=0 && $checkFLOaT2!=0 && $checkFLOaT3!=0 && $checkFLOaT4!=0 && $checkFLOaT5!=0 && $checkFLOaT6!=0){
												 $priceAllData.=$value."~~";
												}
												
									}
									 print_r($priceAllData);
				 
												$totalDataPrice='';
												$pricM=explode('~~',$priceAllData);
												   $toalINS=count($pricM);
												  
												   
												
												foreach ($pricM as $key=>$value) {
													
													
													if (preg_match('/[a-z]/i', $value))
															$checkMatch= "Matches";
														else
															$checkMatch= "No_Matches";
													
													
															
															if($checkMatch=='Matches'){
															
															$priceLL=explode(" ", $value);
															
															if($toalINS!=$key){
																
																if(($toalINS-2)==$key){$keySpace="";}else{$keySpace=",";}
																
															$totalDataPrice.='("'.$DateChek.'","' . str_replace('"",',' ',implode('", "', $priceLL)) . '")'.$keySpace.'';
															}
															}
													
													
													
												}
						
							$datSendArray['date']=$DateChek;
							$datSendArray['totalDataPrice']=$totalDataPrice;
							
							return $datSendArray;
				
					
	
	
	}



// <= PHP 5
//$file = file_get_contents('http://www.dsebd.org/mst.txt', true);
// > PHP 5
//echo $file = file_get_contents('http://www.dsebd.org/mst.txt', FILE_USE_INCLUDE_PATH);
?>

<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
		
		if(isset($_POST["submit_ins"])){
			
			$PriceImpor=$_FILES["uplodeFile"];
				if($PriceImpor['name']!="" && $PriceImpor['type']=='text/plain'):
				$extentation=explode(".",$PriceImpor['name']);
				
				$newFileName=$_POST["dateMark"].'.txt';
				 $repFileLOC="./pms_doc_upload/market_price/".$newFileName;
				
				if(move_uploaded_file($PriceImpor['tmp_name'], $repFileLOC)){
					
					/*Manual Import Data Price List*/
					
			        $totalDataPrice=ImportPriceList($repFileLOC,$_POST["dateMark"]);
					
				
				//echo $totalDataPrice;
				
				
		 $db_obj->sql("SELECT COUNT(`date_pricedate`) AS 'dateList' FROM `market_price_dse` WHERE date_pricedate='".$_POST["dateMark"]."'");
				$DateCheck=$db_obj->getResult();
				if($DateCheck[0]['dateList']=="0"){
					@$db_obj->sql("INSERT INTO `market_price_dse` VALUE ".$totalDataPrice['totalDataPrice']);
					
					header("Location: ./Protfolio.php?MarketAnalysis");
					exit();
					}
					
					/*Manual Import Data Price List*/
					
				}
					
			endif;
			
		}
		
		
		if(isset($_POST["priceLiveImprot"])){
			
		 $totalDataPrice=ImportPriceList("http://www.dsebd.org/mst.txt",date('Y-m-d'),true);
			
			
			
			//echo $totalDataPrice['date'];
			//echo $totalDataPrice['totalDataPrice'];
			
			
			 $db_obj->sql("SELECT COUNT(`date_pricedate`) AS 'dateList' FROM `market_price_dse` WHERE date_pricedate='".$totalDataPrice['date']."'");
				$DateCheck=$db_obj->getResult();
				
				if($DateCheck[0]['dateList']=="0"){
					@$db_obj->sql("INSERT INTO `market_price_dse` VALUE ".$totalDataPrice['totalDataPrice']);
					
				header("Location: ./Protfolio.php?MarketAnalysis");
					exit();
					}
					
				
			}
			
			
	?>


<div class="contentinner content-dashboard">
 
 
  <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }
		  
		  
          
        ?>
            	<h4 class="widgettitle">Price Import </h4>

<div class="row-fluid">
                
                
   	<div class="span12">
                    
          <?php
          $date = date("Y-m-d");
		$date1 = str_replace('-', '/', $date);
			 $daysLase4th = date('Y-m-d',strtotime($date1 . "-4 days"));
		   @$db_obj->delete("market_price_dse", "`date_pricedate`<'".$daysLase4th."'");
		  ?>       
                     
       	
        <div align="center">
        <form action="" method="post" enctype="multipart/form-data" class="stdform">
        <table width="45%" border="1" align="center">
  <tr>
    <td width="40%" height="6">&nbsp;</td>
    <td width="60%" height="6"><input name="timMiniFile" type="hidden" id="timMiniFile" value="<?php echo time();?>" /></td>
  </tr>
  <tr>
    <td height="48" colspan="2" align="center"> <button class="btn btn-danger" name="priceLiveImprot">live import market prices</button></td>
    </tr>
  <tr>
    <td height="16"><strong>Market Price Date</strong></td>
    <td width="60%" height="16"><input name="dateMark" type="text" id="dateMark" value="<?php echo date('Y-m-d');?>" /></td>
  </tr>
  <tr>
    <td height="34"><strong>Uploade Your Price  File Text</strong></td>
    <td height="34"><input type="file" name="uplodeFile" id="uplodeFile" /></td>
  </tr>
  <tr>
    <td height="42">&nbsp;</td>
    <td height="42">&nbsp;</td>
  </tr>
  <tr>
    <td height="16" colspan="2" align="center"><p>
      <button class="btn btn-primary" name="submit_ins">Submit</button>
      <button type="reset" class="btn">Reset Form</button>
    </p></td>
    </tr>
        </table>
      
       </form> 
        </div>

                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
         