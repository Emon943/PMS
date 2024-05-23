<h4 class="widgettitle" style="text-align: center;">Email Template setup</h4>
<br>
<form class="stdform" action="" method="post">
	<table style="margin-left:10px" width="783" border="0" align="center"  cellspacing="0">

		<tr>
			<td width="145" height="33"><strong>Template Name</strong></td>
			<td width="500"><input type="text" name="tem_name"  required/></td>
		</tr>
		<tr>
			<td height="31"><strong>Description</strong></td>
			<td width="500"><textarea id="tem_des" name="tem_desc"></textarea></td>
		</tr>
		<tr>
			<td>
				<button class="btn btn-primary" name="submit_tem">Submit</button>
				<button type="reset" class="btn">Reset Form</button>
			</td>
		</tr>
	</table>		
</form>

<?php
	if(isset($_POST["submit_tem"])){

		$tem_name = $_POST['tem_name'];
		$tem_desc = $_POST['tem_desc'];
		$description = str_replace("'", "\'", $tem_desc);

		$sql = "INSERT INTO email_template (tem_name, tem_desc)
				VALUES ('$tem_name', '$description')";
		$dbObj->insert($sql);

        $_SESSION['in_result_data']="<h3 align='center'>Data Insert Success Full...<h3>";
        $db_obj->disconnect();
		echo'<script>window.location="crm.php?email_template";</script>'; 
        exit();

    }
?>

<script src="https://cdn.tiny.cloud/1/vwuhv1g4lnn0tykppxxjjjrm8bx0rcktagf6ijstunk44fsk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
	tinymce.init({
        selector: '#tem_des',
        forced_root_block : ""
      });
</script>