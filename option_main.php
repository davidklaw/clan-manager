<br>
<span class="Header">Current News Features</span>
<hr noshade size="1">

<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
<tr>
	<td class="CurrentHeader">Headline</td>
	<td class="CurrentHeader" align=center>Poster</td>
	<td class="CurrentHeader" width=20% align=center>Date</td>
	<td class="CurrentHeader" width=15% align=center>Time</td>
	<td class="CurrentHeader" width=3% align=center>Options</td>
</tr>
<?	
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
	<td class="CurrentBlock"  align=center valign="middle">
	<a href="index.php?option=news&perform=edit&ID=<?=$news_id?>&ChooseNews=1"><img src="images/edit.gif" alt="Edit" border=0></a>
	</td>
</tr>
<? 		
}
?>
</table>
<div align=right><a href="index.php?option=news">view all</a></div>
<p>

<span class="Header">Upcoming Matches</span>
<hr noshade size="1">

<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
<tr>
	<td class="CurrentHeader">Opponents</td>
	<td class="CurrentHeader" width=20% align=center>Date</td>
	<td class="CurrentHeader" width=20% align=center>Time</td>
	<td class="CurrentHeader" width=20% align=center>Map</td>
</tr>
<?
	$result = connection("SELECT * FROM records WHERE record_ctl='0' AND record_ctw='0' ORDER BY record_date ASC");
		while( $row = mysql_fetch_array($result)) {
			extract($row);
			$record_date = ChangeDate($record_date);
?>			
<tr>
	<td class="CurrentBlock"><?=$record_awayteam?></td>
	<td class="CurrentBlock" align=center><?=$record_date?></td>
	<td class="CurrentBlock" align=center><?=$record_time?></td>
	<td class="CurrentBlock" align=center><?=$record_map?></td>
</tr>
<? 		
	}
?>
</table>

<p>

<span class="Header">Events</span>
<hr noshade size="1">

<table cellspacing=1 cellpadding=0 border=0 style="CurrentList" width=100%>
<tr>
	<td class="CurrentHeader">Event</td>
	<td class="CurrentHeader" width=15% align=center>Date</td>
	<td class="CurrentHeader" width=20% align=center>Type</td>
	<td class="CurrentHeader" width=5% align=center>Options</td>
</tr>
<?	
		$result = connection("SELECT * FROM events");
			while( $row = mysql_fetch_array($result)) {
			extract($row);
			
			$event_start = ChangeDate($event_start);
?>			
<tr>
	<td class="CurrentBlock"><?=$event_name?></td>
	<td class="CurrentBlock" align=center><?=$event_start?></td>
	<td class="CurrentBlock" align=center><?=$event_type?></td>
	<td class="CurrentBlock" align=center>
	<a href="index.php?option=events&perform=edit&ID=<?=$event_id?>&ChooseEvent=1"><img src="images/edit.gif" alt="Edit" border=0></a>
	</td>
</tr>
<? 		
$counter++;			
}
?>
</table>

<p>
