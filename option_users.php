<b>Registered Users:</b> <? RegisteredNum(); ?>
<p>
<span class="Header">Users</span>
<hr noshade size="1">

<?

if ( Allowed($cm[0], $option) == "TRUE" ) {
		
	if ( $_REQUEST["perform"] == 'add' ) {
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="users">
		<input type=hidden name="perform" value="add">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Username</td>
			<td><input type="TEXT" name="user_name" size="30" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Email</td>
			<td><input type="TEXT" name="user_email" size="30" maxlength="255" value=""></td>
		</tr>
				
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('Aftering making someone an admin, go to their profile again to give them differant levels of access.')"; onMouseout="ONMOUSEOUT=kill()">Type</a></td>
			<td>

				<select name="user_type" size=1>
				<option value="standard">standard</option>
				<option value="admin">admin</option>
				<option value="head admin">head admin</option>
				</select>

			</td>
		</tr>
		
		<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Add"></td>
		</tr>
		
		</table>
		</form>
				
<?
	}
	
	else if ( $_REQUEST["perform"] == 'edit' ) {
		
		if ( $_GET['ChooseUser'] ) {
			
		$result = connection("SELECT * FROM users WHERE user_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);
?>
		
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="users">
		<input type=hidden name="perform" value="edit">
		<input type=hidden name="ID" value="<?=$user_id?>">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Username</td>
			<td><input type="TEXT" name="user_name" size="30" maxlength="255" value="<?=$user_name?>"></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('Resetting a users password will automatically email them their new password.')"; onMouseout="ONMOUSEOUT=kill()">Reset Password</a></td>
			<td><input TYPE="checkbox" NAME="user_reset" VALUE="yes" STYLE="border: 0"> Yes</td>
		</tr>

		<tr>
			<td class="Subject">Email</td>
			<td><input type="TEXT" name="user_email" size="30" maxlength="255" value="<?=$user_email?>"></td>
		</tr>
		
		<tr>
			<td class="Subject"><a class=tip href="#" onMouseover="popup('Aftering making someone an admin, go to their profile again to give them differant levels of access.')"; onMouseout="ONMOUSEOUT=kill()">Type</a></td>
			<td>
<?
	if ( $user_type == "head admin" ) {
		echo "head admin";
		echo "<input type=hidden name='user_type' value='head admin'>";
	}
	else {
?>
				<select name="user_type" size=1>
				<? echo("<option value='$user_type'>$user_type</option>"); ?>
				<option value=""></option>
				<option value="standard">standard</option>
				<option value="admin">admin</option>
				<option value="head admin">head admin</option>
				</select>
<?
	}
?>
			</td>
		</tr>

<? 
	if ( $user_type == "admin" ) {
	
	$user_abil = explode(",", $user_abil);
			
?>		
		<tr>
			<td class="Subject">Abilities</td>
			<td>
				
				<table cellspacing=1 cellpadding=2>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						
						if ( $user_abil[$d] == "news" ) {
							$result = "CHECKED";
						}
						
						if ( !$result ) {
							$result == "UNCHECKED";
						}

					}
?>					
						<input TYPE="checkbox" NAME="news" VALUE="news" STYLE="border: 0" <?=$result?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>News</b>
						<br>
						Gives this user the ability to post, edit and delete news articles.  It also gives them the ability to delete comments posted to news articles which allow comments.
					</td>
				</tr>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "roster" ) {
							$result1 = "CHECKED";
						}
						if ( !$result1 ) {
							$result1 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="roster" VALUE="roster" STYLE="border: 0" <?=$result1?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Roster</b>
						<br>
						Allow this user to add, edit and delete members of the roster.
					</td>
				</tr>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "records" ) {
							$result3 = "CHECKED";
						}
						if ( !$result3 ) {
							$result3 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="records" VALUE="records" STYLE="border: 0" <?=$result3?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Records</b>
						<br>
						Allow this user to add, edit or delete match results that are in the database.
					</td>
				</tr>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "events" ) {
							$result4 = "CHECKED";
						}
						if ( !$result4 ) {
							$result4 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="events" VALUE="events" STYLE="border: 0" <?=$result4?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Events</b>
						<br>
						Allow this user to add, edit or delete events.
					</td>
				</tr>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "templates" ) {
							$result5 = "CHECKED";
						}
						if ( !$result5 ) {
							$result5 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="templates" VALUE="templates" STYLE="border: 0" <?=$result5?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Templates</b>
						<br>
						Give user access to the various templates.  This should only be checked for the webmaster since knowledge of HTML is required.
					</td>
				</tr>

				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "settings" ) {
							$result6 = "CHECKED";
						}
						if ( !$result6 ) {
							$result6 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="settings" VALUE="settings" STYLE="border: 0" <?=$result6?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Settings</b>
						<br>
						Allow this user to access the page settings.
					</td>
				</tr>
								
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "users" ) {
							$result7 = "CHECKED";
						}
						if ( !$result7 ) {
							$result7 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="users" VALUE="users" STYLE="border: 0" <?=$result7?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>Users</b>
						<br>
						Allow this user to access registered members information.  From here you can change people's status and their abilities.  I suggest only allowing your head admin to view this information.
					</td>
				</tr>
				
				<tr>
					<td class="Subject" style="background: #EFEFEF;">
<?
					for($d=0; $d<8; $d++) {
						if ( $user_abil[$d] == "general" ) {
							$result8 = "CHECKED";
						}
						if ( !$result8 ) {
							$result8 == "UNCHECKED";
						}
					}
?>	
						<input TYPE="checkbox" NAME="general" VALUE="general" STYLE="border: 0" <?=$result8?>>
					</td>
					<td style="background: #EFEFEF;">
						<b>General</b>
						<br>
						General access allows this user to access the following sections: Clan Information, Contacts, Servers, Sponsors, Links, Files, Screenshots, and Mail Clan.
					</td>
				</tr>
				
				</table>	
			
			</td>
		</tr>
<?
		}
?>	
		<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
			
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
			<td class="CurrentHeader">User</td>
			<td class="CurrentHeader" width=15%>Email</td>
			<td class="CurrentHeader" width=12% align=center>Status</td>
			<td class="CurrentHeader" width=5% align=center>Options</td>
		</tr>
<?	
	if ( StatusCheck($cm) == "head admin" ) {
		
		$resulth = connection("SELECT * FROM users WHERE user_type='head admin' ORDER BY user_name ASC");
			while( $rowh = mysql_fetch_array($resulth)) {
			extract($rowh);
?>				
		<tr>
			<td class="CurrentBlock" style="background: DFDFDF;"><a href="index.php?option=users&perform=edit&ID=<?=$user_id?>&ChooseUser=1"><?=$user_name?></a></td>
			<td class="CurrentBlock" style="background: DFDFDF;"><?=$user_email?></td>
			<td class="CurrentBlock" style="background: DFDFDF;" align=center><?=$user_type?></td>
			<td class="CurrentBlock" style="background: DFDFDF;" align=center>
			<a href="index.php?option=users&perform=edit&ID=<?=$user_id?>&ChooseUser=1"><img src="images/edit.gif" alt="Edit" border=0></a>
			<a href="process.php?choice=users&perform=delete&ID=<?=$user_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
			</td>
		</tr>
<?
		}	
	}
	
		$result = connection("SELECT * FROM users WHERE user_type != 'head admin' ORDER BY user_type ASC");
			while( $row = mysql_fetch_array($result)) {
			extract($row);
?>				
		<tr>
			<td class="CurrentBlock"><a href="index.php?option=users&perform=edit&ID=<?=$user_id?>&ChooseUser=1"><?=$user_name?></a></td>
			<td class="CurrentBlock"><?=$user_email?></td>
			<td class="CurrentBlock" align=center><?=$user_type?></td>
			<td class="CurrentBlock" align=center>
			<a href="index.php?option=users&perform=edit&ID=<?=$user_id?>&ChooseUser=1"><img src="images/edit.gif" alt="Edit" border=0></a>
			<a href="process.php?choice=users&perform=delete&ID=<?=$user_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
				<td class="HorizMenu"><a href="index.php?option=users&perform=add">Add User</a></td>
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