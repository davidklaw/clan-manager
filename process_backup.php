<? include("global.php"); ?>
<html>

<head>
	<title>Processing... please wait</title>
	<link rel="stylesheet" href="cm.css" type="text/css">
<?
 if ( $choice == null ) {
?>
	<META HTTP-EQUIV="refresh" CONTENT="10;url=../index.php">
<?
 }
 else {
?>
	<META HTTP-EQUIV="refresh" CONTENT="3;url=index.php?option=<?=$choice?>">
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

if ( $perform == "Register" )
{
	$required_fields = explode(",", $_POST['required'] );
		
	$error = 0; 
	foreach($required_fields as $fieldname) {  // check for blank fields
		if ( $_POST[$fieldname] == "") {
    	$error++;
    }
	}
	
	if ( $error == 0 ) {
		
		//check for existing email or username
		$result = connection("SELECT user_email FROM users WHERE user_email='$user_email'");
		if ( $row = mysql_fetch_array($result)) {
			extract($row); $check_email = $user_email; 
		}
		
		$result2 = connection("SELECT user_name FROM users WHERE user_name='$user_name'");
		if ($row2 = mysql_fetch_array($result2)) {
		  extract($row2); $check_name = $user_name; 
		}
		
		if ( ( $check_email == NULL ) && ( $check_name == NULL ) ) {
			
			$user_id = uniqid("ID");
			
			$resultb = connection("SELECT clan_name FROM information");
			$rowb = mysql_fetch_array($resultb); extract($rowb);
			
			$l = 8;
			for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
				$password = $s;

			$password = crypt($password,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');

			$result = connection("INSERT INTO users
				(user_id,
				user_name,
				user_pass,
				user_email,
				user_type) VALUES 
				('$user_id',
				'$user_name',
				'$password',
				'$user_email',
				'standard')");
		
			if ($result) {
					echo "Thank you for registering.<br>Your password will now be emailed to you.<br>";
					mail($user_email,"Your password for $clan_name!","Thank you for registering with $clan_name!\nYour Password is: $s\n","From: A Clan Manager <@>\r\n");		
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

else if ( $perform == "AddComment" )
{
	if ( $register == "YES" ) {
		
		if ( ($Comment) && ( logintest($cm) == TRUE ) ) {
			
			$comments_id = uniqid("ID");

			$result = connection("INSERT INTO comments
					(comments_id,
					news_id,
					userID,
					comment) VALUES 
					('$comments_id',
					'$ID',
					'$cm[0]',
					'$Comment')");

			if ($result)
					echo "Your comment has been added.<br>";
			else
				echo "error.<br>";
		}
		else
			echo "Please complete the forms.<br>";
	}
	
	else if ( $register == "NO" ) {
		
		if ( $Comment ) {
			
			$comments_id = uniqid("ID"); //create a player_id
			
			if ( logintest($cm) == FALSE ) {
				if ( $comment_name == NULL )
					$comment_name = "guest";
			}			
			else
				$comment_name = $cm[0];
							
			$result = connection("INSERT INTO comments
					(comments_id, news_id, userID, comment) VALUES 
					('$comments_id', '$ID', '$comment_name','$Comment')");

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

else if ( $perform == "SendMail" )
{

	if ( $mail_youradd != null )
		$from = $mail_youradd;
	else
		$from = "A Clan Manager";

		mail($recipient,$mail_subject,$mail_content,"From: $from\r\n");		
		echo "Email sent!<br>";

}

//**************************************************************************//

else if ( $perform == "ResetPassword" )
{
	$resultb = connection("SELECT clan_name FROM information");
	$rowb = mysql_fetch_array($resultb); extract($rowb);
	
	$result = connection("SELECT user_name,user_pass,user_email FROM users WHERE user_email='$useremail'");
	if ( $row = mysql_fetch_array($result) ) 
		extract($row);

	if (( $user_name == $username ) && ( $user_email == $useremail )) {
	
		$l = 8;
		for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
		$password = $s;
	
		$password = crypt($password,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');
		
		$result = connection("UPDATE users SET
			user_pass='$password' WHERE user_email='$user_email'");
			
		mail($user_email,"Your new password for $clan_name!","Your password has been reset for $clan_name\nPassword is: $s\n","From: A Clan Manager <@>\r\n");		
		echo "Password reset and email sent!<br>";
	}
	
}

//**************************************************************************//

else if ( $perform == "EditProfile" )
{
	
	//check for existing email or username
	$result = connection("SELECT user_email FROM users WHERE user_email='$user_email'");
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
			if ( $old_pass && $new_pass && $retype_pass && $new_email )
			{
				
				$result = connection("UPDATE users SET
					user_email='$new_email' WHERE user_id='$cm[0]'");
				
				if ( $result )
					echo "Email updated.<br>";
				else
					echo "Email update error.<br>";
				
				if ( $new_pass == $retype_pass && $retype_pass != $old_pass )
				{
					$password = crypt($retype_pass,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');
					
					$result = connection("UPDATE users SET
						user_pass='$password' WHERE user_id='$cm[0]'");
					
					if ( $result )
						echo "Password updated.<br>";
					else
						echo "Password update error.<br>";
		
				}
				else
					echo "Please make sure the new password was retyped correctly.<br>";
			}
			else if ( $new_email )
			{
				$result = connection("UPDATE users SET
					user_email='$new_email' WHERE user_id='$cm[0]'");
				
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

if ( $_REQUEST["choice"] == 'contacts' ) {
	
	$result = connection("UPDATE contacts SET
		webmaster='$webmaster',
		manager='$manager',
		scheduler='$scheduler',
		recruiting='$recruiting',
		help='$help',
		marketing='$marketing'");
	
	if ( $result )
		echo("$choice has been updated.<br>");
	else
		echo("Unknown error.<br>");
}	

//**************************************************************************//

if ( $_REQUEST["choice"] == 'demos' ) {
	
	if ( $_REQUEST["perform"] == 'add' ) {		
		
		$demo_id = uniqid("demoID");
		$demo_comment = nl2br($demo_comment);
	
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
			'$demo_awayteam',
			'$demo_map',
			'$demo_event',
			'$demo_pov',
			'$demo_match',
			'$demo_comment',
			'$cm[0]',
			'$demo_file_name',
			'$demo_file_size')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
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
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		$demo_comment = nl2br($demo_comment);  
		
		if ( $demo_file != NULL ) {
			
			// DELETE OLD FILE
			$result = connection("SELECT demo_file FROM demos WHERE demo_id='$ID'");
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
			$result = connection("UPDATE demos SET
				demo_file='$demo_file_name',
				demo_size='$demo_file_size' WHERE demo_id='$ID'");			
			
		}
		
		$result = connection("UPDATE demos SET
			demo_awayteam='$demo_awayteam',
			demo_event='$demo_event',
			demo_pov='$demo_pov',
			demo_match='$demo_match',
			demo_comment='$demo_comment',
			demo_map='$demo_map' WHERE demo_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {
		
		$result = connection("SELECT demo_file FROM demos WHERE demo_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $row ) {
			$delete = unlink("files/demos/$demo_file");
			mysql_query("DELETE FROM demos WHERE demo_id='$ID'");
			echo "Demo deleted.<br>";
		}
		echo("$choice updated!<br>");			
	}
	
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'events' ) {

	if ( $_REQUEST["perform"] == 'add' ) {
		
		$event_id = uniqid("eventID");
		$event_description = nl2br($event_description);  
		
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
			'$event_name',
			'$event_start',
			'$event_end',
			'$event_price',
			'$event_game',
			'$event_time',
			'$event_contact',
			'$event_location',
			'$event_type',
			'$event_description')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");	
		
		if ( $event_image != null ) {
		
			if ( is_uploaded_file($HTTP_POST_FILES['event_image']['tmp_name']) ) {
				
				if ( copy($HTTP_POST_FILES['event_image']['tmp_name'],"files/events/".$HTTP_POST_FILES['event_image']['name']) )
				{
					unlink($HTTP_POST_FILES['event_image']['tmp_name']);
					echo "Image submitted!<br>";
					
					//UPDATE DB
					$result = connection("UPDATE events SET
					event_image='$event_image_name' WHERE event_id='$event_id'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		$result = connection("UPDATE events SET
		event_name='$event_name',
		event_start='$event_start',
		event_end='$event_end',
		event_price='$event_price',
		event_game='$event_game',
		event_time='$event_time',
		event_contact='$event_contact',
		event_location='$event_location',
		event_type='$event_type',
		event_description='$event_description' WHERE event_id='$ID'");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $remove_img == "Y" ) {
			$result = connection("SELECT event_image FROM events WHERE event_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/events/$event_image");
			
			//UPDATE DB
			$result = connection("UPDATE events SET
			event_image='' WHERE event_id='$ID'");
		}
		
				
		if ( $event_image != null ) {
		
			if ( is_uploaded_file($HTTP_POST_FILES['event_image']['tmp_name']) ) {
				
				// DELETE OLD FILE
				$result = connection("SELECT event_image FROM events WHERE event_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
				
				if ( $row )	
					$delete = unlink("files/events/$event_image");
					
				if ( copy($HTTP_POST_FILES['event_image']['tmp_name'],"files/events/".$HTTP_POST_FILES['event_image']['name']) )
				{
					unlink($HTTP_POST_FILES['event_image']['tmp_name']);
					echo "Image submitted!<br>";
					//UPDATE DB
					$result = connection("UPDATE events SET
					event_image='$event_image_name' WHERE event_id='$ID'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else if ( $event_image != null && $remove_img != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
				
		}
	}
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		$result = connection("SELECT event_image FROM events WHERE event_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/events/$event_image");
		mysql_query("DELETE FROM events WHERE event_id='$ID'");
		echo "Event deleted!<br>";
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'files' ) {
	
	if ( $_REQUEST["perform"] == 'add' ) {		
		
		$file_id = uniqid("fileID");
	
		$result = connection("INSERT INTO files
			(file_id,
			file_name,
			file_size,
			file_description,
			file_external) VALUES 
			('$file_id',
			'$file_data_name',
			'$file_data_size',
			'$file_description',
			'$file_external')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
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
	else if ( $_REQUEST["perform"] == 'edit' ) {

		if ( $file_data != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['file_data']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT file_name FROM files WHERE file_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/$file_name");
				
				if ( copy($HTTP_POST_FILES['file_data']['tmp_name'],"files/".$HTTP_POST_FILES['file_data']['name']) )
				{
					unlink($HTTP_POST_FILES['file_data']['tmp_name']);
					echo "File submitted!<br>";
					//UPDATE DB
					$result = connection("UPDATE files SET
					file_name='$file_data_name',
					file_size='$file_data_size' WHERE file_id='$ID'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $file_name != null )
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		$result = connection("UPDATE files SET
			file_description='$file_description',
			file_external='$file_external' WHERE file_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
	}
	else if ( $_REQUEST["perform"] == 'delete' ) {
		$result = connection("SELECT file_name FROM files WHERE file_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/$file_name");
		mysql_query("DELETE FROM files WHERE file_id='$ID'");
		echo("$choice updated!<br>File deleted.<br>");		
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'information' ) {
	
	$clan_background = nl2br($clan_background);
	
	$result = connection("UPDATE information SET
		clan_name='$clan_name',
		clan_tag='$clan_tag',
		clan_irc='$clan_irc',
		clan_background='$clan_background',
		clan_irc_server='$clan_irc_server'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'links' ) {

	if ( $_REQUEST["perform"] == 'add' ) {
		
		$link_id = uniqid("linkID");
		$link_description = nl2br($link_description);  
		
		$result = connection("INSERT INTO links
			(link_id,
			link_name,
			link_url,
			link_description,
			link_type) VALUES 
			('$link_id',
			'$link_name',
			'$link_url',
			'$link_description',
			'$link_type')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");		
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		$link_description = nl2br($link_description); 
		
		$result = connection("UPDATE links SET
			link_name='$link_name',
			link_url='$link_url',
			link_description='$link_description',
			link_type='$link_type' WHERE link_id='$ID'");
				
			if ( $result )
				echo("$choice has been updated.<br>");
			else
				echo("Unknown error.<br>");		
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		mysql_query("DELETE FROM links WHERE link_id='$ID'");
		echo "Link deleted!<br>";
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'mail' ) {
	
	$from = UserName($cm[0]);
	
	if ( $mail_to == 'ALL' ) {
		$result = connection("SELECT roster_email FROM roster");
		while( $row = mysql_fetch_array($result)) {
			extract($row);
			mail($roster_email,$mail_subject,"This is an email from one of your clan members:\n\n$mail_content","From: $from <@>\r\n");
		}
	}	
	else
		mail($mail_to,$mail_subject,"This is an email from one of your clan members:\n\n$mail_content","From: $from <@>\r\n");

	echo "Mail sent!<br>";
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'news' ) {
	
	if ( $_REQUEST["perform"] == 'add' ) {
		
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
			'$news_subject',
			'$news_content',
			'$news_date',
			'$news_time',
			'$news_caption',
			'$news_numdate',
			'$news_comments')");
	
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
		
		if ( $news_image != null ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['news_image']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['news_image']['tmp_name'],"files/news/".$HTTP_POST_FILES['news_image']['name']) )
				{
					unlink($HTTP_POST_FILES['news_image']['tmp_name']);
					//UPDATE DB
					$result = connection("UPDATE news SET
						news_image='$news_image_name' WHERE news_id='$news_id'");
					echo "Image attached!<br>";
				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}	
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
	
		// add line breaks to content
		// $news_content = nl2br($news_content);   		
		
		if ( $remove_img == "Y" ) {
			$result = connection("SELECT news_image FROM news WHERE news_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/news/$news_image");
			//UPDATE DB
			$result = connection("UPDATE news SET
			news_image='' WHERE news_id='$ID'");
		}
		
		if ( $news_image != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['news_image']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT news_image FROM news WHERE news_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/news/$news_image");
				
				if ( copy($HTTP_POST_FILES['news_image']['tmp_name'],"files/news/".$HTTP_POST_FILES['news_image']['name']) )
				{
					unlink($HTTP_POST_FILES['news_image']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$result = connection("UPDATE news SET
					news_image='$news_image_name' WHERE news_id='$ID'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $event_image != null && $remove_img != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		$result = connection("UPDATE news SET
			news_subject='$news_subject',
			news_content='$news_content',
			news_comments='$news_comments',
			news_caption='$news_caption' WHERE news_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {
		
		$result = connection("SELECT news_image FROM news WHERE news_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		
		if ( $news_image != null )	
			$delete = unlink("files/news/$news_image");
			
		mysql_query("DELETE FROM news WHERE news_id='$ID'");
		
		mysql_query("DELETE FROM comments WHERE news_id='$ID'");
		echo "Comments deleted for this article.<br>";
		echo("News deleted.<br>");		
		
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'records' ) {

	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "*";
	$IMG_WIDTH  = "100";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	require("imgfuncs.php");
	
	if ( $_REQUEST["perform"] == 'add' ) {
		
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
			'$record_awayteam',
			'$record_awaytag',
			'$record_map',
			'$record_roster',
			'$record_ctw',
			'$record_ctl',
			'$record_tw',
			'$record_tl',
			'$record_otw',
			'$record_otl',
			'$record_league',
			'$record_date',
			'$record_time',
			'$record_hltv',
			'$record_scorebot',
			'$record_mvp',
			'$record_event',
			'$record_comments',
			'$record_type')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $record_screen1 != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen1']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen1']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen1']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";
						
					if( $f_res = resizer_main("record_screen1","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen1']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen1']['tmp_name']);
						//UPDATE DB
						$result = connection("UPDATE records SET
							record_screen1='$record_screen1_name' WHERE record_id='$record_id'");
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
		if ( $record_screen2 != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen2']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen2']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen2']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen2","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen2']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen2']['tmp_name']);
						//UPDATE DB
						$result = connection("UPDATE records SET
							record_screen2='$record_screen2_name' WHERE record_id='$record_id'");
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
		if ( $record_screen3 != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen3']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen3']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen3']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";

					if( $f_res = resizer_main("record_screen3","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen3']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen3']['tmp_name']);
						//UPDATE DB
						$result = connection("UPDATE records SET
							record_screen3='$record_screen3_name' WHERE record_id='$record_id'");
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
		if ( $record_screen4 != NULL ) {
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen4']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['record_screen4']['tmp_name'],"files/matches/".$HTTP_POST_FILES['record_screen4']['name']) )
				{
					
					$IMG_ROOT = "files/matches/";
							
					if( $f_res = resizer_main("record_screen4","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['record_screen4']['name']))
					{
						unlink($HTTP_POST_FILES['record_screen4']['tmp_name']);
						//UPDATE DB
						$result = connection("UPDATE records SET
							record_screen4='$record_screen4_name' WHERE record_id='$record_id'");
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
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		if ( $remove_img1 == "Y" ) {
			$result = connection("SELECT record_screen1 FROM records WHERE record_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen1");
			$delete = unlink("files/matches/thumb-$record_screen1");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen1='' WHERE record_id='$ID'");
		}
		
		if ( $record_screen1 != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen1']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen1 FROM records WHERE record_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
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
						$result = connection("UPDATE records SET
						record_screen1='$record_screen1_name' WHERE record_id='$ID'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $record_screen1 != null && $remove_img1 != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $remove_img2 == "Y" ) {
			$result = connection("SELECT record_screen2 FROM records WHERE record_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen2");
			$delete = unlink("files/matches/thumb-$record_screen2");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen2='' WHERE record_id='$ID'");
		}
		
		if ( $record_screen2 != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen2']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen2 FROM records WHERE record_id='$ID'");
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
						$result = connection("UPDATE records SET
						record_screen2='$record_screen2_name' WHERE record_id='$ID'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $record_screen2 != null && $remove_img2 != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $remove_img3 == "Y" ) {
			$result = connection("SELECT record_screen3 FROM records WHERE record_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen3");
			$delete = unlink("files/matches/thumb-$record_screen3");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen3='' WHERE record_id='$ID'");
		}
		
		if ( $record_screen3 != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen3']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen3 FROM records WHERE record_id='$ID'");
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
						$result = connection("UPDATE records SET
						record_screen3='$record_screen3_name' WHERE record_id='$ID'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $record_screen3 != null && $remove_img3 != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $remove_img4 == "Y" ) {
			$result = connection("SELECT record_screen4 FROM records WHERE record_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/matches/$record_screen4");
			$delete = unlink("files/matches/thumb-$record_screen4");
			//UPDATE DB
			$result = connection("UPDATE records SET
			record_screen4='' WHERE record_id='$ID'");
		}
		
		if ( $record_screen4 != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['record_screen4']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT record_screen4 FROM records WHERE record_id='$ID'");
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
						$result = connection("UPDATE records SET
						record_screen4='$record_screen4_name' WHERE record_id='$ID'");	
					}
					else
						echo "Thumbnail creation error.<br>";
						
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $record_screen4 != null && $remove_img4 != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		$result = connection("UPDATE records SET
			record_awayteam='$record_awayteam',
			record_awaytag='$record_awaytag',
			record_map='$record_map',
			record_roster='$record_roster',
			record_ctw='$record_ctw',
			record_ctl='$record_ctl',
			record_tw='$record_tw',
			record_tl='$record_tl',
			record_otw='$record_otw',
			record_otl='$record_otl',
			record_league='$record_league',
			record_date='$record_date',
			record_time='$record_time',
			record_hltv='$record_hltv',
			record_scorebot='$record_scorebot',
			record_mvp='$record_mvp',
			record_event='$record_event',
			record_comments='$record_comments',
			record_type='$record_type' WHERE record_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");	
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		
		$result = connection("SELECT record_screen1,record_screen2 FROM records WHERE record_id='$ID'");
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
		mysql_query("DELETE FROM records WHERE record_id='$ID'");
		echo("Record and images deleted.<br>");	
	}
}

//**************************************************************************//

else if ( $_REQUEST["choice"] == 'roster' ) {
	
	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "*";
	$IMG_WIDTH  = "100";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	
	if ( $_REQUEST["perform"] == 'add' ) {
		
		$roster_id = uniqid("rosterID");
		$roster_bio = nl2br($roster_bio);
		$roster_prevclans= nl2br($roster_prevclans);
		$roster_lanexp= nl2br($roster_lanexp);
		
		// if user who posted does not have a roster_user yet, put his id in there
		// make sure this roster_user doesn't already exist!
		$resultw = connection("SELECT * FROM users WHERE user_id='$cm[0]'");
		$roww = mysql_fetch_array($resultw); extract($roww);
		
		if ( $user_onteam == 'yes' )
		{
			$resultx = connection("SELECT * FROM roster WHERE roster_user='$cm[0]'");
			$rowx = mysql_fetch_array($resultx); extract($rowx);
			
			if ( $rowx != null )
				echo "A roster member with a similar id exists.";
			else
				$roster_user = $cm[0];
		}	
		
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
			'$roster_alias',
			'$roster_name',
			'$roster_rank',
			'$roster_status',
			'$roster_age',
			'$roster_gender',
			'$roster_email',
			'$roster_location',
			'$roster_bio',
			'$roster_quote',
			'$roster_wonid',
			'$roster_sogamed',
			'$roster_gotfrag',
			'$computer_brand',
			'$computer_mobo',
			'$computer_cpu',
			'$computer_ram',
			'$computer_video',
			'$computer_sound',
			'$computer_monitor',
			'$computer_resolution',
			'$computer_headphones',
			'$computer_keyboard',
			'$computer_mouse',
			'$computer_sens',
			'$computer_pad',
			'$computer_accessories',
			/* new as of 3.0 */
			'$roster_job',
			'$computer_refresh',
			'$computer_vsync',
			'$computer_drive',
			'$roster_msn',
			'$roster_yahoo',
			'$roster_aim',
			'$roster_favfood',
			'$roster_favmap',
			'$roster_favweapon',
			'$roster_favplayer',
			'$roster_favmovie',
			'$roster_favmusic',
			'$roster_homepage',
			'$roster_lanexp',
			'$roster_prevclans')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $roster_photo != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['roster_photo']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['roster_photo']['tmp_name'],"files/roster/".$HTTP_POST_FILES['roster_photo']['name']) )
				{
					
					$IMG_ROOT = "files/roster/";
					require("imgfuncs.php");
						
					if( $f_res = resizer_main("roster_photo","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['roster_photo']['name']))
					{
						unlink($HTTP_POST_FILES['roster_photo']['tmp_name']);
						//UPDATE DB
						$result = connection("UPDATE roster SET
							roster_photo='$roster_photo_name' WHERE roster_id='$roster_id'");
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

		if ( $roster_config != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['roster_config']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['roster_config']['tmp_name'],"files/configs/".$roster_alias."-".$HTTP_POST_FILES['roster_config']['name']) )
				{
					unlink($HTTP_POST_FILES['roster_config']['tmp_name']);
					//UPDATE DB
					$result = connection("UPDATE roster SET
						roster_config='$roster_alias-$roster_config_name' WHERE roster_id='$roster_id'");
					echo "Config attached!<br>";
				}
				else 
					echo "Config attachment error.<br>";
			}
			else 
				echo "Information stored but config too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {

		$roster_bio = nl2br($roster_bio);   
		$roster_prevclans= nl2br($roster_prevclans);
		$roster_lanexp= nl2br($roster_lanexp);
		
		if ( $remove_img == "Y" ) {
			$result = connection("SELECT roster_photo FROM roster WHERE roster_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/roster/$roster_photo");
			$delete = unlink("files/roster/thumb-$roster_photo");
			//UPDATE DB
			$result = connection("UPDATE roster SET
			roster_photo='' WHERE roster_id='$ID'");
		}
		
		if ( $roster_photo != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['roster_photo']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT roster_photo FROM roster WHERE roster_id='$ID'");
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
						$result = connection("UPDATE roster SET
						roster_photo='$roster_photo_name' WHERE roster_id='$ID'");
					}
					else
						echo "Thumbnail creation error.<br>";

				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $roster_photo != null && $remove_img != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
		
		if ( $remove_config == "Y" ) {
			$result = connection("SELECT roster_config FROM roster WHERE roster_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/roster/$roster_config");
			//UPDATE DB
			$result = connection("UPDATE roster SET
			roster_config='' WHERE roster_id='$ID'");
		}
		
		if ( $roster_config != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['roster_config']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT roster_config FROM roster WHERE roster_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/roster/$roster_config");
				
				if ( copy($HTTP_POST_FILES['roster_config']['tmp_name'],"files/configs/".$roster_alias."-".$HTTP_POST_FILES['roster_config']['name']) )
				{
					unlink($HTTP_POST_FILES['roster_config']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$result = connection("UPDATE roster SET
					roster_config='$roster_alias-$roster_config_name' WHERE roster_id='$ID'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $roster_config != null && $remove_config != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}
	
		$result = connection("UPDATE roster SET
			roster_alias='$roster_alias',
			roster_name='$roster_name',
			roster_rank='$roster_rank',
			roster_status='$roster_status',
			roster_age='$roster_age',
			roster_gender='$roster_gender',
			roster_email='$roster_email',
			roster_location='$roster_location',
			roster_bio='$roster_bio',
			roster_quote='$roster_quote',
			roster_wonid='$roster_wonid',
			roster_sogamed='$roster_sogamed',
			roster_gotfrag='$roster_gotfrag',
			computer_brand='$computer_brand',
			computer_mobo='$computer_mobo',
			computer_cpu='$computer_cpu',
			computer_ram='$computer_ram',
			computer_video='$computer_video',
			computer_sound='$computer_sound',
			computer_monitor='$computer_monitor',
			computer_resolution='$computer_resolution',
			computer_headphones='$computer_headphones',
			computer_keyboard='$computer_keyboard',
			computer_mouse='$computer_mouse',
			computer_sens='$computer_sens',
			computer_pad='$computer_pad',
			computer_accessories='$computer_accessories',
			/* new as of 3.0 */
			roster_job='$roster_job',
			computer_refresh='$computer_refresh',
			computer_vsync='$computer_vsync',
			computer_drive='$computer_drive',
			roster_msn='$roster_msn',
			roster_yahoo='$roster_yahoo',
			roster_aim='$roster_aim',
			roster_favfood='$roster_favfood',
			roster_favmap='$roster_favmap',
			roster_favweapon='$roster_favweapon',
			roster_favplayer='$roster_favplayer',
			roster_favmovie='$roster_favmovie',
			roster_favmusic='$roster_favmusic',
			roster_homepage='$roster_homepage',
			roster_lanexp='$roster_lanexp',
			roster_prevclans='$roster_prevclans' WHERE roster_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		$result = connection("SELECT roster_photo,roster_config FROM roster WHERE roster_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		if ( $roster_photo ) {
			$delete = unlink("files/roster/$roster_photo");
			$delete = unlink("files/roster/thumb-$roster_photo");
		}
		if ( $roster_config )
			$delete = unlink("files/configs/$roster_config");
		mysql_query("DELETE FROM roster WHERE roster_id='$ID'");
		echo("Player deleted!");
	}	
}

//**************************************************************************//
	
if ( $_REQUEST["choice"] == 'screenshots' ) {
	
	$IMG_ORG_HEIGHT	= "*";
	$IMG_ORG_WIDTH  = "600";
	$IMG_HEIGHT = "108";
	$IMG_WIDTH  = "*";				
	$use_imagecreatetruecolor = true;
	$use_imagecopyresampled	  = true;
	$JPG_QUALITY	=	90;
	
	if ( $_REQUEST["perform"] == 'add' ) {		
		
		$screen_id = uniqid("screenID");
	
		if ( $screen_gallery == null && $screen_newgallery == null )
			echo "Please specify a gallery.<br>";
		
		// if existing gallery, post in it
		else if  ( !$screen_newgallery )
		{	
			$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
			$rowg = mysql_fetch_array($resultg); extract($rowg);
			
			if ( $screen != NULL ) {	
				if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
					
					$IMG_ROOT = "files/screenshots/$gallery_name";
					require("imgfuncs.php");
					
					if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
					{		
						if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
						{
														
							unlink($HTTP_POST_FILES['screen']['tmp_name']);
							echo "Screenshot added!<br>";
							
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
									'$screen_caption')");
							
								if ( $result )
									echo("$choice has been updated.<br>");
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
		else if ( $screen_newgallery ) 
		{	
			$gallery_id = uniqid("gallID");
			$result = connection("INSERT INTO galleries
				(gallery_id,
				gallery_name,
				gallery_desc,
				gallery_date,
				gallery_location) VALUES 
				('$gallery_id',
				'$screen_newgallery',
				'$gallery_desc',
				'$gallery_date',
				'$gallery_location')");
		
			if ( $result )
				echo("New gallery created.<br>");
			else
				echo("Unknown error.<br>");
														
			if ( $make = mkdir("files/screenshots/$screen_newgallery", 0777) ) {
				
				chmod ("files/screenshots/$screen_newgallery",0777);
				
				echo "New gallery added: <b>$screen_newgallery</b><br>";
				if ( $screen != NULL ) {	
					if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
						
						$IMG_ROOT = "files/screenshots/$screen_newgallery";
						require("imgfuncs.php");
							
						if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
						{
							if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT, $HTTP_POST_FILES['screen']['name']))
							{
								
								unlink($HTTP_POST_FILES['screen']['tmp_name']);
								echo "Screenshot added!<br>";
									
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
									'$screen_caption')");
							
								if ( $result )
									echo("$choice has been updated.<br>");
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
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		if ( $screen_gallery == null )
			echo "Please specify a gallery.<br>";
		
		else {
			
			// upload photo if there is a new one
			if ( $screen != null ) {

				if ( is_uploaded_file($HTTP_POST_FILES['screen']['tmp_name']) ) {
					
					$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
					$rowg = mysql_fetch_array($resultg); extract($rowg);
					
					$IMG_ROOT = "files/screenshots/$gallery_name";
						
					require("imgfuncs.php");
						
					if( $f_org = resizer_main("screen","",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT,$screen_name))
					{		
						if( $f_res = resizer_main("screen","thumb-",$IMG_WIDTH,$IMG_HEIGHT,$screen_name))
						{

							$result = connection("UPDATE screenshots SET
								screen_name='$screen_name',
								screen_size='$screen_size' WHERE screen_id='$ID'");
							
							$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$oldgallery'");
							$rowg = mysql_fetch_array($resultg); extract($rowg);
														
							unlink("files/screenshots/$gallery_name/$oldscreen");
							unlink("files/screenshots/$gallery_name/thumb-$oldscreen");
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

			if ( $screen_gallery != $oldgallery )
			{
				$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$oldgallery'");
				$rowg = mysql_fetch_array($resultg); extract($rowg);
				$olddir = $gallery_name;
				
				$resultg = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
				$rowg = mysql_fetch_array($resultg); extract($rowg);
				$newdir = $gallery_name;
				
				// move to a new gallery
				copy("files/screenshots/$olddir/$oldscreen","files/screenshots/$newdir/$oldscreen");
	  		copy("files/screenshots/$olddir/thumb-$oldscreen","files/screenshots/$newdir/thumb-$oldscreen");
	  		echo "File moved.<br>";
	  		
				// delete old instance and check for empty directory
				unlink("files/screenshots/$olddir/$oldscreen");
				unlink("files/screenshots/$olddir/thumb-$oldscreen");
	  		
	  		$resulty = connection("SELECT * FROM screenshots WHERE screen_gallery='$oldgallery'");
				$numy = mysql_num_rows($resulty);
				
				if ( $numy == 1 ) {
					$delete_path = "files/screenshots/$olddir";
					
					$remove = exec("rm -r $delete_path");
					if ( $remove )
						echo "Old directory is empty and has been removed.<br>";
					mysql_query("DELETE FROM galleries WHERE gallery_id='$oldgallery'");
				}	
			}
			
			$result = connection("UPDATE screenshots SET
			screen_caption='$screen_caption',
			screen_gallery='$screen_gallery' WHERE screen_id='$ID'");
			
			$result = connection("UPDATE galleries SET
			gallery_desc='$gallery_desc',
			gallery_date='$gallery_date',
			gallery_location='$gallery_location' WHERE gallery_id='$screen_gallery'");
			
			if ( $result )
				echo("$choice has been updated.<br>");
			else
				echo("Unknown error.<br>");
			
		}	
	}	
		
	else if ( $_REQUEST["perform"] == 'delete' ) {
		
		$result = connection("SELECT screen_name,screen_gallery FROM screenshots WHERE screen_id='$ID'");
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
		
		mysql_query("DELETE FROM screenshots WHERE screen_id='$ID'");
		echo("$choice updated!<br>");
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'servers' ) {

	if ( $_REQUEST["perform"] == 'add' ) {
				
		$result = connection("INSERT INTO servers
			(server_name,
			server_ip,
			server_type) VALUES 
			('$server_name',
			'$server_ip',
			'$server_type')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");

		if ( $server_maplist != NULL ) {	
			if ( is_uploaded_file($HTTP_POST_FILES['server_maplist']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['server_maplist']['tmp_name'],"files/servers/".$server_ip."-".$HTTP_POST_FILES['server_maplist']['name']) )
				{
					unlink($HTTP_POST_FILES['server_maplist']['tmp_name']);
					$result = connection("UPDATE servers SET
						server_maplist='$server_ip-$server_maplist_name' WHERE server_ip='$server_ip'");
					echo "Text file attached!<br>";
				}
				else 
					echo "File attachment error.<br>";
			}
			else 
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
		
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		if ( $remove_list == "Y" ) {
			$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/servers/$server_maplist");
			//UPDATE DB
			$result = connection("UPDATE servers SET
			server_maplist='' WHERE server_ip='$ID'");
		}
		
		if ( $server_maplist != NULL ) {
			
			if ( is_uploaded_file($HTTP_POST_FILES['server_maplist']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/servers/$server_maplist");
				
				if ( copy($HTTP_POST_FILES['server_maplist']['tmp_name'],"files/servers/".$server_ip."-".$HTTP_POST_FILES['server_maplist']['name']) )
				{
					unlink($HTTP_POST_FILES['server_maplist']['tmp_name']);
					echo "Text file attached!<br>";
					//UPDATE DB
					$result = connection("UPDATE servers SET
					server_maplist='$server_ip-$server_maplist_name' WHERE server_ip='$ID'");	
				}
				else 
					echo "File submission error.<br>";
			}
			else if ( $server_maplist != null && $remove_list != 'Y' )
				echo "Information stored but file too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}		
		
		$result = connection("UPDATE servers SET
			server_name='$server_name',
			server_ip='$server_ip',
			server_type='$server_type' WHERE server_ip='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");

	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		$result = connection("SELECT server_maplist FROM servers WHERE server_ip='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/servers/$server_maplist");
		mysql_query("DELETE FROM servers WHERE server_ip='$ID'");
		echo("$choice updated!<br>");
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'settings' ) {

	$result = connection("UPDATE prefs SET date_format='$date_format'");
	$result = connection("UPDATE settings SET force_register='$force_register', cm_dir='$cmdir'");
	
	if ( $result )
		echo("$choice has been updated.");
	else
		echo("Unknown error.");

}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'sponsors' ) {
	
	if ( $_REQUEST["perform"] == 'add' ) {		
		
		$sponsor_id = uniqid("sponsorID");
		$sponsor_description = nl2br($sponsor_description);  
				
		$result = connection("INSERT INTO sponsors
			(sponsor_id,
			sponsor_name,
			sponsor_url,
			sponsor_description) VALUES 
			('$sponsor_id',
			'$sponsor_name',
			'$sponsor_url',
			'$sponsor_description')");
	
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
		
		if ( $sponsor_image != NULL ) {	

			if ( is_uploaded_file($HTTP_POST_FILES['sponsor_image']['tmp_name']) ) {
				if ( copy($HTTP_POST_FILES['sponsor_image']['tmp_name'],"files/sponsors/".$HTTP_POST_FILES['sponsor_image']['name']) )
				{
					unlink($HTTP_POST_FILES['sponsor_image']['tmp_name']);
					$result = connection("UPDATE sponsors SET
						sponsor_image='$sponsor_image_name' WHERE sponsor_id='$sponsor_id'");
					echo "Image attached!<br>";
				}
				else 
					echo "Image attachment error.<br>";
			}
			else 
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";						
		}
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
			
		if ( $remove_img == "Y" ) {
			$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$ID'");
			$row = mysql_fetch_array($result); extract($row);			
			$delete = unlink("files/sponsors/$sponsor_image");
			//UPDATE DB
			$result = connection("UPDATE sponsors SET
			sponsor_image='' WHERE sponsor_id='$ID'");
		}
		
		if ( $sponsor_image != NULL ) {

			if ( is_uploaded_file($HTTP_POST_FILES['sponsor_image']['tmp_name']) ) {
			
				// DELETE OLD FILE
				$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$ID'");
				$row = mysql_fetch_array($result); extract($row);
			
				if ( $row )	
					$delete = unlink("files/sponsors/$sponsor_image");
				
				if ( copy($HTTP_POST_FILES['sponsor_image']['tmp_name'],"files/sponsors/".$HTTP_POST_FILES['sponsor_image']['name']) )
				{
					unlink($HTTP_POST_FILES['sponsor_image']['tmp_name']);
					echo "Image attached!<br>";
					//UPDATE DB
					$result = connection("UPDATE sponsors SET
					sponsor_image='$sponsor_image_name' WHERE sponsor_id='$ID'");	
				}
				else 
					echo "Image submission error.<br>";
			}
			else if ( $sponsor_image != null && $remove_img != 'Y' )
				echo "Information stored but image too large.<br><b><font color=red>Check the FAQ for information about this.</font></b><br>";							
		}	
		
		$result = connection("UPDATE sponsors SET
			sponsor_name='$sponsor_name',
			sponsor_url='$sponsor_url',
			sponsor_description='$sponsor_description' WHERE sponsor_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");
				
	}
	else if ( $_REQUEST["perform"] == 'delete' ) {
		
		$result = connection("SELECT sponsor_image FROM sponsors WHERE sponsor_id='$ID'");
		$row = mysql_fetch_array($result); extract($row);	
		$delete = unlink("files/sponsors/$sponsor_image");
		mysql_query("DELETE FROM sponsors WHERE sponsor_id='$ID'");
		echo("$choice updated!");	
	}
}

//**************************************************************************//

if ( $_REQUEST["choice"] == 'templates' ) {
	
	if ( $_REQUEST["type"] == 'news' ) {	
		
		$result = connection("UPDATE templates SET
			news_headlines='$news_headlines',
			news_post='$news_post',
			news_posts='$news_posts'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
	}
	
	else if ( $_REQUEST["type"] == 'roster' ) {	
		
		$result = connection("UPDATE templates SET
			roster_list='$roster_list',
			roster_detail='$roster_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $_REQUEST["type"] == 'records' ) {	
		
		$result = connection("UPDATE templates SET
			records_upcoming='$records_upcoming',
			records_recent='$records_recent',
			records_list='$records_list',
			records_detail='$records_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $_REQUEST["type"] == 'files' ) {	
		
		$result = connection("UPDATE templates SET
			file_list='$file_list',
			file_detail='$file_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
		
	}


	else if ( $_REQUEST["type"] == 'links' ) {	
		
		$result = connection("UPDATE templates SET
			links_list='$links_list',
			links_detail='$links_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $_REQUEST["type"] == 'events' ) {	
		
		$result = connection("UPDATE templates SET
			event_recent='$event_recent',
			event_list='$event_list',
			event_detail='$event_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $_REQUEST["type"] == 'sponsors' ) {	
		
		$result = connection("UPDATE templates SET
			sponsor_list ='$sponsor_list',
			sponsor_detail='$sponsor_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
		
	}
	
	else if ( $_REQUEST["type"] == 'servers' ) {	

		$result = connection("UPDATE templates SET
			server_list ='$server_list',
			server_detail='$server_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
	}
	
	else if ( $_REQUEST["type"] == 'demos' ) {	

		$result = connection("UPDATE templates SET
			demos_recent='$demos_recent',
			demos_list='$demos_list',
			demos_detail='$demos_detail'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $_REQUEST["type"] == 'contacts' ) {	

		$result = connection("UPDATE templates SET
			contacts_list='$contacts_list'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $_REQUEST["type"] == 'information' ) {	

		$result = connection("UPDATE templates SET
			info_list='$info_list'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");

	}
	
	else if ( $_REQUEST["type"] == 'screenshots' ) {	

		$result = connection("UPDATE templates SET
			screens_detail='$screens_detail',
			screens_list='$screens_list'");
			
		if ( $result )
			echo("$choice has been updated.");
		else
			echo("Unknown error.");
	}

}

// PROCESS USERS
if ( $_REQUEST["choice"] == 'users' ) {

	if ( $_REQUEST["perform"] == 'add' ) {
		
		$user_id = uniqid("userID");
		$resultb = connection("SELECT clan_name FROM information");
		$rowb = mysql_fetch_array($resultb); extract($rowb);
			
		$l = 8;
		for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
		$password = $s;

		$password = crypt($password,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');
		
		$result = connection("INSERT INTO users
			(user_id,
			user_name,
			user_pass,
			user_email,
			user_type) VALUES 
			('$user_id',
			'$user_name',
			'$user_pass',
			'$user_email',
			'$user_type')");
			
		if ($result)
		{
			echo "New user added.<br>";
			mail($user_email,"Your password for $clan_name!","You have been added to $clan_name site. \nYour Username is: $user_name\nYour Password is: $s\n");		
		}
		else
			echo("Unknown error.");
				
	}
	
	else if ( $_REQUEST["perform"] == 'edit' )
	{
	
		// array abilities
		$user_abil .= $news.",";
		$user_abil .= $roster.",";
		$user_abil .= $records.",";
		$user_abil .= $events.",";
		$user_abil .= $templates.",";
		$user_abil .= $settings.",";
		$user_abil .= $users.",";
		$user_abil .= $general;
		
		$result = connection("UPDATE users SET
			user_name='$user_name',
			user_email='$user_email',
			user_type='$user_type',
			user_abil='$user_abil' WHERE user_id='$ID'");
			
		if ( $result )
			echo("$choice has been updated.<br>");
		else
			echo("Unknown error.<br>");

		if ( $user_reset == 'yes' )
		{
			$resultb = connection("SELECT clan_name FROM information");
			$rowb = mysql_fetch_array($resultb); extract($rowb);
			
			$result = connection("SELECT * FROM users WHERE user_email='$user_email'");
			$row = mysql_fetch_array($result); extract($row);
		
			$l = 8;
			for(;strlen($s)<=$l;$s.=chr(rand($a=ord('A'),ord('Z'))+ rand()%2*(ord('a')-$a)));
			$password = $s;
			
			$password = crypt($password,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');
				
			$result = connection("UPDATE users SET
				user_pass='$password' WHERE user_email='$user_email'");
					
			mail($user_email,"Your reset password for $clan_name!","Your password has been reset for $clan_name\nPassword is: $s\n");		
			echo "Password reset and email sent!<br>";
			
		}
		
	}
	
	else if ( $_REQUEST["perform"] == 'delete' ) {		
		mysql_query("DELETE FROM users WHERE user_id='$ID'");
		echo("$choice updated!");
	}
}

// PROCESS COMMENTS
if ( $_REQUEST["choice"] == 'comments' ) {
	
	if ( $_REQUEST["perform"] == 'delete' )
		mysql_query("DELETE FROM comments WHERE comments_id='$ID'");
		echo "Comments deleted.";
}

?>
<p>
redirecting in 3 seconds...
</body>
</html>