<span class="Header">Information</span>
<hr noshade size="1">

<?

	$option = "general";
	
	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		$result = connection("SELECT * FROM information");
		$row = mysql_fetch_array($result); extract($row);
		//$clan_background = strip_tags($row["clan_background"], '<a><img><b><i><u>');
		
?>
			<form action="process.php" method="post">
			<input type=hidden name="choice" value="information">
			
			<table cellspacing="0" cellpadding="0">
			<tr>
				<td class="Subject">Clan Name</td>
				<td><input type="TEXT" name="clan_name" size="40" maxlength="255" value="<?=$clan_name?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Clan Tag</td>
				<td><input type="TEXT" name="clan_tag" size="10" maxlength="255" value="<?=$clan_tag?>"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Do not use the # sign!  Just the channel name.')"; onMouseout="ONMOUSEOUT=kill()">IRC Channel</a></td>
				<td><input type="TEXT" name="clan_irc" size="15" maxlength="255" value="<?=$clan_irc?>"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Make sure this is the exact server, it will automatically link your channel.')"; onMouseout="ONMOUSEOUT=kill()">IRC Server</a></td>
				<td><input type="TEXT" name="clan_irc_server" size="15" maxlength="255" value="<?=$clan_irc_server?>"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Anything can go here!  History, background, whatever you want to display on the information page.')"; onMouseout="ONMOUSEOUT=kill()">Background</a></td>
				<td><textarea rows="20" cols="60" name="clan_background"><?=$clan_background?></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject"></td>
				<td><input class="SubmitButton" type="submit" value="Update"></td>
			</tr>
			
			</table>
			</form>
<?
	}
	
	else {
		echo "<center>This feature is unavailable to you.</center><br>";
	}

?>