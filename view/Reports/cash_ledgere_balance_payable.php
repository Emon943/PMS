
<br/>
<div class="container">
   <form action="cash_ledgere_balance_payable.php" target="_blank" method="post" enctype="multipart/form-data">
    <label for="pwd">Date:</label>
    <input type="date" id="as_on" name="as_on" required >
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
	</select><br><br>
	<!--<label for="email">Agency:</label>
    <select name="agency_id" id="agency_id">
	<option value="">SELECT</option> 
      <?php
	 //$sql="SELECT * FROM `tbl_agency_setup`";
					
					 //$db_obj->sql($sql);
					 //$agency_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	//foreach($agency_name as $agency){
	?>
	
    <option value="<?php //echo $agency['id'];?>"><?php //echo $agency['name']; ?></option>
	 <?php
	//}
	
	?>
	</select>-->
	<label for="email">A/C Type:</label>
    <select name="bo_cate" id="bo_cate">
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