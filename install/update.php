<html>
	<head>
	<title>Clan Manager Update</title>
	<link rel="stylesheet" href="../cm.css" type="text/css">
	</head>

<body>

<center><br>

<?
	if ( $update ) {
		
		ini_set("max_execution_time", "11000");
			
		$errors =0 ;
		
		MySQL_connect($mysql_host,$mysql_dblogin,$mysql_dbpass) or die("could not connect to the MYSQL");
		MySQL_select_db($mysql_dbname) or die("Could not select database");

		$sql = "ALTER TABLE demos ADD `count` int(11) NOT NULL auto_increment, ADD PRIMARY KEY (`count`)";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }
			
		$sql = "ALTER TABLE records ADD `demo_id` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE records ADD `demo_match` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE records ADD `demo_downloads` bigint(20) NOT NULL default '0'";
		$result = mysql_query($sql);		
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE events DROP COLUMN event_start";
		$result = mysql_query($sql);
		$sql = "ALTER TABLE events DROP COLUMN event_end";
		$result = mysql_query($sql);
		$sql = "ALTER TABLE events DROP COLUMN event_time";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE events ADD `event_start` varchar(155) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }
		
		$sql = "ALTER TABLE events ADD `event_end` varchar(155) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }
		
		$sql = "ALTER TABLE events ADD `event_time` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }
				
		$sql = "ALTER TABLE events ADD `event_image` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE files ADD `file_downloads` bigint(11) NOT NULL default '0'";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		
		$sql = "CREATE TABLE `galleries` (
		  `gallery_id` varchar(255) NOT NULL default '',
		  `gallery_name` varchar(255) NOT NULL default '',
		  `gallery_desc` tinytext NOT NULL,
		  `gallery_date` varchar(255) NOT NULL default '',
		  `gallery_location` varchar(255) NOT NULL default ''
		) TYPE=MyISAM;";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_job` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_msn` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_yahoo` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE roster ADD `roster_aim` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_favfood` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_favmap` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);			
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_favweapon` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE roster ADD `roster_favplayer` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `roster_favmovie` varchar(75) NOT NULL default ''";
		$result = mysql_query($sql);									
		if ( $result ) { $errors++; }	

		$sql = "ALTER TABLE roster ADD `roster_favmusic` varchar(100) NOT NULL default ''";
		$result = mysql_query($sql);										
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE roster ADD `roster_homepage` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE roster ADD `roster_lanexp` tinytext NOT NULL";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }

		$sql = "ALTER TABLE roster ADD `roster_prevclans` tinytext NOT NULL";
		$result = mysql_query($sql);	
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `computer_refresh` varchar(15) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `computer_vsync` varchar(15) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE roster ADD `computer_drive` varchar(100) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		// screenshots 
		$sql = "ALTER TABLE screenshots ADD `screen_gallery` varchar(255) NOT NULL default ''";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE screenshots DROP COLUMN screen_data";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; } 		

 		$sql = "ALTER TABLE screenshots DROP COLUMN screen_type";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }

		// templates
		$sql = "ALTER TABLE templates ADD `records_upcoming` text NOT NULL";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE templates ADD `event_recent` text NOT NULL";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE templates ADD `demos_recent` text NOT NULL";
		$result = mysql_query($sql);
		if ( $result ) { $errors++; }		

		$sql = "ALTER TABLE templates ADD `screens_detail` text NOT NULL";
		$result = mysql_query($sql);	 					
		if ( $result ) { $errors++; }

		if ( $errors == 34 )
			echo "Update successful.<br>";
				
		// encrypt all existing passwords

		MySQL_connect($mysql_host,$mysql_dblogin,$mysql_dbpass) or die("could not connect to the MYSQL");
		MySQL_select_db($mysql_dbname) or die("Could not select database");

		$resultj = mysql_query("SELECT * FROM users");
		while ( $row = mysql_fetch_array($resultj) )
		{
			extract($row);
			$password = crypt($user_pass,'$2a$07$A.QAFolLar4v27MGXrrROxpj7hvyhxT2qypSsWtIDjdOSYLMkABq');
			$sql = "UPDATE users SET user_pass='$password' WHERE user_id='$user_id'";
			$result = mysql_query($sql);
		}


		// update roster images
			
		$IMG_ORG_HEIGHT	= "*";
		$IMG_ORG_WIDTH  = "600";
		$IMG_HEIGHT = "*";
		$IMG_WIDTH  = "100";				
		$use_imagecreatetruecolor = true;
		$use_imagecopyresampled	  = true;
		$JPG_QUALITY	=	90;
		$IMG_ROOT = "../files/roster";
		require("../imgfuncs.php");
							
		MySQL_connect($mysql_host,$mysql_dblogin,$mysql_dbpass) or die("could not connect to the MYSQL");
		MySQL_select_db($mysql_dbname) or die("Could not select database");

		$resultj = mysql_query("SELECT * FROM roster");
		while ( $row = mysql_fetch_array($resultj) )
		{
			extract($row);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$roster_photo);
		}
		
		// update match images
			
		$IMG_ORG_HEIGHT	= "*";
		$IMG_ORG_WIDTH  = "600";
		$IMG_HEIGHT = "*";
		$IMG_WIDTH  = "100";				
		$use_imagecreatetruecolor = true;
		$use_imagecopyresampled	  = true;
		$JPG_QUALITY	=	90;
		$IMG_ROOT = "../files/records";
		require("../imgfuncs.php");
							
		MySQL_connect($mysql_host,$mysql_dblogin,$mysql_dbpass) or die("could not connect to the MYSQL");
		MySQL_select_db($mysql_dbname) or die("Could not select database");

		$resultj = mysql_query("SELECT * FROM records");
		while ( $row = mysql_fetch_array($resultj) )
		{
			extract($row);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$record_screen1);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$record_screen2);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$record_screen3);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$record_screen4);
		}
		
		
		// update screenshots
		$gallery_id = uniqid("gallID");
		
		$result = mysql_query("INSERT INTO galleries
			(gallery_id,
			gallery_name,
			gallery_desc,
			gallery_date,
			gallery_location) VALUES 
			('$gallery_id',
			'Old Screenshots',
			'These are our old screenshots before we updated to CM 3.0',
			'2003',
			'All Over')");
		
		
		$IMG_ORG_HEIGHT	= "*";
		$IMG_ORG_WIDTH  = "600";
		$IMG_HEIGHT = "108";
		$IMG_WIDTH  = "*";				
		$use_imagecreatetruecolor = true;
		$use_imagecopyresampled	  = true;
		$JPG_QUALITY	=	90;	
		$IMG_ROOT = "../files/screenshots/Old Screenshots";
		mkdir("../files/screenshots/Old Screenshots", 0777);
		chmod ("../files/screenshots/Old Screenshots",0777);
		require("../imgfuncs.php");
							
		MySQL_connect($mysql_host,$mysql_dblogin,$mysql_dbpass) or die("could not connect to the MYSQL");
		MySQL_select_db($mysql_dbname) or die("Could not select database");

		$resultj = mysql_query("SELECT * FROM screenshots");
		while ( $row = mysql_fetch_array($resultj) )
		{
			extract($row);

			copy("../files/screenshots/$screen_name","../files/screenshots/Old Screenshots/$screen_name");

			resizer_main($handle,"",$IMG_ORG_WIDTH,$IMG_ORG_HEIGHT,$screen_name);
			resizer_main($handle,"thumb-",$IMG_WIDTH,$IMG_HEIGHT,$screen_name);

			unlink("../files/screenshots/$screen_name");
			
			$sql = "UPDATE screenshots SET screen_gallery='$gallery_id' WHERE screen_name='$screen_name'";
			$result = mysql_query($sql);
		}
		
		
	}	
	else {

?>

<table cellspacing=4 cellpadding=5>
<tr>
	<td colspan=3 style="border: 1 solid #444444; padding: 5;"><font style="font-family: Tahoma, Arial; font-size: 14pt; font-weight: bold;">Clan Manager Update ( 2.X to 3.0 )</font><br>From <a href="http://www.kliptmedia.com" target=_new>kliptmedia</a></td>
</tr>

<tr>
	<td style="font-family: Verdana, Arial; font-size: 10px; font-weight: normal; padding: 15; border: 1 solid #444444;" valign=top>
		<form action="<?=$PHP_SELF?>" method="post">
		
		<b>Access Information</b>
		
		<div style="padding: 10;">
		
			Your MySQL host (generally localhost)<br>
			<input type="TEXT" name="mysql_host" size="20" maxlength="255" class=Input value="localhost">
			<p>
			
			Your MySQL login name<br>
			<input type="TEXT" name="mysql_dblogin" size="20" maxlength="255" class=Input value="">
			<p>
			
			Your MySQL login password<br>
			<input type="TEXT" name="mysql_dbpass" size="20" maxlength="255" class=Input value="">
			<p>
			
			Your MySQL database<br>
			<input type="TEXT" name="mysql_dbname" size="20" maxlength="255" class=Input value="">
			<p>
			
			<center>
			<hr noshade size=1>
			<input type="submit" name="update" class=Input value="Update"><br>
			<b>CLICK ONLY ONCE!</b>
			</center>
			
		</div>
		
	</td>

</tr>
<tr>
	<td align=center colspan=3 style="border: 1 solid #444444; padding: 5;">
	copyright © 2002-2004 kliptmedia.com
	</td>
</tr>
</table>
<?
	}
?>
</body>
</html>