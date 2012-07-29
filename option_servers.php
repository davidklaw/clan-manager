<span class="Header">Servers</span>
<hr noshade size="1">

<?
	$option = "general";
	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="servers">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Server Name</td>
				<td><input type="TEXT" name="server_name" size="40" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Server IP:Port</td>
				<td><input type="TEXT" name="server_ip" size="28" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Server Type</td>
				<td>
					<select name="server_type" size=1>
					<option value="Private">Private</option>
					<option value="Public">Public</option>
					<option value="HLTV">HLTV</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('This can be any text file, I suggest your maplist.txt but you can use a motd file or a description of the server.  What ever you want!')"; onMouseout="ONMOUSEOUT=kill()">Text File</a></td>
				<td><input type="file" name="server_maplist"></td>
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
			
			if ( $_GET['ChooseServer'] ) {
			
				$result = connection("SELECT * FROM servers WHERE server_ip='$_GET[ID]'");
				$row = mysql_fetch_array($result); extract($row);
?>
					<form action="process.php" method="post" enctype="multipart/form-data">
					<input type=hidden name="choice" value="servers">
					<input type=hidden name="perform" value="edit">
					<input type=hidden name="ID" value="<?=$server_ip?>">
					
					<table cellspacing="0" cellpadding="0">
					
					<tr>
						<td class="Subject">Server Name</td>
						<td><input type="TEXT" name="server_name" size="40" maxlength="255" value="<?=$server_name?>"></td>
					</tr>
					
					<tr>
						<td class="Subject">Server IP:Port</td>
						<td><input type="TEXT" name="server_ip" size="28" maxlength="255" value="<?=$server_ip?>"></td>
					</tr>
					
					<tr>
						<td class="Subject">Server Type</td>
						<td>
							<select name="server_type" size=1>
							<? echo("<option value='$server_type'>$server_type</option>"); ?>
							<option value=""></option>
							<option value="Private">Private</option>
							<option value="Public">Public</option>
							<option value="HLTV">HLTV</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td class="Subject"><a class=tip href="#" onMouseover="popup('This can be any text file, I suggest your maplist.txt but you can use a motd file or a description of the server.  What ever you want!')"; onMouseout="ONMOUSEOUT=kill()">Text File</a></td>
						<td><input type="file" name="server_maplist"></td>
					</tr>
					
					<tr>
						<td class="Subject" valign="top"></td>
						<td>
<?
						if ( $server_maplist ) 
							echo "<a href='files/servers/$server_maplist'>$server_maplist</a><br><input TYPE='checkbox' NAME='remove_list' VALUE='Y' class=checkbox>remove<br>";
						else
							echo "<font color=red>no file attached</font>";
?>			
						</td>
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
					<td class="CurrentHeader">Server Name</td>
					<td class="CurrentHeader" width=30%>Address</td>
					<td class="CurrentHeader" width=12%>Options</td>
				</tr>
<?	
			$result = connection("SELECT * FROM servers");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
?>				
				<tr>
					<td class="CurrentBlock"><?=$server_name?></td>
					<td class="CurrentBlock"><?=$server_ip?></td>
					<td class="CurrentBlock" align="middle">
					<a href="index.php?option=servers&perform=edit&ID=<?=$server_ip?>&ChooseServer=1"><img src="images/edit.gif" alt="Edit" border=0></a>
					<a href="process.php?choice=servers&perform=delete&ID=<?=$server_ip?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
						<td class="HorizMenu"><a href="index.php?option=servers&perform=add">Add Server</a></td>
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