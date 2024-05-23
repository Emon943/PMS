<?php 
 $start_date = date("d-m-Y");
 $c_date= date('Ymd', strtotime($start_date));
 $month_name = date('F', strtotime($start_date));
 $date = date('d M Y', strtotime($start_date));
 $date = ltrim($date, '0');
 $d=strtotime("tomorrow");
 $next_date= date("d M Y ", $d);
 $next_date = ltrim($next_date, '0');
 
 $sql="SELECT * FROM tbl_calendar WHERE month_title='$month_name'";
					
	$db_obj->sql($sql);
    $calendar=$db_obj->getResult();
	//print_r($calendar);
	
	$sql1="SELECT * FROM tbl_calendar WHERE create_date='$c_date'";		
	$db_obj->sql($sql1);
    $current_status=$db_obj->getResult();
	//print_r($current_status);
	$sql2="SELECT * FROM tbl_calendar WHERE date='$next_date'";			
	$db_obj->sql($sql2);
    $next_status=$db_obj->getResult();
	
 ?>
 
<br>
<h4 class="widgettitle" style="text-align: center;">Working Calendar List</h4>
<br>
 <style>
.my-custom-scrollbar {
position: relative;
height: 400px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

/* The container must be positioned relative: */
.custom-select {
  position: relative;
  font-family: Arial;
}

#fee{
 height:40px;   
}

#fee option{
 height:40px;   
}
</style>

  <div class="table-wrapper-scroll-y my-custom-scrollbar" id="vc">
  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th>Date</th>
        <th>Day</th>
        <th>Status</th>
		<th>Holiday</th>
		<th>Note</th>
      </tr>
    </thead>
    <tbody>
     <?php 
	if($calendar){
						
	foreach($calendar as $cal):
	 ?>
      <tr>
        <td><?php echo $cal['date'];?></td>
        <td><?php echo $cal['day'];?></td>

		  <?php if($cal['status']==0){ ?>
		 <td><?php echo "Pending";?></td>
		  <?php } ?>
		  <?php if($cal['status']==1){ ?>
		 <td><?php echo "Closed";?></td>
		  <?php } ?>
		  
		  <?php if($cal['status']==2){ ?>
		 <td style="background-color:blue"><?php echo "Open";?></td>
		  <?php } ?>
		  
		  <?php if($cal['holiday']=="Yes"){ ?>
		 <td style="background-color:red"><?php echo $cal['holiday'];?></td>
		  <?php } ?>
		  <?php if($cal['holiday']=="No"){ ?>
		 <td style="background-color:white"><?php echo $cal['holiday'];?></td>
		  <?php } ?>
		 <td><?php echo $cal['note']." ".$cal['insert_employee_id'];?></td>
		 
      </tr>
	  
       <?php
		endforeach;
		}
		?>
    </tbody>
  </table>
</div>
<div>

<?php if(@$current_status[0]['status']==2){ ?>
   <a href="calendar.php?day_end&&id=<?php echo base64_encode($date);?>" onclick="clickAndDisable(this);" class="btn" title="Update Data"><span class="icon-hand-right"></span>Day End</a> 
<?php } ?>
 
 <?php if(@$current_status[0]['status']==3){ ?>
   <a href="calendar.php?day_start&&id=<?php echo base64_encode($date);?>" onclick="clickAndDisable(this);" class="btn" title="Update Data"><span class="icon-hand-right"></span>Day Start</a> 

 <?php } 
 ?>
 <?php if(@$current_status[0]['status']==1){ ?>
  <button type="button" disabled>Day End</button>
  <button type="button" disabled>Day Start</button>

 <?php } ?>
	 


</div>
<<script>
      $(document).ready(function() {
          $('#vc').bind('cut copy', function(e) {
              e.preventDefault();
            });
        });
    </script>
<script> 
   function clickAndDisable(link) {
     // disable subsequent clicks
     link.onclick = function(event) {
        event.preventDefault();
     }
   }   
</script>
       