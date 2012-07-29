<?php

/* 

	Modifications of any kind to the kliptmedia Clan Manager code 
	are strictly prohibited. You may not alter the program code in 
	any manner, except to change paths and connection variables, if 
	necessary, or to change absolute paths for required files. You 
	may not add additional code to the kliptmedia Clan Manager.
	
	You may not distribute, sell, or reuse the program in any 
	manner. In addition, you may not use any code snippets from 
	the kliptmedia Clan Manager for any other purpose without the 
	express written consent of David Klawitter. Each download is 
	intended for one customer only.

*/

include("connect.php"); // remove when encrypting

$cm[0] = $HTTP_COOKIE_VARS["cm"][0];
$cm[1] = $HTTP_COOKIE_VARS["cm"][1];

//	
// connection()

function connection($query)
{
	global $mysqlhost;
	global $mysqllogin;
	global $mysqlpass;
	global $mysqldatab;
		
	$db = MySQL_connect($mysqlhost,$mysqllogin,$mysqlpass);
		if (!$db) {	echo("Connection to database failed.");	}
		if (!MySQL_select_db($mysqldatab)) {echo("Database connection failed.");}
		$result = mysql_query($query,$db);
		if (!$result) {	echo("Error: " . mysql_error());}
	return $result;
}

	$result = connection("SELECT cm_dir FROM settings");
	$row = mysql_fetch_array($result); extract($row);
	global $cm_dir;	

//
// StatusCheck($cm)                                         
// Function: Checks a users access level
//
function StatusCheck($cm)
{
	global $mysqlhost;
	global $mysqllogin;
	global $mysqlpass;
	global $mysqldatab;
	global $cm;
	
	MySQL_connect($mysqlhost,$mysqllogin,$mysqlpass) or die("could not connect to the MYSQL");
	MySQL_select_db($mysqldatab) or die("Could not select database");
	$loginTest = mysql_query("SELECT * FROM users WHERE user_id='$cm[0]'");
		$row = mysql_fetch_array($loginTest);
	return $row["user_type"];
			
}	
	
function Allowed( $id, $page ) 
{
	$result = connection("SELECT user_type,user_abil FROM users WHERE user_id='$id'");
	$row = mysql_fetch_array($result); extract($row);
	
	$user_abil = explode(",", $user_abil);
	
	if ( $user_type == "head admin" )
	{
		$result = "TRUE";
	}
	else {
		for($d=0; $d<8; $d++) {
			if ( $user_abil[$d] == $page )
				$result = "TRUE";
			if ( !$result )
				$result == "FALSE";
		}
	}
	
	return $result;
}

//
// ChangeDate($date)                                         
// Function: Changes the MySQL format of a date to standard. 
//        ex. 2003-01-30  ->  1/30/03                        
//
function ChangeDate($date_string)
{
	if (ereg("([0-9]{1,2}).([0-9]{1,2}).([0-9]{4})", $date_string, $regs))
	{ $new_date_string = $regs[2]."-".$regs[3]."-".$regs[1]; }
	if (ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $date_string, $regs))
	{ $new_date_string = $regs[2]."/".$regs[3]."/".$regs[1]; }
	return($new_date_string);
}

		

function login()
{
	global $cm;
	
	$result = connection("SELECT user_pass FROM users WHERE user_name='$username'");
	$row = mysql_fetch_array($result); extract($row);
	
	$pass = crypt(md5($cm[1]), md5($cm[1]));
		
	if ( $pass == $user_pass ) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

//
// logintest($cm)                                         
// Function: Makes sure someone is logged in
//
function logintest($cm)
{
	global $cm;
	
	if ( $cm ) {
		
		$result = connection("SELECT user_pass,user_id FROM users WHERE user_id='$cm[0]'");
		$row = mysql_fetch_array($result); 
	
		if ($row != NULL ) {
			extract($row);
		}
		
		$pass = crypt(md5($cm[1]), md5($cm[1]));
		
		if ( ($cm[0] == $user_id) && ($user_pass == $pass) )
			return TRUE;
		else if (( $cm[0] == "test") && ( $cm[1] == "test" ) )
			return FALSE;
		else
			return FALSE;
	}
	else
		return FALSE;
}

//
// RegisteredNum()                                         
// Function: Display number of registered users
//
function RegisteredNum()
{
	$members=0;
	$memberslist = mysql_query("SELECT * FROM users");
	while (mysql_fetch_array ($memberslist))
	{$members = $members + 1;}
	echo $members;
}

//
// UserName($ID)
// Function: Checks a person's identity given their ID #
//
function UserName($ID)
{
	$Grab = mysql_query("SELECT user_name FROM users WHERE user_id='$ID'");
	if ( $row = mysql_fetch_array($Grab) )
		extract($row);
		
	return $user_name;
}

include("funcs.php"); // remove when encrypting

?>