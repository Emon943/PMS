<?Php
ob_start();
require('fpdf/conso.php');
include("config.php");
 $dbObj = new DBUtility();
 require("include_file/__class_file.php");
 $broker_id=@$_POST["broker_id"];
 $fromdate=@$_POST["fromdate"];
 $todate=@$_POST["todate"];

if($broker_id){
    $sql_bname="SELECT * FROM `tbl_broker_hous`";			
	$broker_list= $dbObj->select($sql_bname);
	 $broker_name=$broker_list[0]['name'];
$sql="SELECT SUM(total_buy) as tb,SUM(total_buy_commi) as tbc,SUM(broker_buy_commi) as bbc,SUM(total_sell) as ts,SUM(total_sell_commi) as tsc,SUM(broker_sell_commi) as bsc FROM tbl_buy_sell_info WHERE broker_code='$broker_id' AND `insert_date` BETWEEN '$fromdate' AND '$todate' GROUP BY broker_code";
$buy_sell= $dbObj->select($sql);
//print_r($buy_sell);
//die();
}else{
$broker_name='All';
$sql="SELECT SUM(total_buy) as tb,SUM(total_buy_commi) as tbc,SUM(broker_buy_commi) as bbc,SUM(total_sell) as ts,SUM(total_sell_commi) as tsc,SUM(broker_sell_commi) as bsc FROM tbl_buy_sell_info WHERE `insert_date` BETWEEN '$fromdate' AND '$todate' GROUP BY broker_code";
$buy_sell= $dbObj->select($sql);
}
$pdf = new FPDF('P','mm',array(260,300));
        $pdf->PageNo();
	    $pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->AddFont('ArialNarrow','','Arialn.php');
    	$pdf->SetFont('ArialNarrow','',12);
		$pdf->Cell(0,10,'Total Client Consolidated',0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell($width_cells[0],0,'',1,0,C,true); // First header column 
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(0,10,'Period: '. date("d-M-Y", strtotime($fromdate)).' To '.date("d-M-Y", strtotime($todate)),0,0,'R');
		$pdf->Ln(3);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Write(6,'Broker Name: ');
		$pdf->SetFont('Helvetica','',9);
		$pdf->Write(6,''.$broker_name."");
		$pdf->Ln(7);
		
$width_cells=array(100,100,40);
$width_cell=array(20,20,20,20,20,20,20,20,20,20,20,20);
$pdf->SetFillColor(255,255,255); // Background color of header 
// Header starts /// 
$pdf->Cell($width_cells[0],10,'Buy',1,0,C,true); // First header column 
$pdf->Cell($width_cells[1],10,'Sale',1,0,C,true); // Second header column
$pdf->Cell($width_cells[2],10,'Income',1,1,C,true); // Second header column


$pdf->SetFont('Arial','B',8);
$pdf->Cell($width_cell[0],10,'Buy',BTL,0,'C',true); // Third header column 
$pdf->Cell($width_cell[1],10,'Commision',BT,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[2],10,'Net Amt',BT,0,'C',true); // Third header column 
$pdf->Cell($width_cell[3],10,'BrokerComm',BT,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[4],10,'HouseIncome',BTR,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[5],10,'Sale',BT,0,'C',true); // Third header column 
$pdf->Cell($width_cell[6],10,'Commision',BT,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[7],10,'Net Amt',BT,0,'C',true); // Third header column 
$pdf->Cell($width_cell[8],10,'BrokerComm',BT,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[9],10,'HouseIncome',BT,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[10],10,'Turn Over',BTL,0,'C',true); // Fourth header column
$pdf->Cell($width_cell[11],10,'HouseIncome',BTR,0,'C',true); // Fourth header column
$pdf->Ln(10);
 for($i=0; $i< count($buy_sell); $i++){
	$tb=$buy_sell[$i]['tb'];
	$tbc=$buy_sell[$i]['tbc'];
	$buy_net_amt=$tb+$tbc;
	$bbc=$buy_sell[$i]['bbc'];
	$bhouseincome=$tbc-$bbc;
	$ts=$buy_sell[$i]['ts'];
	$tsc=$buy_sell[$i]['tsc'];
	$sell_net_amt=$ts-$tsc;
	$bsc=$buy_sell[$i]['bsc'];
	$shouseincome=$tsc-$bsc;
	$total_turnover=$tb+$ts;
	$total_hincome=$shouseincome+$bhouseincome;
 
$pdf->SetFont('Arial','',8);
// First row of data 
$pdf->Cell($width_cell[0],10,number_format($tb, 2),BTL,'C',true); // Third header column 
$pdf->Cell($width_cell[1],10,number_format($tbc, 2),BT,'C',true); // Fourth header column
$pdf->Cell($width_cell[2],10,number_format($buy_net_amt, 2),BT,'C',true); // Third header column 
$pdf->Cell($width_cell[3],10,number_format($bbc, 2),BT,'C',true); // Fourth header column
$pdf->Cell($width_cell[4],10,number_format($bhouseincome, 2),BTR,'C',true); // Fourth header column
$pdf->Cell($width_cell[5],10,number_format($ts, 2),BT,'C',true); // Third header column 
$pdf->Cell($width_cell[6],10,number_format($tsc, 2),BT,'C',true); // Fourth header column
$pdf->Cell($width_cell[7],10,number_format($sell_net_amt, 2),BT,'C',true); // Third header column 
$pdf->Cell($width_cell[8],10,number_format($bsc, 2),BT,'C',true); // Fourth header column
$pdf->Cell($width_cell[9],10,number_format($shouseincome, 2),BT,'C',true); // Fourth header column
$pdf->Cell($width_cell[10],10,number_format($total_turnover, 2),BTL,'C',true); // Fourth header column
$pdf->Cell($width_cell[11],10,number_format($total_hincome, 2),BTR,'C',true); // Fourth header column
$pdf->Ln(5); 
 }
$pdf->Ln(5); 
$pdf->SetFont('Helvetica','B',8);
$pdf->Cell($width_cell[0],10,number_format($tb, 2),B,'C',true); // Third header column 
$pdf->Cell($width_cell[1],10,number_format($tbc, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[2],10,number_format($buy_net_amt, 2),B,'C',true); // Third header column 
$pdf->Cell($width_cell[3],10,number_format($bbc, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[4],10,number_format($bhouseincome, 2),BTR,'C',true); // Fourth header column
$pdf->Cell($width_cell[5],10,number_format($ts, 2),B,'C',true); // Third header column 
$pdf->Cell($width_cell[6],10,number_format($tsc, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[7],10,number_format($sell_net_amt, 2),BT,'C',true); // Third header column 
$pdf->Cell($width_cell[8],10,number_format($bsc, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[9],10,number_format($shouseincome, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[10],10,number_format($total_turnover, 2),B,'C',true); // Fourth header column
$pdf->Cell($width_cell[11],10,number_format($total_hincome, 2),B,'C',true); // Fourth header column
$pdf->Ln(5.5);
$pdf->SetFont('Helvetica','B',8);
$pdf->Write(1, '____________     __________ ____________        _________      __________ ____________     __________ ____________        _________      __________ ____________     __________');
$pdf->Ln(0.75);
$pdf->SetFont('Helvetica','B',8);
$pdf->Write(1, '____________     __________ ____________        _________      __________ ____________     __________ ____________        _________      __________ ____________     __________');
$pdf->Ln(0);
$fileName ='client_consolidated'.$broker_name.'.pdf';
$pdf->Output('download_report/'.$fileName, 'F');
ob_end_clean();
$pdf->Output();

?>