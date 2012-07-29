<span class="Header">Contacts</span> (email addresses)
<hr noshade size="1">

<?

	$option = "general";

	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		$result = connection("SELECT * FROM contacts");
		$row = mysql_fetch_array($result); extract($row);
	
?>

		<form action="process.php" method="post">
		<input type=hidden name="choice" value="contacts">
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Webmaster</td>
			<td><input type="TEXT" name="webmaster" size="40" maxlength="255" value="<?=$webmaster?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Manager</td>
			<td><input type="TEXT" name="manager" size="40" maxlength="255" value="<?=$manager?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Scheduler</td>
			<td><input type="TEXT" name="scheduler" size="40" maxlength="255" value="<?=$scheduler?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Recruiting</td>
			<td><input type="TEXT" name="recruiting" size="40" maxlength="255" value="<?=$recruiting?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Help</td>
			<td><input type="TEXT" name="help" size="40" maxlength="255" value="<?=$help?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Marketing</td>
			<td><input type="TEXT" name="marketing" size="40" maxlength="255" value="<?=$marketing?>"></td>
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
