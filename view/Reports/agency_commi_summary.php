<br>
<div>
   <form action="agency_commi_summary.php" target="_blank" method="post" enctype="multipart/form-data" >
   Period:   <label for="pwd">From:</label>
    <input type="date" id="fromdate" name="fromdate" required="required">
	 <label for="pwd">To:</label>
    <input type="date" id="todate" name="todate" required="required"><br/><br/>
	 <br>
    <input type="submit" value="Generate">
    </form>
   </div><br>
 <div id="showrpt"></div>
<script type="text/javascript">
function show_rpt()
    {
        if($("#fromdate").val()==" "||$("#todate").val()==" ")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/bo_reg_confirmation_print_load.php",{
                fromdate:$("#fromdate").val(),
                todate:$("#todate").val(),
                ac_no:$("#ac_no").val()
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
	
	</script>