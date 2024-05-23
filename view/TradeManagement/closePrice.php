<?php
if(isset($_POST['submit_ins'])){
    $name = $_FILES['file']['name'];
    $temp_name = $_FILES['file']['tmp_name'];  
    if(isset($name)){
        if(!empty($name)){      
            $location = 'pms_doc_upload/market_price/';   
            if(move_uploaded_file($temp_name, $location.$name)){
               $xml = simplexml_load_file($location.'/'.$name);
	            //print_r($xml);
			   //die();
				
			    
				 foreach($xml as $Ticker){ 
				  $short_name=$Ticker['SecurityCode'];
				  $TradeDate=$Ticker['TradeDate'];
				  $ISIN=$Ticker['ISIN'];
				  $Cate=$Ticker['Category'];
				  $Close=$Ticker['Close'];
				  $Open=$Ticker['Open'];
				  $High=$Ticker['High'];
				  $Low=$Ticker['Low'];
				  $VarPercent=$Ticker['VarPercent'];
				  $CompulsorySpot=$Ticker['CompulsorySpot'];
				  $AssetClass=$Ticker['AssetClass'];
				  $Sector=$Ticker['Sector'];
				  
				  
				  $sql_s="INSERT INTO market_price_dse(date_pricedate, instrument_id, ins_cat_id, isin, open, high, low, close, chg_persentage, CompulsorySpot, AssetClass, Sector)
				  VALUES('$TradeDate', '$short_name', '$Cate', '$ISIN', '$Open', '$High', '$Low', '$Close', '$VarPercent', '$CompulsorySpot', '$AssetClass', '$Sector')";
				  $res= $dbObj->insert($sql_s);  
				
				 if($short_name){
				  $sql="UPDATE `instrument` SET `market_price`='$Close',`ins_cat_id`='$Cate' WHERE `short_name`='$short_name'";
                  $result=@mysql_query($sql);
				 
				 }
				  
				 }
				  if($result){
					  echo "successfully Import Price file";
				     }else{
					  echo "Import Price file Unsuccessfully"; 
					 }
            }
        }       
    }  else {
        echo 'You should select a file to upload !!';
    }
	
	//$files = scandir($location.'/'.$name);
	
}
?>


<br>
<div style="padding-left:20px;">
  <form class="stdform" action="" method="post" enctype="multipart/form-data">
		<input type="file" name="file" value="fileupload" id="file" required > <label for="fileupload">Select Price File</label> 
		<button class="btn btn-primary" name="submit_ins">Import</button>
	</form>
</div><br>
<div>
<table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Instrument</th>
        <th>Trading Date</th>
        <th>Opening Price</th>
		<th>Highest Price</th>
		<th>Lowest Price</th>
		<th>Closeing Price</th>
      </tr>
    </thead>
    <tbody>
    <?php 
	$cpdate=date("Y-m-d");
	$sql="SELECT * FROM market_price_dse WHERE date_pricedate='$cpdate'";			
	$db_obj->sql($sql);
    $closing_price=$db_obj->getResult();
	//print_r($closing_price);
	//die();
	if($closing_price){
						
	foreach($closing_price as $price):
	 ?>
      <tr>
        <td><?php echo $price['instrument_id'];?></td>
        <td><?php echo $price['date_pricedate'];?></td>
		<td><?php echo $price['open'];?></td>
		<td><?php echo $price['high'];?></td>
		<td><?php echo $price['low'];?></td>
		<td><?php echo $price['close'];?></td>
		
		 
      </tr>
	  
       <?php
		endforeach;
		}
		?>
    </tbody>
  </table>
  </div>