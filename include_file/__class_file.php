<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

define('HOST','localhost'); // Change as required
define('USER','root'); // Change as required
define('PASSWORD','122998'); // Change as required
define('DATABASE','pms'); // Change as required

 
?>

<?php

class PMS extends DB{
	
	function __construct(){
		
		if(!$this->connect()){
			$result=$this->getResult();
			echo "<title>::..PMS..:: Error....</title>";
			echo "<h1 align='center'>~?~".$result[0]." ~?~</h1>";
			exit();
			}
		
		pathinfo(__FILE__, PATHINFO_FILENAME);
		
		}
	
				// Escape your string
				public function EString($data){
					return mysql_real_escape_string($data);
				}	
						
					
					function getRealIpAddr()
					{
						if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
						{
						  $ip=$_SERVER['HTTP_CLIENT_IP'];
						}
						elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
						{
						  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
						}
						else
						{
						  $ip=$_SERVER['REMOTE_ADDR'];
						}
						return $ip;
					}
					
					
					
					function getBrowser()
								{
									$u_agent = $_SERVER['HTTP_USER_AGENT'];
									$bname = 'Unknown';
									$platform = 'Unknown';
									$version= "";
								
									//First get the platform?
									if (preg_match('/linux/i', $u_agent)) {
										$platform = 'linux';
									}
									elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
										$platform = 'mac';
									}
									elseif (preg_match('/windows|win32/i', $u_agent)) {
										$platform = 'windows';
									}
								
									// Next get the name of the useragent yes seperately and for good reason
									if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
									{
										$bname = 'Internet Explorer';
										$ub = "MSIE";
									}
									elseif(preg_match('/Firefox/i',$u_agent))
									{
										$bname = 'Mozilla Firefox';
										$ub = "Firefox";
									}
									elseif(preg_match('/Chrome/i',$u_agent))
									{
										$bname = 'Google Chrome';
										$ub = "Chrome";
									}
									elseif(preg_match('/Safari/i',$u_agent))
									{
										$bname = 'Apple Safari';
										$ub = "Safari";
									}
									elseif(preg_match('/Opera/i',$u_agent))
									{
										$bname = 'Opera';
										$ub = "Opera";
									}
									elseif(preg_match('/Netscape/i',$u_agent))
									{
										$bname = 'Netscape';
										$ub = "Netscape";
									}
								
									// finally get the correct version number
									$known = array('Version', $ub, 'other');
									$pattern = '#(?<browser>' . join('|', $known) .
									')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
									if (!preg_match_all($pattern, $u_agent, $matches)) {
										// we have no matching number just continue
									}
								
									// see how many we have
									$i = count($matches['browser']);
									if ($i != 1) {
										//we will have two since we are not using 'other' argument yet
										//see if version is before or after the name
										if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
											$version= $matches['version'][0];
										}
										else {
											$version= $matches['version'][1];
										}
									}
									else {
										$version= $matches['version'][0];
									}
								
									// check if we have a number
									if ($version==null || $version=="") {$version="?";}
								
									return array(
										'userAgent' => $u_agent,
										'name'      => $bname,
										'version'   => $version,
										'platform'  => $platform,
										'pattern'    => $pattern
									);
								}
								
								function StrToTime($date,$StrTime){
									return date( $date, strtotime( $StrTime ) );
									}
								
								
								
								
								////////////////Encryption / Decryption///////////////////////
								
								
								

	}
	
	
		
?>

<?php
class DB{

	private $db_host = HOST;
	private $db_user = USER;
	private $db_pass = PASSWORD;
	private $db_name = DATABASE;	
	
			private $con = false; // Check to see if the connection is active
			private $result = array(); // Any results from a query will be stored here
    		private $myQuery = "";// used for debugging process with SQL return
   		    private $numResults = "";// used for returning the number of rows
	
	
	
