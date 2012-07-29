<html>
	<head>
	<title>kliptmedia Clan Manager</title>
	<link rel="stylesheet" href="../cm.css" type="text/css">
	</head>

<body>

<center><br>
<table cellspacing=4 cellpadding=5 width=400>
<tr>
	<td colspan=3 style="border: 1 solid #444444; padding: 5;"><font style="font-family: Tahoma, Arial; font-size: 14pt; font-weight: bold;">Clan Manager Installation</font><br>From <a href="http://www.kliptmedia.com" target=_new>kliptmedia</a></td>
</tr>
<tr>
	<td style="font-family: Verdana, Arial; font-size: 10px; font-weight: normal; padding: 15; border: 1 solid #444444;">
		
		<b>Installation</b><p>
<?

	MySQL_connect($HTTP_POST_VARS['mysql_host'],$HTTP_POST_VARS['mysql_dblogin'],$HTTP_POST_VARS['mysql_dbpass']) or die("could not connect to the MYSQL");
	MySQL_select_db($HTTP_POST_VARS['mysql_dbname']) or die("Could not select database");

// writing COMMENTS table
	
	$sql = "CREATE TABLE `comments` (
	  `counter` int(11) NOT NULL auto_increment,
	  `comments_id` varchar(255) NOT NULL default '',
	  `news_id` varchar(255) NOT NULL default '',
	  `userID` varchar(255) NOT NULL default '',
	  `comment` longtext NOT NULL,
	  PRIMARY KEY  (`counter`)
	) TYPE=MyISAM AUTO_INCREMENT=13;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Comments table <font color=green>created</font>...<br>";
	else
		echo "Comments table <font color=red>failed</font>...<br>";

// writing CONTACTS table
		
	$sql = "CREATE TABLE `contacts` (
	  `webmaster` varchar(255) NOT NULL default '',
	  `manager` varchar(255) NOT NULL default '',
	  `scheduler` varchar(255) NOT NULL default '',
	  `recruiting` varchar(255) NOT NULL default '',
	  `help` varchar(255) NOT NULL default '',
	  `marketing` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
		
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Contacts table <font color=green>created</font>...<br>";
	else
		echo "Contacts table <font color=red>failed</font>...<br>";
	
	$sql = "INSERT INTO `contacts` VALUES ('edit', 'edit', 'edit', 'edit', 'edit', 'edit');";	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Contacts <font color=green>updated</font>...<br>";
	else
		echo "Contacts update <font color=red>failed</font>...<br>";

// writing DEMOS table


	$sql = "CREATE TABLE `demos` (
	  `count` int(11) NOT NULL auto_increment,
	  `demo_id` varchar(255) NOT NULL default '',
	  `demo_awayteam` varchar(255) NOT NULL default '',
	  `demo_map` varchar(100) NOT NULL default '',
	  `demo_match` varchar(255) NOT NULL default '',
	  `demo_pov` varchar(100) NOT NULL default '',
	  `demo_file` varchar(255) NOT NULL default '',
	  `demo_size` varchar(35) NOT NULL default '',
	  `demo_event` varchar(255) NOT NULL default '',
	  `demo_poster` varchar(255) NOT NULL default '',
	  `demo_comment` tinytext NOT NULL,
	  `demo_downloads` bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (`count`)
	) TYPE=MyISAM AUTO_INCREMENT=11;";

	$result = mysql_query($sql);
	if ( $result ) 
		echo "Demos table <font color=green>created</font>...<br>";
	else
		echo "Demos table <font color=red>failed</font>...<br>";
	
// writing EVENTS table	
		
	$sql = "CREATE TABLE `events` (
	  `event_id` varchar(255) NOT NULL default '',
	  `event_name` varchar(255) NOT NULL default '',
	  `event_start` varchar(155) NOT NULL default '',
	  `event_end` varchar(155) NOT NULL default '',
	  `event_price` varchar(50) NOT NULL default '',
	  `event_game` varchar(200) NOT NULL default '',
	  `event_time` varchar(255) NOT NULL default '',
	  `event_location` varchar(255) NOT NULL default '',
	  `event_contact` varchar(255) NOT NULL default '',
	  `event_image` varchar(255) NOT NULL default '',
	  `event_type` varchar(100) NOT NULL default '',
	  `event_description` longtext NOT NULL
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Events table <font color=green>created</font>...<br>";
	else
		echo "Events table <font color=red>failed</font>...<br>";
	
	
