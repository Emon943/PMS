<script>

  $(document).ready(function() {
    $("#datepicker").datepicker();
	 $("#enddatepicker").datepicker();
  });

  </script>
  
  
 <?php 
 if(isset($_POST["submit_ins"])){
	 
	 $start_date=$_POST["startdate"];
     $end_date=$_POST["enddate"];
	 $note="Open By";
 
	$startdate_day = date('d', strtotime($start_date));
	$month_date = date('m', strtotime($start_date)); 
	$year_date = date('Y', strtotime($start_date));
	$month_name = date('F', strtotime($start_date));


	$enddate_day= date('d', strtotime($end_date));
	$month_enddate = date('m', strtotime($end_date)); 
	$year_enddate = date('Y', strtotime($end_date));

	 $months = date('m', strtotime($start_date));
	 $month = date('M', strtotime($start_date));
	 $year = date('Y', strtotime($start_date)); 
	 for($i=$startdate_day; $i<=$enddate_day; $i++){	
	 $date=$i." ".$month." ".$year;
	 $create_date=$year.$months.$i;
	 $weekday = date('l', strtotime($date));
	 $weekday;
	  $db_obj->select('tbl_calendar','*',"date='".$date."'");
        if($db_obj->numRows()!=0){

        echo "<h2 style='text-align:center; color:green'>Data  already Exist</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=calendar.php' />";
           exit();  
		}else{
		 $ins=$db_obj->insert('tbl_calendar',array('date'=>$date,
          'month_title'=>$month_name,
		  'day'=>$weekday,
          'note'=>$note,
		  'create_date'=>$create_date,
          'insert_employee_id'=>$_SESSION['LOGIN_USER']['login_id'])); 
		}	
	 }
         echo "<h2 style='text-align:center; color:green'>Calendar Setup Successfully</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=calendar.php' />";
           exit();  
		
}
 
 ?>
<h2 style="padding-left:10px">Calendar Setup Monthly</h2>
 <br/>
<div style="padding-left:10px">
<form action="" method="post">

<strong>Start Date:</strong><input type="text" name="startdate" id="datepicker"/>
<strong>End Date: </strong><input type="text" name="enddate" id="enddatepicker"/>
<strong><input type="submit" name="submit_ins" value="submit" /></strong>
</form>
</div>




        <div class="row-fluid">
                	<div class="span11"style="padding-left:20px; margin-top:50px">
                    <ul class="widgeticons row-fluid">
                       <li class="one_fifth"><a href="?working_calendar"><img src="img/gemicon/calendar.png" alt="" /><span>Working Calendar</span></a></li>
                       <li class="one_fifth"><a href="?holyday_calendar"><img src="img/gemicon/calendar.png" alt="" /><span>Holiday Calendar</span></a></li>
                            
                   </ul>
                  <br />
                        
                       
             </div><!--span8-->
                   
                   
            </div><!--row-fluid-->