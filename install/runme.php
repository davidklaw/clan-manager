<html>
	<head>
	<title>Clan Manager Installation</title>
	<link rel="stylesheet" href="../cm.css" type="text/css">
	</head>

<body>

<center><br>
<table cellspacing=4 cellpadding=5>
<tr>
	<td colspan=3 style="border: 1 solid #444444; padding: 5;"><font style="font-family: Tahoma, Arial; font-size: 14pt; font-weight: bold;">Clan Manager <font color=red>3.0</font> Installation</font><br>From <a href="http://www.kliptmedia.com" target=_new>kliptmedia</a></td>
</tr>
<tr>
	<td style="font-family: Verdana, Arial; font-size: 10px; font-weight: normal; padding: 15; border: 1 solid #444444;" valign=top width=250>
		<form action="install.php" method="post">
		
		<center>If you are updating from ver. 2 <br>please use the <a href="update.php">update.php</a> file.</center>
		<p>
		
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
			
			Directory ( http://www.yoursite.com/<b>cm</b>/ )<br>
			<input type="TEXT" name="dir" size="20" maxlength="255" class=Input value="cm">
			<p>
		
		</div>
		
	</td>

	<td style="font-family: Verdana, Arial; font-size: 10px; font-weight: normal; padding: 5; border: 1 solid #444444;" valign=top width=200>
		<form action="install.php" method="post">
		
		<br>
		
		<b>Head Administrator</b><br>
		<div style="padding:5;">This will create your head admin account that you will use.</div>
		
		<div style="padding: 10;">
		
			Username (suggest your alias)<br>
			<input type="TEXT" name="adminusername" size="20" maxlength="255" class=Input value="">
			<p>
			
			Password<br>
			<input type="TEXT" name="adminpassword" size="20" maxlength="255" class=Input value="">
			<p>
			
			Email<br>
			<input type="TEXT" name="adminemail" size="20" maxlength="255" class=Input value="">
			<p>
			
			<center>Remember this info!  You 
			<br>will need it to login.</center>
			<p><center>
			<input type="submit" name="Install" class=Input value="Install"><br>
			<font size=1><b>CLICK ONLY ONCE!</b>
		
		</div>
		
	</td>

</tr>
<tr>
	<td align=center colspan=3 style="border: 1 solid #444444; padding: 5;">
	copyright © 2002-2004 kliptmedia.com
	</td>
</tr>
</table>

</body>
</html>