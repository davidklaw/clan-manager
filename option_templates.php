<span class="Header">Templates</span>
<hr noshade size="1">

<?
if ( Allowed($cm[0], $option) == "TRUE" ) {

	if ( $_GET['type'] == "news" )
	{
		$result = connection("SELECT news_headlines,news_posts,news_post FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="news">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Headlines</td>
			<td>
				<textarea rows="12" cols="75" name="news_headlines"><?=$news_headlines?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">News Posts</td>
			<td>
				<textarea rows="12" cols="75" name="news_posts"><?=$news_posts?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Single Post</td>
			<td>
				<textarea rows="12" cols="75" name="news_post"><?=$news_post?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "roster" )
	{
		$result = connection("SELECT roster_list,roster_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="roster">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject" valign=top>Listing</td>
			<td>
				<textarea rows="12" cols="75" name="roster_list"><?=$roster_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject" valign=top>Details</td>
			<td>
				<textarea rows="20" cols="75" name="roster_detail"><?=$roster_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "records" )
	{
		$result = connection("SELECT records_upcoming,records_recent,records_list,records_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="records">
		
		<table cellspacing="0" cellpadding="0">

		<tr>
			<td class="Subject">Upcoming</td>
			<td>
				<textarea rows="12" cols="75" name="records_upcoming"><?=$records_upcoming?></textarea>
			</td>
		</tr>
				
		<tr>
			<td class="Subject">Recent</td>
			<td>
				<textarea rows="12" cols="75" name="records_recent"><?=$records_recent?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="records_list"><?=$records_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="records_detail"><?=$records_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
		else if ( $_GET['type'] == "files" )
	{
		$result = connection("SELECT file_list,file_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="files">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="file_list"><?=$file_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="file_detail"><?=$file_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "links" )
	{
		$result = connection("SELECT links_list,links_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="links">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="links_list"><?=$links_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="links_detail"><?=$links_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "sponsors" )
	{
		$result = connection("SELECT sponsor_list,sponsor_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="sponsors">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="sponsor_list"><?=$sponsor_list?></textarea>
			</td>
		</tr>

		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="sponsor_detail"><?=$sponsor_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "events" )
	{
		$result = connection("SELECT event_recent,event_list,event_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="events">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Recent</td>
			<td>
				<textarea rows="12" cols="75" name="event_recent"><?=$event_recent?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="event_list"><?=$event_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="event_detail"><?=$event_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "servers" )
	{
		$result = connection("SELECT server_list,server_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="servers">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="server_list"><?=$server_list?></textarea>
			</td>
		</tr>

		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="server_detail"><?=$server_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "demos" )
	{
		$result = connection("SELECT demos_recent,demos_list,demos_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="demos">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Recent</td>
			<td>
				<textarea rows="12" cols="75" name="demos_recent"><?=$demos_recent?></textarea>
			</td>
		</tr>
	
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="demos_list"><?=$demos_list?></textarea>
			</td>
		</tr>

		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="demos_detail"><?=$demos_detail?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "contacts" )
	{
		$result = connection("SELECT contacts_list FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="contacts">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="contacts_list"><?=$contacts_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "information" )
	{
		$result = connection("SELECT info_list FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="information">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="info_list"><?=$info_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject"></td>
			<td><input class="SubmitButton" type="submit" value="Update"></td>
		</tr>
		
		</table>
		</form>
<?
	}
	
	else if ( $_GET['type'] == "screenshots" )
	{
		$result = connection("SELECT screens_list,screens_detail FROM templates");
		$row = mysql_fetch_array($result); extract($row);
?>
		<form action="process.php" method="post">
		<input type=hidden name="choice" value="templates">
		<input type=hidden name="type" value="screenshots">
		
		<table cellspacing="0" cellpadding="0">
		
		<tr>
			<td class="Subject">Listing</td>
			<td>
				<textarea rows="12" cols="75" name="screens_list"><?=$screens_list?></textarea>
			</td>
		</tr>
		
		<tr>
			<td class="Subject">Details</td>
			<td>
				<textarea rows="12" cols="75" name="screens_detail"><?=$screens_detail?></textarea>
			</td>
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
		echo "<center>This feature is unavailable to you.</center><br>";
	}
?>