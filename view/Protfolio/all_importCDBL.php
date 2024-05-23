<?php 
      include 'config.php';
	  $dbObj = new DBUtility();

	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
	if(isset($_POST["submit_ins"])){
			
	$db_obj->select('sale_share','*',"day_count='"."0"."'");
	$res_sel=$db_obj->numRows();
	$db_obj->select('tbl_buy_info','*',"day_count='"."0"."'");
	$res_buy=$db_obj->numRows();
	$trade_no=$res_sel+$res_buy;
	//die();
	if($trade_no!=0){
	 echo $_SESSION['in_result_data']= "<h3 align='center'>Already Pandding In-House Settlement!<h3>";
     $db_obj->disconnect();
	  exit(); 
		
	}else{
			 $folder_name=date("d-m-y");
			  if($folder_name)
			 $path="./pms_doc_upload/".$folder_name;
			 //die();
			if(is_dir($path)){
				//echo "Already upload this folder";
				die("Already upload today data");
			}else{
				mkdir($path);
			}
				
			
		foreach($_FILES['files']['name'] as $i=>$name){
			if(strlen($_FILES['files']['name'][$i]>1)){
				
				move_uploaded_file($_FILES['files']['tmp_name'][$i],$path.'/'.$name);
				
			}
			
		}
				
			$files = scandir($path);
			//print_r($files);
			
			for($i=2;$i<count($files); $i++){
				$bo=$files[$i];
				//print_r($bo);
			if($bo=="08DP01UX.TXT"){
				
			 $content = file_get_contents($path.'/'.$bo);
			 $array = explode("\n", $content);
			
			  //print_r($array);
			 // die();
			  foreach($array as $cont){ 
		       //var_dump($cont);
		       //die();
    // Make an array using comma as delimiter
         $arrM = explode('~',$cont); 
	      //var_dump($arrM); die();


	   
	   $ai[0] = isset($arrM[0])? $arrM[0] : '';
	   $ai[1] = isset($arrM[1])? $arrM[1] : '';
	   $ai[2] = isset($arrM[2])? $arrM[2] : '';
	   $ai[3] = isset($arrM[3])? $arrM[3] : '';
	   $ai[4] = isset($arrM[4])? $arrM[4] : '';
	   $ai[5] = isset($arrM[5])? $arrM[5] : '';
	   $ai[6] = isset($arrM[6])? $arrM[6] : '';
	   $ai[7] = isset($arrM[7])? $arrM[7] : '';
	   $ai[8] = isset($arrM[8])? $arrM[8] : '';
	   $ai[9] = isset($arrM[9])? $arrM[9] : '';
	   $ai[10] = isset($arrM[10])? $arrM[10] : '';
	   $ai[11] = isset($arrM[11])? $arrM[11] : '';
	   $ai[12] = isset($arrM[12])? $arrM[12] : '';
	   $ai[13] = isset($arrM[13])? $arrM[13] : '';
	   $ai[14] = isset($arrM[13])? $arrM[14] : '';
	   $ai[15] = isset($arrM[15])? $arrM[15] : '';
	   $ai[16] = isset($arrM[16])? $arrM[16] : '';
	   $ai[17] = isset($arrM[17])? $arrM[17] : '';
	   $ai[18] = isset($arrM[18])? $arrM[18] : '';
	   $ai[19] = isset($arrM[19])? $arrM[19] : '';
	   $ai[20] = isset($arrM[20])? $arrM[20] : '';
	   $ai[21] = isset($arrM[21])? $arrM[21] : '';
	   $ai[22] = isset($arrM[22])? $arrM[22] : '';
	   $ai[23] = isset($arrM[23])? $arrM[23] : '';
	   $ai[24] = isset($arrM[24])? $arrM[24] : '';
	   $ai[25] = isset($arrM[25])? $arrM[25] : '';
	   $ai[26] = isset($arrM[26])? $arrM[26] : '';
	   $ai[27] = isset($arrM[27])? $arrM[27] : '';
	   $ai[28] = isset($arrM[28])? $arrM[28] : '';
	   $ai[29] = isset($arrM[29])? $arrM[29] : '';
	   $ai[30] = isset($arrM[30])? $arrM[30] : '';
	   $ai[31] = isset($arrM[31])? $arrM[31] : '';
	   $ai[32] = isset($arrM[32])? $arrM[32] : '';
	   $ai[33] = isset($arrM[33])? $arrM[33] : '';
	   $ai[34] = isset($arrM[34])? $arrM[34] : '';
	   $ai[35] = isset($arrM[35])? $arrM[35] : '';
	   $ai[36] = isset($arrM[36])? $arrM[36] : '';
	   $ai[37] = isset($arrM[37])? $arrM[37] : '';
	   $ai[38] = isset($arrM[38])? $arrM[38] : '';
	   $ai[39] = isset($arrM[39])? $arrM[39] : '';
	   $ai[40] = isset($arrM[40])? $arrM[40] : '';
	   $ai[41] = isset($arrM[41])? $arrM[41] : '';
	   $ai[42] = isset($arrM[42])? $arrM[42] : '';
	   $ai[43] = isset($arrM[43])? $arrM[43] : '';
	   $ai[45] = isset($arrM[45])? $arrM[45] : '';
	   $ai[46] = isset($arrM[46])? $arrM[46] : '';
	   $ai[47] = isset($arrM[47])? $arrM[47] : '';
	   $ai[48] = isset($arrM[48])? $arrM[48] : '';
	   $ai[49] = isset($arrM[49])? $arrM[49] : '';
	   $ai[50] = $_SESSION['LOGIN_USER']['id'];
	   
	 $db_obj->select('investor','*',"investor_ac_number='".$ai[0]."'");
      if($db_obj->numRows()!=0){
		  echo "This ID ".$ai[0]." Already Exist"."</br>";
	  }else{
    $sql="INSERT INTO investor (investor_ac_number,investor_name,account_status,dp_internal_ref_number,insert_employee_id,created_set_date,txt_file_)
    VALUES ('{$ai[0]}','{$ai[4]}','{$ai[1]}','{$ai[3]}','{$ai[50]}','{$ai[49]}','{$ai[6]}')";
	
	$res= $dbObj->insert($sql);
	$insID=mysql_insert_id();
	 $sql = "update investor_personal set
			dp_internal_ref_number ='{$ai[3]}',
			bo_id ='{$ai[0]}',
			bo_type='{$ai[2]}',
			sex_code ='{$ai[8]}',
			date_of_birth ='{$ai[9]}',
			father_husbands ='{$ai[11]}',
			mothers_name ='{$ai[12]}',
			occupation ='{$ai[13]}',
			residency_flag ='{$ai[14]}',
			citizen_of ='{$ai[15]}',
			address ='{$ai[16]}',
			city ='{$ai[17]}',
			state ='{$ai[20]}',
			country ='{$ai[21]}',
			postal_code ='{$ai[22]}',
			phone ='{$ai[23]}',
			email='{$ai[24]}'
			where investor_id=$insID";
			$dbObj->update($sql);
			
			$sql = "update investor_bank_details set
			 routing_number ='{$ai[42]}',
			 bank_name ='{$ai[34]}',
			 branch_name ='{$ai[35]}',
			 bank_ac_no ='{$ai[36]}',
			 bic_code ='{$ai[40]}',
			 iban ='{$ai[12]}',
			 swift_code ='{$ai[46]}',
			 electronic_divi ='{$ai[14]}'
			 where investor_id=$insID";
			$dbObj->update($sql);
	  }
	//echo $insID;
	if(@$res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 <div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">BO Setup Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  /*----------------------------------------------------------------------------------*/
  
   if($bo=="08DP03UX.TXT"){
			
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			    //print_r($array);
			    //die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //'die();
	   
	   $ai[0] = isset($arrM[0])? $arrM[0] : '';
	   $ai[1] = isset($arrM[1])? $arrM[1] : '';
	   $ai[2] = isset($arrM[2])? $arrM[2] : '';
	   $ai[3] = isset($arrM[3])? $arrM[3] : '';
	   $ai[4] = isset($arrM[4])? $arrM[4] : '';
	   $ai[5] = isset($arrM[5])? $arrM[5] : '';
	   $ai[6] = isset($arrM[6])? $arrM[6] : '';
	  
	 
      
    if($ai[4]=="PHONE_1"){
    $sql = "update investor_personal set phone='{$ai[6]}' WHERE BO_ID='$ai[1]'";
	$dbObj->update($sql);
	}else{
	$sql = "update investor_personal set email='{$ai[6]}' WHERE BO_ID='$ai[1]'";
	$dbObj->update($sql);
	}
	
     }
	 // die();
	 ?>
	 
	 <div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">BO Update Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  /*-----------------------------------------------------------------------------------------*/
  
  if($bo=="11DPA6UX.TXT"){
			
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			    //print_r($array);
			    //die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	   
	   $ai[0] = isset($arrM[0])? $arrM[0] : '';
	   $ai[1] = isset($arrM[1])? $arrM[1] : '';
	   $ai[2] = isset($arrM[2])? $arrM[2] : '';
	   $ai[3] = isset($arrM[3])? $arrM[3] : '';
	   $ai[4] = isset($arrM[4])? $arrM[4] : '';
	   $ai[5] = isset($arrM[5])? $arrM[5] : '';
	   $c_bal="$ai[5]";
	 
      $sqls="SELECT * FROM tbl_ipo WHERE ISIN='$ai[0]' AND BO_ID='$ai[2]'";
      $result= $dbObj->select($sqls);
	 
	  $Current_Bal=@$result[0]['Current_Bal'];
	  $BO_ID=@$result[0]['BO_ID'];
	  
    if (strcmp((int)$c_bal, (int)$Current_Bal) !== 0) { 
     echo "Please Check File 11DPA6UX.TXT Current_Bal Not Match Of BO ID"." ".$ai[2]. "ISIN: ".$ai[0]. "<br>";
    } 
    else{ 
    } 
		//echo "successfully update BO";
     }?>
	 <div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Holding Report Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  if($bo=="38DP77UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	   
	   $ai[0] = isset($arrM[0])? $arrM[0] : '';
	   $ai[1] = isset($arrM[1])? $arrM[1] : '';
	   $ai[4] = isset($arrM[4])? $arrM[4] : '';
	   $ai[5] = isset($arrM[5])? $arrM[5] : '';
	   $ai[6] = isset($arrM[6])? $arrM[6] : '';
	   $ai[7] = isset($arrM[7])? $arrM[7] : '';
	   $ai[14] = isset($arrM[14])? $arrM[14] : '';
	   $ai[16] = isset($arrM[16])? $arrM[16] : '';
	   $ai[18] = isset($arrM[18])? $arrM[18] : '';
	  
	 
    $sql="INSERT INTO tbl_payin(s_exchange,sl_no,bo_id,name,isin,instument,quantity,dp_code,date) 
    VALUES ('{$ai[0]}','{$ai[1]}','{$ai[4]}','{$ai[5]}','{$ai[6]}','{$ai[7]}','{$ai[14]}','{$ai[16]}','{$ai[18]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 <div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">PayIn Report Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  if($bo=="38DP80UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		// die();
	   
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
	    $ai[11] = isset($arrM[11])? $arrM[11] : '';
	    $ai[12] = isset($arrM[12])? $arrM[12] : '';
	    $ai[13] = isset($arrM[13])? $arrM[13] : '';
	    $ai[16] = isset($arrM[16])? $arrM[16] : '';
	    $ai[17] = isset($arrM[17])? $arrM[17] : '';
	  
	 
    $sql="INSERT INTO tbl_payout(s_exchange,sl_no,quantity,bo_id,name,ISIN,ISIN_name,code,buy_date,broker_name) 
    VALUES ('{$ai[0]}','{$ai[1]}','{$ai[3]}','{$ai[4]}','{$ai[11]}','{$ai[6]}','{$ai[7]}','{$ai[16]}','{$ai[17]}','{$ai[13]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 <div style="padding-left:20px">
	  <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">PayOut Report Successfully...</span></strong></div>
	</div></br></br>
	 <?php
  }
  
  
  if($bo=="43DP18UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	   
	   
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
	    $ai[11] = isset($arrM[11])? $arrM[11] : '';
	    $ai[12] = isset($arrM[12])? $arrM[12] : '';
	    $ai[13] = isset($arrM[13])? $arrM[13] : '';
	  
	 
    $sql="INSERT INTO monthly_bill_of_cdbl(business_date,charge_desc,no_of_trans,Dr_Cr_flag, Quantity,trans_value,total_charge,s_tax,total_amt,charge_rate_amt,total_bill_amt,fdtd) 
    VALUES ('{$ai[2]}','{$ai[3]}','{$ai[4]}','{$ai[5]}','{$ai[6]}','{$ai[7]}','{$ai[8]}','{$ai[9]}','{$ai[10]}','{$ai[11]}','{$ai[12]}','{$ai[13]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 <div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">CDBL Bill Report Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  
  
   /*------------------------------------------------------------------*/
  
  if($bo=="43DP52UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
		$ai[11] = isset($arrM[11])? $arrM[11] : '';
		$ai[12] = isset($arrM[12])? $arrM[12] : '';
		$ai[13] = isset($arrM[13])? $arrM[13] : '';
		$ai[14] = isset($arrM[14])? $arrM[14] : '';
		
	  
	 
    $sql="INSERT INTO dailyTrans_report(bo_id,trans_desc,qty,total_charge,BO_Short_Name,Trans_Ref_No, Trans_Value,Service_Tax,ISIN_Name,Charge_Rate,Total_Amt,T_Amt_for_BO,T_Amt_for_DP,ISIN,date) 
    VALUES ('{$ai[0]}','{$ai[1]}','{$ai[2]}','{$ai[3]}','{$ai[4]}','{$ai[5]}','{$ai[6]}','{$ai[7]}','{$ai[8]}','{$ai[9]}','{$ai[10]}','{$ai[11]}','{$ai[12]}','{$ai[13]}','{$ai[14]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Daily Charge Report Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  /*---------------------------------------------------------------*/
  
  
  
   /*------------------------------------------------------------------*/
  
 /*  if($bo=="16DP71UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
         $arrM = explode('~',$cont); 
	     var_dump($arrM);
		//die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
		
		
	  
	 
    $sql="INSERT INTO tbl_aging_report(DRN,DRF,ISIN,ISIN_Short_Name,BO_ID,BO_Short_Name, Requested_Qty,Balance_Type,Setup_Date,Aging_Days) 
    VALUES ('{$ai[0]}','{$ai[1]}','{$ai[2]}','{$ai[3]}','{$ai[4]}','{$ai[5]}','{$ai[6]}','{$ai[7]}','{$ai[8]}','{$ai[10]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 <div>
	  <div style="float:left">Aging Report</div><div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div>
	</div>
	 <?php
  } */
  
  /*---------------------------------------------------------------*/

  
  
  
  if($bo=="16DP95UX.TXT"){
				
			$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
	    $ai[11] = isset($arrM[11])? $arrM[11] : '';
	    $ai[12] = isset($arrM[12])? $arrM[12] : '';
		$free_balance=$ai[8]-$ai[9];
		
	  $sqlq="SELECT * FROM investor WHERE investor_ac_number='$ai[4]'";
      $result= $dbObj->select($sqlq);
	  $ac_no=@$result[0]["dp_internal_ref_number"];
	  //die();
	  
	 
    $sql="INSERT INTO tbl_IPO(account_no,ISIN,Seq_No,trade_date,BO_ID,instrument,BO_Cate,BO_Ac_Status,Current_Bal,Lockin_Balance,avg_rate,LockIn_Exp_Date,date) 
    VALUES ('$ac_no','{$ai[0]}','{$ai[2]}','{$ai[3]}','{$ai[4]}','{$ai[1]}','{$ai[6]}','{$ai[7]}','$free_balance','{$ai[9]}','0','{$ai[11]}','{$ai[12]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">IPO Report Successfully...</span></strong></div>
	</div></br>
	 <?php
  }
  
  /*------------------------------------------------------------------*/
  
  
  
  if($bo=="17DP48UX.TXT"){
				
	$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		// die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
	    $ai[11] = isset($arrM[11])? $arrM[11] : '';
	    $ai[12] = isset($arrM[12])? $arrM[12] : '';
		$ai[13] = isset($arrM[13])? $arrM[13] : '';
		$ai[14] = isset($arrM[14])? $arrM[14] : '';
		$ai[15] = isset($arrM[15])? $arrM[15] : '';
		$ai[16] = isset($arrM[16])? $arrM[16] : '';
		$ai[17] = isset($arrM[17])? $arrM[17] : '';
		$ai[18] = isset($arrM[18])? $arrM[18] : '';
	    $payment_date = date("Y-M-d", strtotime($ai[7]));
		
	  
    $sql="INSERT INTO tbl_cash_dividend(bo_id,isin_short_name,record_date,payment_date,cash_fac_amt,tax_amount,bo_holding,net_cash)
    VALUES('{$ai[9]}','{$ai[1]}','{$ai[4]}','$payment_date','{$ai[8]}','{$ai[16]}','{$ai[18]}','{$ai[17]}')";
	//die();
	$res= $dbObj->insert($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Cash Dividend Report Successfully...</span></strong></div>
	</div></br>
	 <?php		
  }
  
  if($bo=="17DP64UX.TXT"){
				
	$content = file_get_contents($path.'/'.$bo);
			$array = explode("\n", $content);
			   // print_r($array);
			   // die();
			    foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	     //var_dump($arrM);
		 //die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
		$ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
	    $ai[6] = isset($arrM[6])? $arrM[6] : '';
	    $ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
	    $ai[11] = isset($arrM[11])? $arrM[11] : '';
	    $ai[12] = isset($arrM[12])? $arrM[12] : '';
		$ai[13] = isset($arrM[13])? $arrM[13] : '';
		$ai[14] = isset($arrM[14])? $arrM[14] : '';
		$ai[15] = isset($arrM[15])? $arrM[15] : '';
		$ai[16] = isset($arrM[16])? $arrM[16] : '';
		$ai[17] = isset($arrM[17])? $arrM[17] : '';
		$ai[18] = isset($arrM[18])? $arrM[18] : '';
	    $payment_date = date("Y-M-d", strtotime($ai[5]));
		
	 $sql_bc="SELECT * FROM tbl_ipo WHERE ISIN='$ai[0]' AND BO_ID='$ai[13]'";
     $result_bonus_check= $dbObj->select($sql_bc);
	 $Current_Bal=$result_bonus_check[0]['Current_Bal'];
	 $qty=$result_bonus_check[0]['qty'];
	 $avg_rate=$result_bonus_check[0]['avg_rate'];
	 $bonus_share=$result_bonus_check[0]['bonus_share'];
	 $total_share=$Current_Bal+$qty+$bonus_share;
	 $total_amt=$total_share*$avg_rate;
	 $update_bonus=$bonus_share+$ai[16];
	 $total_qty=$Current_Bal+$qty+$bonus_share+$ai[16];
	 $update_avg_cost=@$total_amt/$total_qty;
	 
	 
		
	 
    $sql="INSERT INTO tbl_bonus_share(isin,isin_short_name,record_date,effective_date,Cash_Fraction_Amt,bo_id,bo_holding,qty)
    VALUES('{$ai[0]}','{$ai[1]}','{$ai[4]}','$payment_date','{$ai[6]}','{$ai[13]}','{$ai[15]}','{$ai[16]}')";
	//die();
	$res= $dbObj->insert($sql);
	$sql = "update tbl_ipo set bonus_share='$update_bonus',avg_rate='$update_avg_cost' WHERE BO_ID='$ai[13]' AND ISIN='$ai[0]'";
	$dbObj->update($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }?>
	 
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Shared Dividend Report Successfully...</span></strong></div>
	</div></br>
	 <?php		
  }
  
  
  
  
  if($bo=="17DP70UX.TXT"){
				
	$content = file_get_contents($path.'/'.$bo);
	$array = explode("\n", $content);
			   // print_r($array);
			   // die();
	foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	    // var_dump($arrM);
		
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[10] = isset($arrM[10])? $arrM[10] : '';
	    $ai[14] = isset($arrM[14])? $arrM[14] : '';
	    $ai[15] = isset($arrM[15])? $arrM[15] : '';
	    $ai[16] = isset($arrM[16])? $arrM[16] : '';
	   
	  $sqls="SELECT * FROM tbl_ipo WHERE ISIN='$ai[0]' AND BO_ID='$ai[10]'";
      $result= $dbObj->select($sqls);
	  $Current_Bal=$result[0]['Current_Bal'];
	  $t_curr_bal=$Current_Bal+$ai[14];
	  $sql = "update tbl_ipo set bonus_share='{$ai[16]}',Current_Bal='$t_curr_bal' WHERE BO_ID='$ai[10]' AND ISIN='$ai[0]'";
	  $res=$dbObj->update($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }
	 ?>
	
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Corporate Process Successfully...</span></strong></div>
  </div></br>
	 <?php		
  }
  
  
  
   if($bo=="16DPB7UX.TXT"){
				
	$content = file_get_contents($path.'/'.$bo);
	$array = explode("\n", $content);
			   // print_r($array);
			   // die();
	foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	    //var_dump($arrM);
		//die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
	    $ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
	   
	  $sqls="SELECT * FROM tbl_ipo WHERE ISIN='$ai[2]' AND BO_ID='$ai[0]'";
      $result= $dbObj->select($sqls);
	  $Current_Bal=$result[0]['Current_Bal'];
	  $t_curr_bal=$Current_Bal+$ai[4];
	  $sql = "update tbl_ipo set Lockin_Balance='0.00',Current_Bal='$t_curr_bal' WHERE BO_ID='$ai[0]' AND ISIN='$ai[2]'";
	  $res=$dbObj->update($sql);
    if($res){
		//echo "success";
	}
		//echo "successfully update BO";
     }
	 ?>
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">IPO Lock Free Successfully...</span></strong></div>
  </div></br>
	 <?php		
  }
  
  
  /*------------------------------------------------------------------------*/
  
  
   if($bo=="16DP61UX.TXT"){
			
	$content = file_get_contents($path.'/'.$bo);
	$array = explode("\n", $content);
			   // print_r($array);
			   // die();
	foreach($array as $cont){ 
		        //var_dump($cont);
		         //die();
        //Make an array using comma as delimiter
        $arrM = explode('~',$cont); 
	   // var_dump($arrM);
		//die();
	    $ai[0] = isset($arrM[0])? $arrM[0] : '';
	    $ai[1] = isset($arrM[1])? $arrM[1] : '';
	    $ai[2] = isset($arrM[2])? $arrM[2] : '';
	    $ai[3] = isset($arrM[3])? $arrM[3] : '';
	    $ai[4] = isset($arrM[4])? $arrM[4] : '';
		$ai[5] = isset($arrM[5])? $arrM[5] : '';
		$ai[6] = isset($arrM[6])? $arrM[6] : '';
		$ai[7] = isset($arrM[7])? $arrM[7] : '';
		$ai[8] = isset($arrM[8])? $arrM[8] : '';
		$ai[9] = isset($arrM[9])? $arrM[9] : '';
		$ai[10] = isset($arrM[10])? $arrM[10] : '';
		$ai[11] = isset($arrM[11])? $arrM[11] : '';
		$ai[12] = isset($arrM[12])? $arrM[12] : '';
		$ai[13] = isset($arrM[13])? $arrM[13] : '';
	    $ai[14] = isset($arrM[14])? $arrM[14] : '';
		$ai[16] = isset($arrM[16])? $arrM[16] : '';
		$ai[20] = isset($arrM[20])? $arrM[20] : '';
	  $sqlq="SELECT * FROM investor WHERE investor_ac_number='$ai[4]'";
      $results= $dbObj->select($sqlq);
	  //print_r($results);
	 $ac_no=@$results[0]["dp_internal_ref_number"];
	  
	if($ai[6]="CONFIRMED" AND $ai[14]="ACCEPTED"){
		
	  $sqls="SELECT * FROM tbl_ipo WHERE ISIN='$ai[2]' AND BO_ID='$ai[4]'";
      $result= $dbObj->select($sqls);
	  //print_r($result);
	  // die();
	  if($result){
	   $Current_Bal=$result[0]['Current_Bal'];
	   $t_curr_bal=$Current_Bal+$ai[13];
	   $sql = "update tbl_ipo set Current_Bal='$t_curr_bal' WHERE BO_ID='$ai[4]' AND ISIN='$ai[2]'";
	   $res=$dbObj->update($sql);
	  }else{
		$sql="INSERT INTO tbl_IPO(account_no,ISIN,Seq_No,trade_date,BO_ID,instrument,Current_Bal,avg_rate,date) 
        VALUES ('$ac_no','{$ai[2]}','{$ai[0]}','{$ai[20]}','{$ai[4]}','{$ai[3]}','{$ai[13]}','0','{$ai[20]}')";
	  //die();
	    $res= $dbObj->insert($sql); 
	  }
	    $sql="INSERT INTO tbl_demand_share(isin,isin_short_name,bo_id,BO_Short_Name,Status,Requested_Qty,Accepted_Qty,Rejected_Qty,Balance_Type,Cert_Qty,Cert_Status,Cert_Seq_No,Date) 
        VALUES ('{$ai[2]}','{$ai[3]}','{$ai[4]}','{$ai[5]}','{$ai[6]}','{$ai[7]}','{$ai[8]}','{$ai[9]}','{$ai[10]}','{$ai[13]}','{$ai[14]}','{$ai[16]}','{$ai[20]}')";
		 $res= $dbObj->insert($sql); 	
		}
	   
     }
	 ?>
	<div style="padding-left:20px">
	 <div style="float:left"><img src="pms_doc_upload/investor_cdbl/ok.jpg"width="20" height="20"/></span></div><div style="float:left"><strong><span style="Color:green">Demat Share Successfully...</span></strong></div>
  </div></br>
	 <?php		
  }
  
  $sql="INSERT INTO tbl_CDBL(file_name,date) 
    VALUES ('$bo','$folder_name')";
	$res= $dbObj->insert($sql); 
				
}
			
    		  
	} }else{
	//echo "Folder upload fail";	
  }
	?>
<div class="contentinner content-dashboard">
 
 
  <?php

          if(@$_SESSION['in_result_data']){

            echo $_SESSION['in_result_data'];
            unset($_SESSION['in_result_data']);
          }
		  
		  
          
           if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?addInvestor" class="btn alert-info"><span class="icon-th-large"></span> All Investor </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">All Import CDBL File </h4>

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                 
                     
       	
        <div align="center">
        <form action="" method="post" enctype="multipart/form-data" class="stdform">
        <table width="45%" border="1" align="center">
  <tr>
    <td width="40%" height="33">&nbsp;</td>
    <td width="60%" height="33"><input name="timMiniFile" type="hidden" id="timMiniFile" value="<?php echo time();?>" /></td>
  </tr>
  <tr>
    <td height="50px"><strong>Uploade Your CDBL folder</strong></td>
    <td height="50px"><input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="" required /></td>
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
         