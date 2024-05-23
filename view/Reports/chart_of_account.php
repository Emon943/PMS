
<br/>
<div class="container">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   <label for="email">Financial Year:</label>
    <select name="year" id="year" requried=""/>
	<option value="2018">2018-2018</option>
	<option value="2019">2019-2019</option> 
	<option value="2020">2020-2020</option>
	</select>
	
	<label for="email">Account Type:</label>
    <select name="ac_type" id="ac_type" requried=""/>
	<option value="2018">Select All</option>
	<option value="2019">Balance Sheet</option> 
	<option value="2020">Profit & Loss</option>
	</select>
	
   <input type="button" value="View" onclick="show_rpt()">
    <div class="grid_16 clearfix" id="showrpt"></div>
  </form>
</div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#fromdate").val()==""||$("#todate").val()==""||$("#ac_no").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/client_ledger_report_print_load.php",{
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
	
	
	 function print_rpt()
    {
        URL="Print_a4_Eng_card.php?selLayer=PrintArea";
        day = new Date();
        id = day.getTime();
        eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=yes,scrollbars=yes ,location=0,statusbar=0 ,menubar=yes,resizable=1,width=880,height=600,left = 20,top = 50');");        
    }
	
	</script>