<br>
<div>
  <form action="purchase_power.php" target="_blank" method="post" enctype="multipart/form-data" >
	 <label for="pwd">As On:</label>
    <input type="date" id="as_on" name="as_on" required ><br/><br/>
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