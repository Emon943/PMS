<?php
if(isset($_GET['dell']) && $page['delete_status']=="Active"){
    $ipo_id=$enc->decryptIt($_GET['dell']);
  
        $db_obj->delete("tbl_ipo_declaration", "id='$ipo_id'");
   	
	if(isset($_SERVER['HTTP_REFERER'])){
   // header('Location: ' . $_SERVER['HTTP_REFERER']);
   echo'<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';
	  exit();
	}
	
	echo "<h2>Please don't try manually system</h2>";
 	 exit();

}

?>

<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>   
<div class="contentinner content-dashboard">
 

<div class="row-fluid">
                
                
   	<div class="span12">
                    
                    <?php
                    if($page['add_status']=="Active"):
					?>
      <div align="right">
        <a href="?IPOdeclarationNew" class="btn btn-primary"><span class="icon-plus-sign"></span>New IPO Declaration</a>

                    
                     
      </div>
      <?php endif;?>
                     
                     
       	<table width="100%" class="table table-bordered" id="dyntable">
                   
          <thead>
              <tr>
            <th width="114" class="head0" title="Short Name">Full Name</th>
             <th width="181" class="head1" title="ISIN">Short Name</th>
              <th width="394" class="head0" title="Name">Declaration Date</th>
               <th width="225" class="head1" title="Industry">Closing Date</th>
               <th width="201" class="head1" title="Market Price">Status</th>
               <th width="157" class="head1">Action</th>
              </tr>
          </thead>
          <tbody>
                    
            <?php
					
					 $sql="SELECT * FROM `tbl_ipo_declaration` ORDER BY id DESC";
					
					 $db_obj->sql($sql);
					 $ipo_declaration=$db_obj->getResult();
					 
					if($ipo_declaration){
						
						foreach($ipo_declaration as $ipo_dec):
						
					?>
               <tr class="gradeX">
                  <td><?php echo $ipo_dec['inst_name'];?></td>
                  <td><?php echo $ipo_dec['short_name'];?></td>
                  <td><?php echo $ipo_dec['dec_date'];?></td>
                  <td class="center"><?php echo $ipo_dec['close_date'];?></td>
                  <td class="center"><?php
				  if($ipo_dec['status']==0){
					 echo "Panding";
				   }else{
					   echo "Close";
				   }
				   
				  ?></td>
                  <td><?php
                    if($page['edit_status']=="Active"):
					?>
                   <a href="ipo.php?IPOdeclarationEdit&getID=<?php echo urlencode($enc->encryptIt($ipo_dec['id']));?>" class="btn" title="Update Data"><span class=" icon-edit"></span></a>
                            
					<?php endif;
					 if($page['delete_status']=="Active"):
					?>
                    <a href="<?php echo $_SERVER['REQUEST_URI']?>&dell=<?php echo urlencode($enc->encryptIt($ipo_dec['id']));?>" class="btn" title="Delete Data"><span class=" icon-trash"></span></a>
                            
                    <?php endif;?>
                            
                </td>
              </tr>
              <?php
						endforeach;
					}
						?>
                        
          </tbody>
      </table>
                       
                         
    </div><!--span8-->
                   
                
    <!--span8-->  
            
                  
  </div><!--row-fluid-->
  
 </div>
 
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
         