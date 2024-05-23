
<h4 class="widgettitle">CDBL Reconciliation Summary</h4>
<br/>
<div class="container">
   <form action="cdbl_reconciliation_summary.php" target="_blank" method="post" enctype="multipart/form-data">
    <label for="pwd">Date:</label>
    <input type="date" id="as_no" name="as_no">
   <input type="submit" value="Generate">
  </form>
</div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#fromdate").val()==""||$("#todate").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/income_statement_print_load.php",{
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