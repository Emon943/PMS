<?php
 include("../include_file/__class_file.php");
 $db_obj=new PMS;
 
$ac_no=@$_POST["ac_no"];
$fromdate=@$_POST["fromdate"];

if($ac_no){
 $db_obj->sql("SELECT dp_internal_ref_number,investor_name,total_balance FROM investor_group INNER JOIN investor ON investor.investor_group_id = investor_group.investor_group_id where dp_internal_ref_number='$ac_no'");
 $ac_type=$db_obj->getResult();
  //print_r($ac_type);
}
else{
  
 $db_obj->sql("SELECT dp_internal_ref_number,investor_name,total_balance FROM investor_group INNER JOIN investor ON investor.investor_group_id = investor_group.investor_group_id where loan_applicable='Yes'");
 $ac_type=$db_obj->getResult();
}

?>
 

 <?php 
 if($ac_type){

 ?>
<br>
	<div style="border-bottom: 2px solid; border-bottom-style:solid;">
	<h5 style="float:right;font-size: 12px; font-weight:bold;">Client Exprosure Statement</h5>
	</div>
	<div style="font-size: 12px; font-weight:bold; margin-bottom: 2px;">
		<!--        <h6 class="report_title" style="text-align: center; padding: 10px;">Admit Card</h6>-->
		<!--<h6>Student ID: <?php /*echo $student['TBL35_REGISTRATION_NUMBER'];*/?></h6>-->
	<p style="font-size: 12px; font-weight:bold;">Date: <?php echo $fromdate; ?>     &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;   A/C No: <?php if($ac_no){
		echo $ac_no;}else{
			echo "All";
		} ?></p>
 
	</div>		
           
					    
    <table id="example" class="display" style="width:100%; text-align:center">
     <thead>
    <tr>
      <th scope="col">Account Number</th>
	  <th scope="col">Investor Name</th>
      <th scope="col">Ledger Balance</th>
      <th scope="col">Total Equity</th>
      <th scope="col">Market Value</th>
	   <th scope="col">Debt Equity Ratio(%)</th>
	   <th scope="col">Exprosure(%)</th>
	    <th scope="col">Status</th>
    </tr>
  </thead>
	
  <tbody>
									
    <?php 
								   
	 foreach($ac_type as $margin){
		 
	  $dp_internal_ref_number=$margin['dp_internal_ref_number'];
	  $investor_name=$margin['investor_name'];
	  $Avai_balance=$margin['total_balance'];
	  $db_obj->sql("SELECT account_no,SUM(market_val)as market_val FROM tbl_ipo WHERE account_no='".$db_obj->EString($dp_internal_ref_number)."'");
      $resultp=$db_obj->getResult();
	   //print_r($resultp);
	 $account_no=@$resultp[0]['account_no'];
	
	if($account_no){
	$market_val=@$resultp[0]['market_val'];
   $total_equity=$Avai_balance+$market_val;
	
	 if($Avai_balance < 0){
	    $debit_ratio=($total_equity/$Avai_balance)*100;
		$debit_ratio=(abs($debit_ratio));
		$debit_ratio=round($debit_ratio, 2);
	 }else{
		$debit_ratio=0.00; 
	 }
	if(@$total_equity > 0){
    $loans_utilize=round(@$Avai_balance/$total_equity*100,2);
      }
	if(@$loans_utilize < 0){
   $loan_utilize=abs($loans_utilize);
   $db_obj->sql("SELECT * FROM loan_catagory_exposure");
   $loan_exploser=$db_obj->getResult(); 

 

	$exposure_from=$loan_exploser[0]['exposure_from'];
	$esposure_to=$loan_exploser[0]['esposure_to'];
	$exposure_from1=$loan_exploser[1]['exposure_from'];
	$esposure_to1=$loan_exploser[1]['esposure_to'];
	$exposure_from2=$loan_exploser[2]['exposure_from'];
	$esposure_to2=$loan_exploser[2]['esposure_to'];
	$exposure_from3=$loan_exploser[3]['exposure_from'];
	$esposure_to3=$loan_exploser[3]['esposure_to'];
	$exposure_from4=$loan_exploser[4]['exposure_from'];
	$esposure_to4=$loan_exploser[4]['esposure_to'];
	 
 if(@$loan_utilize > $exposure_from && @$loan_utilize < $esposure_to){
		 $code=$loan_exploser[0]['code'];
	 }elseif(@$loan_utilize > @$exposure_from1 && @$loan_utilize < @$esposure_to1){
		 $code=$loan_exploser[1]['code'];
	 }elseif(@$loan_utilize > $exposure_from2 && $loan_utilize < $esposure_to2){
		 $code=$loan_exploser[2]['code'];
	 }elseif(@$loan_utilize > $exposure_from3 && $loan_utilize < $esposure_to3){
		 $code=$loan_exploser[3]['code'];
	 }elseif(@$loan_utilize > $exposure_from4){
		$code=$loan_exploser[4]['code']; 
	 }
  }else{
	 $loan_utilize="0.00";
	 $code="N/A";
  } 
	 
								   
?>
                                      
                                    <tr>
							
                                        <td scope="row"><?php echo $dp_internal_ref_number;?></td>
										<td><?php echo $investor_name;?></td>
                                        <td><?php echo $Avai_balance;?></td>
										<td><?php echo $total_equity;?></td>
										<td><?php echo $market_val;?></td>
										<td><?php echo $debit_ratio;?></td>
										<td><?php echo $loan_utilize;?></td>
                                        <td><?php echo $code;?></td>
                                        
                                    </tr>
									
							   <?php }  } ?>
                                 	
                            </tbody>
							
                        </table>
		
	<?php }else{ ?>
		<h2 style="Color:red">Result Not Found</h2>
		 
	<?php } ?>



<script>
//var today = new Date();
//var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var title = 'CAPM Advisory Limited' + '\n' + 'Tower Hamlet(9th floor),' + '\n' + '16 Kamal Ataturk Avenue,Banani C/A'+ '\n' +'Dhaka-1213,Bangladesh.'+ '\n' + 'Client Exprosure Statement';
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', footer: true, title: title, filename: 'Client Exprosure Statement',  messageTop: "<?php echo"To Date: ".$fromdate."          " . "A/C NO: ".$ac_no."      "."Report Date: ".date("d-M-Y"); ?>" },
            { extend: 'pdfHtml5', footer: true, title: title, filename: 'Client Exprosure Statement',  messageTop: "<?php echo"From Date: ".$fromdate."          " . "A/C NO: ".$ac_no."      "."Report Date: ".date("d-M-Y"); ?>",
			messageBottom: 'Contact us | Tel: 02-9822391-2 | Fax: 02-9822393 | Web: www.capmadvisorybd.com',
			customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
						width:120,
						height:60,
                        alignment: 'center',
						image: 'data:image/png;base64,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'
                    } )
                }
			}
        ]
		
    } );
	
} );
</script>
