<?php
 if(isset($_GET['dell']) && $page['delete_status']=="Active"){
         $ipo_id=$enc->decryptIt($_GET['dell']);
         $db_obj->delete("ipo_application", "id='$ipo_id'");
		  echo "<h2 style='text-align:center; color:green'>Delete Successfully</h2>";
                     
                 $db_obj->disconnect();
		   echo "<meta http-equiv='refresh' content='1; URL=ipo.php?IPOapplication' />";
           exit();  	
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}
  

	
	//if(mysqli_query($con, $sql)){
?>

<div class="container-fluid">
<?php if($page['view_status']=="Active"):
					?>
                  <div align="right"><a href="?IPOapplication" class="btn alert-info"><span class="icon-th-large"></span>IPO Applied List</a></div>
                     <?php endif;?>
            	<h4 class="widgettitle">IPO Apply </h4>

<form id="myForm" method="post">
 <p>
 Company Name:  <select name="company_id" id="company_id" required >
	<!--<option value="">SELECT</option>-->
	<?php
	 $sql="SELECT * FROM `tbl_ipo_declaration` where status=0";
					
					 $db_obj->sql($sql);
					 $company_name=$db_obj->getResult();
					 //print_r($company_name);
					//die();
  //if($company_name){
						
	foreach($company_name as $com_name){
	?>
	
    <option value="<?php echo $com_name['inst_name'];?>"><?php echo $com_name['inst_name']; ?></option>
	 <?php
	}
	?>
 </select>
 </p>
 <p>
  Account Number:  <input type='text' name='ac_no' id='ac_no' required />
 </p>
  <input type="button" id="submitFormData" onclick="SubmitFormData();" value="Submit" />

 </form>

<br/>
	 Your data will display below..... <br />
	 ==============================<br />
	<form id="myForm" method="post">
	 <div id="results">
	    <!-- All data will display here  -->
	 </div>
 
 </form>
 
 
</div>

