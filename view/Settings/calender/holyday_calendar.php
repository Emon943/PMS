 <?php

if(isset($_GET['dell'])){
    $id=$enc->decryptIt($_GET['dell']);
           
		   $sql="UPDATE tbl_calendar SET `status`=0,`holiday`='No',`note`='Open By',`active`=0 WHERE `id`='$id'";
           $result=@mysql_query($sql);
			 
		   echo "<h2 style='text-align:center; color:green'>Holyday Delete Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=calendar.php?holyday_calendar' />";
           exit();

}

?>
 
 <?php
 if(isset($_POST["updateInv"])){
		    $Fri=$_POST["Fri"];	
		    $Satur=$_POST["Satur"];
           
		   $sql="UPDATE tbl_calendar SET `status`=1,`holiday`='Yes',`note`='Weekend Close By' WHERE `day`='$Fri' OR `day`='$Satur'";
           $result=@mysql_query($sql);
			 
		   echo "<h2 style='text-align:center; color:green'>Holyday Weekend Setup Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=calendar.php?holyday_calendar'/>";
           exit();
							  
	}
	
	if(isset($_POST["submit"])){
		    $date=$_POST["date"];
            $date = date('d M Y', strtotime($date));
            $date = ltrim($date, '0');			
		    $note=$_POST["note"];
			$active=$_POST["active"];
		   $sql1="UPDATE tbl_calendar SET `status`='1',`holiday`='Yes',`note`='$note',`active`='$active' WHERE `date`='$date'";
           $result=@mysql_query($sql1);
			 
		   echo "<h2 style='text-align:center; color:green'>Public Holyday Setup Successfully</h2>";
                     
                 $db_obj->disconnect();
		  echo "<meta http-equiv='refresh' content='1;URL=calendar.php?holyday_calendar'/>";
           exit();
							  
	}
	?>
 
 
 <div align="center">
 <h3>Holyday Calendar</h3>
 <p>Weekend</p>
 <hr>
<form action="" method="post">
  <input type="checkbox" name="vehicle" value="Sunday"><strong> Sunday</strong>   
  <input type="checkbox" name="vehicle" value="Monday" ><strong> Monday </strong>
  <input type="checkbox" name="vehicle" value="Tuesday"><strong> Tuesday  </strong>
  <input type="checkbox" name="vehicle" value="Wednesday" ><strong> Wednesday</strong> 	<br>
  <input type="checkbox" name="vehicle" value="Thursday"> <strong> Thursday </strong>
  <input type="checkbox" name="Fri" value="Friday" checked><strong> Friday</strong>
  <input type="checkbox" name="Satur" value="Saturday" checked><strong> Saturday </strong><br><br>
  <input type="submit" name="updateInv" value="Save">
</form> 
</div>
<hr>

<div class="container">
  <h2 style="padding-left:50px">Add New Holyday</h2>
  <br/>
  <form class="form-horizontal" action="" method="post">

    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Day Off:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="datepicker" name="date">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Note:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="note" placeholder="Write Note" name="note">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="pwd"></label>
      <div class="col-sm-10">          
        <input type="checkbox" name="active" value="1" checked ><strong> Is Active</strong>   
      </div>
    </div>
	
    <br>
    <div class="form-group" style="padding-left:50px">     
      <div class="col-sm-offset-3 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Save</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to delete this?');
    }
</script>
<br>
<h4 class="widgettitle" style="text-align: center;">Public Holyday List</h4>
<br>
 <style>
.my-custom-scrollbar {
position: relative;
height: 300px;
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

  <div class="table-wrapper-scroll-y my-custom-scrollbar">
  <table class="table table-bordered table-striped mb-0">

    <thead>
      <tr>
        <th>Date</th>
        <th>Active</th>
        <th>Note</th>
		<th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php
	$sql="SELECT * FROM tbl_calendar WHERE active='1' ORDER BY id DESC";
					
	$db_obj->sql($sql);
    $holiday_calendar=$db_obj->getResult();
	if($holiday_calendar){
						
	foreach($holiday_calendar as $holy_cal):
	 ?>
	
      <tr>
        <td><?php echo $holy_cal['date'];?></td>
        <td><?php if($holy_cal['active']==1){
			  echo "True";
		}else{
			 echo "False";
		  } ?></td>
        <td><?php echo $holy_cal['note'];?></td>
		<td>
                    <a href="calendar.php?holyday_update&getID=<?php echo urlencode($enc->encryptIt($holy_cal['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($holy_cal['id']));?>" onclick="return confirmation()" class="btn" title="Delete Data"><span class="  icon-trash"></span></a>
                            
                    
                  </td>
      </tr>
      <?php
		endforeach;
		}
		?>
    </tbody>
  </table>
</div>