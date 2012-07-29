<span class="Header">Roster</span>
<hr noshade size="1">

<?
if ( Allowed($cm[0], $option) == "TRUE" || $ChooseRoster ) {

	if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post"  enctype="multipart/form-data">
			<input type=hidden name="choice" value="roster">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Alias</td>
				<td><input type="TEXT" name="roster_alias" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Name</td>
				<td><input type="TEXT" name="roster_name" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">SteamID</td>
				<td><input type="TEXT" name="roster_wonid" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Rank</td>
				<td>
					<select name="roster_rank" size=1>
					<option value="1">Leader</option>
					<option value="2">Co-Leader</option>
					<option value="3">Member</option>
					<option value="4">Recruit</option>
					<option value="5">Scheduler</option>
					<option value="6">Manager</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Status</td>
				<td>
					<select name="roster_status" size=1>
					<option value="Active">Active</option>
					<option value="Semi-Active">Semi-Active</option>
					<option value="Inactive">Inactive</option>
					</select>
				</td>
			</tr>

			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
						
			<tr>
				<td class="Subject">Email</td>
				<td><input type="TEXT" name="roster_email" size="40" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">MSN</td>
				<td><input type="TEXT" name="roster_msn" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Yahoo</td>
				<td><input type="TEXT" name="roster_yahoo" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">AIM</td>
				<td><input type="TEXT" name="roster_aim" size="20" maxlength="255" value=""></td>
			</tr>

			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
						
			<tr>
				<td class="Subject">Age</td>
				<td><input type="TEXT" name="roster_age" size="3" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Gender</td>
				<td>
					<select name="roster_gender" size=1>
					<option value='Male'>Male</option>
					<option value='Female'>Female</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Location</td>
				<td><input type="TEXT" name="roster_location" size="20" maxlength="255" value=""></td>
			</tr>

			<tr>
				<td class="Subject">Homepage</td>
				<td><input type="TEXT" name="roster_homepage" size="50" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Job</td>
				<td><input type="TEXT" name="roster_job" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Photo</td>
				<td><input type="file" name="roster_photo"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
						
			<tr>
				<td class="Subject" valign="top">Bio</td>
				<td><textarea rows="8" cols="60" name="roster_bio"></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">LAN Exp.</td>
				<td><textarea rows="4" cols="60" name="roster_lanexp"></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject">Previous Clans</td>
				<td><input type="TEXT" name="roster_prevclans" size="50" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Config</td>
				<td><input type="file" name="roster_config"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Do not use quotation marks.')"; onMouseout="ONMOUSEOUT=kill()">Quote</a></td>
				<td><input type="TEXT" name="roster_quote" size="50" maxlength="255" value=""></td>
			</tr>

			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
			
			<tr>
				<td class="Subject">Favorite Food</td>
				<td><input type="TEXT" name="roster_favfood" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Map</td>
				<td><input type="TEXT" name="roster_favmap" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Weapon</td>
				<td><input type="TEXT" name="roster_favweapon" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Player</td>
				<td><input type="TEXT" name="roster_favplayer" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Movie</td>
				<td><input type="TEXT" name="roster_favmovie" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Music</td>
				<td><input type="TEXT" name="roster_favmusic" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
						
			<tr>
				<td class="Subject">SoGamed URL</td>
				<td><input type="TEXT" name="roster_sogamed" size="40" maxlength="255" value="http://"></td>
			</tr>
			
			<tr>
				<td class="Subject">GotFrag URL</td>
				<td><input type="TEXT" name="roster_gotfrag" size="40" maxlength="255" value="http://"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
			
			<tr>
				<td class="Subject">Comp Brand</td>
				<td><input type="TEXT" name="computer_brand" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">CPU</td>
				<td><input type="TEXT" name="computer_cpu" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Motherboard</td>
				<td><input type="TEXT" name="computer_mobo" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">RAM</td>
				<td><input type="TEXT" name="computer_ram" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Video</td>
				<td><input type="TEXT" name="computer_video" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Sound</td>
				<td><input type="TEXT" name="computer_sound" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Hard Drive</td>
				<td><input type="TEXT" name="computer_drive" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Monitor</td>
				<td><input type="TEXT" name="computer_monitor" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Refresh Rate</td>
				<td><input type="TEXT" name="computer_refresh" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Vsync Setting</td>
				<td><input type="TEXT" name="computer_vsync" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Resolution</td>
				<td><input type="TEXT" name="computer_resolution" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Headphones</td>
				<td><input type="TEXT" name="computer_headphones" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Keyboard</td>
				<td><input type="TEXT" name="computer_keyboard" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Mouse</td>
				<td><input type="TEXT" name="computer_mouse" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Sensitivity</td>
				<td><input type="TEXT" name="computer_sens" size="5" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Mousepad</td>
				<td><input type="TEXT" name="computer_pad" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Accessories</td>
				<td><input type="TEXT" name="computer_accessories" size="50" maxlength="255" value=""></td>
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
			
			if ( $_GET['ChooseRoster'] ) {
				
			$result = connection("SELECT * FROM roster WHERE roster_id='$_GET[ID]'");
			$row = mysql_fetch_array($result); extract($row);
				
				//$roster_bio = strip_tags($row["roster_bio"], '<a><b><i><u>');
				//$roster_lanexp = strip_tags($row["roster_lanexp"], '<a><b><i><u>');
		
?>
			<form action="process.php" method="post"  enctype="multipart/form-data">
			<input type=hidden name="choice" value="roster">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$roster_id?>">
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Alias</td>
				<td><input type="TEXT" name="roster_alias" size="20" maxlength="255" value="<?=$roster_alias?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Name</td>
				<td><input type="TEXT" name="roster_name" size="20" maxlength="255" value="<?=$roster_name?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">SteamID</td>
				<td><input type="TEXT" name="roster_wonid" size="20" maxlength="255" value="<?=$roster_wonid?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Rank</td>
				<td>
					<select name="roster_rank" size=1>
<?
					switch ($roster_rank)
					{
						case 1:	$rank = "Leader"; break;
						case 2: $rank = "Co-Leader"; break;
						case 3: $rank = "Member"; break;
						case 4: $rank = "Recruit"; break;
						case 5: $rank = "Scheduler"; break;
						case 6: $rank = "Manager"; break;
					}
					echo("<option value='$roster_rank'>$rank</option>");
?>

					<option value=""></option>
					<option value="1">Leader</option>
					<option value="2">Co-Leader</option>
					<option value="3">Member</option>
					<option value="4">Recruit</option>
					<option value="5">Scheduler</option>
					<option value="6">Manager</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Status</td>
				<td>
					<select name="roster_status" size=1>
					<? echo("<option value='$roster_status'>$roster_status</option>"); ?>
					<option value=""></option>
					<option value="Active">Active</option>
					<option value="Semi-Active">Semi-Active</option>
					<option value="Inactive">Inactive</option>
					</select>
				</td>
			</tr>

			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
						
			<tr>
				<td class="Subject">Email</td>
				<td><input type="TEXT" name="roster_email" size="40" maxlength="255" value="<?=$roster_email?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">MSN</td>
				<td><input type="TEXT" name="roster_msn" size="20" maxlength="255" value="<?=$roster_msn?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Yahoo</td>
				<td><input type="TEXT" name="roster_yahoo" size="20" maxlength="255" value="<?=$roster_yahoo?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">AIM</td>
				<td><input type="TEXT" name="roster_aim" size="20" maxlength="255" value="<?=$roster_aim?>"></td>
			</tr>

			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>	
					
			<tr>
				<td class="Subject">Age</td>
				<td><input type="TEXT" name="roster_age" size="3" maxlength="255" value="<?=$roster_age?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Gender</td>
				<td>
					<select name="roster_gender" size=1>
					<? echo("<option value='$roster_gender'>$roster_gender</option>"); ?>
					<option value=""></option>
					<option value='Male'>Male</option>
					<option value='Female'>Female</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Location</td>
				<td><input type="TEXT" name="roster_location" size="20" maxlength="255" value="<?=$roster_location?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Homepage</td>
				<td><input type="TEXT" name="roster_homepage" size="50" maxlength="255" value="<?=$roster_homepage?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Job</td>
				<td><input type="TEXT" name="roster_job" size="20" maxlength="255" value="<?=$roster_job?>"></td>
			</tr>		
			
			<tr>
				<td class="Subject">Photo</td>
				<td><input type="file" name="roster_photo"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $roster_photo ) 
					echo "<a href='files/roster/$roster_photo'><img src='files/roster/thumb-$roster_photo' border=0></a><br><input TYPE='checkbox' NAME='remove_img' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>	
				
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
					
			<tr>
				<td class="Subject" valign="top">Bio</td>
				<td><textarea rows="8" cols="60" name="roster_bio"><?=$roster_bio?></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">LAN Exp.</td>
				<td><textarea rows="4" cols="60" name="roster_lanexp"><?=$roster_lanexp?></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject">Previous Clans</td>
				<td><input type="TEXT" name="roster_prevclans" size="50" maxlength="255" value="<?=$roster_prevclans?>"></td>
			</tr>							
			
			<tr>
				<td class="Subject">Config</td>
				<td><input type="file" name="roster_config"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $roster_config ) 
					echo "<a href='files/configs/$roster_config'>$roster_config</a><br><input TYPE='checkbox' NAME='remove_config' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no file attached</font>";
