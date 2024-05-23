
<br/>
<div class="container">
   <form action="client_consolidated.php" target="_blank" method="post" enctype="multipart/form-data" >
   Period:   <label for="pwd">From:</label>
    <input type="date" id="fromdate" name="fromdate">
	 <label for="pwd">To:</label>
    <input type="date" id="todate" name="todate"><br/><br/>
	
	 <label for="email">Broker:</label>
    <select name="broker_id" id="broker_id" requried=""/>
	<option value="">Select Broker</option>
	<?php
	 $sql="SELECT * FROM `tbl_broker_hous`";			
	 $db_obj->sql($sql);
	 $broker_list=$db_obj->getResult();
	
						
	foreach($broker_list as $broker){
	?>
    <option value="<?php echo $broker['trace_id'];?>"><?php echo $broker['name']; ?></option>
	 <?php
	}
	?>
	</select>
   <input type="submit" value="Generate">
  </form>
</div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#fromdate").val()==""||$("#todate").val()==""||$("#branch_id").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/broker_commision_report_print_load.php",{
                fromdate:$("#fromdate").val(),
                todate:$("#todate").val(),
                branch_id:$("#branch_id").val()
            }, function(result){
				  //alert (result);
                if(result){
                    $('#div_loader').remove();
                       //alert (result);
                    $("#showrpt").html(result);
                } 
            });
        }
    }
	
	
	 function print_rpt()
    {
        URL="Print_a4_Eng_card.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");        
    }
	
	</script>