// writing FILES table
	
	$sql = "CREATE TABLE `files` (
	  `file_id` varchar(255) NOT NULL default '',
	  `file_description` tinytext NOT NULL,
	  `file_external` varchar(255) NOT NULL default '',
	  `file_name` varchar(255) NOT NULL default '',
	  `file_size` varchar(255) NOT NULL default '',
	  `file_downloads` bigint(11) NOT NULL default '0'
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Files table <font color=green>created</font>...<br>";
	else
		echo "Files table <font color=red>failed</font>...<br>";
	
	
// writing INFORMATION TABLE
	
	$sql = "CREATE TABLE `information` (
	  `clan_name` varchar(255) NOT NULL default '',
	  `clan_tag` varchar(255) NOT NULL default '',
	  `clan_irc` varchar(255) NOT NULL default '',
	  `clan_irc_server` varchar(255) NOT NULL default '',
	  `clan_background` text NOT NULL
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Info table <font color=green>created</font>...<br>";
	else
		echo "Info table <font color=red>failed</font>...<br>";
	
	$sql = "INSERT INTO `information` VALUES ('edit', 'edit', 'edit', 'edit', 'edit');";	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Info <font color=green>updated</font>...<br>";
	else
		echo "Info update <font color=red>failed</font>...<br>";


// writing LINKS table

	$sql = "CREATE TABLE `links` (
	  `link_id` varchar(255) NOT NULL default '',
	  `link_name` varchar(255) NOT NULL default '',
	  `link_url` varchar(255) NOT NULL default '',
	  `link_type` varchar(255) NOT NULL default '',
	  `link_description` tinytext NOT NULL
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Links table <font color=green>created</font>...<br>";
	else
		echo "Links table <font color=red>failed</font>...<br>";


// writing NEWS table

	$sql = "CREATE TABLE `news` (
	  `count` int(11) NOT NULL auto_increment,
	  `news_id` varchar(255) NOT NULL default '',
	  `news_reporter` varchar(255) NOT NULL default '',
	  `news_date` varchar(255) NOT NULL default '',
	  `news_time` varchar(255) NOT NULL default '',
	  `news_subject` varchar(255) NOT NULL default '',
	  `news_content` longtext NOT NULL,
	  `news_image` varchar(255) NOT NULL default '',
	  `news_caption` tinytext NOT NULL,
	  `news_numdate` varchar(255) NOT NULL default '',
	  `news_comments` varchar(5) NOT NULL default '',
	  PRIMARY KEY  (`count`)
	) TYPE=MyISAM AUTO_INCREMENT=11;";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "News table <font color=green>created</font>...<br>";
	else
		echo "News table <font color=red>failed</font>...<br>";


// writing PREFERENCES table

	$sql = "CREATE TABLE `prefs` (
	  `date_format` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Preferences table <font color=green>created</font>...<br>";
	else
		echo "Preferences table <font color=red>failed</font>...<br>";
	
	$sql = "INSERT INTO prefs
		(date_format) VALUES 
		('1');";
		
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Preferences <font color=green>updated</font>...<br>";
	else
		echo "Preferences update <font color=red>failed</font>...<br>";
	

