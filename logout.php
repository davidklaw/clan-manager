<?
	
	setcookie("cm[0]",test, time()+604800, "/");
	setcookie("cm[1]",test, time()+604800, "/");

	header("Location: $HTTP_REFERER");
	
?>