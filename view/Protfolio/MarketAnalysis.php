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

<?php

$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, "http://www.dsebd.org/mst.txt");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
$fh= fopen('test.txt', 'w+');
curl_setopt($curl, CURLOPT_STDERR, $fh );
curl_exec($curl);
fclose($fh);
curl_close($curl);
//echo file_get_contents("test.txt");
?>

<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.resize.min.js"></script>
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
      
      
                
   	
         
                    
   	<div class="span12">
                    
        			 <h4 class="widgettitle">Market </h4>
                        <div class="widgetcontent">
                            <div id="tabs2" class="tabs2">
                                <ul>
                                    <!---<li><a href="#stabs1">Market Price</a></li>--->
                                    <li><a href="#stabs2">Market Price (Tabular)</a></li>
                                    <li><a href="#stabs3">Transaction Volume</a></li>
                                    <li><a href="#stabs4">Variation</a></li>
                                    <li><a href="#stabs5">Value</a></li>
                                </ul>
                                
								<!---<div id="stabs1">
                                
                                
                                    <div class="widgetcontent">
                        	<div id="chartplace2" style="height:300px;"></div>
								</div>
                        
                        
                                </div>--->
								
                                <div id="stabs2">
                                   
                                   <div class="table-responsive">
                                   	<table width="773" class="table table-bordered" id="">
                   
          <thead>
              <tr>
               	  <th width="107" class="head0">Trading Date</th>
                  <th width="73" class="head1">Instument</th>
                  <th width="138" class="head0">Opening Price</th>
                  <th width="109" class="head0">Highest Price</th>
                  <th width="95" class="head0">Lowes Price</th>
                  <th width="111" class="head0">Chosing Price</th>
                  <th width="43" class="head0">Value</th>
                  <th width="61" class="head0">Volume</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
            $marketLastDateQUERY="SELECT `date_pricedate`, `instrument_id`,`open`,`high`,`low`,`close`,`chg_parsentage`,`trade`,`volume`,`value_mn`
FROM `market_price_dse`
WHERE `date_pricedate` = (
    SELECT MAX(`date_pricedate`)
    FROM `market_price_dse`)";
		$db_obj->sql($marketLastDateQUERY);
			$instrumentPriceD=$db_obj->getResult();
			
			foreach($instrumentPriceD as $value):
			?>
                    
              <tr class="gradeX">
                <td><?php echo $value['date_pricedate'];?></td>
                  <td><?php echo $value['instrument_id'];?></td>
                  <td><?php echo $value['open'];?></td>
                  <td><?php echo $value['high'];?></td>
                  <td><?php echo $value['low'];?></td>
                  <td><?php echo $value['close'];?></td>
                  <td><?php echo $value['trade'];?></td>
                  <td><?php echo $value['volume'];?></td>
              </tr>
             <?php endforeach;?>
                        
          </tbody>
      </table>

                      </div>             
                                   
                    </div>
                                <div id="stabs3">
                                    Your content goes here for Transaction Volume
                                </div>
                                 <div id="stabs4">
                                    Your content goes here for Variation
                                </div>
                                 <div id="stabs5">
                                    Your content goes here for Value
                                </div>
                            </div><!--#tabs-->
      
                        </div><!--widgetcontent-->           
             
    </div ><!--span8-->
       
         
       
         
         
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
            </div>
         <script type="text/javascript">
jQuery(document).ready(function(){
								
		// basic chart
		var market_1 = [[0, 2], [1, 6], [2,3], [3, 8], [4, 5], [5, 13], [6, 8]];
		//var market_2 = [[0, 5], [1, 4], [2,4], [3, 1], [4, 9], [5, 10], [6, 13]];
		
			
		function showTooltip(x, y, contents) {
			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo("body").fadeIn(200);
		}
	
			
		var plot = jQuery.plot(jQuery("#chartplace2"),
			   [ { data: market_1, label: "Market(1)", color: "#fb6409"}
			    ], {
				   series: {
					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
					   points: { show: true }
				   },
				   legend: { position: 'nw'},
				   grid: { hoverable: true, clickable: true, borderColor: '#ccc', borderWidth: 1, labelMargin: 10 },
				   yaxis: { min: 0, max: 15 }
				 });
		
		var previousPoint = null;
		jQuery("#chartplace2").bind("plothover", function (event, pos, item) {
			jQuery("#x").text(pos.x.toFixed(2));
			jQuery("#y").text(pos.y.toFixed(2));
			
			if(item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
						
					jQuery("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);
						
					showTooltip(item.pageX, item.pageY,
									item.series.label + " of " + x + " = " + y);
				}
			
			} else {
			   jQuery("#tooltip").remove();
			   previousPoint = null;            
			}
		
		});
		
		jQuery("#chartplace2").bind("plotclick", function (event, pos, item) {
			if (item) {
				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
				plot.highlight(item.series, item.datapoint);
			}
		});
});
</script>