// writing RECORDS table
	
	$sql = "CREATE TABLE `records` (
	  `record_id` varchar(255) NOT NULL default '',
	  `record_awayteam` varchar(255) NOT NULL default '',
	  `record_map` varchar(255) NOT NULL default '',
	  `record_roster` text NOT NULL,
	  `record_ctw` tinyint(4) NOT NULL default '0',
	  `record_ctl` tinyint(4) NOT NULL default '0',
	  `record_tw` tinyint(4) NOT NULL default '0',
	  `record_tl` tinyint(4) NOT NULL default '0',
	  `record_otw` tinyint(4) NOT NULL default '0',
	  `record_otl` tinyint(4) NOT NULL default '0',
	  `record_league` varchar(255) NOT NULL default '',
	  `record_date` varchar(255) NOT NULL default '',
	  `record_time` varchar(100) NOT NULL default '',
	  `record_hltv` varchar(100) NOT NULL default '',
	  `record_scorebot` varchar(100) NOT NULL default '',
	  `record_mvp` varchar(255) NOT NULL default '',
	  `record_screen1` varchar(255) NOT NULL default '',
	  `record_screen2` varchar(255) NOT NULL default '',
	  `record_event` varchar(255) NOT NULL default '',
	  `record_comments` text NOT NULL,
	  `record_type` varchar(255) NOT NULL default '',
	  `record_awaytag` varchar(255) NOT NULL default '',
	  `record_demo` varchar(255) NOT NULL default '',
	  `record_screen3` varchar(255) NOT NULL default '',
	  `record_screen4` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Records table <font color=green>created</font>...<br>";
	else
		echo "Records table <font color=red>failed</font>...<br>";
	

// writing ROSTER table
	
	$sql = "CREATE TABLE `roster` (
	  `roster_id` varchar(255) NOT NULL default '',
	  `roster_alias` varchar(255) NOT NULL default '',
	  `roster_name` varchar(255) NOT NULL default '',
	  `roster_rank` varchar(255) NOT NULL default '',
	  `roster_age` varchar(10) NOT NULL default '',
	  `roster_gender` varchar(20) NOT NULL default '',
	  `roster_email` varchar(255) NOT NULL default '',
	  `roster_location` varchar(255) NOT NULL default '',
	  `roster_bio` longtext NOT NULL,
	  `roster_quote` varchar(255) NOT NULL default '',
	  `roster_wonid` varchar(255) NOT NULL default '',
	  `roster_sogamed` varchar(255) NOT NULL default '',
	  `roster_gotfrag` varchar(255) NOT NULL default '',
	  `roster_job` varchar(75) NOT NULL default '',
	  `roster_msn` varchar(75) NOT NULL default '',
	  `roster_yahoo` varchar(75) NOT NULL default '',
	  `roster_aim` varchar(75) NOT NULL default '',
	  `roster_favfood` varchar(255) NOT NULL default '',
	  `roster_favmap` varchar(75) NOT NULL default '',
	  `roster_favweapon` varchar(75) NOT NULL default '',
	  `roster_favplayer` varchar(75) NOT NULL default '',
	  `roster_favmovie` varchar(75) NOT NULL default '',
	  `roster_favmusic` varchar(100) NOT NULL default '',
	  `roster_homepage` varchar(255) NOT NULL default '',
	  `roster_lanexp` tinytext NOT NULL,
	  `roster_prevclans` tinytext NOT NULL,
	  `computer_brand` varchar(255) NOT NULL default '',
	  `computer_cpu` varchar(255) NOT NULL default '',
	  `computer_ram` varchar(255) NOT NULL default '',
	  `computer_video` varchar(255) NOT NULL default '',
	  `computer_sound` varchar(255) NOT NULL default '',
	  `computer_monitor` varchar(255) NOT NULL default '',
	  `computer_resolution` varchar(100) NOT NULL default '',
	  `computer_headphones` varchar(100) NOT NULL default '',
	  `computer_mouse` varchar(255) NOT NULL default '',
	  `computer_pad` varchar(255) NOT NULL default '',
	  `computer_accessories` varchar(255) NOT NULL default '',
	  `roster_photo` varchar(255) NOT NULL default '',
	  `roster_config` varchar(255) NOT NULL default '',
	  `roster_status` varchar(50) NOT NULL default '',
	  `computer_mobo` varchar(255) NOT NULL default '',
	  `computer_keyboard` varchar(255) NOT NULL default '',
	  `computer_sens` varchar(255) NOT NULL default '',
	  `computer_refresh` varchar(15) NOT NULL default '',
	  `computer_vsync` varchar(15) NOT NULL default '',
	  `computer_drive` varchar(100) NOT NULL default '',
	  UNIQUE KEY `RosterAlias` (`roster_alias`)
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Roster table <font color=green>created</font>...<br>";
	else
		echo "Roster table <font color=red>failed</font>...<br>";
	

