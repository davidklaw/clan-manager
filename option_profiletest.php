<?
	if ( logintest($cm) == true )
	{
		$result = connection("SELECT * FROM users WHERE user_id='$cm[0]'");
		$row = mysql_fetch_array($result); extract($row);
	}
?>