<? 
	session_start();
	
	//	
	// connection()
	//
	function connection($query)
	{
		include("connect.php");
		$db = MySQL_connect($mysqlhost,$mysqllogin,$mysqlpass);
			if (!$db) {	echo("Connection to database failed.");	}
			if (!MySQL_select_db($mysqldatab)) {echo("Database connection failed.");}
			$result = mysql_query($query,$db);
			if (!$result) {	echo("Error: " . mysql_error());}
		return $result;
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

	$resultw = connection("SELECT * FROM settings");
	$roww = mysql_fetch_array($resultw); extract($roww);
	
	if ( logintest($cm) == TRUE || $force_register == "N" ) 
	{
		
		if ( $fileid ) 
		{
			$resulty = connection("SELECT * FROM files WHERE file_id='$fileid'");
			$rowy = mysql_fetch_array($resulty); extract($rowy);
			
			$file_downloads++;
			
			$resultx = connection("UPDATE files SET
				file_downloads='$file_downloads' WHERE file_id='$file_id'");
			
			if ( $file_external == null )	
			{
				$location = "files/".$file_name;
			}
			else
				$location = $file_external;
		}
	
		else if ( $demoid )
		{
			$resulti = connection("SELECT * FROM demos WHERE demo_id='$demoid'");
			$rowi = mysql_fetch_array($resulti); extract($rowi);
	
			$demo_downloads++;
			
			$resultx = connection("UPDATE demos SET
				demo_downloads='$demo_downloads' WHERE demo_id='$demo_id'");
	
			$location = "files/demos/".$demo_file;
		}
	
		header("Location: $location");

		exit;
	}
	else {
		echo "<br><br><center><font face='verdana, arial' size=1>You must be logged in to download.</font></center>";
	}	

?>