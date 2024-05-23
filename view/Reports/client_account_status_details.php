<br>
<div>
<h4 class="widgettitle">Client Account Status Details</h4>
  <form action="client_ac_status_details.php" target="_blank" method="post" enctype="multipart/form-data" >
	 <label for="pwd">As On:</label>
     <input type="date" id="as_on" name="as_on"><br/><br/>
	 
   <input type="radio" id="age1" name="age" value="all">
  <label for="age1">All Investor</label><br>
  <input type="radio" id="age2" name="age" value="1">A/C Number :<input type="text" id="ac" name="ac">
 
	  
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