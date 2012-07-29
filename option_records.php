<span class="Header">Records</span>
<hr noshade size="1">

<?
	if ( Allowed($cm[0], $option) == "TRUE" ) {

		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post"  enctype="multipart/form-data">
			<input type=hidden name="home_team" value="home">
			<input type=hidden name="choice" value="records">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Opponent Name</td>
				<td><input type="TEXT" name="record_awayteam" size="20" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Opponent Tag</td>
				<td><input type="TEXT" name="record_awaytag" size="10" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Map Played</td>
				<td><input type="TEXT" name="record_map" size="10" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Seperate names with a single , and no spaces!')"; onMouseout="ONMOUSEOUT=kill()">Roster</a></td>
				<td><input type="TEXT" name="record_roster" size="50" maxlength="255" value=""></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
			<td colspan=2>
			
				<table cellspacing="0" cellpadding="0" width=90%>
				<tr>
					<td class="Subject">CT Wins</td>
					<td><input type="TEXT" name="record_ctw" size="2" maxlength="255" value=""></td>
					<td class="Subject">T Wins</td>
					<td><input type="TEXT" name="record_tw" size="2" maxlength="255" value=""></td>
					<td class="Subject">OT Wins</td>
					<td><input type="TEXT" name="record_otw" size="2" maxlength="255" value="0"></td>
				</tr>
				<tr>
					<td class="Subject">CT Losses</td>
					<td><input type="TEXT" name="record_ctl" size="2" maxlength="255" value=""></td>
					<td class="Subject">T Losses</td>
					<td><input type="TEXT" name="record_tl" size="2" maxlength="255" value=""></td>
					<td class="Subject">OT Losses</td>
					<td><input type="TEXT" name="record_otl" size="2" maxlength="255" value="0"></td>
				</tr>
				</table>
			</td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">League</td>
				<td><input type="TEXT" name="record_league" size="10" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD')"; onMouseout="ONMOUSEOUT=kill()">Date</a></td>
				<td><input type=TEXT name="record_date" size=13 maxlength=10 value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Time</td>
				<td><input type=TEXT name="record_time" size=10 maxlength=15 value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">HLTV</td>
				<td><input type=TEXT name="record_hltv" size=20 maxlength=40 value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Scorebot</td>
				<td><input type=TEXT name="record_scorebot" size=20 maxlength=40 value=""></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">Screenshot 1</td>
				<td><input type="file" name="record_screen1"></td>
			</tr>
			
			<tr>
				<td class="Subject">Screenshot 2</td>
				<td><input type="file" name="record_screen2"></td>
			</tr>
		
			<tr>
				<td class="Subject">Screenshot 3</td>
				<td><input type="file" name="record_screen3"></td>
			</tr>
			
			<tr>
				<td class="Subject">Screenshot 4</td>
				<td><input type="file" name="record_screen4"></td>
			</tr>
		
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">MVP</td>
				<td>
					<select name="roster_mvp" size=1>
					<option value="">n/a</option>
					<?
						$result = connection("SELECT roster_alias FROM roster");
							while( $row = mysql_fetch_array($result)) {
							extract($row);
							echo("<option value='$roster_alias'>$roster_alias</option>"); 
						}
					?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Comments</td>
				<td><textarea rows="4" cols="60" name="record_comments"></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject">Match Type</td>
				<td>
					<select name="record_type" size=1>
					<option value="League Match">League Match</option>
					<option value="LAN Tournament">LAN Tournament</option>
					<option value="Online Tournament">Online Tournament</option>
					<option value="Qualifier">Qualifier</option>
					<option value="LANParty">LANParty</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Event Name*</td>
				<td><input type="TEXT" name="record_event" size="30" maxlength="255" value=""></td>
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
			
			if ( $_GET['ChooseRecord'] ) {
			
			$result = connection("SELECT * FROM records WHERE record_id='$_GET[ID]'");
			$row = mysql_fetch_array($result); extract($row);
						
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="500000000">
			<input type=hidden name="choice" value="records">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$record_id?>">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Opponent Name</td>
				<td><input type="TEXT" name="record_awayteam" size="20" maxlength="255" value="<?=$record_awayteam?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Opponent Tag</td>
				<td><input type="TEXT" name="record_awaytag" size="10" maxlength="255" value="<?=$record_awaytag?>"></td>
			</tr>
			
			
			<tr>
				<td class="Subject">Map Played</td>
				<td><input type="TEXT" name="record_map" size="10" maxlength="255" value="<?=$record_map?>"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Seperate names with a single , and no spaces!')"; onMouseout="ONMOUSEOUT=kill()">Roster</a></td>
				<td><input type="TEXT" name="record_roster" size="50" maxlength="255" value="<?=$record_roster?>"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
			<td colspan=2>
			
				<table cellspacing="0" cellpadding="0" width=90%>
				<tr>
					<td class="Subject">CT Wins</td>
					<td><input type="TEXT" name="record_ctw" size="2" maxlength="255" value="<?=$record_ctw?>"></td>
					<td class="Subject">T Wins</td>
					<td><input type="TEXT" name="record_tw" size="2" maxlength="255" value="<?=$record_tw?>"></td>
					<td class="Subject">OT Wins</td>
					<td><input type="TEXT" name="record_otw" size="2" maxlength="255" value="<?=$record_otw?>"></td>
				</tr>
				<tr>
					<td class="Subject">CT Losses</td>
					<td><input type="TEXT" name="record_ctl" size="2" maxlength="255" value="<?=$record_ctl?>"></td>
					<td class="Subject">T Losses</td>
					<td><input type="TEXT" name="record_tl" size="2" maxlength="255" value="<?=$record_tl?>"></td>
					<td class="Subject">OT Losses</td>
					<td><input type="TEXT" name="record_otl" size="2" maxlength="255" value="<?=$record_otl?>"></td>
				</tr>
				</table>
			</td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">League</td>
				<td><input type="TEXT" name="record_league" size="10" maxlength="255" value="<?=$record_league?>"></td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('YYYY-MM-DD')"; onMouseout="ONMOUSEOUT=kill()">Date</a></td>
				<td><input type=TEXT name="record_date" size=13 maxlength=10 value="<?=$record_date?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Time</td>
				<td><input type=TEXT name="record_time" size=10 maxlength=15 value="<?=$record_time?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">HLTV</td>
				<td><input type=TEXT name="record_hltv" size=20 maxlength=40 value="<?=$record_hltv?>"></td>
			</tr>

			<tr>
				<td class="Subject">Scorebot</td>
				<td><input type=TEXT name="record_scorebot" size=20 maxlength=40 value="<?=$record_scorebot?>"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">Screenshot 1</td>
				<td><input type="file" name="record_screen1"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $record_screen1 ) 
					echo "<a href='files/matches/$record_screen1'><img src='files/matches/thumb-$record_screen1' border=0></a><br><input TYPE='checkbox' NAME='remove_img1' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>
		
			<tr>
				<td class="Subject">Screenshot 2</td>
				<td><input type="file" name="record_screen2"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $record_screen2 ) 
					echo "<a href='files/matches/$record_screen2'><img src='files/matches/thumb-$record_screen2' border=0></a><br><input TYPE='checkbox' NAME='remove_img2' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Screenshot 3</td>
				<td><input type="file" name="record_screen3"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $record_screen3 ) 
					echo "<a href='files/matches/$record_screen3'><img src='files/matches/thumb-$record_screen3' border=0></a><br><input TYPE='checkbox' NAME='remove_img3' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Screenshot 4</td>
				<td><input type="file" name="record_screen4"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $record_screen4 ) 
					echo "<a href='files/matches/$record_screen4'><img src='files/matches/thumb-$record_screen4' border=0></a><br><input TYPE='checkbox' NAME='remove_img4' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject">MVP</td>
				<td>
					<select name="record_mvp" size=1>
					<option value='<?=$record_mvp?>'><?=$record_mvp?></option>
					<option value=''>n/a</option>
					<?
						$result = connection("SELECT roster_alias FROM roster");
							while( $row = mysql_fetch_array($result)) {
							extract($row);
							echo("<option value='$roster_alias'>$roster_alias</option>"); 
						}
					?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Comments</td>
				<td><textarea rows="4" cols="60" name="record_comments"><?=$record_comments?></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject">Match Type</td>
				<td>
					<select name="record_type" size=1>
					<? echo("<option value='$record_type'>$record_type</option>"); ?>
					<option value="League Match">League Match</option>
					<option value="LAN Tournament">LAN Tournament</option>
					<option value="Online Tournament">Online Tournament</option>
					<option value="Qualifier">Qualifier</option>
					<option value="LANParty">LANParty</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Event Name*</td>
				<td><input type="TEXT" name="record_event" size="30" maxlength="255" value="<?=$record_event?>"></td>
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
				<td class="CurrentHeader">Opponents</td>
				<td class="CurrentHeader" width=15% align="middle">League</td>
				<td class="CurrentHeader" align=center>Map</td>
				<td class="CurrentHeader" align="middle" width=5%>H</td>
				<td class="CurrentHeader" align="middle" width=5%>A</td>
				<td class="CurrentHeader" width=12%>Options</td>
			</tr>
