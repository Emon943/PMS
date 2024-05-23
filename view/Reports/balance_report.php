
<br/>
<div class="container">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
	 <label for="pwd">BO Category:</label>
	
	<select name="bo_cate" id="bo_cate" required="required">
			   <option value="">Select </option>
               <?php
                       $bcsql = "select * from tbl_bo_cate";
                       $db_obj->sql($bcsql);
					   $investor_cat_res=$db_obj->getResult();
						//print_r($investor_cat_res);
                        for ($i = 0; $i < count($investor_cat_res); $i++){ 
                            ?>
                            <option value="<?php echo $investor_cat_res[$i]["id"]; ?>">
                              <?php echo $investor_cat_res[$i]["cate_name"]; ?></option>
                        <?php } ?>
				 </select>
     
    <input type="button" value="View" onclick="show_rpt()">
     <div class="grid_16 clearfix" id="showrpt"></div>	
  </form>
</div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#bo_cate").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/balance_statement_print_load.php",{
				bo_cate:$("#bo_cate").val()
                
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