<span class="Header">News</span>
<hr noshade size="1">
<?

if ( Allowed($cm[0], $option) == "TRUE" ) {

	if ( $_REQUEST["perform"] == 'edit' ) {

		if ( $_GET['ChooseNews'] ) {
			
			$result = connection("SELECT * FROM news WHERE news_id='$_GET[ID]'");
				$row = mysql_fetch_array($result);
				extract($row);
		
			//$news_content = strip_tags($row["news_content"], '<a><img><b><i><u>');
?>	
			<form action="process.php" method="post" enctype="multipart/form-data">
			<input type=hidden name="choice" value="news">
			<input type=hidden name="perform" value="edit">
			<input type=hidden name="ID" value="<?=$news_id?>">
			
			<table cellspacing="0" cellpadding="0">
			
			<tr>
				<td class="Subject">Date</td>
				<td><?=$news_date?></td>
			</tr>
			
			<tr>
				<td class="Subject">Subject</td>
				<td><input type="TEXT" name="news_subject" size="45" maxlength="255" value="<?=$news_subject?>"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Content</td>
				<td><textarea rows="10" cols="60" name="news_content"><?=$news_content?></textarea></td>
			</tr>
			
			<tr><td><br></td><td></td></tr>
			
			<tr>
				<td class="Subject" valign="top">Image</td>
				<td><input type="file" name="news_image"></td>
			</tr>
			
			<tr>
				<td class="Subject" valign="top">Current</td>
				<td>
		<?
					if ( $news_image ) 
						echo "<img src='files/news/$news_image'><br><input TYPE='checkbox' NAME='remove_img' VALUE='Y'>remove<br>";
					else
						echo "<font color=red>no image attached</font>";
		?>			
				</td>
			</tr>
			
			<tr>
				<td class="Subject">Caption</td>
				<td><input type="TEXT" name="news_caption" size="45" maxlength="255" value="<?=$news_caption?>"></td>
			</tr>
			
			<tr>
				<td class="Subject">Comments?</td>
				<td>
					<select name="news_comments" size=1>
		<?
					if ( $news_comments == "Y" ) 
						echo "<option value='Y'>Yes</option><option value='N'>No</option>";
					else 
						echo "<option value='N'>No</option><option value='Y'>Yes</option>";
		?>
					</select>
				</td>
			</tr>
			
			<tr><td><br></td><td></td></tr>
			
			<tr>
				<td class="Subject" valign="top"></td>
				<td align="right"><input class="SubmitButton" type="submit" value="Update"></td>
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
		
		$user_name = UserName($userID);

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
			<td class="CurrentHeader">Headline</td>
			<td class="CurrentHeader" align=center>Poster</td>
			<td class="CurrentHeader" align=center width=20%>Date</td>
			<td class="CurrentHeader" align=center width=15%>Time</td>
			<td class="CurrentHeader" align=center width=3%>Options</td>
		</tr>
<?	
		if ( $display == "all" )
			$result = connection("SELECT * FROM news");
		else
			$result = connection("SELECT * FROM news ORDER BY count DESC LIMIT 5");
			
			while( $row = mysql_fetch_array($result)) {
			extract($row);
			
			$news_reporter = UserName($news_reporter); // userID gets Alias
?>				
		<tr>
			<td class="CurrentBlock"><?=$news_subject?></td>
			<td class="CurrentBlock" align=center><?=$news_reporter?></td>
			<td class="CurrentBlock" align=center><?=$news_date?></td>
			<td class="CurrentBlock" align=center><?=$news_time?></td>
			<td class="CurrentBlock" align="middle" align=center>
			<a href="index.php?option=news&perform=edit&ID=<?=$news_id?>&ChooseNews=1"><img src="images/edit.gif" alt="Edit" border=0></a>
			<a href="process.php?choice=news&perform=delete&ID=<?=$news_id?>"><img src="images/delete.gif" alt="Remove" border=0></a>
			</td>
		</tr>
<? 		
	
		}

		echo("</table>");

		if ( $display != "all" ) echo("<div align=right><a href='index.php?option=news&display=all'>view all</a></div>");
?>
		
		<br><br><br>
		
		<span class="Header">Add A News Item</span>
		<hr noshade size="1">
<?
		$result = connection("SELECT date_format FROM prefs");
			$row = mysql_fetch_array($result);
			extract($row);
	
		// check to see desired date format
		if ( $date_format == '1' ) 
			$news_date = date("n/j/Y");
		else if ( $date_format == '2' )
			$news_date = date("F j, Y");
		else if ( $date_format == '3' )
			$news_date = date("l, F j");
?>
		<form action="process.php" method="post" enctype="multipart/form-data">
		<input type=hidden name="choice" value="news">
		<input type=hidden name="perform" value="add">
		<input type=hidden name="news_date" value="<?=$news_date?>">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Date</td>
			<td><?=$news_date?></td>
		</tr>
		
		<tr>
			<td class="Subject">Subject</td>
			<td><input type="TEXT" name="news_subject" size="45" maxlength="255" value=""></td>
		</tr>
		
		<tr>
			<td class="Subject">Content</td>
			<td><textarea rows="10" cols="60" name="news_content"></textarea></td>
		</tr>
		
		<tr><td><br></td><td></td></tr>
		
		<tr>
			<td class="Subject">Image</td>
			<td><input type="file" name="news_image"></td>
		</tr>
		
		<tr>
			<td class="Subject">Caption</td>
			<td><input type="TEXT" name="news_caption" size="45" maxlength="255" value=""></td></td>
		</tr>
		
		<tr>
			<td class="Subject">Comments?</td>
			<td>
				<select name="news_comments" size=1>
				<option value="Y">Yes</option>
				<option value="N">No</option>
				</select>
			</td>
		</tr>
		
		<tr><td><br></td><td></td></tr>
		
		<tr>
			<td class="Subject" valign="top"></td>
			<td align="right"><input class="SubmitButton" type="submit" value="Post"> <input class="SubmitButton" type="reset" value="Clear"></td>
		</tr>
		</table>
		
		</form>
		
<?
	}
}
else {
	echo "<center>This feature is unavailable to you.</center><br>";
}
?>