
<?php


ob_start();
$id=($_SESSION['LOGIN_USER']['id']);
$sql="SELECT * FROM tbl_calendar Where status=2";				
$db_obj->sql($sql);
$business_date=$db_obj->getResult();
?>
<div class="headerpanel">
        	<a href="#" class="showmenu"></a>
            
            <a title="Back Page" href="javascript:history.back(1);" class="backMenu"></a>
         <!-- <a href="#"  class="notification"><img  src="img/colorbox/back.png"></a>-->
            <div class="headerright"><span style="color:white">Business Date : <?php if($business_date){
			echo $business_date[0]['date']; }?></span>
            	
               
                <!--<div class="dropdown notification">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="http://demo.themepixels.com/page.html">
                    	<span class="iconsweets-globe iconsweets-white"></span>
                    </a>
                    <ul class="dropdown-menu">
                    	<li class="nav-header">Notifications</li>
                        <li>
                        	<a href="#">
                        	<strong>3 people viewed your profile</strong><br />
                            <img src="img/thumbs/thumb1.png" alt="" />
                            <img src="img/thumbs/thumb2.png" alt="" />
                            <img src="img/thumbs/thumb3.png" alt="" />
                            </a>
                        </li>
                        <li><a href="#"><span class="icon-envelope"></span> New message from <strong>Jack</strong> <small class="muted"> - 19 hours ago</small></a></li>
                        <li><a href="#"><span class="icon-envelope"></span> New message from <strong>Daniel</strong> <small class="muted"> - 2 days ago</small></a></li>
                        <li><a href="#"><span class="icon-user"></span> <strong>Bruce</strong> is now following you <small class="muted"> - 2 days ago</small></a></li>
                        <li class="viewmore"><a href="#">View More Notifications</a></li>
                    </ul>
                </div>--><!--dropdown-->
                
    			<div class="dropdown userinfo">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><?php echo ($_SESSION['LOGIN_USER']['name']);?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
					  <li><a href="#">Business Date : <?php echo $business_date[0]['date'];?> </a></li>
						<li class="divider"></li>
                       <li><a href="Updateprofile.php?&getID=<?php echo $id;?>"><span class="icon-edit"></span> Edit Profile</a></li>
                        <li><a href="#"><span class="icon-wrench"></span> Account Settings</a></li>
                        <li><a href="#"><span class="icon-eye-open"></span> Privacy Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><span class="icon-off"></span> Sign Out</a></li>
                    </ul>
                </div><!--dropdown-->
    		
            </div><!--headerright-->
            
    	</div>
        
        <!--breadcrumbwidget-->
        <!--<div class="breadcrumbwidget">
        	<ul class="skins">
               
                <li class="fixed"><a href="#" class="skin-layout fixed"></a></li>
                <li class="wide"><a href="#" class="skin-layout wide"></a></li>
            </ul>-->
            
            <!--skins-->
        	<!--<ul class="breadcrumb">
                <li><a href="dashboard.php">Home</a> <span class="divider">/</span></li>
                <li class="active">Dashboard</li>
            </ul>
        </div>--><!--breadcrumbwidget-->