<?php 
	if($page['add_status']!="Active"){
		//header("Location: ".$mainLink);
		echo'<script>window.location="'.$mainLink.'";</script>';
		return 0;
		
		}
		
if(isset($_GET["getID"])){
	$BO_ID=$enc->decryptIt($_GET["getID"]);
	
	
			$db_obj->sql("SELECT * FROM `daily_bo_holding`WHERE bo_id='".$db_obj->EString($BO_ID)."'");
			  $bo_holding=$db_obj->getResult();
			 // print_r($bo_holding);
			  //die();
			  if(!$bo_holding){
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
                  <div align="right"><a href="?viewreports" class="btn alert-info"><span class="icon-th-large"></span>ISIN Holding Report </a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">Daily BO ISIN Holding Report(DP)</h4>

    <div class="row-fluid" id="mydiv">
                
                
   	<div class="span12">
                    
                 
                     
       	
        <div align="center">
          <table width="80%" border="0">
            <tr>
              <td colspan="2" align="center"><strong>Central Depository Bangladesh Limited(CDBL)</strong><br />
                BDBL Bhaban(18th Floor)12 Karwan Bazar Dhaka 1215<br />
				<h5><strong>Daily BO-ISIN Holding Report(DP)</strong></h5>
				<h5><strong>DP : 529000 CAPM Advisory Limited</strong></h5>
               </td>
            </tr>
            <tr>
              <td colspan="2"><hr/></td>
            </tr>
            
            <tr>
              <td height="18"><strong>BO ID:</strong> <?php echo $bo_holding[0]['bo_id'];?><p><br />
              </p></td>
			   <td height="18"><strong>BO Short Name:</strong> <?php echo $bo_holding[0]['bo_short_name'];?><p><br />
              </p></td>
			  <td height="18"><strong>DP INT. Ref. NO:</strong> <?php echo $bo_holding[0]['dp_int_ref_no'];?><p><br />
              </p></td>
			   <tr>
              <td colspan="2"><hr/></td>
            </tr>
            </tr>
            </table>
			 <table width="80%" border="0">
              <thead>
              <tr>
               	  <th width="102" class="head0">ISIN</th>
                  <th width="126" class="head1">ISIN Name</th>
                  <!--<th width="142" class="head0">Securities No.</th>-->
                  <th width="102" class="head0">Current Balance</th>
                  <th width="126" class="head1">Free Balance</th>
              </tr>
          </thead>
		   <tr>
              <td colspan="1"><hr/></td>
            </tr>
			  <?php 
			  foreach($bo_holding as $BoId_hold){ ?>
				  
            <tr>
               <td width="20%" align="center"><?php echo $BoId_hold['ISIN'];?></td>
			   <td width="20%" align="center"><?php echo $BoId_hold['ISIN_name'];?></td>
			    <td width="20%" align="center"><?php echo $BoId_hold['current_balance'];?></td>
				<td width="20%" align="center"><?php echo $BoId_hold['free_balance'];?></td>
            </tr>
            <?php } ?>
          </table>
          </form> 
        </div>

                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
            <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > </script> 
            <script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'Investor', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Investor</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<p align="right">
           <input type="button" value="Print" onclick="PrintElem('#mydiv')" />
           
           </p>
         