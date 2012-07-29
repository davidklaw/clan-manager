<span class="Header">Demos</span>
<hr noshade size="1">

<?
	
	$option = "general";

	if ( Allowed($cm[0], $option) == "TRUE" ) {

		if ( $_REQUEST["perform"] == 'add' ) {
?>

		<form action="process.php" method="post" enctype="multipart/form-data">
		<input type=hidden name="choice" value="demos">
		<input type=hidden name="perform" value="add">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Opponents</td>
			<td><input type="TEXT" name="demo_awayteam" size="30" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Map Played</td>
			<td><input type="TEXT" name="demo_map" size="10" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Event</td>
			<td><input type="TEXT" name="demo_event" size="30" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">POV</td>
			<td><input type="TEXT" name="demo_pov" size="20" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Match</td>
			<td>
				<select name="demo_match" size=1>
				<option value=''>none</option>
<?
				$matchlist = connection("SELECT record_id,record_date,record_awayteam,record_map FROM records ORDER BY record_date DESC");
					while( $row = mysql_fetch_array($matchlist) ) {
						extract($row);
						$record_date = ChangeDate($record_date);
						echo("<option value='$record_id'>$record_date - $record_awayteam - $record_map</option>");
					}
?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="Subject" valign="top">Demo Comment</td>
			<td><textarea rows="4" cols="50" name="demo_comment"></textarea></td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>

		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('Most web hosts limit this upload to 2MB or 8MB!  Check the FAQ to see how to get around this.')"; onMouseout="ONMOUSEOUT=kill()">Demo</a></td>
			<td><input type="file" name="demo_file"></td>
		</tr>

		<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Add"></td>
		</tr>
		
		</table>
		</form>
		

<?
	}

	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		if ( $_GET["ChooseDemo"] ) {
		
		$result = connection("SELECT * FROM demos WHERE demo_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);
						
?>
		<form action="process.php" method="post" enctype="multipart/form-data">
		<input type=hidden name="choice" value="demos">
		<input type=hidden name="perform" value="edit">
		<input type=hidden name="ID" value="<?=$demo_id?>">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Opponents</td>
			<td><input type="TEXT" name="demo_awayteam" size="30" maxlength="255" value="<?=$demo_awayteam?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Map Played</td>
			<td><input type="TEXT" name="demo_map" size="10" maxlength="255" value="<?=$demo_map?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Event</td>
			<td><input type="TEXT" name="demo_event" size="30" maxlength="255" value="<?=$demo_event?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">POV</td>
			<td><input type="TEXT" name="demo_pov" size="20" maxlength="255" value="<?=$demo_pov?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Match</td>
			<td>
				<select name="demo_match" size=1>
<?
				$current = connection("SELECT record_id,record_date,record_awayteam,record_map FROM records WHERE record_id='$demo_match'");
				$row = mysql_fetch_array($current);
				extract($row);
				
				$record_date = ChangeDate($record_date);
						echo("<option value='$record_id'>$record_date - $record_awayteam - $record_map</option>");
						echo("<option value=''></option>");
				
				$matchlist = connection("SELECT record_id,record_date,record_awayteam,record_map FROM records ORDER BY record_date DESC");
					while( $row = mysql_fetch_array($matchlist) ) {
						extract($row);
						$record_date = ChangeDate($record_date);
						echo("<option value='$record_id'>$record_date - $record_awayteam - $record_map</option>");
					}
?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="Subject" valign="top">Demo Comment</td>
			<td><textarea rows="4" cols="50" name="demo_comment"><?=$demo_comment?></textarea></td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>

		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('Most web hosts limit this upload to 2MB or 8MB!  Check the FAQ to see how to get around this.')"; onMouseout="ONMOUSEOUT=kill()">Demo</a></td>
			<td><input type="file" name="demo_file"></td>
		</tr>

		<tr>
			<td class="Subject">Current Demo</td>
			<td><?=$demo_file?></td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>		
		
		</form>
	
	
	<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
		<tr>
			<td class="CurrentHeader">User</td>
			<td class="CurrentHeader">Comment</td>
			<td class="CurrentHeader" width=5%>Options</td>
		</tr>
<?
		$result = connection("SELECT * FROM comments WHERE news_id='$_GET[ID]'");
			while( $row = mysql_fetch_array($result)) {
			extract($row);
			
			if ( $userID[0] == "u" || $userID[0] == "I" ) {
				$user_name = UserName($userID);
			}
			else {
				$user_name = $userID;
			}
?>				
		<tr>
			<td class="CurrentBlock"><?=$user_name?></td>
			<td class="CurrentBlock"><?=$comment?></td>
			<td class="CurrentBlock" align="middle" valign="middle">
			<a href="process.php?choice=comments&perform=delete&ID=<?=$comments_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
			</td>
		</tr>
<?
		}
?>		
		
		</table>
		
		<?
		}

	}
	
	else {
		
?>		
		<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
		<tr>
			<td class="CurrentHeader">Demo Name</td>
			<td class="CurrentHeader" width=15% align="middle">Map</td>
			<td class="CurrentHeader" width=12%>Options</td>
		</tr>
<?	
		$counter;
		$result = connection("SELECT * FROM demos");
			
			while( $row = mysql_fetch_array($result)) {
				extract($row);
?>				
				<tr>
					<td class="CurrentBlock"><?=$demo_file?></td>
					<td class="CurrentBlock" align=center><?=$demo_map?></td>
					<td class="CurrentBlock" align=center valign="middle">
					<a href="index.php?option=demos&perform=edit&ID=<?=$demo_id?>&ChooseDemo=1"><img src="images/edit.gif" alt="Edit" border=0></a>
					<a href="process.php?choice=demos&perform=delete&ID=<?=$demo_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
					</td>
				</tr>
<? 				
			$counter++;
		}
?>
		</table>
		
		<br>
		
		<div align=right>
		<table cellspacing="1" cellpadding="4" border="0">
		<tr>
			<td class="HorizMenu"><a href="index.php?option=demos&perform=add">Add Demo</a></td>			
		</tr>
		</table>
		</div>
<?
	}
}
else {
	echo "<center>This feature is unavailable to you.</center><br>";
}
?>