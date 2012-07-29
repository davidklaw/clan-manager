<span class="Header">Links</span>
<hr noshade size="1">

<?

	$option = "general";
	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post">
			<input type=hidden name="choice" value="links">
			<input type=hidden name="perform" value="add">
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Link Name</td>
				<td><input type="TEXT" name="link_name" size="30" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Link URL</td>
				<td><input type="TEXT" name="link_url" size="30" maxlength="255" value="http://"></td>
			</tr>
			
			<tr>
				<td class="Subject">Link Type</td>
				<td>
					<select name="link_type" size=1>
					<option value="affiliate">affiliate</option>
					<option value="clan site">clan site</option>
					<option value="informational">informational</option>
					<option value="LAN center">LAN center</option>
					<option value="LANParty">LANParty</option>
					<option value="league">league</option>
					<option value="sponsor">sponsor</option>
					<option value="other">other</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Description</td>
				<td><textarea rows="4" cols="50" name="link_description"></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject"></td>
				<td><input class="SubmitButton" type="submit" value="Add"></td>
			</tr>
			
			</table>
			</form>
				
<?
		}
	
		else if ( $_REQUEST["perform"] == 'edit' ) {
			
			if ( $_GET['ChooseLink'] ) {
			
			$result = connection("SELECT * FROM links WHERE link_id='$_GET[ID]'");
			$row = mysql_fetch_array($result); extract($row);
?>
			<form action="process.php" method="post">
			<input type=hidden name="choice" value="links">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$link_id?>">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Link Name</td>
				<td><input type="TEXT" name="link_name" size="30" maxlength="255" value="<?=$link_name?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Link URL</td>
				<td><input type="TEXT" name="link_url" size="30" maxlength="255" value="<?=$link_url?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Link Type</td>
				<td>
					<select name="link_type" size=1>
					<? echo("<option value='$link_type'>$link_type</option>"); ?>
					<option value="affiliate">affiliate</option>
					<option value="clan site">clan site</option>
					<option value="informational">informational</option>
					<option value="LAN center">LAN center</option>
					<option value="LANParty">LANParty</option>
					<option value="league">league</option>
					<option value="sponsor">sponsor</option>
					<option value="other">other</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Description</td>
				<td><textarea rows="4" cols="50" name="link_description"><?=$link_description?></textarea></td>
			</tr>
			
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
				<td class="CurrentHeader">Link</td>
				<td class="CurrentHeader" width=15% align=center>Type</td>
				<td class="CurrentHeader" width=12% align=center>Options</td>
			</tr>
<?	
			$result = connection("SELECT * FROM links");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
?>				
			<tr>
				<td class="CurrentBlock"><a href="index.php?option=links&perform=edit&ID=<?=$link_id?>&ChooseLink=1"><?=$link_name?></a></td>
				<td class="CurrentBlock" align=center><?=$link_type?></td>
				<td class="CurrentBlock" align=center>
				<a href="index.php?option=links&perform=edit&ID=<?=$link_id?>&ChooseLink=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=links&perform=delete&ID=<?=$link_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
					<td class="HorizMenu"><a href="index.php?option=links&perform=add">Add Link</a></td>
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