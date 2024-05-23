
<h4 class="widgettitle" style="text-align: center;">Email Send Process</h4>
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
<form class="stdform" action="mail_process_generate.php" method="post">
<div class="table-wrapper-scroll-y my-custom-scrollbar">
  <table class="table table-bordered table-striped mb-0">
    <thead>
	<p><strong>To:</strong></p>
      <tr>
        <th>Is Select</th>
        <th scope="col">A/C Number</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
      </tr>
    </thead>
	<?php
    $sql="SELECT * FROM investor INNER JOIN investor_personal ON investor_personal.investor_id = investor.investor_id where status=0 ORDER BY investor.dp_internal_ref_number ASC";
	$db_obj->sql($sql);
    $investor=$db_obj->getResult();
		 
	?>
    <tbody>
	
	<?php
	
	for($i=0; $i<count($investor); $i++){
	 $ac_no=$investor[$i]['dp_internal_ref_number'];
	 $investor_name=$investor[$i]['investor_name'];
	 $email=$investor[$i]['email'];
		
		?>
      <tr>
	  <td><input type="checkbox" name="check[ ]" class="cb-element" multiple="multiple" value="<?php echo $ac_no;?>"></td>
        
        <td><?php echo $ac_no;?></td>
        <td><?php echo $investor_name;?></td>
		<td><?php echo $email;?></td>
		
      </tr>
<?php } ?>
    </tbody>
  </table>
</div>
<br>

<div style="padding-left:10px">
        <input style="padding-left:10px" type="button" class="box btn btn-default mb-3" id="box" value="check all" />
 </div>

<br>

    <div style="padding-left:10px">
        <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td width="145" height="33"><strong>Select Template</strong></td>
                <td width="500">
                    <select style="width: 35%" class="form-control" name="temp_id" id="temp_id">
                        <option value="">------Select Template------</option> 
                        <?php
                            $sql="SELECT * FROM `email_template`";
                            $db_obj->sql($sql);
                            $mail_template=$db_obj->getResult();
                            foreach($mail_template as $mail_temp){?>
                                <option value="<?php echo $mail_temp['id'];?>"><?php echo $mail_temp['tem_name']; ?></option>
                                <?php
                            }
                        ?>
        
                    </select>
                </td>
            </tr>
            <tr>
                <td width="145" height="33"><strong>Mail Subject</strong></td>
                <td width="500"><input type="text" name="mail_sub" id="mail_sub"  required/></td>
            </tr>
            <tr>
                <td height="31"><strong>Description</strong></td>
                <td width="500">
                    <div id="desc">
                        <textarea name="temp_desc" id="temp_desc"></textarea>
                    </div>
                    <div id="tem_d" style="text-align:justify; background:#fff; padding:5px;"></div>
                </td>
            </tr>
        </table>
    </div>

 <div style="padding-left:10px">
 <button style="padding-left:10px" type="submit" name="submit_ins" class="btn btn-default" onclick="return confirmation()">Send Mail</button>
 </div>
</form>

<script type="text/javascript">
    function confirmation() {
      return confirm('Are you sure you want to post this fee?');
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
  // Check and Uncheck All With Single Button
        $("#box").click(function() {
            if ($("#box").val() == "check all") {
                $(".cb-element").prop("checked", true);
                $("#box").val("uncheck all");
            } else if ($("#box").val() == "uncheck all") {
                $(".cb-element").prop("checked", false);
                $("#box").val("check all");
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#temp_id').change(function(){
            var temid = $("#temp_id").val();

            if(temid == ''){
                $("#mail_sub").val('');
                document.getElementById("tem_d").style.display = "none";
                document.getElementById("desc").style.display = "block";
            }

            else{
                document.getElementById("desc").style.display = "none";
                document.getElementById("tem_d").style.display = "block";
               $.ajax({
                    type:'post',
                    url: "ajax/mail_temp.php",
                    dataType: 'Json',
                    data: {'id':temid},
                    success: function(data) {
                        $("#mail_sub").val('');
                        $("#tem_d").val('');
                        $.each(data, function(key, value) {
                            $("#mail_sub").val(value.tem_name);
                            var codeBlock = value.tem_desc;
                            document.getElementById("tem_d").innerHTML = codeBlock;
                        });
                    }
                }); 
            }

        });
     
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://cdn.tiny.cloud/1/vwuhv1g4lnn0tykppxxjjjrm8bx0rcktagf6ijstunk44fsk/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">
    tinymce.init({
        selector: '#temp_desc',
        forced_root_block : ""
      });
</script>