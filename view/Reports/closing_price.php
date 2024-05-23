<br>
<div>
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
	 <label for="email">As On:</label>
     <input type="date" id="as_on" name="as_on">
   <input type="button" value="View" onclick="show_rpt()">
  </form>
</div><br>
 <div id="showrpt"></div>
<script type="text/javascript">
function show_rpt()
    {
        if($("#as_on").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/closing_price_report_print_load.php",{
                as_on:$("#as_on").val()
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