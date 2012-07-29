<span class="Header">Screenshots</span>
<hr noshade size="1">

<?
	$option = "general";

	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="screenshots">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Your image automatically gets resized to 600px wide and a thumbnail is created.')"; onMouseout="ONMOUSEOUT=kill()">Screenshot</a></td>
				<td><input type="file" name="screen"></td>
			</tr>

			<tr>
				<td class="Subject">Gallery</td>
				<td>
					<select name="screen_gallery" size=1>
						<option value=''></option>
<?
						$result = connection("SELECT screen_gallery FROM screenshots GROUP BY screen_gallery");
							while( $row = mysql_fetch_array($result)) {
								extract($row);
								
								$resultx = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
								$rowx = mysql_fetch_array($resultx);
								extract($rowx);
								
								$gallery = $screen_gallery;
								echo("<option value='$gallery'>$gallery_name</option>"); 
						}
?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Caption</td>
				<td><input type="TEXT" name="screen_caption" size="50" maxlength="255" value=""></td>
			</tr>
			
			<tr><td class="Subject"></td><td><br><b>New Gallery Information</b> (optional)<br><hr noshade size=1></td></tr>
						
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Use this only to create a gallery that does not already exist.')"; onMouseout="ONMOUSEOUT=kill()">New Gallery</a></td>
				<td><input type="TEXT" name="screen_newgallery" size="30" maxlength="255" value=""></td>
			</tr>

			<tr>
				<td class="Subject">Description</td>
				<td><input type="TEXT" name="gallery_desc" size="50" maxlength="255" value=""></td>
			</tr>

			<tr>
				<td class="Subject">Date</td>
				<td><input type="TEXT" name="gallery_date" size="50" maxlength="255" value=""></td>
			</tr>

			<tr>
				<td class="Subject">Location</td>
				<td><input type="TEXT" name="gallery_location" size="50" maxlength="255" value=""></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1><p></td></tr>
							
			<tr>
				<td class="Subject"></td>
				<td><input class="SubmitButton" type="submit" value="Add"></td>
			</tr>
			
			</table>
			</form>
<?
		}
	
		else if ( $_REQUEST["perform"] == 'edit' ) {
			
			if ( $_GET['ChooseScreen'] ) {
			
			$result2 = connection("SELECT * FROM screenshots WHERE screen_id='$_GET[ID]'");
			$row2 = mysql_fetch_array($result2); extract($row2);
			
			$resultx = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
			$rowx = mysql_fetch_array($resultx); 
			if ( $rowx != null )
				extract($rowx);
?>
			<br>
			<font size=2><b>Gallery:</b> <?=$gallery_name?><p></font>
			<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
			<tr>
				<td class="CurrentHeader" width=20%>Image</td>
				<td class="CurrentHeader" width=12%>Options</td>
			</tr>
<?	
				
			$result = connection("SELECT * FROM screenshots WHERE screen_gallery='$screen_gallery'");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
				
				$resultx = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
				$rowx = mysql_fetch_array($resultx);
				if ( $rowx != null )
					extract($rowx);
				
?>				
			<tr>
				<td class="CurrentBlock" align=middle><a href="index.php?option=screenshots&perform=edit&ID=<?=$screen_id?>&ChooseScreen=1"><img src="files/screenshots/<?=$gallery_name?>/thumb-<?=$screen_name?>" border=0></a><br>
				<td class="CurrentBlock" align="middle">
				<a href="index.php?option=screenshots&perform=edit&ID=<?=$screen_id?>&ChooseScreen=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=screenshots&perform=delete&ID=<?=$screen_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
				</td>
			</tr>
<? 			
			}
?>
			</table><p>
<?
			
			$resultd = connection("SELECT * FROM screenshots WHERE screen_id='$_GET[ID]'");
			$rowd = mysql_fetch_array($resultd); extract($rowd);
			
			$resultx = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
			$rowx = mysql_fetch_array($resultx); 			
			if ( $rowx != null )
				extract($rowx);
?>			
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="screenshots">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="oldgallery" value="<?=$screen_gallery?>">
			<input type=hidden name="oldscreen" value="<?=$screen_name?>">
			<input type=hidden name="ID" value="<?=$screen_id?>">
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Your image automatically gets resized to 600px wide and a thumbnail is created.')"; onMouseout="ONMOUSEOUT=kill()">Screenshot</a></td>
				<td><input type="file" name="screen"></td>
			</tr>
			
			<tr>
				<td class="Subject">Current Screenshot</td>
				<td><a href="files/screenshots/<?=$gallery_name?>/<?=$screen_name?>"><?=$screen_name?></a></td>
			</tr>
			
			<tr>
				<td class="Subject">Gallery</td>
				<td>
					<select name="screen_gallery" size=1>
<?	
						
						echo("<option value='$screen_gallery'>$gallery_name</option>"); 
						echo("<option value=''></option>"); 
						
						$result = connection("SELECT screen_gallery FROM screenshots GROUP BY screen_gallery");
							while( $row = mysql_fetch_array($result)) {
							extract($row);
							$gallery = $screen_gallery;
							
							$resultx = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
							$rowx = mysql_fetch_array($resultx);
							extract($rowx);
							
							echo("<option value='$gallery'>$gallery_name</option>"); 
						}
?>
					</select>
				</td>
			</tr>

			<tr>
				<td class="Subject">Caption</td>
				<td><input type="TEXT" name="screen_caption" size="50" maxlength="255" value="<?=$screen_caption?>"></td>
			</tr>

			<tr><td class="Subject"></td><td><br><b>Gallery Information</b> (these changes apply to all in gallery)<br><hr noshade size=1></td></tr>
									
			<tr>
				<td class="Subject">Description</td>
				<td><input type="TEXT" name="gallery_desc" size="50" maxlength="255" value="<?=$gallery_desc?>"></td>
			</tr>

			<tr>
				<td class="Subject">Date</td>
				<td><input type="TEXT" name="gallery_date" size="50" maxlength="255" value="<?=$gallery_date?>"></td>
			</tr>

			<tr>
				<td class="Subject">Location</td>
				<td><input type="TEXT" name="gallery_location" size="50" maxlength="255" value="<?=$gallery_location?>"></td>
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
				<td class="CurrentHeader" width=20%>Gallery</td>
				<td class="CurrentHeader" width=5% align=center>Images</td>
				<td class="CurrentHeader" width=12%>Options</td>
			</tr>
<?	

			$result = connection("SELECT * FROM screenshots GROUP BY screen_gallery");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
				
				$result2 = connection("SELECT * FROM screenshots WHERE screen_gallery='$screen_gallery'");
				$num = mysql_num_rows($result2);
				
				$result3 = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
				$row3 = mysql_fetch_array($result3);
				if ( $row3 != null )
					extract($row3);
?>				
			<tr>
				<td class="CurrentBlock" align=middle><?=$gallery_name?><br>
				<td class="CurrentBlock" align=center><?=$num?></td>
				<td class="CurrentBlock" align="middle">
				<a href="index.php?option=screenshots&perform=edit&ID=<?=$screen_id?>&ChooseScreen=1"><img src="images/edit.gif" alt="Edit" border=0></a>
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
					<td class="HorizMenu"><a href="index.php?option=screenshots&perform=add">Add Image</a></td>
				</tr>
				</table>
			</div>

<?	
		}
	}
	else
		echo "<center>This feature is unavailable to you.</center><br>";
?>