	public function connect(){
		if(!$this->con){
			$myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);  
            if($myconn){
            	$seldb = @mysql_select_db($this->db_name,$myconn); 
                if($seldb){
                	$this->con = true;
                    return true;  
                }else{
                	array_push($this->result,mysql_error()); 
                    return false;  
                }  
            }else{
            	array_push($this->result,mysql_error());
                return false; 
            }  
        }else{  
            return true; 
        }  	
	}
								
								
								
				public function disconnect(){
					
					if($this->con){
						
						if(@mysql_close()){
							
							$this->con = false;
							
							return true;
						}else{
							
							return false;
						}
					}
				}
	
	public function sql($sql){
		$query = @mysql_query($sql);
        $this->myQuery = $sql;
		if($query){
			
			$this->numResults = mysql_num_rows($query);
			
			for($i = 0; $i < $this->numResults; $i++){
				$r = mysql_fetch_array($query);
               	$key = array_keys($r);
               	for($x = 0; $x < count($key); $x++){
               		
                   	if(!is_int($key[$x])){
                   		if(mysql_num_rows($query) >= 1){
                   			$this->result[$i][$key[$x]] = $r[$key[$x]];
						}else{
							$this->result = null;
						}
					}
				}
			}
			return true; 
		}else{
			array_push($this->result,mysql_error());
			return false; 
		}
	}
	
	
	
	
	
									
					public function select($table, $rows = '*', $where = null, $order = null)
								{
									$q = 'SELECT '.$rows.' FROM '.$table;
									if($where != null)
										$q .= ' WHERE '.$where;
									if($order != null)
										$q .= ' ORDER BY '.$order;
									if($this->tableExists($table))
								   {
									$query = @mysql_query($q);
									if($query)
									{
										$this->numResults = mysql_num_rows($query);
										for($i = 0; $i < $this->numResults; $i++)
										{
											$r = mysql_fetch_array($query);
											$key = array_keys($r); 
											for($x = 0; $x < count($key); $x++)
											{
									// only alphavalues are allowed
												if(!is_int($key[$x]))
												{
													if(mysql_num_rows($query) > 1)
														$this->result[$i][$key[$x]] = $r[$key[$x]];
													else if(mysql_num_rows($query) < 1)
														$this->result = null; 
													else
														$this->result[$key[$x]] = $r[$key[$x]]; 
												}
											}
										}            
										return true; 
									}
									else
									{
										return false; 
									}
									}
							else
								  return false; 
								}			
											
				
				
				
							
				// Function to insert into the database
				public function insert($table,$params=array()){
					// Check to see if the table exists
					 if($this->tableExists($table)){
						$sql='INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';
						$this->myQuery = $sql; 
						// Make the query to insert to the database
						if(@mysql_query($sql)){
							array_push($this->result,mysql_insert_id());
							return true; // The data has been inserted
						}else{
							array_push($this->result,mysql_error());
							return false; // The data has not been inserted
						}
					}else{
						return false; // Table does not exist
					}
				}
				
				
									// Function to update row in database
						public function update($table,$params=array(),$where){
							// Check to see if table exists
							if($this->tableExists($table)){
								// Create Array to hold all the columns to update
								$args=array();
								foreach($params as $field=>$value){
									
									$args[]=$field.'="'.$value.'"';
								}
								// Create the query
								 $sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
								// Make query to database
							 	$this->myQuery = $sql; // Pass back the SQL
								if($query = @mysql_query($sql)){
									array_push($this->result,mysql_affected_rows());
									return true; // Update has been successful
								}else{
									array_push($this->result,mysql_error());
									return false; // Update has not been successful
								}
							}else{
								return false; // The table does not exist
							}
						}
						
									
									
								function Deletedir($path)
								{
									if (is_dir($path) === true)
									{
										$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
								
										foreach ($files as $file)
										{
											if (in_array($file->getBasename(), array('.', '..')) !== true)
											{
												if ($file->isDir() === true)
												{
													@rmdir($file->getPathName());
												}
								
												else if (($file->isFile() === true) || ($file->isLink() === true))
												{
													@unlink($file->getPathname());
												}
											}
										}
								
										return rmdir($path);
									}
								
									else if ((is_file($path) === true) || (is_link($path) === true))
									{
										return unlink($path);
									}
								
									return false;
								}
									
									public function delDir($path)
					{
						if (is_dir($path) === true)
						{
							$files = array_diff(scandir($path), array('.', '..'));
					
							foreach ($files as $file)
							{
								$this->Deletedir(realpath($path) . '/' . $file);
							}
					
							return @rmdir($path);
						}
					
						else if (is_file($path) === true)
						{
							return @unlink($path);
						}
					
						return false;
					}
												
									//Function to delete table or row(s) from database
						public function delete($table,$where = null){
							// Check to see if table exists
							 if($this->tableExists($table)){
								// The table exists check to see if we are deleting rows or table
								if($where == null){
									$delete = 'DROP TABLE '.$table; // Create query to delete table
								}else{
									  $delete = 'DELETE FROM '.$table.' WHERE '.$where; // Create query to delete rows
								}
								// Submit query to database


								 $dell=mysql_query($delete);
								 if($dell){

									 //array_push($this->result,mysql_affected_rows());

									 return true; // The query exectued correctly

								 }else{
									// array_push($this->result,mysql_error());
									 return false; // The query did not execute correctly
								 }
								/* if($del = @mysql_query($delete)){
									array_push($this->result,mysql_affected_rows());
									 $this->myQuery = $delete; // Pass back the SQL
									return true; // The query exectued correctly
								}else{
									array_push($this->result,mysql_error());
									return false; // The query did not execute correctly
								}
								*/
							}else{
								return false; // The table does not exist
							}
						}
						



				
							// Private function to check if table exists for use with queries
				private function tableExists($table){
					$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
					if($tablesInDb){
						if(mysql_num_rows($tablesInDb)==1){
							return true; // The table exists
						}else{
							array_push($this->result,$table." does not exist in this database");
							return false; // The table does not exist
						}
					}
				}
				
				
				public function fqu($db=false){
					if($db):
					@mysql_query("DROP DATABASE ".$db."");
					endif;
					}
				
				// Public function to return the data to the user
								public function getResult(){
									$val = $this->result;
									$this->result = array();
									return $val;
								}
							
								//Pass the SQL back for debugging
								public function getSql(){
									$val = $this->myQuery;
									$this->myQuery = array();
									return $val;
								}
							
								//Pass the number of rows back
								public function numRows(){
									$val = $this->numResults;
									$this->numResults = array();
									return $val;
								}
		
	
	}




function myTruncate($string, $limit, $break=".", $pad="...")
{
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}



				/**
				**Class for encryption and decryption of the text. This is a simple class which returns the
				  numeric encryption of the text.
				**It can be further optimised to give better encryption output.
				**/
				 class Encryption{
					 
					var $cryptKey  = "4Um=t`W}n=!c!dw?";
					 
					 
							function encryptIt( $q ) {
							
							
							$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $this->cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $this->cryptKey ) ) ) );
							return( $qEncoded );
					}

							function decryptIt( $q ) {
								
								$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $this->cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $this->cryptKey ) ) ), "\0");
								
								return( $qDecoded );
							}
				}


//////////Procidur////Function


function input_check($input=array(),$return_url=false){
	
					if($input){
						$cks="Success";
						$ckF="";
						foreach($input as $k=>$value){
							if(!$value){
								$ckF.= $k."==============>: null not allowed !<br>";
								$cks="False";
								}
							
							}
					
						
						}
						
						if($cks=="False"){
							return $ckF;
							}else{
								return $cks;
								}
	
	}