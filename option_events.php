<span class="Header">Events</span>
<hr noshade size="1">

<?

	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		if ( $_REQUEST["perform"] == 'add' ) {
?>
		<form action="process.php" method="post" enctype="multipart/form-data">
		<input type=hidden name="choice" value="events">
		<input type=hidden name="perform" value="add">
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Event Name</td>
			<td><input type="TEXT" name="event_name" size="30" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD format')"; onMouseout="ONMOUSEOUT=kill()">Start Date</a></td>
			<td><input type="TEXT" name="event_start" size="13" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD format')"; onMouseout="ONMOUSEOUT=kill()">End Date</a></td>
			<td><input type="TEXT" name="event_end" size="13" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Time</td>
			<td><input type="TEXT" name="event_time" size="10" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><b><br>Optional Information</b><br><hr noshade size=1></td>
		</tr>
				
		<tr>
			<td class="Subject">Event Price</td>
			<td><input type="TEXT" name="event_price" size="10" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Game</td>
			<td><input type="TEXT" name="event_game" size="20" maxlength="255" value=""></td>
		</tr>
			
		<tr>
			<td class="Subject">Image/Logo</td>
			<td><input type="file" name="event_image"></td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size=1><br></td></tr>
				
		<tr>
			<td class="Subject">Event Location</td>
			<td><input type="TEXT" name="event_location" size="20" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Site/Email</td>
			<td><input type="TEXT" name="event_contact" size="20" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject" valign="top">Event Description</td>
			<td><textarea rows="4" cols="50" name="event_description"></textarea></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Type</td>
			<td><input type="TEXT" name="event_type" size="30" maxlength="255" value=""></td>
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
	
		if ( $_GET['ChooseEvent'] ) {
			
			$result = connection("SELECT * FROM events WHERE event_id='$_GET[ID]'");
				$row = mysql_fetch_array($result);
				extract($row);
				
			//$event_description = strip_tags($row["event_description"], '<a><b><i><u>');
		
?>
		<form action="process.php" method="post" enctype="multipart/form-data">
		<input type=hidden name="choice" value="events">
		<input type=hidden name="perform" value="edit">
		<input type=hidden name="ID" value="<?=$event_id?>">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Event Name</td>
			<td><input type="TEXT" name="event_name" size="30" maxlength="255" value="<?=$event_name?>"></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD format')"; onMouseout="ONMOUSEOUT=kill()">Start Date</a></td>
			<td><input type="TEXT" name="event_start" size="13" maxlength="255" value="<?=$event_start?>"></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD format')"; onMouseout="ONMOUSEOUT=kill()">End Date</a></td>
			<td><input type="TEXT" name="event_end" size="13" maxlength="255" value="<?=$event_end?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Time</td>
			<td><input type="TEXT" name="event_time" size="10" maxlength="255" value="<?=$event_time?>"></td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><b><br>Optional Information</b><br><hr noshade size=1></td>
		</tr>
				
		<tr>
			<td class="Subject">Event Price</td>
			<td><input type="TEXT" name="event_price" size="10" maxlength="255" value="<?=$event_price?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Game</td>
			<td><input type="TEXT" name="event_game" size="20" maxlength="255" value="<?=$event_game?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Image/Logo</td>
			<td><input type="file" name="event_image"></td>
		</tr>
		
		<tr>
			<td class="Subject" valign="top"></td>
			<td>
<?
				if ( $event_image ) 
					echo "<img src='files/events/$event_image'><br><input TYPE='checkbox' NAME='remove_img' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
			</td>
		</tr>	
		
		<tr><td class="Subject"></td><td><hr noshade size=1><br></td></tr>
				
		<tr>
			<td class="Subject">Event Location</td>
			<td><input type="TEXT" name="event_location" size="20" maxlength="255" value="<?=$event_location?>"></td>
		</tr>
		
		<tr>
			<td class="Subject">Site/Email</td>
			<td><input type="TEXT" name="event_contact" size="20" maxlength="255" value="<?=$event_contact?>"></td>
		</tr>
		
		<tr>
			<td class="Subject" valign="top">Event Description</td>
			<td><textarea rows="4" cols="50" name="event_description"><?=$event_description?></textarea></td>
		</tr>
		
		<tr>
			<td class="Subject">Event Type</td>
			<td><input type="TEXT" name="event_type" size="30" maxlength="255" value="<?=$event_type?>"></td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
		}	
	}
	else {
?>

		<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
		<tr>
			<td class="CurrentHeader">Event</td>
			<td class="CurrentHeader" width=15% align=center>Date</td>
			<td class="CurrentHeader" width=20% align=center>Type</td>
			<td class="CurrentHeader" width=12% align=center>Options</td>
		</tr>
<?	
		$result = connection("SELECT * FROM events");
			while( $row = mysql_fetch_array($result)) {
			extract($row);
			
			$event_start = ChangeDate($event_start);
?>				
		<tr>
			<td class="CurrentBlock"><?=$event_name?></td>
			<td class="CurrentBlock" align=center><?=$event_start?></td>
			<td class="CurrentBlock" align=center><?=$event_type?></td>
			<td class="CurrentBlock" align=center>
			<a href="index.php?option=events&perform=edit&ID=<?=$event_id?>&ChooseEvent=1"><img src="images/edit.gif" alt="Edit" border=0></a>
			<a href="process.php?choice=events&perform=delete&ID=<?=$event_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
			</td>
		</tr>
<? 		
	
		}
?>
		</table>
		
		<br>
			
		<div align="right">
			<table cellspacing="1" cellpadding="4" border="0">
			<tr>
				<td class="HorizMenu"><a href="index.php?option=events&perform=add">Add Event</a></td>
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