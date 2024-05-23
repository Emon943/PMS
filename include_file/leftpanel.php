<?php
require "customfunction.php";
$page=Page_Chack($mainLink);
/* echo '<pre>';
print_r($page);
echo '</pre>'; */
$array_menu=array();
?>

<div class="leftpanel">
  <div class="logopanel">
    <h1><a href="dashboard.php">PMS <span>v0.1</span></a></h1>
  </div>
  <!--logopanel--> 
  
  <!-- <div class="datewidget"></div>-->
  
  <div class="leftmenu">
    <ul class="nav nav-tabs nav-stacked">
      <li class="nav-header">Main PMS Navigation</li>
      <?php
              $db_obj->sql(Main_Module($_SESSION['LOGIN_USER']['id']));
			  $mainmenu= $db_obj->getResult();
			  $countMainModule=$db_obj->numRows();
			  
			  if($countMainModule>0){
			  
			  foreach($mainmenu as $k=>$menu):
			 
			 $db_obj->sql(Sub_Module($_SESSION['LOGIN_USER']['id'],$menu['main_menu_sl'])); 
			 $subModule=$db_obj->getResult();
				array_push($array_menu,$subModule);
				
				if($subModule){
					$dropdown="dropdown";
					$sub=true;
					}else{
						$dropdown='';
						$sub=false;
						}
				?>
      <?php
                		
							
								////Link Class Active
								
									if(Module_Chack($menu['main_menu_name'],$menu['main_menu_link'],$mainLink)){
										$class="active";
										}else{
											$class="";
											}
											
										
				?>
      <li class=" <?php echo $class." ".$dropdown;?>"><a href="<?php echo $menu['main_menu_link'];?>"><span class="<?php echo $menu['main_menu_icone'];?>"></span> <?php echo $menu['main_menu_name'];?></a>
        <?php
					
                    if($sub){
						
						 
						?>
        <ul <?php if(ActiveMenu(@$mainLink)==@$menu['main_menu_name']):?>style="display:block<?php endif;?>">
          <?php 
						//print_r($subModule);
							foreach($subModule as $subModulemenu):
						?>
          <li><a href="<?php echo $subModulemenu["sub_menu_link"];?>"><?php echo $subModulemenu["sub_menu_name"];?></a></li>
          <?php
		  endforeach;
							 
		?>
        </ul>
        <?php
						}
					
					?>
      </li>
      <?php endforeach;
				
			}else{
				
				?>
      <li class="active"> <br />
        If you have any questions please feel free to contact me at <br />
        <tt>Mobile: +8801558207445</tt> <br />
        <tt>E-mail: motiur943@gmail.com</tt> <br />
        *---------***@Md. Motiur Rahman@***---------* </li>
      <?php
				
				}
				
				?>
    </ul>
  </div>
  <!--leftmenu--> 
  
</div>
<!--mainleft--> 