// writing SCREENSHOTS table

	$sql = "CREATE TABLE `screenshots` (
	  `screen_id` varchar(255) NOT NULL default '',
	  `screen_caption` varchar(255) NOT NULL default '',
	  `screen_name` varchar(255) NOT NULL default '',
	  `screen_size` varchar(255) NOT NULL default '',
	  `screen_gallery` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Screenshots table <font color=green>created</font>...<br>";
	else
		echo "Screenshots table <font color=red>failed</font>...<br>";

// writing GALLERIES table

	$sql = "CREATE TABLE `galleries` (
  	`gallery_id` varchar(255) NOT NULL default '',
	  `gallery_name` varchar(255) NOT NULL default '',
	  `gallery_desc` tinytext NOT NULL,
	  `gallery_date` varchar(255) NOT NULL default '',
	  `gallery_location` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Galleries table <font color=green>created</font>...<br>";
	else
		echo "Galleries table <font color=red>failed</font>...<br>";



// writing SERVERS table	
	
	$sql = "CREATE TABLE `servers` (
	  `server_name` varchar(255) NOT NULL default '',
	  `server_ip` varchar(255) NOT NULL default '',
	  `server_type` varchar(255) NOT NULL default '',
	  `server_maplist` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Servers table <font color=green>created</font>...<br>";
	else
		echo "Servers table <font color=red>failed</font>...<br>";
	

// writing SETTINGS table	
	
	$sql = "CREATE TABLE `settings` (
	  `force_register` varchar(5) NOT NULL default '',
	  `cm_dir` varchar(100) NOT NULL default 'cm'
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Settings table <font color=green>created</font>...<br>";
	else
		echo "Settings table <font color=red>failed</font>...<br>";
	
	$sql = "INSERT INTO `settings` VALUES ('Y', '$HTTP_POST_VARS[dir]');";	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Info <font color=green>updated</font>...<br>";
	else
		echo "Info update <font color=red>failed</font>...<br>";
	

// writing SPONSORS table

	$sql = "CREATE TABLE `sponsors` (
	  `sponsor_id` varchar(255) NOT NULL default '',
	  `sponsor_name` varchar(255) NOT NULL default '',
	  `sponsor_url` varchar(255) NOT NULL default '',
	  `sponsor_description` text NOT NULL,
	  `sponsor_image` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Sponsors table <font color=green>created</font>...<br>";
	else
		echo "Sponsors table <font color=red>failed</font>...<br>";
	

