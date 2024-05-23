<?php

function Main_Module($employee){
	
	return "SELECT
	`modul_list`.`id` AS 'main_modul_id'
	, `permission`.`employer_id`
    , `modul_list`.`main_menu_sl` AS 'main_menu_sl'
    , `modul_list`.`main_menu_name`
      , `modul_list`.`main_menu_link`
    , `modul_list`.`img_icone_class` AS 'main_menu_icone'
     , `permission`.`branch_access`
    , `modul_list`.`sub_menu_sl`
    , `modul_list`.`sub_menu_name`
     , `modul_list`.`sub_menu_link`
    , `modul_list`.`sub_img_class`
    , `modul_list`.`status` AS 'main_menu_status'
    , `permission`.`add_status` 
    , `permission`.`edit_status`
    , `permission`.`delete_status`
    , `permission`.`view_status`
   
FROM
    `permission`
    INNER JOIN `modul_list` 
        ON (`permission`.`modul_id` = `modul_list`.`id`) WHERE `permission`.`employer_id`='".mysql_real_escape_string($employee)."'
        AND  `modul_list`.`status`='Active'  AND `modul_list`.`sub_menu_sl`=0 ORDER BY `modul_list`.`main_menu_sl` ASC;";
		;
	
	}
	
	
	function Sub_Module($employee,$main_menu_id){
		return "SELECT
	`modul_list`.`id` AS 'main_modul_id'
	, `permission`.`employer_id`
    , `modul_list`.`main_menu_sl` AS 'main_menu_sl'
    , `modul_list`.`main_menu_name`
      , `modul_list`.`main_menu_link`
    , `modul_list`.`img_icone_class` AS 'main_menu_icone'
     , `permission`.`branch_access`
    , `modul_list`.`sub_menu_sl`
    , `modul_list`.`sub_menu_name`
     , `modul_list`.`sub_menu_link`
    , `modul_list`.`sub_img_class`
    , `modul_list`.`status` AS 'main_menu_status'
    , `permission`.`add_status` 
    , `permission`.`edit_status`
    , `permission`.`delete_status`
    , `permission`.`view_status`
   
FROM
    `permission`
    INNER JOIN `modul_list` 
        ON (`permission`.`modul_id` = `modul_list`.`id`) WHERE `permission`.`employer_id`='".mysql_real_escape_string($employee)."'
        AND  `modul_list`.`status`='Active'  AND `modul_list`.`main_menu_sl`='".mysql_real_escape_string($main_menu_id)."'  AND `modul_list`.`sub_menu_sl`!=0;";
		}
		
		
		 function Module_Chack($mainMenu,$mainMenuLink,$subMenuLik){
			
			 $sql="SELECT COUNT(*) FROM `modul_list` WHERE `main_menu_name`='".mysql_real_escape_string($mainMenu)."' AND (`sub_menu_link`='".mysql_real_escape_string($subMenuLik)."' or main_menu_link='".mysql_real_escape_string($subMenuLik)."')";
			 $result=mysql_result(mysql_query($sql),0);
			 if($result>0){
				 return true;
				 }else{
					 return false;
					 }
			}
			
			
			function Page_Chack($main_menu_link=false){
				
				$result=array();
				
			
	$sql="SELECT
    `permission`.`modul_id`
    , `permission`.`employer_id`
    , `permission`.`add_status`
    , `permission`.`edit_status`
    , `permission`.`delete_status`
    , `permission`.`view_status`
    , `permission`.`branch_access`
    , `modul_list`.`status`
    , `modul_list`.`main_menu_link`
    , `modul_list`.`sub_menu_link`
FROM
    `permission`
    INNER JOIN `modul_list` 
        ON (`permission`.`modul_id` = `modul_list`.`id`) WHERE `modul_list`.`status`='Active' AND 
        `permission`.`employer_id`='".$_SESSION['LOGIN_USER']['id']."' AND (`modul_list`.`main_menu_link`='".mysql_real_escape_string($main_menu_link)."' or `modul_list`.`sub_menu_link`='".mysql_real_escape_string($main_menu_link)."')";
		
		$query=mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			
			$result=$row;
			}
			
			
			return $result;	
				}


////////////////////////Employee Name///////////

function employee($id){
	
	$result=@mysql_result(mysql_query("SELECT CONCAT(`login_id`,' => ',`name`) FROM `employee` WHERE `id`='".mysql_real_escape_string($id)."'"),0);
	if($result){
		return $result;
		}else{
			return false;
			}
	
	}
	//////////////////Single Result 0
	function s_result($sql){
	
	$result=@mysql_result(mysql_query($sql),0);
	if($result){
		return $result;
		}else{
			return false;
			}
	
	}
	
	
	
	/////////////permission Check per Employee Add, Edit, Delete, Branch////////////
	function permission_check($fieldName,$modul_id,$employer_id){
		$defaultResult="<i style='color:#F00;'>Inactive</i>";
	$result=@mysql_result(mysql_query("SELECT ".$fieldName." FROM `permission` WHERE `modul_id`='".mysql_real_escape_string($modul_id)."' and `employer_id`='".mysql_real_escape_string($employer_id)."'"),0);
	if($result){
				if($result=="Inactive"){
					return "Inactive";
					///<i style='color:#F00;'>Inactive</i>
					}else{
						return $result;//"<i style='color:#175103;'><strong>".."</strong></i>";
						}
		
		}else{
			return $defaultResult;
			}
	
		
		}
		
		function ActiveMenu($url){
			
			$res= @mysql_result(mysql_query("SELECT `main_menu_name` FROM `modul_list` WHERE `sub_menu_link`= '".mysql_real_escape_string($url)."' OR `main_menu_link`='".mysql_real_escape_string($url)."' LIMIT 1"),0);
			
			return $res;
			
			}
	
?>