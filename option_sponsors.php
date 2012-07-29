<span class="Header">Sponsors</span>
<hr noshade size="1">

<?
	$option = "general";
	
	if ( Allowed($cm[0], $option) == "TRUE" ) {
		
		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="sponsors">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Sponsor Name</td>
				<td><input type="TEXT" name="sponsor_name" size="40" maxlength="255" value=""></td>
			</tr>
			
			<tr>
				<td class="Subject">Sponsor URL</td>
				<td><input type="TEXT" name="sponsor_url" size="40" maxlength="255" value="http://"></td>
			</tr>
			
			<tr>
				<td class="Subject">Sponsor Image</td>
				<td><input type="file" name="sponsor_image"></td>
			</tr>
			
			<tr>
				<td class="Subject">Description</td>
				<td><textarea rows="6" cols="50" name="sponsor_description"></textarea></td>
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
			
			if ( $_GET['ChooseSponsor'] ) {
		
			$result = connection("SELECT * FROM sponsors WHERE sponsor_id='$_GET[ID]'");
			$row = mysql_fetch_array($result); extract($row);
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="sponsors">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$sponsor_id?>">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Sponsor Name</td>
				<td><input type="TEXT" name="sponsor_name" size="40" maxlength="255" value="<?=$sponsor_name?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Sponsor URL</td>
				<td><input type="TEXT" name="sponsor_url" size="40" maxlength="255" value="<?=$sponsor_url?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Sponsor Image</td>
				<td><input type="file" name="sponsor_image"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td>
<?
				if ( $sponsor_image ) 
					echo "<img src='files/sponsors/$sponsor_image'><br><input TYPE='checkbox' NAME='remove_img' VALUE='Y' class=checkbox>remove<br>";
				else
					echo "<font color=red>no image attached</font>";
?>			
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Description</td>
				<td><textarea rows="6" cols="50" name="sponsor_description"><?=$sponsor_description?></textarea></td>
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
				<td class="CurrentHeader">Sponsor Name</td>
				<td class="CurrentHeader" width=12% align=center>Options</td>
			</tr>
<?	
		$result = connection("SELECT * FROM sponsors");
			while( $row = mysql_fetch_array($result)) {
			extract($row);
?>				
			<tr>
				<td class="CurrentBlock"><a href="<?=$sponsor_url?>" target="_new"><?=$sponsor_name?></a></td>
				<td class="CurrentBlock" align="middle">
				<a href="index.php?option=sponsors&perform=edit&ID=<?=$sponsor_id?>&ChooseSponsor=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=sponsors&perform=delete&ID=<?=$sponsor_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
					<td class="HorizMenu"><a href="index.php?option=sponsors&perform=add">Add Sponsor</a></td>
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