// writing TEMPLATES table

	$sql = "CREATE TABLE `templates` (
	  `news_headlines` text NOT NULL,
	  `news_posts` text NOT NULL,
	  `news_post` text NOT NULL,
	  `roster_list` text NOT NULL,
	  `roster_detail` text NOT NULL,
	  `records_upcoming` text NOT NULL,
	  `records_recent` text NOT NULL,
	  `records_list` text NOT NULL,
	  `records_detail` text NOT NULL,
	  `file_list` text NOT NULL,
	  `file_detail` text NOT NULL,
	  `links_list` text NOT NULL,
	  `links_detail` text NOT NULL,
	  `sponsor_list` text NOT NULL,
	  `sponsor_detail` text NOT NULL,
	  `event_recent` text NOT NULL,
	  `event_list` text NOT NULL,
	  `event_detail` text NOT NULL,
	  `server_list` text NOT NULL,
	  `server_detail` text NOT NULL,
	  `contacts_list` text NOT NULL,
	  `demos_recent` text NOT NULL,
	  `demos_list` text NOT NULL,
	  `demos_detail` text NOT NULL,
	  `info_list` text NOT NULL,
	  `screens_list` text NOT NULL,
	  `screens_detail` text NOT NULL
	) TYPE=MyISAM;";
	
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Templates table <font color=green>created</font>...<br>";
	else
		echo "Templates table <font color=red>failed</font>...<br>";
	
	$sql = "INSERT INTO `templates` VALUES ('<li> <% subject %> - <% date %><br>', '<div class=headline><% subject %></div>\r\n<div class=details>posted by <% reporter %> on <% date %> @ <% time %> | <% comments %></div>\r\n<div class=post><% post %></div>\r\n<p>', '<div class=headline><% subject %></div>\r\n<div class=details>posted by <% reporter %> on <% date %></div>\r\n<div class=post><% post %></div>\r\n<p>\r\n<% showcomments %>\r\n', '<tr>\r\n<td class=\'<% rowClass %>\'> <% alias %></td>\r\n<td class=\'<% rowClass %>\' align=center><% age %></td>\r\n<td class=\'<% rowClass %>\' align=center><% location %></td>\r\n<td class=\'<% rowClass %>\' align=center><% details %></td>\r\n</tr>', '<table cellspacing=5 cellpadding=0 border=0 width=100%>\r\n<tr>		\r\n <td align=right>\r\n <span class=headline>Alias:</span></td><td><% alias %><br>\r\n </td>\r\n</tr>\r\n<tr>		\r\n <td align=right>\r\n <span class=headline>Photo:</span></td><td><% photo %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Name:</span></td><td><% name %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Email:</span></td><td><% email %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>AOL:</span></td><td><% aim %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>MSN:</span></td><td><% msn %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Yahoo:</span></td><td><% yahoo %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Work:</span></td><td><% job %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Food:</span></td><td><% favfood %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Map:</span></td><td><% favmap %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Weapon:</span></td><td><% favweapon %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Player:</span></td><td><% favplayer %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Movie:</span></td><td><% favmovie %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Favorite Music:</span></td><td><% favmusic %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Homepage:</span></td><td><% homepage %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Lan Exp:</span></td><td><% lanexp %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Previous Clans:</span></td><td><% prevclans %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Age:</span></td><td><% age %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Sogamed:</span></td><td><% sogamed %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Gotfrag:</span></td><td><% gotfrag %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Matches:</span></td><td><% matches %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Location:</span></td><td><% location %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Quote:</span></td><td><% quote %>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right><br></td><td>\r\n <br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td colspan=2>\r\n <span class=headline>Bio:</span><div style=\'padding: 4;\'><% bio %></div>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right><br></td><td>\r\n <br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>SteamID:</span></td><td><% wonid %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Config:</span></td><td><% config %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>CPU:</span></td><td><% cpu %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>RAM:</span></td><td><% ram %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Drive:</span></td><td><% hdrive %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Vsync:</span></td><td><% vsync %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Refresh:</span></td><td><% refreshrate %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Video:</span></td><td><% video %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Mouse:</span></td><td><% mouse %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Sensitivity:</span></td><td><% sens %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Pad:</span></td><td><% pad %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Headphones:</span></td><td><% headphones %><br>\r\n </td>\r\n</tr>\r\n\r\n</table>\r\n', '<table cellspacing=5 cellpadding=0 width=230 class=matches>\r\n<tr>\r\n<td>\r\n <font color=6C7D84 size=4><% opponents %></font>\r\n</td>\r\n<td rowspan=2 valign=middle>\r\n </td>\r\n</tr>\r\n<tr>\r\n<td valign=top>\r\n <b><font color=6C7D84>Date</font></b>: <% date %><br>\r\n <b><font color=6C7D84>Time</font></b>: <% time %><br>\r\n <b><font color=6C7D84>Map</font></b>: <% map %><br>\r\n <b><font color=6C7D84>HLTV</font></b>: <% hltv %><br>\r\n <b><font color=6C7D84>Scorebot</font></b>: <% scorebot %><br>\r\n</td>\r\n</tr>\r\n</table>', '<tr>\r\n<td align=center><% opponents %></td>\r\n<td align=center><% map %></td>\r\n<td align=center><% result %></td>\r\n<td align=center><% details %></td>\r\n</tr>', '<tr>\r\n<td class=\'<% rowClass %>\'><% opponents %></td>\r\n<td class=\'<% rowClass %>\'  align=center><% date %></td>\r\n<td class=\'<% rowClass %>\'  align=center><% map %></td>\r\n<td class=\'<% rowClass %>\'  align=center><% result %></td>\r\n<td class=\'<% rowClass %>\'  align=center><% details %></td>\r\n</tr>', '<table cellspacing=5 cellpadding=0 border=0 width=400>\r\n<tr>		\r\n <td align=right width=20%>\r\n <span class=headline>Opponent:</span></td><td><% opponents %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>League:</span></td><td><% league %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Date:</span></td><td><% date %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Roster:</span></td><td><% roster %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Demo(s):</span></td><td><% demo %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Type:</span></td><td><% type %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>Event:</span></td><td><% event %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right><br></td><td><br></td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>CT Rounds:</span></td><td><% ctw %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right>\r\n <span class=headline>T Rounds:</span></td><td><% tw %><br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right >\r\n <span class=headline>Final:</span></td><td><% homescore %> - <% awayscore %>  Result: <% result %> <br>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right><br></td><td><br></td>\r\n</tr>\r\n<tr>\r\n <td colspan=2>\r\n <span class=headline>Match Comments:</span>\r\n <div style=\'padding: 4;\'><% comment %></div>\r\n </td>\r\n</tr>\r\n<tr>\r\n <td align=right colspan=2><br></td><td><br></td>\r\n</tr>\r\n<tr>\r\n <td valign=top colspan=2>\r\n <% screen1 %><p>\r\n <% screen2 %><p>\r\n <% screen3 %><p>\r\n <% screen4 %><p>\r\n </td>\r\n</tr>\r\n</table>\r\n</center>\r\n<% showcomments %>', '<tr>\r\n<td class=<% rowClass %> align=center><% filename %></td>\r\n<td class=<% rowClass %> align=center><% filesize %></td>\r\n<td class=<% rowClass %> align=center><% downloads %></td>\r\n<td class=<% rowClass %> align=center><% details %></td>\r\n</tr>', '<b>File:</b> <% filename %><br>\r\n<b>Size:</b> <% filesize %><br>\r\nDownloaded <% numofdls %> times.<p>\r\n<b>Description:</b>\r\n<div style=\'padding: 8\'><% filedesc %></div>\r\n<b>Download:</b> <% download %>', '<tr>\r\n<td class=<% rowClass %> align=center><% linkname %></td>\r\n<td class=<% rowClass %> align=center><% linktype %></td>\r\n<td class=<% rowClass %> align=center><% details %></td>\r\n</tr>', '<b>Link:</b> <% linkname %><p>\r\n<b>URL:</b> <% linkurl %><br>\r\n<b>Type:</b> <% linktype %><br>\r\n<b>Description:</b><div style=\'padding: 6;\'><% linkdesc %></div>\r\n', '<tr>\r\n<td class=<% rowClass %> align=center><% sponsorname %></td>\r\n<td class=<% rowClass %> align=center><% sponsorimage %></td>\r\n<td class=<% rowClass %> align=center><% details %></td>\r\n</tr>', '<font size=4><% sponsorname %></font><br>\r\n<a href=\'<% sponsorurl %>\' target=_new><% sponsorurl %></a><br>\r\n<table cellspacing=5 cellpadding=0>\r\n<tr>\r\n<td width=60%><% sponsordesc %></td>\r\n<td valign=top align=center><% sponsorimage %></td>\r\n</tr>\r\n</table>\r\n<p>', '<table>\r\n<tr>\r\n<td align=center><% eventname %></td>\r\n<td align=center><% eventstart %></td>\r\n<td align=center><% details %></td>\r\n</tr>\r\n</table>', '<tr>\r\n<td class=\'<% rowClass %>\'> <% eventname %></td>\r\n<td class=\'<% rowClass %>\' align=center><% eventstart %></td>\r\n<td class=\'<% rowClass %>\' align=center><% eventlocation %></td>\r\n<td class=\'<% rowClass %>\' align=center><% details %></td>\r\n</tr>', '<% eventname %><br>\r\n<% eventlocation %><br>\r\n<% eventdesc %><p>', '<tr>\r\n<td class=\'<% rowClass %>\'> <% servername %></td>\r\n<td class=\'<% rowClass %>\' align=center><% serverip %></td>\r\n<td class=\'<% rowClass %>\' align=center><% servertype %></td>\r\n<td class=\'<% rowClass %>\' align=center><% details %></td>\r\n</tr>', '<b><font size=3><% servername %></font></b><br>\r\n<div style=\'padding: 10;\'>\r\n <b>IP Address:</b> <% serverip %><br>\r\n <b>Type:</b> <% servertype %><p>\r\n <b>Additional Info:</b>\r\n <div style=\'padding: 10;\'><% servermaplist %></div>\r\n</div>\r\n<p>\r\n', '<b>Webmaster:</b> <% webmaster %><br>\r\n<b>Manager:</b> <% manager %><br>\r\n<b>Recruiting:</b> <% recruiting %><br>\r\n<b>Scheduler:</b> <% scheduler %><br>\r\n<b>Support:</b> <% help %><br>\r\n<b>Sponsorships:</b> <% marketing %><br>', '<table>\r\n<tr>\r\n<td align=center><% demoteam %></td>\r\n<td align=center><% demomap %></td>\r\n<td align=center><% demopov %></td>\r\n<td align=center><% details %></td>\r\n</tr>\r\n</table>', '<tr>\r\n<td class=<% rowClass %> ><% demoteam %></td>\r\n<td class=<% rowClass %>  align=center><% demomap %></td>\r\n<td class=<% rowClass %>  align=center><% demopov %></td>\r\n<td class=<% rowClass %>  align=center><% numofdls %></td>\r\n<td class=<% rowClass %>  align=center><% details %></td>\r\n</tr>', '<b>Opponents:</b> <% demoteam %><br>\r\n<b>Map:</b> <% demomap %><br>\r\nDownloaded <% numofdls %> times.<p>\r\n<b>Match:</b> <% demomatch %><br>\r\n<b>Event:</b> <% demoevent %><br>\r\n<b>Comment:</b>\r\n<div style=\'padding: 8\'><% democomment %></div>\r\n<b>Download:</b> <% download %>', '<b>Clan:</b> <% clanname %><br>\r\n<b>Tag:</b> <% clantag %><br>\r\n<b>Channel:</b> <% ircchannel %><br>\r\n<b>IRC Server:</b> <% ircserver %><br>\r\n<br>\r\n<b>History:</b>\r\n<div style=\'padding: 10;\'><% background %></div>', '<tr>\r\n<td class=\'<% rowClass %>\'> <% gallery %></td>\r\n<td class=\'<% rowClass %>\'><% location %></td>\r\n<td class=\'<% rowClass %>\' align=center><% numofimages %></td>\r\n<td class=\'<% rowClass %>\' align=center><% view %></td>\r\n</tr>', '<b><font size=3><% gallery %></font></b><br>\r\n<b><% location %></b> - <% date %><br>\r\n<div style=\'padding: 8;\'><% desc %></div><br>\r\n<% display %>');";
	
	$result = mysql_query($sql);
	if ( $result ) 
		echo "Templates <font color=green>updated</font>...<br>";
	else
		echo "Templates update <font color=red>failed</font>...<br>";
	
	
