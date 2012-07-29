<? include("global.php"); ?>
<html>

<head>
	<title>Processing... please wait</title>
	<link rel="stylesheet" href="cm.css" type="text/css">
<?
 if ( $HTTP_POST_VARS['choice'] == null ) {
?>
	<META HTTP-EQUIV="refresh" CONTENT="5;url=../index.php" target="_top">
<?
 }
 else {
?>
	<META HTTP-EQUIV="refresh" CONTENT="5;url=index.php?option=<?=$choice?>" target="_top">
<?
	}
?>
</head>

<body>
<center><br><br><br>
<font face=verdana>

<?

ini_set("max_execution_time", "11000");
ini_set("upload_max_filesize", "40MB");
ini_set("file_uploads", "1");
ini_set("post_max_size", "38MB");
ini_set("memory_limit", "64M");


//**************************************************************************//
$cm[0] = $HTTP_COOKIE_VARS["cm"][0];
$cm[1] = $HTTP_COOKIE_VARS["cm"][1];

if ( $HTTP_POST_VARS['perform'] == "Register" )
{
	$required_fields = explode(",", $HTTP_POST_VARS['required'] );
		
	$error = 0; 
	foreach($required_fields as $fieldname) {  // check for blank fields
		if ( $HTTP_POST_VARS[$fieldname] == "") {
    	$error++;
    }
	}
	
	if ( $error == 0 ) {
		
		//check for existing email or username
		$result = connection("SELECT user_email FROM users WHERE user_email='$HTTP_POST_VARS[user_email]'");
		if ( $row = mysql_fetch_array($result)) {
			extract($row); $check_email = $HTTP_POST_VARS['user_email']; 
		}
		
		$result2 = connection("SELECT user_name FROM users WHERE user_name='$HTTP_POST_VARS[$user_name]'");
		if ($row2 = mysql_fetch_array($result2)) {
		  extract($row2); $check_name = $HTTP_POST_VARS['user_name']; 
		}
		
		if ( ( $check_email == NULL ) && ( $check_name == NULL ) ) {
			
			$user_id = uniqid("ID");
			
			$resultb = connection("SELECT clan_name FROM information");
			$rowb = mysql_fetch_array($resultb); extract($rowb);
			
			$l = 8;
			for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
				$password = $s;
			
			$password = crypt(md5($password), md5($password));
			
			$result = connection("INSERT INTO users
				(user_id,
				user_name,
				user_pass,
				user_email,
				user_type) VALUES 
				('$user_id',
				'$HTTP_POST_VARS[user_name]',
				'$password',
				'$HTTP_POST_VARS[user_email]',
				'standard')");
		
			if ($result) {
					echo "Thank you for registering.<br>Your password will now be emailed to you.<br>";
					mail($HTTP_POST_VARS['user_email'],"Your password for $clan_name!","Thank you for registering with $clan_name!\nYour Password is: $s\n","From: kliptmedia clan manager <@>\r\n");		
					echo "Your password is: <b>".$s."</b><br>";
			}
			else
				echo "Player registration error.<br>";
		}
		else
			echo("Sorry, username and/or email already in use.<br>");
	}
	else
		echo "Sorry, you did not complete the forms.<br>";
}

//**************************************************************************//

else if ( $HTTP_POST_VARS['perform'] == "AddComment" )
{
	if ( $HTTP_POST_VARS['register'] == "YES" ) {
		
		if ( ( $HTTP_POST_VARS['Comment'] ) && ( logintest($cm) == TRUE ) ) {
			
			$comments_id = uniqid("ID");

			$result = connection("INSERT INTO comments
					(comments_id,
					news_id,
					userID,
					comment) VALUES 
					('$comments_id',
					'$HTTP_POST_VARS[ID]',
					'$cm[0]',
					'$HTTP_POST_VARS[Comment]')");

			if ($result)
					echo "Your comment has been added.<br>";
			else
				echo "error.<br>";
		}
		else
			echo "Please complete the forms.<br>";
	}
	
	else if ( $HTTP_POST_VARS['register'] == "NO" ) {
		
		if ( $HTTP_POST_VARS['Comment'] ) {
			
			$comments_id = uniqid("ID"); //create a player_id
			
			if ( logintest($cm) == FALSE ) {
				if ( $HTTP_POST_VARS['comment_name'] == NULL )
					$comment_name = "guest";
			}			
			else
				$comment_name = $cm[0];
							
			$result = connection("INSERT INTO comments
					(comments_id, news_id, userID, comment) VALUES 
					('$comments_id', '$HTTP_POST_VARS[ID]', '$comment_name','$HTTP_POST_VARS[Comment]')");

			if ($result)
					echo "Your comment has been added.<br>";
			else
				echo "error.<br>";
		}
		else
			echo "Please complete the forms.<br>";		
	}
}

//**************************************************************************//

else if ( $HTTP_POST_VARS['perform'] == "SendMail" )
{

	if ( $HTTP_POST_VARS['$mail_youradd'] != null )
		$from = $mail_youradd;
	else
		$from = "kliptmedia clan manager";

		mail($HTTP_POST_VARS['$recipient'],
			$HTTP_POST_VARS['mail_subject'],
			$HTTP_POST_VARS['mail_content'],
			"From: $from\r\n");
			
		echo "Email sent!<br>";

}

//**************************************************************************//

else if ( $HTTP_POST_VARS['perform'] == "ResetPassword" )
{
	$resultb = connection("SELECT clan_name FROM information");
	$rowb = mysql_fetch_array($resultb); extract($rowb);
	
	$result = connection("SELECT user_name,user_pass,user_email FROM users WHERE user_email='$HTTP_POST_VARS[useremail]'");
	if ( $row = mysql_fetch_array($result) ) 
		extract($row);
	
	if (( $user_name == $HTTP_POST_VARS['username'] ) && ( $user_email == $HTTP_POST_VARS['useremail'] )) {
	
		$l = 8;
		for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
		$password = $s;
	
		$password = crypt(md5($password), md5($password));
		//$password = crypt($password,'$2a');
		
		$result = connection("UPDATE users SET
			user_pass='$password' WHERE user_email='$user_email'");
		
		if ( mail($user_email,"Your new password for $clan_name!","Your password has been reset for $clan_name\nPassword is: $s\n","From: kliptmedia clan manager <@>\r\n") ) {
			echo "Password reset and email sent to <b>".$user_email."</b>!<br>";
		}
		echo "Your new password is <b>".$s."</b>!<br>";
	}
	
}

//**************************************************************************//

else if ( $HTTP_POST_VARS['perform'] == "EditProfile" )
{
	$resultb = connection("SELECT clan_name FROM information");
	$rowb = mysql_fetch_array($resultb); extract($rowb);
	
	//check for existing email or username
	$result = connection("SELECT user_email FROM users WHERE user_email='$HTTP_POST_VARS[user_email]'");
	if ( $row = mysql_fetch_array($result) ) {
		extract($row);
		$emailcheck = $user_email;
	}
	else
		$emailcheck = false;
		
	if ( $emailcheck == null )
	{

		$resultj = connection("SELECT * FROM users WHERE user_id='$cm[0]'");
		$rowj = mysql_fetch_array($resultj); extract($rowj);
		
		if ( $user_id == $cm[0] )
		{
			if ( $HTTP_POST_VARS['old_pass'] && $HTTP_POST_VARS['new_pass'] 
				&& $HTTP_POST_VARS['retype_pass'] && $HTTP_POST_VARS['new_email'] )
			{
				
				$result = connection("UPDATE users SET
					user_email='$new_email' WHERE user_id='$cm[0]'");
				
				if ( $result )
					echo "Email updated.<br>";
				else
					echo "Email update error.<br>";
				
				if ( $HTTP_POST_VARS['new_pass'] == $HTTP_POST_VARS['retype_pass']
					 && $HTTP_POST_VARS['retype_pass'] != $HTTP_POST_VARS['old_pass'] )
				{
					
					$password = crypt(md5($HTTP_POST_VARS['retype_pass']), md5($HTTP_POST_VARS['retype_pass']));
					//$password = crypt($HTTP_POST_VARS['retype_pass'],'$2a');
					
					$result = connection("UPDATE users SET
						user_pass='$password' WHERE user_id='$cm[0]'");
					
					if ( $result ) {
						echo "Password updated.<br>";
						mail($user_email,"Your new password for $clan_name!","Your password has been reset for $clan_name\nPassword is: $HTTP_POST_VARS[retype_pass]\n","From: kliptmedia clan manager <@>\r\n");		
					}
					else
						echo "Password update error.<br>";
		
				}
				else
					echo "Please make sure the new password was retyped correctly.<br>";
			}
			else if ( $HTTP_POST_VARS['new_email'] )
			{
				$result = connection("UPDATE users SET
					user_email='$HTTP_POST_VARS[new_email]' WHERE user_id='$cm[0]'");
				
				if ( $result )
					echo "Email updated.<br>";
				else
					echo "Email update error.<br>";
			}
			
		}
		else
			echo "Incorrect user.<br>";
	}
	else
		echo "Email address already in use.<br>";
	

}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'contacts' ) {
	
	$result = connection("UPDATE contacts SET
		webmaster='$HTTP_POST_VARS[webmaster]',
		manager='$HTTP_POST_VARS[manager]',
		scheduler='$HTTP_POST_VARS[scheduler]',
		recruiting='$HTTP_POST_VARS[recruiting]',
		help='$HTTP_POST_VARS[help]',
		marketing='$HTTP_POST_VARS[marketing]'");
	
	if ( $result )
		echo("$HTTP_POST_VARS[choice] has been updated.<br>");
	else
		echo("Unknown error.<br>");
}	

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'demos' || $_GET['choice'] == 'demos' ) {

	if ( $HTTP_POST_VARS['perform'] == 'add' ) {		
		
		$demo_id = uniqid("demoID");
		$demo_comment = nl2br($HTTP_POST_VARS['demo_comment']);
		
		$demo_name = $HTTP_POST_FILES['demo_file']['name'];
		$demo_size = $HTTP_POST_FILES['demo_file']['size'];
		
		$result = connection("INSERT INTO demos
			(demo_id,
			demo_awayteam,
			demo_map,
			demo_event,
			demo_pov,
			demo_match,
			demo_comment,
			demo_poster,
			demo_file,
			demo_size) VALUES 
			('$demo_id',
			'$HTTP_POST_VARS[demo_awayteam]',
			'$HTTP_POST_VARS[demo_map]',
			'$HTTP_POST_VARS[demo_event]',
			'$HTTP_POST_VARS[demo_pov]',
			'$HTTP_POST_VARS[demo_match]',
			'$demo_comment',
			'$cm[0]',
			'$demo_name',
			'$demo_size')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( is_uploaded_file($HTTP_POST_FILES['demo_file']['tmp_name']) ) {
			if ( copy($HTTP_POST_FILES['demo_file']['tmp_name'],"files/demos/".$HTTP_POST_FILES['demo_file']['name']) )
			{
				unlink($HTTP_POST_FILES['demo_file']['tmp_name']);
				echo "File submitted!<br>";
			}
			else 
				echo "File submission error.<br>";
		}
		else 
			echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		$demo_comment = nl2br($HTTP_POST_VARS['demo_comment']);  
		
		if ( $HTTP_POST_VARS['demo_file']['name'] != NULL ) {
			
			// DELETE OLD FILE
			$result = connection("SELECT demo_file FROM demos WHERE demo_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);
			
			if ( $row )	
				$delete = unlink("files/demos/$demo_file");
			
			// UPLOAD NEW FILE
			if ( is_uploaded_file($HTTP_POST_FILES['demo_file']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['demo_file']['tmp_name'],"files/demos/".$HTTP_POST_FILES['demo_file']['name']) )
				{
					unlink($HTTP_POST_FILES['demo_file']['tmp_name']);
					echo "File submitted!<br>";
				}
				else 
					echo "File submission error.<br>";
			}
			else 
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";
			
			//UPDATE DB
			$demo_name = $HTTP_POST_VARS['demo_file']['name'];
			$demo_size = $HTTP_POST_VARS['demo_file']['size'];
			
			$result = connection("UPDATE demos SET
				demo_file='$demo_name',
				demo_size='$demo_size' WHERE demo_id='$HTTP_POST_VARS[ID]'");			
			
		}
		
		$result = connection("UPDATE demos SET
			demo_awayteam='$HTTP_POST_VARS[demo_awayteam]',
			demo_event='$HTTP_POST_VARS[demo_event]',
			demo_pov='$HTTP_POST_VARS[demo_pov]',
			demo_match='$HTTP_POST_VARS[demo_match]',
			demo_comment='$demo_comment',
			demo_map='$HTTP_POST_VARS[demo_map]' WHERE demo_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_GET['perform'] == 'delete' ) {
		
		$result = connection("SELECT demo_file FROM demos WHERE demo_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $row ) {
			$delete = unlink("files/demos/$demo_file");
			mysql_query("DELETE FROM demos WHERE demo_id='$_GET[ID]'");
			echo "Demo deleted.<br>";
		}
		echo("$_GET[choice] updated!<br>");			
	}
	
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'events' || $_GET['choice'] == 'events' ) {

	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$event_id = uniqid("eventID");
		//$event_description = nl2br($HTTP_POST_VARS['event_description']);  
		
		$result = connection("INSERT INTO events
			(event_id,
			event_name,
			event_start,
			event_end,
			event_price,
			event_game,
			event_time,
			event_contact,
			event_location,
			event_type,
			event_description) VALUES 
			('$event_id',
			'$HTTP_POST_VARS[event_name]',
			'$HTTP_POST_VARS[event_start]',
			'$HTTP_POST_VARS[event_end]',
			'$HTTP_POST_VARS[event_price]',
			'$HTTP_POST_VARS[event_game]',
			'$HTTP_POST_VARS[event_time]',
			'$HTTP_POST_VARS[event_contact]',
			'$HTTP_POST_VARS[event_location]',
			'$HTTP_POST_VARS[event_type]',
			'$event_description')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");	
		
		if ( $HTTP_POST_FILES['event_image']['name'] != null ) {
		
			if ( is_uploaded_file($HTTP_POST_FILES['event_image']['tmp_name']) ) {
				
				if ( copy($HTTP_POST_FILES['event_image']['tmp_name'],"files/events/".$HTTP_POST_FILES['event_image']['name']) )
				{
					unlink($HTTP_POST_FILES['event_image']['tmp_name']);
					echo "Image submitted!<br>";
					
					//UPDATE DB
					$image_name = $HTTP_POST_FILES['event_image']['name'];
					
					$result = connection("UPDATE events SET
					event_image='$image_name' WHERE event_id='$event_id'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		$result = connection("UPDATE events SET
		event_name='$HTTP_POST_VARS[event_name]',
		event_start='$HTTP_POST_VARS[event_start]',
		event_end='$HTTP_POST_VARS[event_end]',
		event_price='$HTTP_POST_VARS[event_price]',
		event_game='$HTTP_POST_VARS[event_game]',
		event_time='$HTTP_POST_VARS[event_time]',
		event_contact='$HTTP_POST_VARS[event_contact]',
		event_location='$HTTP_POST_VARS[event_location]',
		event_type='$HTTP_POST_VARS[event_type]',
		event_description='$HTTP_POST_VARS[event_description]' WHERE event_id='$ID'");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $HTTP_POST_VARS['remove_img'] == "Y" ) {
			$result = connection("SELECT event_image FROM events WHERE event_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);
			$delete = unlink("files/events/$event_image");
			
			//UPDATE DB
			$result = connection("UPDATE events SET
			event_image='' WHERE event_id='$HTTP_POST_VARS[ID]'");
		}
		
				
		if ( $HTTP_POST_FILES['event_image']['name'] != null ) {
		
			if ( is_uploaded_file($HTTP_POST_FILES['event_image']['tmp_name']) ) {
				
				// DELETE OLD FILE
				$result = connection("SELECT event_image FROM events WHERE event_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
				
				if ( $row )	
					$delete = unlink("files/events/$event_image");
					
				if ( copy($HTTP_POST_FILES['event_image']['tmp_name'],"files/events/".$HTTP_POST_FILES['event_image']['name']) )
				{
					unlink($HTTP_POST_FILES['event_image']['tmp_name']);
					echo "Image submitted!<br>";
					//UPDATE DB
					$image_name = $HTTP_POST_FILES['event_image']['name'];
					
					$result = connection("UPDATE events SET
					event_image='$image_name' WHERE event_id='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['event_image'] != null && $HTTP_POST_VARS['remove_img'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
				
		}
	}
	else if ( $_GET['perform'] == 'delete' ) {		
		$result = connection("SELECT event_image FROM events WHERE event_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/events/$event_image");
		mysql_query("DELETE FROM events WHERE event_id='$_GET[ID]'");
		echo "Event deleted!<br>";
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'files' || $_GET['choice'] == 'files' ) {
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {		
		
		$file_id = uniqid("fileID");
		
		$file_name = $HTTP_POST_FILES['file_data']['name'];
		$file_size = $HTTP_POST_FILES['file_data']['size'];

		$result = connection("INSERT INTO files
			(file_id,
			file_name,
			file_size,
			file_description,
			file_external) VALUES 
			('$file_id',
			'$file_name',
			'$file_size',
			'$HTTP_POST_VARS[file_description]',
			'$HTTP_POST_VARS[file_external]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( is_uploaded_file($HTTP_POST_FILES['file_data']['tmp_name']) ) {
			if ( copy($HTTP_POST_FILES['file_data']['tmp_name'],"files/".$HTTP_POST_FILES['file_data']['name']) )
			{
				unlink($HTTP_POST_FILES['file_data']['tmp_name']);
				echo "File submitted!<br>";
			}
			else 
				echo "File submission error.<br>";
		}
		else 
			echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {

		if ( $HTTP_POST_FILES['file_data']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['file_data']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT file_name FROM files WHERE file_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/$file_name");
				
				if ( copy($HTTP_POST_FILES['file_data']['tmp_name'],"files/".$HTTP_POST_FILES['file_data']['name']) )
				{
					unlink($HTTP_POST_FILES['file_data']['tmp_name']);
					echo "File submitted!<br>";
					//UPDATE DB
					$file_name = $HTTP_POST_FILES['file_data']['name'];
					$file_size = $HTTP_POST_FILES['file_data']['size'];
					
					$result = connection("UPDATE files SET
					file_name='$file_name',
					file_size='$file_size' WHERE file_id='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['file_name'] != null )
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		$result = connection("UPDATE files SET
			file_description='$HTTP_POST_VARS[file_description]',
			file_external='$HTTP_POST_VARS[file_external]' WHERE file_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
	}
	else if ( $_GET['perform'] == 'delete' ) {
		$result = connection("SELECT file_name FROM files WHERE file_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/$file_name");
		mysql_query("DELETE FROM files WHERE file_id='$_GET[ID]'");
		echo("$_GET[choice] updated!<br>File deleted.<br>");		
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'information' ) {
	
	$clan_background = nl2br($HTTP_POST_VARS['$clan_background']);
	
	$result = connection("UPDATE information SET
		clan_name='$HTTP_POST_VARS[clan_name]',
		clan_tag='$HTTP_POST_VARS[clan_tag]',
		clan_irc='$HTTP_POST_VARS[clan_irc]',
		clan_background='$HTTP_POST_VARS[clan_background]',
		clan_irc_server='$HTTP_POST_VARS[clan_irc_server]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'links' || $_GET['choice'] == 'links' ) {

	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$link_id = uniqid("linkID");
		$link_description = nl2br($HTTP_POST_VARS['link_description']);  
		
		$result = connection("INSERT INTO links
			(link_id,
			link_name,
			link_url,
			link_description,
			link_type) VALUES 
			('$link_id',
			'$HTTP_POST_VARS[link_name]',
			'$HTTP_POST_VARS[link_url]',
			'$link_description',
			'$HTTP_POST_VARS[link_type]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");		
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		$link_description = nl2br($HTTP_POST_VARS['link_description']); 
		
		$result = connection("UPDATE links SET
			link_name='$HTTP_POST_VARS[link_name]',
			link_url='$HTTP_POST_VARS[link_url]',
			link_description='$link_description',
			link_type='$HTTP_POST_VARS[link_type]' WHERE link_id='$HTTP_POST_VARS[ID]'");
				
			if ( $result )
				echo("$HTTP_POST_VARS[choice] has been updated.<br>");
			else
				echo("Unknown error.<br>");		
	}
	
	else if ( $_GET['perform'] == 'delete' ) {		
		mysql_query("DELETE FROM links WHERE link_id='$_GET[ID]'");
		echo "Link deleted!<br>";
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'mail' ) {
	
	$from = UserName($cm[0]);
	
	if ( $HTTP_POST_VARS['mail_to'] == 'ALL' ) {
		$result = connection("SELECT roster_email FROM roster");
		while( $row = mysql_fetch_array($result)) {
			extract($row);
			mail($roster_email,$HTTP_POST_VARS['mail_subject'],"This is an email from one of your clan members:\n\n$HTTP_POST_VARS[mail_content]","From: $from <@>\r\n");
		}
	}	
	else
		mail($HTTP_POST_VARS['mail_to'],$HTTP_POST_VARS['mail_subject'],"This is an email from one of your clan members:\n\n$HTTP_POST_VARS[mail_content]","From: $from <@>\r\n");

	echo "Mail sent!<br>";
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'news' || $_GET['choice'] == 'news' ) {
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$result = connection("SELECT date_format FROM prefs");
		$row = mysql_fetch_array($result); extract($row);
	
		// check to see desired date format
		if ( $date_format == '1' ) 
			$news_date = date("n/j/Y");
		else if ( $date_format == '2' )
			$news_date = date("F j, Y");
		else if ( $date_format == '3' )
			$news_date = date("l, F j");
		
		$news_id = uniqid("newsID");
		$news_time = date("g:i a");		
		$news_numdate = date("m/d/Y");
		
		// add line breaks to content
		// $news_content = nl2br($news_content);  
		
		// insert news
		$result = connection("INSERT INTO news
			(news_id,
			news_reporter,
			news_subject,
			news_content,
			news_date,
			news_time,
			news_caption,
			news_numdate,
			news_comments) VALUES 
			('$news_id',
			'$cm[0]',
			'$HTTP_POST_VARS[news_subject]',
			'$HTTP_POST_VARS[news_content]',
			'$news_date',
			'$news_time',
			'$HTTP_POST_VARS[news_caption]',
			'$news_numdate',
			'$HTTP_POST_VARS[news_comments]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");

		if ( $HTTP_POST_FILES['news_image']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['news_image']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['news_image']['tmp_name'],"files/news/".$HTTP_POST_FILES['news_image']['name']) )
				{
					unlink($HTTP_POST_FILES['news_image']['tmp_name']);
					//UPDATE DB
					$image_name = $HTTP_POST_FILES['news_image']['name'];
					
					$result = connection("UPDATE news SET
						news_image='$image_name' WHERE news_id='$news_id'");
					echo "Image attached!<br>";
				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}	
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
	
		// add line breaks to content
		// $news_content = nl2br($news_content);   		
		
		if ( $HTTP_POST_VARS['remove_img'] == "Y" ) {
			$result = connection("SELECT news_image FROM news WHERE news_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/news/$news_image");
			//UPDATE DB
			$result = connection("UPDATE news SET
			news_image='' WHERE news_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['news_image']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['news_image']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT news_image FROM news WHERE news_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/news/$news_image");
				
				if ( copy($HTTP_POST_FILES['news_image']['tmp_name'],"files/news/".$HTTP_POST_FILES['news_image']['name']) )
				{
					unlink($HTTP_POST_FILES['news_image']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$image_name = $HTTP_POST_FILES['news_image']['name'];
					$result = connection("UPDATE news SET
					news_image='$image_name' WHERE news_id='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['event_image'] != null && $HTTP_POST_VARS['remove_img'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		$result = connection("UPDATE news SET
			news_subject='$HTTP_POST_VARS[news_subject]',
			news_content='$HTTP_POST_VARS[news_content]',
			news_comments='$HTTP_POST_VARS[news_comments]',
			news_caption='$HTTP_POST_VARS[news_caption]' WHERE news_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_GET['perform'] == 'delete' ) {
		
		$result = connection("SELECT news_image FROM news WHERE news_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $HTTP_POST_VARS['news_image'] != null )	
			$delete = unlink("files/news/$news_image");
			
		mysql_query("DELETE FROM news WHERE news_id='$_GET[ID]'");
		
		mysql_query("DELETE FROM comments WHERE news_id='$_GET[ID]'");
		echo "Comments deleted for this article.<br>";
		echo("News deleted.<br>");		
		
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'records' || $_GET['choice'] == 'records' ) {

	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "*";
	$IMG_WIDTH  = "100";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	require("imgfuncs.php");
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$record_id = uniqid("matchID");
		
		$result = connection("INSERT INTO records
			(record_id,
			record_awayteam,
			record_awaytag,
			record_map,
			record_roster,
			record_ctw,
			record_ctl,
			record_tw,
			record_tl,
			record_otw,
			record_otl,
			record_league,
			record_date,
			record_time,
			record_hltv,
			record_scorebot,
			record_mvp,
			record_event,
			record_comments,
			record_type) VALUES 
			('$record_id',
			'$HTTP_POST_VARS[record_awayteam]',
			'$HTTP_POST_VARS[record_awaytag]',
			'$HTTP_POST_VARS[record_map]',
			'$HTTP_POST_VARS[record_roster]',
			'$HTTP_POST_VARS[record_ctw]',
			'$HTTP_POST_VARS[record_ctl]',
			'$HTTP_POST_VARS[record_tw]',
			'$HTTP_POST_VARS[record_tl]',
			'$HTTP_POST_VARS[record_otw]',
			'$HTTP_POST_VARS[record_otl]',
			'$HTTP_POST_VARS[record_league]',
			'$HTTP_POST_VARS[record_date]',
			'$HTTP_POST_VARS[record_time]',
			'$HTTP_POST_VARS[record_hltv]',
			'$HTTP_POST_VARS[record_scorebot]',
			'$HTTP_POST_VARS[record_mvp]',
			'$HTTP_POST_VARS[record_event]',
			'$HTTP_POST_VARS[record_comments]',
			'$HTTP_POST_VARS[record_type]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $HTTP_POST_FILES['record_screen1']['name'] != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen1']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen1']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen1']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";
						
					if( $f_res = resizer_main("record_screen1","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen1']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen1']['tmp_name']);
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen1']['name'];
						$result = connection("UPDATE records SET
							record_screen1='$screen_name' WHERE record_id='$record_id'");
						echo "Image attached!<br>";
					}
					else
						echo "Thumbnail creation error.<br>";
							
				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image #1 too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		if ( $HTTP_POST_FILES['record_screen2']['name'] != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen2']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen2']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen2']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen2","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen2']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen2']['tmp_name']);
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen2']['name'];
						$result = connection("UPDATE records SET
							record_screen2='$screen_name' WHERE record_id='$record_id'");
						echo "Image attached!<br>";
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image #2 too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		if ( $HTTP_POST_FILES['record_screen3']['name'] != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen3']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen3']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen3']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen3","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen3']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen3']['tmp_name']);
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen3']['name'];
						$result = connection("UPDATE records SET
							record_screen3='$screen_name' WHERE record_id='$record_id'");
						echo "Image attached!<br>";
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image #3 too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		if ( $HTTP_POST_FILES['record_screen4']['name'] != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen4']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen4']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen4']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";
							
					if( $f_res = resizer_main("record_screen4","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen4']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen4']['tmp_name']);
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen4']['name'];
						$result = connection("UPDATE records SET
							record_screen4='$screen_name' WHERE record_id='$record_id'");
						echo "Image attached!<br>";
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image #4 too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		if ( $HTTP_POST_VARS['remove_img1'] == "Y" ) {
			$result = connection("SELECT record_screen1 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen1");
			$delete = unlink("files/matches/thumb-$record_screen1");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen1='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen1']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen1']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen1 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $record_screen1 != null )	
				{
					$delete = unlink("files/matches/$record_screen1");
					$delete = unlink("files/matches/thumb-$record_screen1");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen1']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen1']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen1","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen1']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen1']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen1']['name'];
						$result = connection("UPDATE records SET
						record_screen1='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen1']['name'] != null && $HTTP_POST_VARS['remove_img1'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_img2'] == "Y" ) {
			$result = connection("SELECT record_screen2 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen2");
			$delete = unlink("files/matches/thumb-$record_screen2");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen2='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen2']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen2']['tmp_name']) ) {
			
				// DELETE OLD FILE				
				$result = connection("SELECT record_screen2 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $record_screen2 != null )	
				{
					$delete = unlink("files/matches/$record_screen2");
					$delete = unlink("files/matches/thumb-$record_screen2");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen2']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen2']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen2","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen2']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen2']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen2']['name'];
						$result = connection("UPDATE records SET
						record_screen2='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen2']['name'] != null && $HTTP_POST_VARS['remove_img2'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_img3'] == "Y" ) {
			$result = connection("SELECT record_screen3 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen3");
			$delete = unlink("files/matches/thumb-$record_screen3");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen3='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen3']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen3']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen3 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $record_screen3 != null )
				{
					$delete = unlink("files/matches/$record_screen3");
					$delete = unlink("files/matches/thumb-$record_screen3");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen3']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen3']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen3","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen3']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen3']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen3']['name'];
						$result = connection("UPDATE records SET
						record_screen3='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen3']['name'] != null && $HTTP_POST_VARS['remove_img3'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_img4'] == "Y" ) {
			$result = connection("SELECT record_screen4 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen4");
			$delete = unlink("files/matches/thumb-$record_screen4");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen4='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen4']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen4']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen4 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $record_screen4 != null )	
				{
					$delete = unlink("files/matches/$record_screen4");
					$delete = unlink("files/matches/thumb-$record_screen4");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen4']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen4']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen4","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen4']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen4']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen4']['name'];
						$result = connection("UPDATE records SET
						record_screen4='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen4']['name'] != null && $HTTP_POST_VARS['remove_img4'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		/*
		if ( $HTTP_POST_VARS['remove_img2'] == "Y" ) {
			$result = connection("SELECT record_screen2 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen2");
			$delete = unlink("files/matches/thumb-$record_screen2");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen2='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen2']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen2']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen2 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
				{
					$delete = unlink("files/matches/$record_screen2");
					$delete = unlink("files/matches/thumb-$record_screen2");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen2']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen2']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen2","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen2']['name']))
					{
					
						unlink($HTTP_POST_FILES['record_screen2']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen2']['name'];
						$result = connection("UPDATE records SET
						record_screen2='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen2']['name'] != null && $HTTP_POST_VARS['remove_img2'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_img3'] == "Y" ) {
			$result = connection("SELECT record_screen3 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen3");
			$delete = unlink("files/matches/thumb-$record_screen3");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen3='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen3']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen3']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen3 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
				{
					$delete = unlink("files/matches/$record_screen3");
					$delete = unlink("files/matches/thumb-$record_screen3");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen3']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen3']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen3","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen3']['name']))
					{
						
						unlink($HTTP_POST_FILES['record_screen3']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen3']['name'];
						$result = connection("UPDATE records SET
						record_screen3='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen3']['name'] != null && $HTTP_POST_VARS['remove_img3'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_img4'] == "Y" ) {
			$result = connection("SELECT record_screen4 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen4");
			$delete = unlink("files/matches/thumb-$record_screen4");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen4='' WHERE record_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['record_screen4']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen4']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen4 FROM records WHERE record_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
				{
					$delete = unlink("files/matches/$record_screen4");
					$delete = unlink("files/matches/thumb-$record_screen4");
				}
				
				if ( copy($HTTP_POST_FILES['record_screen4']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen4']['name']) )
				{
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen4","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen4']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen4']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$screen_name = $HTTP_POST_FILES['record_screen4']['name'];
						$result = connection("UPDATE records SET
						record_screen4='$screen_name' WHERE record_id='$HTTP_POST_VARS[ID]'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['record_screen4']['name'] != null && $HTTP_POST_VARS['remove_img4'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		*/
		$result = connection("UPDATE records SET
			record_awayteam='$HTTP_POST_VARS[record_awayteam]',
			record_awaytag='$HTTP_POST_VARS[record_awaytag]',
			record_map='$HTTP_POST_VARS[record_map]',
			record_roster='$HTTP_POST_VARS[record_roster]',
			record_ctw='$HTTP_POST_VARS[record_ctw]',
			record_ctl='$HTTP_POST_VARS[record_ctl]',
			record_tw='$HTTP_POST_VARS[record_tw]',
			record_tl='$HTTP_POST_VARS[record_tl]',
			record_otw='$HTTP_POST_VARS[record_otw]',
			record_otl='$HTTP_POST_VARS[record_otl]',
			record_league='$HTTP_POST_VARS[record_league]',
			record_date='$HTTP_POST_VARS[record_date]',
			record_time='$HTTP_POST_VARS[record_time]',
			record_hltv='$HTTP_POST_VARS[record_hltv]',
			record_scorebot='$HTTP_POST_VARS[record_scorebot]',
			record_mvp='$HTTP_POST_VARS[record_mvp]',
			record_event='$HTTP_POST_VARS[record_event]',
			record_comments='$HTTP_POST_VARS[record_comments]',
			record_type='$HTTP_POST_VARS[record_type]' WHERE record_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");	
	}
	
	else if ( $_GET['perform'] == 'delete' ) {		
		
		$result = connection("SELECT record_screen1,record_screen2,record_screen3,record_screen4 FROM records WHERE record_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $record_screen1 )
		{
			$delete = unlink("files/matches/$record_screen1");
			$delete = unlink("files/matches/thumb-$record_screen1");
		}
		if ( $record_screen2 )
		{
			$delete = unlink("files/matches/$record_screen2");
			$delete = unlink("files/matches/thumb-$record_screen2");
		}
		if ( $record_screen3 )
		{
			$delete = unlink("files/matches/$record_screen3");
			$delete = unlink("files/matches/thumb-$record_screen2");
		}
		if ( $record_screen4 )
		{
			$delete = unlink("files/matches/$record_screen4");
			$delete = unlink("files/matches/thumb-$record_screen2");
		}
		mysql_query("DELETE FROM records WHERE record_id='$_GET[ID]'");;
		echo("Record and images deleted.<br>");	
	}
}

//**************************************************************************//

else if ( $HTTP_POST_VARS['choice'] == 'roster' || $_GET['choice'] == 'roster' ) {
	
	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "*";
	$IMG_WIDTH  = "100";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$roster_id = uniqid("rosterID");
		//$roster_bio = nl2br($HTTP_POST_VARS['roster_bio']);
		//$roster_prevclans= nl2br($HTTP_POST_VARS['roster_prevclans']);
		//$roster_lanexp= nl2br($HTTP_POST_VARS['roster_lanexp']);
		
		// if user who posted does not have a roster_user yet, put his id in there
		// make sure this roster_user doesn't already exist!
		/*$resultw = connection("SELECT * FROM users WHERE user_id='$cm[0]'");
		$roww = mysql_fetch_array($resultw); extract($roww);
		
		if ( $HTTP_POST_VARS['user_onteam'] == 'yes' )
		{
			$resultx = connection("SELECT * FROM roster WHERE roster_user='$cm[0]'");
			$rowx = mysql_fetch_array($resultx); extract($rowx);
			
			if ( $rowx != null )
				echo "A roster member with a similar id exists.";
			else
				$roster_user = $cm[0];
		}	
		*/
		$result = connection("INSERT INTO roster
			(roster_id,
			roster_alias,
			roster_name,
			roster_rank,
			roster_status,
			roster_age,
			roster_gender,
			roster_email,
			roster_location,
			roster_bio,
			roster_quote,
			roster_wonid,
			roster_sogamed,
			roster_gotfrag,
			computer_brand,
			computer_mobo,
			computer_cpu,
			computer_ram,
			computer_video,
			computer_sound,
			computer_monitor,
			computer_resolution,
			computer_headphones,
			computer_keyboard,
			computer_mouse,
			computer_sens,
			computer_pad,
			computer_accessories,
			/* new as of 3.0 */
			roster_job,
			computer_refresh,
			computer_vsync,
			computer_drive,
			roster_msn,
			roster_yahoo,
			roster_aim,
			roster_favfood,
			roster_favmap,
			roster_favweapon,
			roster_favplayer,
			roster_favmovie,
			roster_favmusic,
			roster_homepage,
			roster_lanexp,
			roster_prevclans) VALUES 
			('$roster_id',
			'$HTTP_POST_VARS[roster_alias]',
			'$HTTP_POST_VARS[roster_name]',
			'$HTTP_POST_VARS[roster_rank]',
			'$HTTP_POST_VARS[roster_status]',
			'$HTTP_POST_VARS[roster_age]',
			'$HTTP_POST_VARS[roster_gender]',
			'$HTTP_POST_VARS[roster_email]',
			'$HTTP_POST_VARS[roster_location]',
			'$HTTP_POST_VARS[roster_bio]',
			'$HTTP_POST_VARS[roster_quote]',
			'$HTTP_POST_VARS[roster_wonid]',
			'$HTTP_POST_VARS[roster_sogamed]',
			'$HTTP_POST_VARS[roster_gotfrag]',
			'$HTTP_POST_VARS[computer_brand]',
			'$HTTP_POST_VARS[computer_mobo]',
			'$HTTP_POST_VARS[computer_cpu]',
			'$HTTP_POST_VARS[computer_ram]',
			'$HTTP_POST_VARS[computer_video]',
			'$HTTP_POST_VARS[computer_sound]',
			'$HTTP_POST_VARS[computer_monitor]',
			'$HTTP_POST_VARS[computer_resolution]',
			'$HTTP_POST_VARS[computer_headphones]',
			'$HTTP_POST_VARS[computer_keyboard]',
			'$HTTP_POST_VARS[computer_mouse]',
			'$HTTP_POST_VARS[computer_sens]',
			'$HTTP_POST_VARS[computer_pad]',
			'$HTTP_POST_VARS[computer_accessories]',
			/* new as of 3.0 */
			'$HTTP_POST_VARS[roster_job]',
			'$HTTP_POST_VARS[computer_refresh]',
			'$HTTP_POST_VARS[computer_vsync]',
			'$HTTP_POST_VARS[computer_drive]',
			'$HTTP_POST_VARS[roster_msn]',
			'$HTTP_POST_VARS[roster_yahoo]',
			'$HTTP_POST_VARS[roster_aim]',
			'$HTTP_POST_VARS[roster_favfood]',
			'$HTTP_POST_VARS[roster_favmap]',
			'$HTTP_POST_VARS[roster_favweapon]',
			'$HTTP_POST_VARS[roster_favplayer]',
			'$HTTP_POST_VARS[roster_favmovie]',
			'$HTTP_POST_VARS[roster_favmusic]',
			'$HTTP_POST_VARS[roster_homepage]',
			'$HTTP_POST_VARS[roster_lanexp]',
			'$HTTP_POST_VARS[roster_prevclans]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $HTTP_POST_FILES['roster_photo']['name'] != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['roster_photo']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['roster_photo']['tmp_name'],"files/roster/".$HTTP_POST_FILES['roster_photo']['name']) )
				{
					
					$IMG_ROOT = "files/roster/";
					require("imgfuncs.php");
						
					if( $f_res = resizer_main("roster_photo","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['roster_photo']['name']))
					{
						unlink($HTTP_POST_FILES['roster_photo']['tmp_name']);
						//UPDATE DB
						$image_name = $HTTP_POST_FILES['roster_photo']['name'];
						$result = connection("UPDATE roster SET
							roster_photo='$image_name' WHERE roster_id='$roster_id'");
						echo "Image attached!<br>";
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else
					echo "Image upload error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}

		if ( $HTTP_POST_FILES['roster_config']['name'] != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['roster_config']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['roster_config']['tmp_name'],"files/configs/".$roster_alias."-".$HTTP_POST_FILES['roster_config']['name']) )
				{
					unlink($HTTP_POST_FILES['roster_config']['tmp_name']);
					//UPDATE DB
					$config_name = $HTTP_POST_FILES['roster_config']['name'];
					$result = connection("UPDATE roster SET
						roster_config='$HTTP_POST_VARS[roster_alias]-$config_name' WHERE roster_id='$roster_id'");
					echo "Config attached!<br>";
				}
				else 
					echo "Config attachment error.<br>";
			}
			else 
				echo "Information stored but config too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {

		//$roster_bio = nl2br($HTTP_POST_VARS['roster_bio']);   
		//$roster_prevclans= nl2br($HTTP_POST_VARS['roster_prevclans']);
		//$roster_lanexp= nl2br($HTTP_POST_VARS['roster_lanexp']);
		
		if ( $HTTP_POST_VARS['remove_img'] == "Y" ) {
			$result = connection("SELECT roster_photo FROM roster WHERE roster_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/roster/$roster_photo");
			$delete = unlink("files/roster/thumb-$roster_photo");
			//UPDATE DB
			$result = connection("UPDATE roster SET
				roster_photo='' WHERE roster_id='$HTTP_POST_VARSID]'");
		}
		
		if ( $HTTP_POST_FILES['roster_photo']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['roster_photo']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT roster_photo FROM roster WHERE roster_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )
				{
					$delete = unlink("files/roster/$roster_photo");
					$delete = unlink("files/roster/thumb-$roster_photo");
				}
				
				if ( copy($HTTP_POST_FILES['roster_photo']['tmp_name'],"files/roster/".$HTTP_POST_FILES['roster_photo']['name']) )
				{
					$IMG_ROOT = "files/roster";
					require("imgfuncs.php");

					if( $f_res = resizer_main("roster_photo","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['roster_photo']['name']))
					{

						unlink($HTTP_POST_FILES['roster_photo']['tmp_name']);
						echo "Image attached!<br>";
						//UPDATE DB
						$image_name = $HTTP_POST_FILES['roster_photo']['name'];
						$result = connection("UPDATE roster SET
						roster_photo='$image_name' WHERE roster_id='$HTTP_POST_VARS[ID]'");
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['roster_photo']['name'] != null && $HTTP_POST_VARS['remove_img'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $HTTP_POST_VARS['remove_config'] == "Y" ) {
			$result = connection("SELECT roster_config FROM roster WHERE roster_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/roster/$roster_config");
			//UPDATE DB
			$result = connection("UPDATE roster SET
				roster_config='' WHERE roster_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['roster_config']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['roster_config']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT roster_config FROM roster WHERE roster_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/roster/$roster_config");
				
				if ( copy($HTTP_POST_FILES['roster_config']['tmp_name'],"files/configs/".$roster_alias."-".$HTTP_POST_FILES['roster_config']['name']) )
				{
					unlink($HTTP_POST_FILES['roster_config']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$config_name = $HTTP_POST_FILES['roster_config']['name'];
					$result = connection("UPDATE roster SET
					roster_config='$HTTP_POST_VARS[roster_alias]-$config_name' WHERE roster_id='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['roster_config']['name'] != null && $HTTP_POST_VARS['remove_config'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
	
		$result = connection("UPDATE roster SET
			roster_alias='$HTTP_POST_VARS[roster_alias]',
			roster_name='$HTTP_POST_VARS[roster_name]',
			roster_rank='$HTTP_POST_VARS[roster_rank]',
			roster_status='$HTTP_POST_VARS[roster_status]',
			roster_age='$HTTP_POST_VARS[roster_age]',
			roster_gender='$HTTP_POST_VARS[roster_gender]',
			roster_email='$HTTP_POST_VARS[roster_email]',
			roster_location='$HTTP_POST_VARS[roster_location]',
			roster_bio='$HTTP_POST_VARS[roster_bio]',
			roster_quote='$HTTP_POST_VARS[roster_quote]',
			roster_wonid='$HTTP_POST_VARS[roster_wonid]',
			roster_sogamed='$HTTP_POST_VARS[roster_sogamed]',
			roster_gotfrag='$HTTP_POST_VARS[roster_gotfrag]',
			computer_brand='$HTTP_POST_VARS[computer_brand]',
			computer_mobo='$HTTP_POST_VARS[computer_mobo]',
			computer_cpu='$HTTP_POST_VARS[computer_cpu]',
			computer_ram='$HTTP_POST_VARS[computer_ram]',
			computer_video='$HTTP_POST_VARS[computer_video]',
			computer_sound='$HTTP_POST_VARS[computer_sound]',
			computer_monitor='$HTTP_POST_VARS[computer_monitor]',
			computer_resolution='$HTTP_POST_VARS[computer_resolution]',
			computer_headphones='$HTTP_POST_VARS[computer_headphones]',
			computer_keyboard='$HTTP_POST_VARS[computer_keyboard]',
			computer_mouse='$HTTP_POST_VARS[computer_mouse]',
			computer_sens='$HTTP_POST_VARS[computer_sens]',
			computer_pad='$HTTP_POST_VARS[computer_pad]',
			computer_accessories='$HTTP_POST_VARS[computer_accessories]',
			/* new as of 3.0 */
			roster_job='$HTTP_POST_VARS[roster_job]',
			computer_refresh='$HTTP_POST_VARS[computer_refresh]',
			computer_vsync='$HTTP_POST_VARS[computer_vsync]',
			computer_drive='$HTTP_POST_VARS[computer_drive]',
			roster_msn='$HTTP_POST_VARS[roster_msn]',
			roster_yahoo='$HTTP_POST_VARS[roster_yahoo]',
			roster_aim='$HTTP_POST_VARS[roster_aim]',
			roster_favfood='$HTTP_POST_VARS[roster_favfood]',
			roster_favmap='$HTTP_POST_VARS[roster_favmap]',
			roster_favweapon='$HTTP_POST_VARS[roster_favweapon]',
			roster_favplayer='$HTTP_POST_VARS[roster_favplayer]',
			roster_favmovie='$HTTP_POST_VARS[roster_favmovie]',
			roster_favmusic='$HTTP_POST_VARS[roster_favmusic]',
			roster_homepage='$HTTP_POST_VARS[roster_homepage]',
			roster_lanexp='$HTTP_POST_VARS[roster_lanexp]',
			roster_prevclans='$HTTP_POST_VARS[roster_prevclans]' WHERE roster_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_GET['perform'] == 'delete' ) {		
		$result = connection("SELECT roster_photo,roster_config FROM roster WHERE roster_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $roster_photo ) {
			$delete = unlink("files/roster/$roster_photo");
			$delete = unlink("files/roster/thumb-$roster_photo");
		}
		
		if ( $roster_config )
			$delete = unlink("files/configs/$roster_config");
		
		mysql_query("DELETE FROM roster WHERE roster_id='$_GET[ID]'");
		echo("Player deleted!");
	}	
}

//**************************************************************************//
	
if ( $HTTP_POST_VARS['choice'] == 'screenshots' || $_GET['choice'] == 'screenshots' ) {
	
	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "108";
	$IMG_WIDTH  = "*";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {		
		
		$screen_id = uniqid("screenID");
	
		if ( $HTTP_POST_VARS['screen_gallery'] == null && $HTTP_POST_VARS['screen_newgallery'] == null )
			echo "Please specify a gallery.<br>";
		
		// if existing gallery, post in it
		else if ( !$HTTP_POST_VARS['screen_newgallery'] )
		{	
			$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$HTTP_POST_VARS[screen_gallery]'");
			$rowg = mysql_fetch_array($resultg); extract($rowg);
			
			if ( $HTTP_POST_FILES['screen']['name'] != NULL ) {	
				if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
					
					$IMG_ROOT = "files/screenshots/$gallery_name";
					require("imgfuncs.php");
					
					if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
					{		
						if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
						{
														
							unlink($HTTP_POST_FILES['screen']['tmp_name']);
							echo "Screenshot added!<br>";
								
								$screen_name = $HTTP_POST_FILES['screen']['name'];
								$screen_size = $HTTP_POST_FILES['screen']['size'];
								
								$result = connection("INSERT INTO screenshots
									(screen_id,
									screen_gallery,
									screen_name,
									screen_size,
									screen_caption) VALUES 
									('$screen_id',
									'$gallery_id',
									'$screen_name',
									'$screen_size',
									'$HTTP_POST_VARS[screen_caption]')");
							
								if ( $result )
									echo("$HTTP_POST_VARS[choice] has been updated.<br>");
								else
									echo("Unknown error.<br>");
						}
						else
							echo "Thumbnail creation error.<br>";
					}
					else 
						echo "Image manipulation error.<br>";
				}
				else 
					echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
			}
		}
		
		// else create the new gallery and post into that
		else if ( $HTTP_POST_VARS['screen_newgallery'] ) 
		{	
			$gallery_id = uniqid("gallID");
			$result = connection("INSERT INTO galleries
				(gallery_id,
				gallery_name,
				gallery_desc,
				gallery_date,
				gallery_location) VALUES 
				('$gallery_id',
				'$HTTP_POST_VARS[screen_newgallery]',
				'$HTTP_POST_VARS[gallery_desc]',
				'$HTTP_POST_VARS[gallery_date]',
				'$HTTP_POST_VARS[gallery_location]')");
		
			if ( $result )
				echo("New gallery created.<br>");
			else
				echo("Unknown error.<br>");
														
			if ( $make = mkdir("files/screenshots/$HTTP_POST_VARS[screen_newgallery]", 0777) ) {
				
				chmod ("files/screenshots/$HTTP_POST_VARS[screen_newgallery]",0777);
				
				echo "New gallery folder added: <b>$HTTP_POST_VARS[screen_newgallery]</b><br>";
				
				if ( $HTTP_POST_FILES['screen']['name'] != NULL ) {	
					
					if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
						
						$IMG_ROOT = "files/screenshots/$HTTP_POST_VARS[screen_newgallery]";
						require("imgfuncs.php");

						if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
						{
							if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
							{
								
								unlink($HTTP_POST_FILES['screen']['tmp_name']);
								echo "Screenshot added!<br>";
									
									$screen_name = $HTTP_POST_FILES['screen']['name'];
									$screen_size = $HTTP_POST_FILES['screen']['size'];
									
									$result = connection("INSERT INTO screenshots
									(screen_id,
									screen_gallery,
									screen_name,
									screen_size,
									screen_caption) VALUES 
									('$screen_id',
									'$gallery_id',
									'$screen_name',
									'$screen_size',
									'$HTTP_POST_VARS[screen_caption]')");
							
								if ( $result )
									echo("$HTTP_POST_VARS[choice] has been updated.<br>");
								else
									echo("Unknown error.<br>");
							}
							else
								echo "Thumbnail creation error.<br>";
						}
						else 
							echo "Image manipulation error.<br>";
					}
					else 
						echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
				}
			}
		}
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		if ( $HTTP_POST_VARS['screen_gallery'] == null )
			echo "Please specify a gallery.<br>";
		
		else {
			
			// upload photo if there is a new one
			if ( $HTTP_POST_FILES['screen']['name'] != null ) {

				if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
					
					$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$HTTP_POST_VARS[screen_gallery]'");
					$rowg = mysql_fetch_array($resultg); extract($rowg);
					
					$IMG_ROOT = "files/screenshots/$gallery_name";
						
					require("imgfuncs.php");
						
					if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT,$screen_name))
					{		
						if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT,$screen_name))
						{
							$screen_name = $HTTP_POST_FILES['screen']['name'];
							$screen_size = $HTTP_POST_FILES['screen']['size'];
							
							$result = connection("UPDATE screenshots SET
								screen_name='$screen_name',
								screen_size='$screen_size' WHERE screen_id='$HTTP_POST_VARS[ID]'");
							
							$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$HTTP_POST_VARS[oldgallery]'");
							$rowg = mysql_fetch_array($resultg); extract($rowg);
														
							unlink("files/screenshots/$gallery_name/$HTTP_POST_VARS[oldscreen]");
							unlink("files/screenshots/$gallery_name/thumb-$HTTP_POST_VARS[oldscreen]");
							unlink($HTTP_POST_FILES['screen']['tmp_name']);
							echo "Screenshot added!<br>";
								
						}
						else
							echo "Thumbnail creation error.<br>";
					}
					else 
						echo "Image manipulation error.<br>";
				}
				else
					echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
			}			

			if ( $HTTP_POST_VARS['screen_gallery'] != $HTTP_POST_VARS['oldgallery'] )
			{
				$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$HTTP_POST_VARS[oldgallery]'");
				$rowg = mysql_fetch_array($resultg); extract($rowg);
				$olddir = $gallery_name;
				
				$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$HTTP_POST_VARS[screen_gallery]'");
				$rowg = mysql_fetch_array($resultg); extract($rowg);
				$newdir = $gallery_name;
				
				// move to a new gallery
				copy("files/screenshots/$olddir/$oldscreen","files/screenshots/$newdir/$HTTP_POST_VARS[oldscreen]");
	  		copy("files/screenshots/$olddir/thumb-$oldscreen","files/screenshots/$newdir/thumb-$HTTP_POST_VARS[oldscreen]");
	  		echo "File moved.<br>";
	  		
				// delete old instance and check for empty directory
				unlink("files/screenshots/$olddir/$HTTP_POST_VARS[oldscreen]");
				unlink("files/screenshots/$olddir/thumb-$HTTP_POST_VARS[oldscreen]");
	  		
	  		$resulty = connection("SELECT * FROM screenshots WHERE screen_gallery='$HTTP_POST_VARS[oldgallery]'");
				$numy = mysql_num_rows($resulty);
				
				if ( $numy == 1 ) {
					$delete_path = "files/screenshots/$HTTP_POST_VARS[olddir]";
					
					$remove = exec("rm -r $delete_path");
					if ( $remove )
						echo "Old directory is empty and has been removed.<br>";
					mysql_query("DELETE FROM galleries WHERE gallery_id='$HTTP_POST_VARS[oldgallery]'");
				}	
			}
			
			$result = connection("UPDATE screenshots SET
			screen_caption='$HTTP_POST_VARS[screen_caption]',
			screen_gallery='$HTTP_POST_VARS[screen_gallery]' WHERE screen_id='$HTTP_POST_VARS[ID]'");
			
			$result = connection("UPDATE galleries SET
			gallery_desc='$HTTP_POST_VARS[gallery_desc]',
			gallery_date='$HTTP_POST_VARS[gallery_date]',
			gallery_location='$HTTP_POST_VARS[gallery_location]' WHERE gallery_id='$HTTP_POST_VARS[screen_gallery]'");
			
			if ( $result )
				echo("$HTTP_POST_VARS[choice] has been updated.<br>");
			else
				echo("Unknown error.<br>");
			
		}	
	}	
		
	else if ( $_GET['perform'] == 'delete' ) {
		
		$result = connection("SELECT screen_name,screen_gallery FROM screenshots WHERE screen_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);
		
		$result2 = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
		$row2 = mysql_fetch_array($result2); extract($row2);	
		
		// delete old instance and check for empty directory
		unlink("files/screenshots/$gallery_name/$screen_name");
		unlink("files/screenshots/$gallery_name/thumb-$screen_name");
		
		$resulty = connection("SELECT * FROM screenshots WHERE screen_gallery='$gallery_id'");
		$numy = mysql_num_rows($resulty);
		if ( $numy == 1 ) {
			$delete_path = "files/screenshots/$gallery_name";
			$remove = exec("rm -r $delete_path");
			if ( $remove )
				echo "Gallery is empty and has been removed.<br>";
			mysql_query("DELETE FROM galleries WHERE gallery_id='$screen_gallery'");
		}	
		
		mysql_query("DELETE FROM screenshots WHERE screen_id='$_GET[ID]'");
		echo("$_GET[choice] updated!<br>");
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'servers' || $_GET['choice'] == 'servers' ) {

	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
				
		$result = connection("INSERT INTO servers
			(server_name,
			server_ip,
			server_type) VALUES 
			('$HTTP_POST_VARS[server_name]',
			'$HTTP_POST_VARS[server_ip]',
			'$HTTP_POST_VARS[server_type]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");

		if ( $HTTP_POST_FILES['server_maplist']['name'] != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['server_maplist']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['server_maplist']['tmp_name'],"files/servers/".$HTTP_POST_VARS['server_ip']."-".$HTTP_POST_FILES['server_maplist']['name']) )
				{
					unlink($HTTP_POST_FILES['server_maplist']['tmp_name']);
					
					$file_name = $HTTP_POST_FILES['server_maplist']['name'];
					
					$result = connection("UPDATE servers SET
						server_maplist='$HTTP_POST_VARS[server_ip]-$file_name' WHERE server_ip='$HTTP_POST_VARS[server_ip]'");
					echo "Text file attached!<br>";
				}
				else 
					echo "File attachment error.<br>";
			}
			else 
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
		
		if ( $HTTP_POST_VARS['remove_list'] == "Y" ) {
			$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/servers/$server_maplist");
			//UPDATE DB
			$result = connection("UPDATE servers SET
			server_maplist='' WHERE server_ip='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['server_maplist']['name'] != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['server_maplist']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/servers/$server_maplist");
				
				if ( copy($HTTP_POST_FILES['server_maplist']['tmp_name'],"files/servers/".$HTTP_POST_VARS['server_ip']."-".$HTTP_POST_FILES['server_maplist']['name']) )
				{
					unlink($HTTP_POST_FILES['server_maplist']['tmp_name']);
					echo "Text file attached!<br>";
					//UPDATE DB
					$file_name = $HTTP_POST_FILES['server_maplist']['name'];
					
					$result = connection("UPDATE servers SET
					server_maplist='$HTTP_POST_VARS[server_ip]-$file_name' WHERE server_ip='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['server_maplist'] != null && $HTTP_POST_VARS['remove_list'] != 'Y' )
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}		
		
		$result = connection("UPDATE servers SET
			server_name='$HTTP_POST_VARS[server_name]',
			server_ip='$HTTP_POST_VARS[server_ip]',
			server_type='$HTTP_POST_VARS[server_type]' WHERE server_ip='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");

	}
	
	else if ( $_GET['perform'] == 'delete' ) {		
		$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$_GET[ID]'");;
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/servers/$server_maplist");
		mysql_query("DELETE FROM servers WHERE server_ip='$_GET[ID]'");
		echo("$_GET[choice] updated!<br>");
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'settings' ) {

	$result = connection("UPDATE prefs SET 
		date_format='$HTTP_POST_VARS[date_format]'");
	
	$result = connection("UPDATE settings SET 
		force_register='$HTTP_POST_VARS[force_register]',
		cm_dir='$HTTP_POST_VARS[cmdir]'");
	
	if ( $result )
		echo("$HTTP_POST_VARS[choice] has been updated.");
	else
		echo("Unknown error.");

}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'sponsors' || $_GET['choice'] == 'sponsors' ) {
	
	if ( $HTTP_POST_VARS['perform'] == 'add' ) {		
		
		$sponsor_id = uniqid("sponsorID");
		//$sponsor_description = nl2br($HTTP_POST_VARS['sponsor_description']);  
				
		$result = connection("INSERT INTO sponsors
			(sponsor_id,
			sponsor_name,
			sponsor_url,
			sponsor_description) VALUES 
			('$sponsor_id',
			'$HTTP_POST_VARS[sponsor_name]',
			'$HTTP_POST_VARS[sponsor_url]',
			'$HTTP_POST_VARS[sponsor_description]')");
	
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $HTTP_POST_FILES['sponsor_image']['name'] != NULL ) {	

			if ( is_uploaded_file($HTTP_POST_FILES['sponsor_image']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['sponsor_image']['tmp_name'],"files/sponsors/".$HTTP_POST_FILES['sponsor_image']['name']) )
				{
					unlink($HTTP_POST_FILES['sponsor_image']['tmp_name']);
					$image_name = $HTTP_POST_FILES['sponsor_image']['name'];
					
					$result = connection("UPDATE sponsors SET
						sponsor_image='$image_name' WHERE sponsor_id='$sponsor_id'");
					echo "Image attached!<br>";
				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' ) {
			
		if ( $HTTP_POST_VARS['remove_img'] == "Y" ) {
			$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$HTTP_POST_VARS[ID]'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/sponsors/$sponsor_image");
			//UPDATE DB
			$result = connection("UPDATE sponsors SET
			sponsor_image='' WHERE sponsor_id='$HTTP_POST_VARS[ID]'");
		}
		
		if ( $HTTP_POST_FILES['sponsor_image']['name'] != NULL ) {

			if ( is_uploaded_file($HTTP_POST_FILES['sponsor_image']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$HTTP_POST_VARS[ID]'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/sponsors/$sponsor_image");
				
				if ( copy($HTTP_POST_FILES['sponsor_image']['tmp_name'],"files/sponsors/".$HTTP_POST_FILES['sponsor_image']['name']) )
				{
					unlink($HTTP_POST_FILES['sponsor_image']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$image_name = $HTTP_POST_FILES['sponsor_image']['name'];
					
					$result = connection("UPDATE sponsors SET
					sponsor_image='$image_name' WHERE sponsor_id='$HTTP_POST_VARS[ID]'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else if ( $HTTP_POST_VARS['sponsor_image']['name'] != null && $HTTP_POST_VARS['remove_img'] != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}	
		
		$result = connection("UPDATE sponsors SET
			sponsor_name='$HTTP_POST_VARS[sponsor_name]',
			sponsor_url='$HTTP_POST_VARS[sponsor_url]',
			sponsor_description='$HTTP_POST_VARS[sponsor_description]' WHERE sponsor_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$_GET[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");
				
	}
	else if ( $_GET['perform'] == 'delete' ) {
		
		$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/sponsors/$sponsor_image");
		mysql_query("DELETE FROM sponsors WHERE sponsor_id='$_GET[ID]'");
		echo("$_GET[choice] updated!");	
	}
}

//**************************************************************************//

if ( $HTTP_POST_VARS['choice'] == 'templates' || $_GET['choice'] == 'templates' ) {
	
	if ( $HTTP_POST_VARS["type"] == 'news' ) {	
		
		$result = connection("UPDATE templates SET
			news_headlines='$HTTP_POST_VARS[news_headlines]',
			news_post='$HTTP_POST_VARS[news_post]',
			news_posts='$HTTP_POST_VARS[news_posts]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
	}
	
	else if ( $HTTP_POST_VARS["type"] == 'roster' ) {	
		
		$result = connection("UPDATE templates SET
			roster_list='$HTTP_POST_VARS[roster_list]',
			roster_detail='$HTTP_POST_VARS[roster_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $HTTP_POST_VARS["type"] == 'records' ) {	
		
		$result = connection("UPDATE templates SET
			records_upcoming='$HTTP_POST_VARS[records_upcoming]',
			records_recent='$HTTP_POST_VARS[records_recent]',
			records_list='$HTTP_POST_VARS[records_list]',
			records_detail='$HTTP_POST_VARS[records_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $HTTP_POST_VARS["type"] == 'files' ) {	
		
		$result = connection("UPDATE templates SET
			file_list='$HTTP_POST_VARS[file_list]',
			file_detail='$HTTP_POST_VARS[file_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
		
	}


	else if ( $HTTP_POST_VARS["type"] == 'links' ) {	
		
		$result = connection("UPDATE templates SET
			links_list='$HTTP_POST_VARS[links_list]',
			links_detail='$HTTP_POST_VARS[links_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $HTTP_POST_VARS["type"] == 'events' ) {	
		
		$result = connection("UPDATE templates SET
			event_recent='$HTTP_POST_VARS[event_recent]',
			event_list='$HTTP_POST_VARS[event_list]',
			event_detail='$HTTP_POST_VARS[event_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $HTTP_POST_VARS["type"] == 'sponsors' ) {	
		
		$result = connection("UPDATE templates SET
			sponsor_list ='$HTTP_POST_VARS[sponsor_list]',
			sponsor_detail='$HTTP_POST_VARS[sponsor_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $HTTP_POST_VARS["type"] == 'servers' ) {	

		$result = connection("UPDATE templates SET
			server_list ='$HTTP_POST_VARS[server_list]',
			server_detail='$HTTP_POST_VARS[server_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
	}
	
	else if ( $HTTP_POST_VARS["type"] == 'demos' ) {	

		$result = connection("UPDATE templates SET
			demos_recent='$HTTP_POST_VARS[demos_recent]',
			demos_list='$HTTP_POST_VARS[demos_list]',
			demos_detail='$HTTP_POST_VARS[demos_detail]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $HTTP_POST_VARS["type"] == 'contacts' ) {	

		$result = connection("UPDATE templates SET
			contacts_list='$HTTP_POST_VARS[contacts_list]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $HTTP_POST_VARS["type"] == 'information' ) {	

		$result = connection("UPDATE templates SET
			info_list='$HTTP_POST_VARS[info_list]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $HTTP_POST_VARS["type"] == 'screenshots' ) {	

		$result = connection("UPDATE templates SET
			screens_detail='$HTTP_POST_VARS[screens_detail]',
			screens_list='$HTTP_POST_VARS[screens_list]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.");
		else
			echo("Unknown error.");
	}

}

// PROCESS USERS
if ( $HTTP_POST_VARS['choice'] == 'users' || $_GET['choice'] == 'users' ) {

	if ( $HTTP_POST_VARS['perform'] == 'add' ) {
		
		$user_id = uniqid("userID");
		$resultb = connection("SELECT clan_name FROM information");
		$rowb = mysql_fetch_array($resultb); extract($rowb);
			
		$l = 8;
		for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
		$password = $s;

		$password = crypt(md5($password), md5($password));
		//$password = crypt($password,'$2a');
		
		$result = connection("INSERT INTO users
			(user_id,
			user_name,
			user_pass,
			user_email,
			user_type) VALUES 
			('$user_id',
			'$HTTP_POST_VARS[user_name]',
			'$password',
			'$HTTP_POST_VARS[user_email]',
			'$HTTP_POST_VARS[user_type]')");
			
		if ($result)
		{
			echo "New user added.<br>";
			mail($HTTP_POST_VARS['user_email'],"Your password for $clan_name!","You have been added to $clan_name site. \nYour Username is: $HTTP_POST_VARS[user_name]\nYour Password is: $s\n");		
		}
		else
			echo("Unknown error.");
				
	}
	
	else if ( $HTTP_POST_VARS['perform'] == 'edit' )
	{
	
		// array abilities
		$user_abil .= $HTTP_POST_VARS['news'].",";
		$user_abil .= $HTTP_POST_VARS['roster'].",";
		$user_abil .= $HTTP_POST_VARS['records'].",";
		$user_abil .= $HTTP_POST_VARS['events'].",";
		$user_abil .= $HTTP_POST_VARS['templates'].",";
		$user_abil .= $HTTP_POST_VARS['settings'].",";
		$user_abil .= $HTTP_POST_VARS['users'].",";
		$user_abil .= $HTTP_POST_VARS['general'];
		
		$result = connection("UPDATE users SET
			user_name='$HTTP_POST_VARS[user_name]',
			user_email='$HTTP_POST_VARS[user_email]',
			user_type='$HTTP_POST_VARS[user_type]',
			user_abil='$user_abil' WHERE user_id='$HTTP_POST_VARS[ID]'");
			
		if ( $result )
			echo("$HTTP_POST_VARS[choice] has been updated.<br>");
		else
			echo("Unknown error.<br>");

		if ( $HTTP_POST_VARS['user_reset'] == 'yes' )
		{
			$resultb = connection("SELECT clan_name FROM information");
			$rowb = mysql_fetch_array($resultb); extract($rowb);
			
			$result = connection("SELECT * FROM users WHERE user_email='$HTTP_POST_VARS[user_email]'");
			$row = mysql_fetch_array($result); extract($row);
		
			$l = 8;
			for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
			$password = $s;
			
			$password = crypt(md5($password), md5($password));
			//$password = crypt($password,'$2a');
				
			$result = connection("UPDATE users SET
				user_pass='$password' WHERE user_email='$HTTP_POST_VARS[user_email]'");
					
			mail($HTTP_POST_VARS['user_email'],"Your reset password for $clan_name!","Your password has been reset for $clan_name\nPassword is: $s\n");		
			echo "Password reset and email sent!<br>";
			
		}
		
	}
	
	else if ( $_GET['perform'] == 'delete' ) {		
		mysql_query("DELETE FROM users WHERE user_id='$_GET[ID]'");
		echo("$_GET[choice] updated!");
	}
	
}

// PROCESS COMMENTS
if ( $HTTP_POST_VARS['choice'] == 'comments' ) {
	
	if ( $_GET['perform'] == 'delete' )
		mysql_query("DELETE FROM comments WHERE comments_id='$_GET[ID]'");
		echo "Comments deleted.";
}

if ( $_GET['choice'] == 'comments' ) {
	
	if ( $_GET['perform'] == 'delete' )
		mysql_query("DELETE FROM comments WHERE comments_id='$_GET[ID]'");
		echo "Comments deleted.";
}

?>
<p>
redirecting in 5 seconds...
</body>
</html>