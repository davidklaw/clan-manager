<span class="Header">Mail Clan</span>
<hr noshade size="1">

<?
	$option = "general";

	if ( Allowed($cm[0], $option) == "TRUE" ) {
?>

	<form action="process.php" method="post">
	<input type=hidden name="choice" value="mail">
	<table cellspacing="0" cellpadding="0">
	
	<tr>
		<td class="Subject">Mail Who?</td>
		<td>
			<select name="mail_to" size=1>
			<option value="ALL">Entire Clan</option>
			<?
				$result = connection("SELECT roster_alias,roster_email FROM roster");
					while( $row = mysql_fetch_array($result)) {
					extract($row);
					echo("<option value='$roster_email'>$roster_alias</option>"); 
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td class="Subject">Subject</td>
		<td><input type="TEXT" name="mail_subject" size="40" maxlength="255" value=""></td>
	</tr>
	
	<tr>
		<td class="Subject">Content</td>
		<td><textarea rows="10" cols="60" name="mail_content"></textarea></td>
	</tr>
	
	<tr>
		<td class="Subject"></td>
		<td><input class="SubmitButton" type="submit" value="Send Mail"></td>
	</tr>
	
	</table>
	</form>

<?
	}
	else {
		echo "<center>This feature is unavailable to you.</center><br>";
	}
?>