// writing USERS table		

	$sql = "CREATE TABLE `users` (
	  `user_id` varchar(255) NOT NULL default '',
	  `user_name` varchar(255) NOT NULL default '',
	  `user_pass` varchar(255) NOT NULL default '',
	  `user_email` varchar(255) NOT NULL default '',
	  `user_type` varchar(255) NOT NULL default '',
	  `user_abil` varchar(255) NOT NULL default ''
	) TYPE=MyISAM;";
	$result = mysql_query($sql);
	
	if ( $result ) 
		echo "Users table <font color=green>created</font>...<br>";
	else
		echo "Users table <font color=red>failed</font>...<br>";
		
	$password = crypt(md5($HTTP_POST_VARS['adminpassword']), md5($HTTP_POST_VARS['adminpassword']));
	
	$ID = uniqid("userID");
	$sql = "INSERT INTO users
		(user_id,
		user_name,
		user_pass,
		user_email,
		user_type,
		user_abil) VALUES 
		('$ID',
		'$HTTP_POST_VARS[adminusername]',
		'$password',
		'$HTTP_POST_VARS[adminemail]',
		'head admin',
		'news,roster,records,events,templates,settings,users,general');";
		
	$result = mysql_query($sql);
	if ( $result ) 
		echo "User <font color=red>entered</font>...<br>";
	else
		echo "User <font color=red>error</font>...<br>";

	MySQL_close();

	
	echo "<br><br>Installation complete.";
	
?>

<br><br>
</td>
</tr>

<tr>
	<td align=center colspan=3 style="border: 1 solid #444444; padding: 5;">
	copyright © 2002-2003 kliptmedia.com
	</td>
</tr>

</table>
</body>

</html>