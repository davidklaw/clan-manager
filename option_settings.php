<span class="Header">Settings</span>
<hr noshade size="1">
<?

	if ( Allowed($cm[0], $option) == "TRUE" ) {
		
		$result = connection("SELECT * FROM settings");
		$row = mysql_fetch_array($result); extract($row);	
		
?>	
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="settings">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('If you choose yes users will have to be registered and logged in with the site to post comments and download your demos.')"; onMouseout="ONMOUSEOUT=kill()">Force Registration</a></td>
			<td>
				<select name="force_register" size=1>
<?
			if ( $force_register == "Y" )
				echo "<option value='Y'>Yes</option><option value='N'>No</option>";
			else 
				echo "<option value='N'>No</option><option value='Y'>Yes</option>";
?>
				</select>
		
			</td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('If you change this you must also rename the folder on your FTP and the global include at the top of your clan sites HTML code.')"; onMouseout="ONMOUSEOUT=kill()">Manager Dir</a></td>
			<td><input type="TEXT" name="cmdir" size="20" maxlength="255" value="<?=$cm_dir?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">News Date Format</td>
				<td>
					<select name="date_format" size=1>
<?
				$resultx = connection("SELECT date_format FROM prefs");
				$rowx = mysql_fetch_array($resultx);
					extract($rowx);	
					
				if ( $date_format == "1" ) {
					echo("<option value='1'>30/12/2003</option><option value='2'>Month 30, 2003</option><option value='3'>Day, Month 30</option>");
				}
				else if ( $date_format == "2" ) {
					echo("<option value='2'>Month 30, 2003</option><option value='1'>30/12/2003</option><option value='3'>Day, Month 30</option>");	
				}
				else if ( $date_format == "3" ) {
					echo("<option value='3'>Day, Month 30</option><option value='1'>30/12/2003</option><option value='2'>Month 30, 2003</option>");	
				}
?>			
				
					</select>
				</td>
			</tr>
		
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
				
			<tr>
				<td class="Subject"></td>
				<td><input class="SubmitButton" type="submit" value="Update"></td>
			</tr>
			
			</table>
			</form>
<?
	}
	else
		echo "<center>This feature is unavailable to you.</center><br>";
?>