<br>
<div>
<h4 class="widgettitle">High Net Worth Customer</h4>
  <form action="high_net_worth_customer.php" target="_blank" method="post" enctype="multipart/form-data" >
	 <label for="pwd">As On:</label>
     <input type="date" id="as_on" name="as_on"><br/><br/>
	 <label for="email">Branch:</label>
    <select name="branch_id" id="branch_id">
	<?php
	 $sql="SELECT * FROM `branch_list`";			
	 $db_obj->sql($sql);
	 $branch_list=$db_obj->getResult();
	
						
	foreach($branch_list as $branch){
	?>
    <option value="<?php echo $branch['name'];?>"><?php echo $branch['name']; ?></option>
	 <?php
	}
	?>
	</select>
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