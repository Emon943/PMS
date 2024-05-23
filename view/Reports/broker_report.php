
<br/>
<div class="container">
  <form id="att_form" name="att_form" method="post" enctype="multipart/form-data" >
   <label for="email">Panel Broker:</label>
    <select name="broker_id" id="broker_id" requried=""/>
	<option value="">Select panel broker</option>
	<option value="3">All</option>
	<?php
	 $sql="SELECT trace_id,name FROM `tbl_broker_hous`";
					
					 $db_obj->sql($sql);
					 $broker_house=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($broker_house as $broker){
	?>
	
    <option value="<?php echo $broker['trace_id'];?>"><?php echo $broker['name']; ?></option>
	 <?php
	}
	?>
	</select>
	
	<label for="email">Stock Exchange:</label>
    <select name="stock_id" id="stock_id" requried=""/>
	<option value="">Select stock exchange</option>
	<?php
	 $sql="SELECT * FROM `tbl_stockexchange`";			
	 $db_obj->sql($sql);
	 $stock_exchange=$db_obj->getResult();
	
						
	foreach($stock_exchange as $exchange){
	?>
    <option value="<?php echo $exchange['stock_id'];?>"><?php echo $exchange['stock_name']; ?></option>
	 <?php
	}
	?>
	</select><br/><br/>
    <label for="email">Report Name:</label>
    <select name="report_id" id="report_id" requried=""/>
	<option value="">select report name</option>
	<option value="1">Broker CNS</option> 
	<option value="2">Broker Trade Status</option>
	</select>
    <label for="pwd">As On:</label>
    <input type="date" id="date" name="date">
   <input type="button" value="View" onclick="show_rpt()">
    <div class="grid_16 clearfix" id="showrpt"></div>	
  </form>
</div>


<script type="text/javascript">
function show_rpt()
    {
        if($("#broker_id").val()==""||$("#stock_id").val()==""||$("#report_id").val()==""||$("#date").val()=="")
        {
            alert ('Please Select All Drop Down Box  ..');
        }
        else
        {
            $("#showrpt").html('');
            $("#showrpt").append("<div id='div_loader'><img src='img/fb_loader.gif' /></div>");
            $.post("report_action_load/broker_report_print_load.php",{
                broker_id:$("#broker_id").val(),
                stock_id:$("#stock_id").val(),
                report_id:$("#report_id").val(),
                date:$("#date").val()
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