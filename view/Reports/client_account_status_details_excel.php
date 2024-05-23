<br>
<div>
<h4 class="widgettitle">Client Account Status Details Excel</h4>
 <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
	 <label for="pwd">As On:</label>
     <input type="date" id="as_on" name="as_on"><br/><br/>
	 
   <input type="radio" id="age" name="age" value="all">
  <label for="age1">All Investor</label><br>
  <input type="radio" id="age" name="age" value="1" >A/C Number :<input type="text" id="ac" name="ac">
 
	  
   <input type="button" value="View" onclick="show_rpt()">
    <div id="showrpt"></div>	
  </form>
</div><br>


 <div id="showrpt"></div>
<script type="text/javascript">
function show_rpt()
    {
        if($("#as_on").val()==" ")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/client_account_status_details_excel.php",{
                date:$("#as_on").val(),
				age:$("#age").val(),
                ac_no:$("#ac").val()
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