<?	
			$counter;
			$result = connection("SELECT * FROM records ORDER BY record_date DESC");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
				
				$PullMatch = mysql_query("SELECT * FROM records ORDER BY record_date DESC");			
							
				$home_score = mysql_result($PullMatch,$counter,"record_ctw");
				$home_score += mysql_result($PullMatch,$counter,"record_tw");
				$home_score += mysql_result($PullMatch,$counter,"record_otw");
				$away_score = mysql_result($PullMatch,$counter,"record_ctl");
				$away_score += mysql_result($PullMatch,$counter,"record_tl");
				$away_score += mysql_result($PullMatch,$counter,"record_otl");
?>				
			<tr>
				<td class="CurrentBlock"><?=$record_awayteam?></td>
				<td class="CurrentBlock" align=center><?=$record_league?></td>
				<td class="CurrentBlock" align=center><?=$record_map?></td>
				<td class="CurrentBlock" align=center>
<?
				if ($home_score >= $away_score)
					echo "<b>".$home_score."</b>";
				else
					echo $home_score;
?>
			
				</td>
				<td class="CurrentBlock" align=center><?=$away_score?></td>
				<td class="CurrentBlock" align=center valign="middle">
				<a href="index.php?option=records&perform=edit&ID=<?=$record_id?>&ChooseRecord=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=records&perform=delete&ID=<?=$record_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
				<td class="HorizMenu"><a href="index.php?option=records&perform=add">Add Match</a></td>			
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