<br/>
<div>
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   As On:   <label for="pwd"></label>
    <input type="date" id="fromdate" name="fromdate">
	
	 <label for="email">A/C Number:</label>
     <input type="text" id="ac_no" name="ac_no">
   <input type="button" value="View" onclick="show_rpt()">	
  </form>
</div><br>
 <div id="showrpt"></div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#fromdate").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/client_exposure_print_load.php",{
                fromdate:$("#fromdate").val(),
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