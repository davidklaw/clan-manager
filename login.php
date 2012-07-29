<?
	
	include('connect.php');
	
	MySQL_connect($mysqlhost,$mysqllogin,$mysqlpass) or die("could not connect to the MYSQL");
	MySQL_select_db($mysqldatab) or die("Could not select database");
	
	$login_test = mysql_query("SELECT user_id,user_pass,user_name FROM users WHERE user_name='$HTTP_POST_VARS[username]'");

	if ($row = mysql_fetch_array($login_test))
		extract($row);
	
	$pass = crypt(md5($HTTP_POST_VARS['password']), md5($HTTP_POST_VARS['password']));
	
	if ( ( $user_name == $HTTP_POST_VARS['username'] ) && ( $pass == $user_pass ) ) {
		
		setcookie("tempcookie","test", time()+604800, "/");
		
		if ( $HTTP_COOKIE_VARS["tempcookie"] != "test") {	
			session_register("cm");
			$_SESSION['cm'][0] = $user_id;
			$_SESSION['cm'][1] = $HTTP_POST_VARS['password'];
		}
		else {
			setcookie("cm[0]",$user_id, time()+604800, "/");
			setcookie("cm[1]",$HTTP_POST_VARS['password'], time()+604800, "/");
		}
	}

	header("Location: $HTTP_REFERER");

?>