?>			
				</td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Do not use quotation marks.')"; onMouseout="ONMOUSEOUT=kill()">Quote</a></td>
				<td><input type="TEXT" name="roster_quote" size="50" maxlength="255" value="<?=$roster_quote?>"></td>
			</tr>
		
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
			
			<tr>
				<td class="Subject">Favorite Food</td>
				<td><input type="TEXT" name="roster_favfood" size="30" maxlength="255" value="<?=$roster_favfood?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Map</td>
				<td><input type="TEXT" name="roster_favmap" size="30" maxlength="255" value="<?=$roster_favmap?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Weapon</td>
				<td><input type="TEXT" name="roster_favweapon" size="30" maxlength="255" value="<?=$roster_favweapon?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Player</td>
				<td><input type="TEXT" name="roster_favplayer" size="30" maxlength="255" value="<?=$roster_favplayer?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Movie</td>
				<td><input type="TEXT" name="roster_favmovie" size="30" maxlength="255" value="<?=$roster_favmovie?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Favorite Music</td>
				<td><input type="TEXT" name="roster_favmusic" size="30" maxlength="255" value="<?=$roster_favmusic?>"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
							
			<tr>
				<td class="Subject">SoGamed URL</td>
				<td><input type="TEXT" name="roster_sogamed" size="40" maxlength="255" value="<?=$roster_sogamed?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">GotFrag URL</td>
				<td><input type="TEXT" name="roster_gotfrag" size="40" maxlength="255" value="<?=$roster_gotfrag?>"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size="1"></td></tr>
			
			<tr>
				<td class="Subject">Comp Brand</td>
				<td><input type="TEXT" name="computer_brand" size="20" maxlength="255" value="<?=$computer_brand?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Motherboard</td>
				<td><input type="TEXT" name="computer_mobo" size="20" maxlength="255" value="<?=$computer_mobo?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">CPU</td>
				<td><input type="TEXT" name="computer_cpu" size="20" maxlength="255" value="<?=$computer_cpu?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">RAM</td>
				<td><input type="TEXT" name="computer_ram" size="20" maxlength="255" value="<?=$computer_ram?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Video</td>
				<td><input type="TEXT" name="computer_video" size="20" maxlength="255" value="<?=$computer_video?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Sound</td>
				<td><input type="TEXT" name="computer_sound" size="20" maxlength="255" value="<?=$computer_sound?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Hard Drive</td>
				<td><input type="TEXT" name="computer_drive" size="20" maxlength="255" value="<?=$computer_drive?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Monitor</td>
				<td><input type="TEXT" name="computer_monitor" size="20" maxlength="255" value="<?=$computer_monitor?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Refresh Rate</td>
				<td><input type="TEXT" name="computer_refresh" size="20" maxlength="255" value="<?=$computer_refresh?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Vsync Setting</td>
				<td><input type="TEXT" name="computer_vsync" size="20" maxlength="255" value="<?=$computer_vsync?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Resolution</td>
				<td><input type="TEXT" name="computer_resolution" size="20" maxlength="255" value="<?=$computer_resolution?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Headphones</td>
				<td><input type="TEXT" name="computer_headphones" size="20" maxlength="255" value="<?=$computer_headphones?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Keyboard</td>
				<td><input type="TEXT" name="computer_keyboard" size="20" maxlength="255" value="<?=$computer_keyboard?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Mouse</td>
				<td><input type="TEXT" name="computer_mouse" size="20" maxlength="255" value="<?=$computer_mouse?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Sensitivity</td>
				<td><input type="TEXT" name="computer_sens" size="5" maxlength="255" value="<?=$computer_sens?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Mousepad</td>
				<td><input type="TEXT" name="computer_pad" size="20" maxlength="255" value="<?=$computer_pad?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Accessories</td>
				<td><input type="TEXT" name="computer_accessories" size="50" maxlength="255" value="<?=$computer_accessories?>"></td>
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
		}
		else {
?>
			<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
			<tr>
				<td class="CurrentHeader">Member</td>
				<td class="CurrentHeader" align=center>Name</td>
				<td class="CurrentHeader" align=center>Rank</td>
				<td class="CurrentHeader" align=center>SteamID</td>
				<td class="CurrentHeader" width=12% align=center>Options</td>
			</tr>
<?	
			$result = connection("SELECT * FROM roster");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
				
				switch ($roster_rank)
				{
					case 1:	$roster_rank = "Leader"; break;
					case 2: $roster_rank = "Co-Leader"; break;
					case 3: $roster_rank = "Member"; break;
					case 4: $roster_rank = "Recruit"; break;
					case 5: $roster_rank = "Scheduler"; break;
					case 6: $roster_rank = "Manager"; break;
				}
				
?>				
			<tr>
				<td class="CurrentBlock"><?=$roster_alias?></td>
				<td class="CurrentBlock" align=center><?=$roster_name?></td>
				<td class="CurrentBlock" align=center><?=$roster_rank?></td>
				<td class="CurrentBlock" align=center><?=$roster_wonid?></td>
				<td class="CurrentBlock" align=center valign="middle">
				<a href="index.php?option=roster&perform=edit&ID=<?=$roster_id?>&ChooseRoster=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=roster&perform=delete&ID=<?=$roster_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
					<td class="HorizMenu"><a href="index.php?option=roster&perform=add">Add Member</a></td>
				</tr>
				</table>
			</div>
<?	
		}
	}
?>
