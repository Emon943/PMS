
<br/>
<div class="container">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   Period:   <label for="pwd">From:</label>
    <input type="date" id="fromdate" name="fromdate">
	 <label for="pwd">To:</label>
    <input type="date" id="todate" name="todate"><br/><br/>
	
	 <label for="email">Branch:</label>
    <select name="branch_id" id="branch_id" requried=""/>
	<option value="">Select Branch</option>
	<?php
	 $sql="SELECT * FROM `branch_list`";			
	 $db_obj->sql($sql);
	 $branch_list=$db_obj->getResult();
	
						
	foreach($branch_list as $branch){
	?>
    <option value="<?php echo $branch['branch_id'];?>"><?php echo $branch['name']; ?></option>
	 <?php
	}
	?>
	</select>
   <input type="button" value="View" onclick="show_rpt()">
    <div class="grid_16 clearfix" id="showrpt"></div>	
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