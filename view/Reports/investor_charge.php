<br>
<div>
  <form action="investor_charge.php" target="_blank" method="post" enctype="multipart/form-data" >
	 <label for="pwd">As On:</label>
    <input type="text" id="as_on" name="as_on" value="<?php echo date("d-m-Y");?>"  readonly ><br/><br/>
	 <label for="email">A/C Number:</label>
     <input type="text" id="ac" name="ac">
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