<span class="Header">Files</span>
<hr noshade size="1">

<?

	$option = "general";

	if ( Allowed($cm[0], $option) == "TRUE" ) {
	
		if ( $_REQUEST["perform"] == 'add' ) {
?>
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="files">
			<input type=hidden name="perform" value="add">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Most web hosts limit this upload to 2MB or 8MB!  Check the FAQ to see how to get around this.')"; onMouseout="ONMOUSEOUT=kill()">File</a></td>
				<td><input type="file" name="file_data"></td>
			</tr>
			
			<tr>
				<td class="Subject">Description</td>
				<td><textarea rows="4" cols="50" name="file_description"></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject"></td>
				<td><br><b>External URL</b> (optional)<br>
					<hr noshade size=1>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">File</td>
				<td><input type="TEXT" name="file_external" size="40" maxlength="255" value=""></td>
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
		
		$result = connection("SELECT * FROM files WHERE file_id='$_GET[ID]'");
		$row = mysql_fetch_array($result); extract($row);
?>
		
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="files">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$file_id?>">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject"><a class=tip href="#" onMouseover="popup('Most web hosts limit this upload to 2MB or 8MB!  Check the FAQ to see how to get around this.')"; onMouseout="ONMOUSEOUT=kill()">File</a></td>
				<td><input type="file" name="file_data"></td>
			</tr>
			
			<tr>
				<td class="Subject">Current</td>
				<td><a href="files/<?=$file_name?>"><?=$file_name?></a></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
							
			<tr>
				<td class="Subject">Description</td>
				<td><textarea rows="4" cols="50" name="file_description"><?=$file_description?></textarea></td>
			</tr>
			
			<tr>
				<td class="Subject"></td>
				<td><br><b>External URL</b> (optional)<br>
					<hr noshade size=1>
				</td>
			</tr>
			
			<tr>
				<td class="Subject">External File</td>
				<td><input type="TEXT" name="file_external" size="40" maxlength="255" value="<?=$file_external?>"></td>
			</tr>
			
			<tr><td class="Subject"></td><td><hr noshade size=1></td></tr>
			
			<tr>
				<td class="Subject"></td>
				<td><input class="SubmitButton" type="submit" value="Update"></td>
			</tr>
			
			</table>

<?
		}
	
		else {
?>
			<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
			<tr>
				<td class="CurrentHeader">File</td>
				<td class="CurrentHeader">Size</td>
				<td class="CurrentHeader" width=12%>Options</td>
			</tr>
<?	
			$result = connection("SELECT * FROM files");
				while( $row = mysql_fetch_array($result)) {
				extract($row);
				$file_size = (int) ($file_size/1024);
?>				
			<tr>
				<td class="CurrentBlock"><a href="index.php?option=files&perform=edit&ID=<?=$file_id?>&ChooseFile=1"><?=$file_name?></a></td>
				<td class="CurrentBlock"><?=$file_size?> KB</td>
				<td class="CurrentBlock" align="middle" valign="middle">
				<a href="index.php?option=files&perform=edit&ID=<?=$file_id?>&ChooseFile=1"><img src="images/edit.gif" alt="Edit" border=0></a>
				<a href="process.php?choice=files&perform=delete&ID=<?=$file_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
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
					<td class="HorizMenu"><a href="index.php?option=files&perform=add">Add File</a></td>
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