<?php

/* 

	Modifications of any kind to the kliptmedia Clan Manager code 
	are strictly prohibited. You may not alter the program code in 
	any manner, except to change paths and connection variables, if 
	necessary, or to change absolute paths for required files. You 
	may not add additional code to the kliptmedia Clan Manager.
	
	You may not distribute, sell, or reuse the program in any 
	manner. In addition, you may not use any code snippets from 
	the kliptmedia Clan Manager for any other purpose without the 
	express written consent of David Klawitter. Each download is 
	intended for one customer only.

*/
		
function DisplayHeadlines($Num)
{
	$resultk = connection("SELECT * FROM news ORDER BY count DESC LIMIT $Num");
	
	$rowmult = 1;
	
	while( $rowk = mysql_fetch_array($resultk) )  {

		extract($rowk);
		
		if ( $rowmult % 2 == 0 )
			$rowClass = "AlternateRow1";
		else
			$rowClass = "AlternateRow2";
			
		$news_reporter = UserName($news_reporter);  // convert reporter id to alias
		
		$result4 = connection("SELECT roster_id FROM roster WHERE roster_alias='$news_reporter'");
		$row4 = mysql_fetch_array($result4);
		if ( $row4 ) { extract($row4); }            // extract reporters id if on roster
		
		$result2 = connection("SELECT news_headlines FROM templates");  // get template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $news_headlines;
		
		if ( $news_comments == "Y" )
		{
			$sql = connection("SELECT * FROM comments WHERE news_id='$news_id' ORDER BY counter DESC");
			$comnum = mysql_num_rows($sql);
			$comments = "<a href='index.php?newsid=$news_id'>$comnum</a>";
		}
		else
			$comments = "";
		
		// template for news headlines	
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);		
		$template = eregi_replace("<% subject %>", "<a href='index.php?newsid=$news_id'>$news_subject</a>", $template);	
		$template = eregi_replace("<% reporter %>", "<a href=index.php?page=roster&ChooseRoster=$roster_id>$news_reporter</a>", $template);
		$template = eregi_replace("<% date %>", "$news_date", $template);
		$template = eregi_replace("<% time %>", "$news_time", $template);
		$template = eregi_replace("<% comments %>", "$comments", $template);
		$template = eregi_replace("<% post %>", "$news_content", $template);
		
			echo $template; // display headline
			
		$rowmult++;
	}	
}

//**************************************************************************//

function DisplayNews($Num)
{
	$counter = 0;
	$result = connection("SELECT * FROM news ORDER BY count DESC LIMIT $Num");
	
	while( $row = mysql_fetch_array($result) )  {
		
		extract($row);
		$news_reporter = UserName($news_reporter);  // convert reporter id to alias
		
		$result4 = connection("SELECT roster_id FROM roster WHERE roster_alias='$news_reporter'");
		$row4 = mysql_fetch_array($result4);
		if ( $row4 ) { extract($row4); }            // extract reporters id if on roster
			
		$result2 = connection("SELECT news_posts FROM templates");  // get template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $news_posts;
		
		if ( $news_comments == "Y" )
		{
			$sql = connection("SELECT * FROM comments WHERE news_id='$news_id' ORDER BY counter DESC");
			$comnum = mysql_num_rows($sql);
			$comments = "<a href='index.php?newsid=$news_id'>$comnum</a>";
		}
		else
			$comments = "";
		
		// setup image display
		if ( $news_image )
			$attachment = "<img src='".$cm_dir."/files/news/$news_image'><br>";
		else
				$attachment = "";	
		
		//$news_content = preg_replace("/(http|ftp)+(s)?:(\\/\\/)((\\w|\\.)+)(\\/)?(\\S+)?/i", "<a href=\"\\0\" target=_new>\\4</a>", $news_content );
		$news_content = preg_replace("/(^|[[:space:]\(\),\^\*\$Ž£\[\]\{\}@#])(https?:\/\/)([a-zA-Z0-9=\?\/\.\-_~&\+%]+)($|[[:space:]\(\),\^\*\$Ž£\[\]\{\}@#])/","\\1<a href=\"\\2\\3\" target=\"_blank\">".substr("\\3", 0, 10)."</a>", $news_content);
		$news_content = nl2br($news_content);
		
		// template for news headlines					
		$template = eregi_replace("<% subject %>", "$news_subject", $template);	
		$template = eregi_replace("<% reporter %>", "<a href='index.php?page=roster&ChooseRoster=$roster_id'>$news_reporter</a>", $template);
		$template = eregi_replace("<% date %>", "$news_date", $template);
		$template = eregi_replace("<% time %>", "$news_time", $template);
		$template = eregi_replace("<% comments %>", "$comments", $template);
		$template = eregi_replace("<% post %>", "$news_content", $template);
		$template = eregi_replace("<% image %>","$attachment", $template);
		$template = eregi_replace("<% caption %>", "$news_caption", $template);
		
			echo $template; // display post
		
		$counter++; // increment to next news post
	}	

}

//**************************************************************************//

function DisplayPost($id)
{
	$result = connection("SELECT * FROM news WHERE news_id='$id'");
	$row = mysql_fetch_array($result); extract($row);
	$news_reporter = UserName($news_reporter);

	$result = connection("SELECT force_register,cm_dir FROM settings");
	$row = mysql_fetch_array($result); extract($row);
	
	$result4 = connection("SELECT roster_id FROM roster WHERE roster_alias='$news_reporter'");
	$row4 = mysql_fetch_array($result4);
	if ( $row4 ) { extract($row4); }            // extract reporters id if on roster

	// setup image display
	if ( $news_image )
		$attachment = "<img src='".$cm_dir."/files/news/$news_image'><br>";
	else
			$attachment = "";	

	// setup comments
	if ( $news_comments == "Y" )
	{
		$sql = connection("SELECT * FROM comments WHERE news_id='$news_id' ORDER BY counter ASC");
		$comnum = mysql_num_rows($sql);
		$comments = "<a href='index.php?newsid=$news_id'>$comnum</a>";
				
		// goes through all comments and displays them
		while( $row = mysql_fetch_array($sql) )  {
			extract($row);
			
			$user_name = UserName($userID);
			if ( $user_name == null )
			  $user_name = $userID;
			  
			$showcomments .= "<div class='CommentName'>$user_name</div>
												<div class='CommentPost'>$comment</div><br>";
		}
		
		if ( $force_register == "Y" ) 
		{
			if ( logintest($cm[0]) == TRUE ) {
			
				$showcomments .= "<form action='$cm_dir/process.php' method='post'>
					<font size=1><b>Comment:</b></font><br>
					<input type=hidden name='perform' value='AddComment'>
					<input type=hidden name='register' value='YES'>
					<input type=hidden name='ID' value='$id'>
					<textarea rows='4' cols='30' name='Comment'></textarea>
					<br>
					<input type='submit' value='Submit'>
					</form>";
			}
			else
				$showcomments .= "<font size=1>please login to post comments</font>";
		}

		else if ( $force_register == "N" ) {
	
			$showcomments .= "<form action='$cm_dir/process.php' method='post'>
				<input type=hidden name='perform' value='AddComment'>
				<input type=hidden name='register' value='NO'>
				<input type=hidden name='ID' value='$id'>";
	
			if ( logintest($cm[0]) == FALSE )
				$showcomments .= "Name:<br><input type='TEXT' name='comment_name' size='10' maxlength='255' value=''><br>";
				
			$showcomments .= "Comment:<br><textarea rows='4' cols='30' name='Comment' class='CommentTextarea'></textarea>
												<br><input type='submit' class='SubmitButton' value='Submit'></form>";
		}
		
	}
	else
		$comments = "";
	
		//$news_content = preg_replace("/(http|ftp)+(s)?:(\\/\\/)((\\w|\\.)+)(\\/)?(\\S+)?/i", "<a href=\"\\0\" target=_new>\\4</a>", $news_content );
		$news_content = preg_replace("/(^|[[:space:]\(\),\^\*\$Ž£\[\]\{\}@#])(https?:\/\/)([a-zA-Z0-9=\?\/\.\-_~&\+%]+)($|[[:space:]\(\),\^\*\$Ž£\[\]\{\}@#])/","\\1<a href=\"\\2\\3\" target=\"_blank\">".substr("\\3", 0, 10)."</a>", $news_content);
		$news_content = nl2br($news_content);
	
	$result2 = connection("SELECT news_post FROM templates");  // get news template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $news_post;

	$template = eregi_replace("<% subject %>", "$news_subject", $template);	
	$template = eregi_replace("<% reporter %>", "<a href=index.php?page=roster&ChooseRoster=$roster_id>$news_reporter</a>", $template);
	$template = eregi_replace("<% date %>", "$news_date", $template);
	$template = eregi_replace("<% time %>", "$news_time", $template);
	$template = eregi_replace("<% comments %>", "$comments", $template);
	$template = eregi_replace("<% post %>", "$news_content", $template);
	$template = eregi_replace("<% image %>","$attachment", $template);
	$template = eregi_replace("<% caption %>", "$news_caption", $template);
	$template = eregi_replace("<% showcomments %>", "$showcomments", $template);

		echo $template; // display post
}

//**************************************************************************//

function DisplayRosterList($sort,$scend)
{		
	global $cm_dir;
	
	if ( $sort == null )
		$result = connection("SELECT * FROM roster ORDER BY roster_rank ASC");
	else {
		$order = "roster_".$sort;
		$result = connection("SELECT * FROM roster ORDER BY $order $scend");
	}
	
	$rowmult = 1;
	
	while( $row = mysql_fetch_array($result) ) {
		extract($row);
		
		if ( $rowmult % 2 == 0 )
			$rowClass = "AlternateRow1";
		else
			$rowClass = "AlternateRow2";

		$result2 = connection("SELECT roster_list FROM templates");  // get roster template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $roster_list;
			
		if ( $roster_photo )
			$picture = "<a href='$cm_dir/files/roster/$roster_photo'><img src='$cm_dir/files/roster/thumb-$roster_photo' border=0></a>";
		else
			$picture = "";
	
		if ( $roster_config )
			$conf = "<a href='$cm_dir/files/configs/$roster_config'>click here</a>";
		else
			$conf = "not available";
			
			$gotfrag2 = explode("user/",$roster_gotfrag);
			$gotfrag3 = explode("/",$gotfrag2[1]);
			$gotfrag = $gotfrag3[0];
			$sogamed = explode("=",$roster_sogamed);
			$sogamed = $sogamed[1];	
			
			switch ($roster_rank)
			{
				case 1:	$roster_rank = "Leader"; break;
				case 2: $roster_rank = "Co-Leader"; break;
				case 3: $roster_rank = "Member"; break;
				case 4: $roster_rank = "Recruit"; break;
				case 5: $roster_rank = "Scheduler"; break;
				case 6: $roster_rank = "Manager"; break;
			}
			
			$roster_bio = nl2br($roster_bio);
			$roster_prevclans = nl2br($roster_prevclans);
			$roster_lanexp = nl2br($roster_lanexp);
			
			$template = eregi_replace("<% rowClass %>", $rowClass, $template);			
			$template = eregi_replace("<% alias %>", "<a href=index.php?page=roster&ChooseRoster=$roster_id>$roster_alias</a>", $template);
			$template = eregi_replace("<% name %>", "$roster_name", $template);	
			$template = eregi_replace("<% rank %>", "$roster_rank", $template);	
			$template = eregi_replace("<% status %>", "$roster_status", $template);	
			$template = eregi_replace("<% age %>", "$roster_age", $template);	
			$template = eregi_replace("<% gender %>", "$roster_gender", $template);	
			$template = eregi_replace("<% location %>", "$roster_location", $template);	
			$template = eregi_replace("<% email %>", "<a href='index.php?page=email&id=$roster_id'>email me</a>", $template);	
			$template = eregi_replace("<% bio %>", "$roster_bio", $template);
			$template = eregi_replace("<% quote %>", "$roster_quote", $template);	
			$template = eregi_replace("<% wonid %>", "$roster_wonid", $template);	
			$template = eregi_replace("<% gotfrag %>", "<a href='$roster_gotfrag' target=_new>$gotfrag</a>", $template);	
			$template = eregi_replace("<% sogamed %>", "<a href='$roster_sogamed' target=_new>$sogamed</a>", $template);	
			$template = eregi_replace("<% brand %>", "$computer_brand", $template);
			$template = eregi_replace("<% mobo %>", "$computer_mobo", $template);
			$template = eregi_replace("<% cpu %>", "$computer_cpu", $template);
			$template = eregi_replace("<% ram %>", "$computer_ram", $template);
			$template = eregi_replace("<% video %>", "$computer_video", $template);
			$template = eregi_replace("<% sound %>", "$computer_sound", $template);
			$template = eregi_replace("<% monitor %>", "$computer_monitor", $template);
			$template = eregi_replace("<% resolution %>", "$computer_resolution", $template);
			$template = eregi_replace("<% headphones %>", "$computer_headphones", $template);
			$template = eregi_replace("<% keyboard %>", "$computer_keyboard", $template);
			$template = eregi_replace("<% mouse %>", "$computer_mouse", $template);
			$template = eregi_replace("<% sens %>", "$computer_sens", $template);
			$template = eregi_replace("<% pad %>", "$computer_pad", $template);
			$template = eregi_replace("<% accessories %>", "$computer_accessories", $template);
			$template = eregi_replace("<% photo %>", "$picture", $template);
			$template = eregi_replace("<% config %>", "$conf", $template);
		
			// new as of ver 3.0
			$template = eregi_replace("<% job %>", "$roster_job", $template);
			$template = eregi_replace("<% refreshrate %>", "$computer_refresh", $template);
			$template = eregi_replace("<% vsync %>", "$computer_vsync", $template);
			$template = eregi_replace("<% hdrive %>", "$computer_drive", $template);
			$template = eregi_replace("<% msn %>", "$roster_msn", $template);
			$template = eregi_replace("<% yahoo %>", "$roster_yahoo", $template);
			$template = eregi_replace("<% aim %>", "$roster_aim", $template);
			$template = eregi_replace("<% favfood %>", "$roster_favfood", $template);
			$template = eregi_replace("<% favmap %>", "$roster_favmap", $template);
			$template = eregi_replace("<% favweapon %>", "$roster_favweapon", $template);
			$template = eregi_replace("<% favplayer %>", "$roster_favplayer", $template);
			$template = eregi_replace("<% favmovie %>", "$roster_favmovie", $template);
			$template = eregi_replace("<% favmusic %>", "$roster_favmusic", $template);
			$template = eregi_replace("<% homepage %>", "$roster_homepage", $template);
			$template = eregi_replace("<% lanexp %>", "$roster_lanexp", $template);
			$template = eregi_replace("<% prevclans %>", "$roster_prevclans", $template);
			$template = eregi_replace("<% details %>", "<a href=index.php?page=roster&ChooseRoster=$roster_id>details</a>", $template);
			
				echo $template;  // display roster list
				
			$rowmult++;
	}	
}

//**************************************************************************//

function DisplayRosterDetails($ChooseRoster)
{
	global $cm_dir;
	
	$result = connection("SELECT * FROM roster WHERE roster_id='$ChooseRoster'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT roster_detail FROM templates");  // get roster template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $roster_detail;

	if ( $roster_photo )
		$picture = "<a href='$cm_dir/files/roster/$roster_photo'><img src='$cm_dir/files/roster/thumb-$roster_photo' border=0></a>";
	else
		$picture = "";

	if ( $roster_config )
		$conf = "<a href='$cm_dir/files/configs/$roster_config'>click here</a>";
	else
		$conf = "not available";
	
	$matches .= "<form action='index.php' method='get'><input type=hidden name='page' value='records'><select name='ChooseRecord' size=1>";
	
	$result5 = connection("SELECT record_id,record_awayteam,record_map,record_roster FROM records");  // get roster template
	while( $row5 = mysql_fetch_array($result5) ) {
		extract($row5);
	
		// roster display
		$players = explode(",",$record_roster);
		for( $counter=0; $counter <= strlen($players); $counter++ ) {
			if ( $players[$counter] == $roster_alias )
				$matches .= "<option value='".$record_id."'>".$record_awayteam."</a> on ".$record_map."</option>";
		}		
	}
	$matches .= "	</select><div style='padding: 3;'></div><input class='SubmitButton' type='submit' value='View'></form>";
	
	$gotfrag2 = explode("user/",$roster_gotfrag);
	$gotfrag3 = explode("/",$gotfrag2[1]);
	$gotfrag = $gotfrag3[0];
	
	$sogamed2 = explode("id=",$roster_sogamed);
	$sogamed = $sogamed2[1];	
	
	switch ($roster_rank)
	{
		case 1:	$roster_rank = "Leader"; break;
		case 2: $roster_rank = "Co-Leader"; break;
		case 3: $roster_rank = "Member"; break;
		case 4: $roster_rank = "Recruit"; break;
		case 5: $roster_rank = "Scheduler"; break;
		case 6: $roster_rank = "Manager"; break;
	}
	
	$roster_bio = nl2br($roster_bio);
	$roster_prevclans = nl2br($roster_prevclans);
	$roster_lanexp = nl2br($roster_lanexp);
		
	$template = eregi_replace("<% alias %>", "$roster_alias", $template);
	$template = eregi_replace("<% name %>", "$roster_name", $template);	
	$template = eregi_replace("<% rank %>", "$roster_rank", $template);	
	$template = eregi_replace("<% status %>", "$roster_status", $template);	
	$template = eregi_replace("<% age %>", "$roster_age", $template);	
	$template = eregi_replace("<% gender %>", "$roster_gender", $template);	
	$template = eregi_replace("<% location %>", "$roster_location", $template);	
	$template = eregi_replace("<% email %>", "<a href='index.php?page=email&id=$roster_id'>email me</a>", $template);	
	$template = eregi_replace("<% bio %>", "$roster_bio", $template);
	$template = eregi_replace("<% quote %>", "$roster_quote", $template);	
	$template = eregi_replace("<% wonid %>", "$roster_wonid", $template);	
	$template = eregi_replace("<% gotfrag %>", "<a href='$roster_gotfrag' target=_new>$gotfrag</a>", $template);	
	$template = eregi_replace("<% sogamed %>", "<a href='$roster_sogamed' target=_new>$sogamed</a>", $template);	$template = eregi_replace("<% brand %>", "$computer_brand", $template);
	$template = eregi_replace("<% mobo %>", "$computer_mobo", $template);
	$template = eregi_replace("<% cpu %>", "$computer_cpu", $template);
	$template = eregi_replace("<% ram %>", "$computer_ram", $template);
	$template = eregi_replace("<% video %>", "$computer_video", $template);
	$template = eregi_replace("<% sound %>", "$computer_sound", $template);
	$template = eregi_replace("<% monitor %>", "$computer_monitor", $template);
	$template = eregi_replace("<% resolution %>", "$computer_resolution", $template);
	$template = eregi_replace("<% headphones %>", "$computer_headphones", $template);
	$template = eregi_replace("<% keyboard %>", "$computer_keyboard", $template);
	$template = eregi_replace("<% mouse %>", "$computer_mouse", $template);
	$template = eregi_replace("<% sens %>", "$computer_sens", $template);
	$template = eregi_replace("<% pad %>", "$computer_pad", $template);
	$template = eregi_replace("<% accessories %>", "$computer_accessories", $template);
	$template = eregi_replace("<% photo %>", "$picture", $template);
	$template = eregi_replace("<% config %>", "$conf", $template);

	// new as of ver 3.0
	$template = eregi_replace("<% job %>", "$roster_job", $template);
	$template = eregi_replace("<% refreshrate %>", "$computer_refresh", $template);
	$template = eregi_replace("<% vsync %>", "$computer_vsync", $template);
	$template = eregi_replace("<% hdrive %>", "$computer_drive", $template);
	$template = eregi_replace("<% msn %>", "$roster_msn", $template);
	$template = eregi_replace("<% yahoo %>", "$roster_yahoo", $template);
	$template = eregi_replace("<% aim %>", "$roster_aim", $template);
	$template = eregi_replace("<% favfood %>", "$roster_favfood", $template);
	$template = eregi_replace("<% favmap %>", "$roster_favmap", $template);
	$template = eregi_replace("<% favweapon %>", "$roster_favweapon", $template);
	$template = eregi_replace("<% favplayer %>", "$roster_favplayer", $template);
	$template = eregi_replace("<% favmovie %>", "$roster_favmovie", $template);
	$template = eregi_replace("<% favmusic %>", "$roster_favmusic", $template);
	$template = eregi_replace("<% homepage %>", "$roster_homepage", $template);
	$template = eregi_replace("<% lanexp %>", "$roster_lanexp", $template);
	$template = eregi_replace("<% prevclans %>", "$roster_prevclans", $template);
	$template = eregi_replace("<% matches %>", "$matches", $template);
	
		echo $template;  // display roster list
}

//**************************************************************************//

function DisplayUpcomingMatches($Num)
{
	
	$recresult = connection("SELECT * FROM records WHERE record_ctl='0' AND record_ctw='0' ORDER BY record_date ASC LIMIT $Num");
		 
	while( $row = mysql_fetch_array($recresult) )  {
		
		extract($row);
		
		$result2 = connection("SELECT records_upcoming FROM templates");  // get records template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $records_upcoming;	
	
		$record_date = ChangeDate($record_date);
		
		$template = eregi_replace("<% opponents %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awayteam</a>", $template);	
		$template = eregi_replace("<% tag %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awaytag</a>", $template);	
		$template = eregi_replace("<% date %>", "$record_date", $template);	
		$template = eregi_replace("<% roster %>", "$record_roster", $template);	
		$template = eregi_replace("<% map %>", "$record_map", $template);	
		$template = eregi_replace("<% league %>", "$record_league", $template);	
		$template = eregi_replace("<% mvp %>", "$record_mvp", $template);	
		$template = eregi_replace("<% hltv %>", "$record_hltv", $template);	
		$template = eregi_replace("<% scorebot %>", "$record_scorebot", $template);	
		$template = eregi_replace("<% type %>", "$record_type", $template);	
		$template = eregi_replace("<% comment %>", "$record_comments", $template);	
		$template = eregi_replace("<% event %>", "$record_event", $template);	
		$template = eregi_replace("<% time %>", "$record_time", $template);
		$template = eregi_replace("<% details %>", "<a href=index.php?page=records&ChooseRecord=$record_id>details</a>", $template);
		
			echo $template;  // increment to next recent match
	}	
}

//**************************************************************************//

function DisplayRecentMatches($Num)
{
	
	$recresult = connection("SELECT * FROM records WHERE record_ctl>'0' OR record_ctw>'0' ORDER BY record_date DESC LIMIT $Num");
	
	while( $row = mysql_fetch_array($recresult) )  {
		
		extract($row);
		
		$result2 = connection("SELECT records_recent FROM templates");  // get records template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $records_recent;	
	
		$homescore = $record_ctw + $record_tw + $record_otw;  // total home score
		$awayscore = $record_ctl + $record_tl + $record_otl;  // total away score
		
		if ( $homescore > $awayscore)	$result = "W";
			else if ( $homescore == $awayscore ) $result = "T";
			else $result = "L";
			
		if ( $record_screen1 ) $screen1 = "<a href='$cm_dir/files/matches/$record_screen1'><img src='$cm_dir/files/matches/thumb-$record_screen1' border=0 width=100></a>";
			else $screen1 = "";
		if ( $record_screen2 ) $screen2 = "<a href='$cm_dir/files/matches/$record_screen2'><img src='$cm_dir/files/matches/thumb-$record_screen2' border=0 width=100></a>";
			else $screen2 = "";
		if ( $record_screen3 ) $screen3 = "<a href='$cm_dir/files/matches/$record_screen3'><img src='$cm_dir/files/matches/thumb-$record_screen3' border=0 width=100></a>";
			else $screen3 = "";
		if ( $record_screen4 ) $screen4 = "<a href='$cm_dir/files/matches/$record_screen4'><img src='$cm_dir/files/matches/thumb-$record_screen4' border=0 width=100></a>";
			else $screen4 = "";
			
		$record_date = ChangeDate($record_date);
		
		$template = eregi_replace("<% opponents %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awayteam</a>", $template);	
		$template = eregi_replace("<% tag %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awaytag</a>", $template);	
		$template = eregi_replace("<% date %>", "$record_date", $template);	
		$template = eregi_replace("<% roster %>", "$record_roster", $template);	
		$template = eregi_replace("<% map %>", "$record_map", $template);	
		$template = eregi_replace("<% league %>", "$record_league", $template);	
		$template = eregi_replace("<% mvp %>", "$record_mvp", $template);	
		$template = eregi_replace("<% type %>", "$record_type", $template);	
		$template = eregi_replace("<% comment %>", "$record_comments", $template);	
		$template = eregi_replace("<% event %>", "$record_event", $template);	
		$template = eregi_replace("<% time %>", "$record_time", $template);
		$template = eregi_replace("<% ctw %>", "$record_ctw", $template);	
		$template = eregi_replace("<% ctl %>", "$record_ctl", $template);	
		$template = eregi_replace("<% tl %>", "$record_tl", $template);	
		$template = eregi_replace("<% tw %>", "$record_tw", $template);	
		$template = eregi_replace("<% otw %>", "$record_otw", $template);	
		$template = eregi_replace("<% otl %>", "$record_otl", $template);	
		$template = eregi_replace("<% homescore %>", "$homescore", $template);
		$template = eregi_replace("<% awayscore %>", "$awayscore", $template);
		$template = eregi_replace("<% result %>", "$result", $template);
		$template = eregi_replace("<% screen1 %>", "$screen1", $template);
		$template = eregi_replace("<% screen2 %>", "$screen2", $template);
		$template = eregi_replace("<% screen3 %>", "$screen3", $template);
		$template = eregi_replace("<% screen4 %>", "$screen4", $template);
		$template = eregi_replace("<% details %>", "<a href=index.php?page=records&ChooseRecord=$record_id>details</a>", $template);
		
			echo $template;  // increment to next recent match
	}	
}

//**************************************************************************//

function DisplayRecordsList($sort,$scend)
{

	if ( $sort == null )
		$resultrec2 = connection("SELECT * FROM records WHERE record_ctl>'0' OR record_ctw>'0' ORDER BY record_date DESC");
	else {
		$order = "record_".$sort;
		$resultrec2 = connection("SELECT * FROM records WHERE record_ctl>'0' OR record_ctw>'0' ORDER BY $order $scend");
	} 
	
	$rowmult = 1;
	
	while( $row = mysql_fetch_array($resultrec2) ) {
		extract($row);
		
		if ( $rowmult % 2 == 0 )
			$rowClass = "AlternateRow1";
		else
			$rowClass = "AlternateRow2";

		$result2 = connection("SELECT records_list FROM templates");
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $records_list;
		
		$homescore = $record_ctw + $record_tw + $record_otw;  // total home score
		$awayscore = $record_ctl + $record_tl + $record_otl;  // total away score
		
		if ( $homescore > $awayscore)	$result = "W";
			else if ( $homescore == $awayscore ) $result = "T";
			else $result = "L";
			
		if ( $record_screen1 ) $screen1 = "<a href='$cm_dir/files/matches/$record_screen1'><img src='$cm_dir/files/matches/thumb-$record_screen1' border=0 width=100></a>";
			else $screen1 = "";
		if ( $record_screen2 ) $screen2 = "<a href='$cm_dir/files/matches/$record_screen2'><img src='$cm_dir/files/matches/thumb-$record_screen2' border=0 width=100></a>";
			else $screen2 = "";
		if ( $record_screen3 ) $screen3 = "<a href='$cm_dir/files/matches/$record_screen3'><img src='$cm_dir/files/matches/thumb-$record_screen3' border=0 width=100></a>";
			else $screen3 = "";
		if ( $record_screen4 ) $screen4 = "<a href='$cm_dir/files/matches/$record_screen4'><img src='$cm_dir/files/matches/thumb-$record_screen4' border=0 width=100></a>";
			else $screen4 = "";
			
		$record_date = ChangeDate($record_date);
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);	
		$template = eregi_replace("<% opponents %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awayteam</a>", $template);	
		$template = eregi_replace("<% tag %>", "<a href=index.php?page=records&ChooseRecord=$record_id>$record_awaytag</a>", $template);	
		$template = eregi_replace("<% date %>", "$record_date", $template);	
		$template = eregi_replace("<% roster %>", "$record_roster", $template);	
		$template = eregi_replace("<% map %>", "$record_map", $template);	
		$template = eregi_replace("<% league %>", "$record_league", $template);	
		$template = eregi_replace("<% mvp %>", "$record_mvp", $template);	
		$template = eregi_replace("<% type %>", "$record_type", $template);	
		$template = eregi_replace("<% comment %>", "$record_comments", $template);	
		$template = eregi_replace("<% event %>", "$record_event", $template);	
		$template = eregi_replace("<% time %>", "$record_time", $template);
		$template = eregi_replace("<% hltv %>", "$record_hltv", $template);
		$template = eregi_replace("<% scorebot %>", "$record_scorebot", $template);
		$template = eregi_replace("<% ctw %>", "$record_ctw", $template);	
		$template = eregi_replace("<% ctl %>", "$record_ctl", $template);	
		$template = eregi_replace("<% tl %>", "$record_tl", $template);	
		$template = eregi_replace("<% tw %>", "$record_tw", $template);	
		$template = eregi_replace("<% otw %>", "$record_otw", $template);	
		$template = eregi_replace("<% otl %>", "$record_otl", $template);	
		$template = eregi_replace("<% homescore %>", "$homescore", $template);
		$template = eregi_replace("<% awayscore %>", "$awayscore", $template);
		$template = eregi_replace("<% result %>", "$result", $template);
		$template = eregi_replace("<% screen1 %>", "$screen1", $template);
		$template = eregi_replace("<% screen2 %>", "$screen2", $template);
		$template = eregi_replace("<% screen3 %>", "$screen3", $template);
		$template = eregi_replace("<% screen4 %>", "$screen4", $template);
		$template = eregi_replace("<% details %>", "<a href=index.php?page=records&ChooseRecord=$record_id>details</a>", $template);
		
		// new for 2.1
		
			echo $template;  // increment to next recent match
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayRecordsDetails($ChooseRecord)
{
	$result0 = connection("SELECT * FROM records WHERE record_id='$ChooseRecord'");
	$row0 = mysql_fetch_array($result0); extract($row0);
	
	$result1 = connection("SELECT force_register,cm_dir FROM settings");
	$row1 = mysql_fetch_array($result1); extract($row1);
	
	$result2 = connection("SELECT records_detail FROM templates");
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $records_detail;
	
	$homescore = $record_ctw + $record_tw + $record_otw;  // total home score
	$awayscore = $record_ctl + $record_tl + $record_otl;  // total away score
	
	if ( $homescore > $awayscore)	$result = "W";
		else if ( $homescore == $awayscore ) $result = "T";
		else $result = "L";
			
	if ( $record_screen1 ) $screen1 = "<a href='$cm_dir/files/matches/$record_screen1'><img src='$cm_dir/files/matches/thumb-$record_screen1' border=0 width=100></a>";
		else $screen1 = "";
	if ( $record_screen2 ) $screen2 = "<a href='$cm_dir/files/matches/$record_screen2'><img src='$cm_dir/files/matches/thumb-$record_screen2' border=0 width=100></a>";
		else $screen2 = "";
	if ( $record_screen3 ) $screen3 = "<a href='$cm_dir/files/matches/$record_screen3'><img src='$cm_dir/files/matches/thumb-$record_screen3' border=0 width=100></a>";
		else $screen3 = "";
	if ( $record_screen4 ) $screen4 = "<a href='$cm_dir/files/matches/$record_screen4'><img src='$cm_dir/files/matches/thumb-$record_screen4' border=0 width=100></a>";
		else $screen4 = "";
	
	// roster display
	$players = explode(",",$record_roster);

	for( $counter=0; $counter < sizeof($players); $counter++ ) {
		
		$resultx = connection("SELECT roster_id FROM roster WHERE roster_alias='$players[$counter]'");
			
		if ( $rowx = mysql_fetch_array($resultx) ) {
			$roster_id = $rowx['roster_id'];
			$listplayers .= "<a href='index.php?page=roster&ChooseRoster=$roster_id'>$players[$counter]</a>";
		}
		else {
			$listplayers .= "$players[$counter]";
		}
		if ( $counter != sizeof($players)-1 ) $listplayers .= ", ";
	}
	
	// setup comments
	$sql = connection("SELECT * FROM comments WHERE news_id='$record_id' ORDER BY counter ASC");

	// goes through all comments and displays them
	while( $rowc = mysql_fetch_array($sql) )  {
		extract($rowc);
		
		$user_name = UserName($userID);
		if ( $user_name == null )
		  $user_name = $userID;
		  
		$showcomments .= "<div style='CommentName'>$user_name</div>
											<div style='CommentPost'>$comment</div><br>";
	}
	
	if ( $force_register == "Y" ) 
	{
		if ( logintest($cm[0]) == TRUE ) {
		
			$showcomments .= "<form action='$cm_dir/process.php' method='post'>
				<font size=1><b>Comment:</b></font><br>
				<input type=hidden name='perform' value='AddComment'>
				<input type=hidden name='register' value='YES'>
				<input type=hidden name='ID' value='$record_id'>
				<textarea rows='4' cols='30' name='Comment'></textarea>
				<br>
				<input type='submit' value='Submit'>
				</form>";
		}
		else
			$showcomments .= "<font size=1>please login to post comments</font>";
	}

	else if ( $force_register == "N" ) {

		$showcomments .= "<form action='$cm_dir/process.php' method='post'>
			<input type=hidden name='perform' value='AddComment'>
			<input type=hidden name='register' value='NO'>
			<input type=hidden name='ID' value='$record_id'>";

		if ( logintest($cm[0]) == FALSE )
			$showcomments .= "Name:<br><input type='TEXT' name='comment_name' size='10' maxlength='255' value=''><br>";
			
		$showcomments .= "Comment:<br><textarea rows='4' cols='30' name='Comment' class='CommentTextarea'></textarea>
											<br><input type='submit' class='SubmitButton' value='Submit'></form>";
	}
	
	// process demos accordingly
	$demodisplay .= "<table cellspacing=0 cellpadding=4><tr>
						<td class='RecordDemosHead'>Opponents</td>
						<td class='RecordDemosHead'>Map</td>
						<td class='RecordDemosHead'>POV</td>
						<td class='RecordDemosHead'>Details</td></tr>";

	$resultg = connection("SELECT * FROM demos WHERE demo_match='$record_id' ORDER BY demo_pov ASC");
	while( $rowg = mysql_fetch_array($resultg) )
	{
		extract($rowg);
		$demodisplay .= "<tr><td class='RecordDemosCell'>".$demo_awayteam."</td>
									 <td class='RecordDemosCell'>".$demo_map."</td>
									 <td class='RecordDemosCell'>".$demo_pov."</td>
									 <td class='RecordDemosCell'><a href='index.php?page=demos&ChooseDemo=".$demo_id."'>view</a></td></tr>";
	}
	$demodisplay .= "</table>";
	
	
	$record_date = ChangeDate($record_date);
			
	
	$template = eregi_replace("<% opponents %>", "$record_awayteam", $template);	
	$template = eregi_replace("<% tag %>", "$record_awaytag", $template);	
	$template = eregi_replace("<% date %>", "$record_date", $template);	
	$template = eregi_replace("<% roster %>", "$listplayers", $template);	
	$template = eregi_replace("<% map %>", "$record_map", $template);	
	$template = eregi_replace("<% league %>", "$record_league", $template);	
	$template = eregi_replace("<% mvp %>", "$record_mvp", $template);	
	$template = eregi_replace("<% type %>", "$record_type", $template);	
	$template = eregi_replace("<% comment %>", "$record_comments", $template);	
	$template = eregi_replace("<% event %>", "$record_event", $template);	
	$template = eregi_replace("<% time %>", "$record_time", $template);
	$template = eregi_replace("<% demos %>", "$demodisplay", $template);	
	$template = eregi_replace("<% ctw %>", "$record_ctw", $template);	
	$template = eregi_replace("<% ctl %>", "$record_ctl", $template);	
	$template = eregi_replace("<% tl %>", "$record_tl", $template);	
	$template = eregi_replace("<% tw %>", "$record_tw", $template);	
	$template = eregi_replace("<% otw %>", "$record_otw", $template);	
	$template = eregi_replace("<% otl %>", "$record_otl", $template);	
	$template = eregi_replace("<% homescore %>", "$homescore", $template);
	$template = eregi_replace("<% awayscore %>", "$awayscore", $template);
	$template = eregi_replace("<% result %>", "$result", $template);
	$template = eregi_replace("<% screen1 %>", "$screen1", $template);
	$template = eregi_replace("<% screen2 %>", "$screen2", $template);
	$template = eregi_replace("<% screen3 %>", "$screen3", $template);
	$template = eregi_replace("<% screen4 %>", "$screen4", $template);
	
	// new as of ver 3.0
	$template = eregi_replace("<% showcomments %>", "$showcomments", $template);
	
		echo $template;  // increment to next recent match
}

//**************************************************************************//

function DisplayFileList($sort,$scend)
{
	if ( $sort == null )
		$result = connection("SELECT * FROM files ORDER BY file_name ASC");
	else {
		$order = "file_".$sort;
		$result = connection("SELECT * FROM files ORDER BY $order $scend");
	} 
	
	$rowmult = 1;

	while( $row = mysql_fetch_array($result)) {
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$result2 = connection("SELECT file_list FROM templates");  // get files template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $file_list;
			
		$file_size = (int) ($file_size/1024)." KB";
		if ( $file_size > 1024 )
			$file_size = round($file_size/1024,2)." MB";	
		
		if ( $file_external ) {
			$external_name = explode("/",$file_external);
			$size = sizeof($external_name); $size-=1;			
			$template = eregi_replace("<% filename %>", "<a href='index.php?page=files&ChooseFile=$file_id'>$external_name[$size]</a>", $template);
			$template = eregi_replace("<% filesize %>", "n/a", $template);	
		}
		else {
			$template = eregi_replace("<% filename %>", "<a href='index.php?page=files&ChooseFile=$file_id'>$file_name</a>", $template);
			$template = eregi_replace("<% filesize %>", "$file_size", $template);
		}			
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% filedesc %>", "$file_description", $template);
		$template = eregi_replace("<% downloads %>", "$file_downloads", $template);
		$template = eregi_replace("<% details %>", "<a href=index.php?page=files&ChooseFile=$file_id>download</a>", $template);
		
			echo $template;  // display file
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayFileDetails($ChooseFile)
{
	global $cm_dir;

	$result = connection("SELECT * FROM files WHERE file_id='$ChooseFile'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT file_detail FROM templates");  // get files template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $file_detail;
	
	$file_size = (int) ($file_size/1024)." KB";
	if ( $file_size > 1024 )
		$file_size = round($file_size/1024,2)." MB";	
	
	if ( $file_external ) {
		$external_name = explode("/",$file_external);
		$size = sizeof($external_name); $size-=1;			
		$template = eregi_replace("<% filename %>", "<a href='$file_external'>$external_name[$size]</a>", $template);
		$template = eregi_replace("<% filesize %>", "n/a", $template);	
	}
	else {
		$template = eregi_replace("<% filename %>", "<a href='$cm_dir/download.php?fileid=$file_id'>$file_name</a>", $template);
		$template = eregi_replace("<% filesize %>", "$file_size", $template);
	}			

	$template = eregi_replace("<% filedesc %>", "$file_description", $template);
	$template = eregi_replace("<% numofdls %>", "$file_downloads", $template);
	$template = eregi_replace("<% download %>", "<a href=javascript:popUp('$cm_dir/download.php?fileid=$file_id',100,400);>download</a>", $template);	
		
		echo $template;	
}

//**************************************************************************//

function DisplayLinksList($sort,$scend)
{
	if ( $sort == null )
		$result = connection("SELECT * FROM links");
	else {
		$order = "link_".$sort;
		$result = connection("SELECT * FROM links ORDER BY $order $scend");
	} 
	
	$rowmult = 1;

	while( $row = mysql_fetch_array($result)) {
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";

		$result2 = connection("SELECT links_list FROM templates");  // get links template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $links_list;
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% linkname %>", "<a href='index.php?page=links&ChooseLink=$link_id'>$link_name</a>", $template);
		$template = eregi_replace("<% linkurl %>", "$link_url", $template);
		$template = eregi_replace("<% linktype %>", "$link_type", $template);
		$template = eregi_replace("<% linkdesc %>", "$link_description", $template);
		$template = eregi_replace("<% details %>", "<a href=index.php?page=links&ChooseLink=$link_id>view</a>", $template);
		
			echo $template;  // display files
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayLinksDetails($ChooseLink)
{
	$result = connection("SELECT * FROM links WHERE link_id='$ChooseLink'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT links_detail FROM templates");
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $links_detail;
	
	$template = eregi_replace("<% linkname %>", "$link_name", $template);
	$template = eregi_replace("<% linkurl %>", "<a href='$link_url' target=_new>$link_url</a>", $template);
	$template = eregi_replace("<% linktype %>", "$link_type", $template);
	$template = eregi_replace("<% linkdesc %>", "$link_description", $template);

	echo $template;	

}

//**************************************************************************//

function DisplaySponsorsList($sort,$scend)
{	
	global $cm_dir;
	
	if ( $sort == null )
		$result = connection("SELECT * FROM sponsors ORDER BY sponsor_name ASC");
	else {
		$order = "sponsor_".$sort;
		$result = connection("SELECT * FROM sponsors ORDER BY $order $scend");
	} 
	
	$rowmult = 1;

	while( $row = mysql_fetch_array($result)) {
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
	
		$result2 = connection("SELECT sponsor_list FROM templates");  // get sponsors template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $sponsor_list;
			
		if ( $sponsor_image )
			$image = "<img src='$cm_dir/files/sponsors/$sponsor_image' border=0>";
		else
			$image = "";
			
		$sponsor_description = nl2br($sponsor_description);
	
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% sponsorname %>", "<a href='index.php?page=sponsors&ChooseSponsor=$sponsor_id'>$sponsor_name</a>", $template);
		$template = eregi_replace("<% sponsorurl %>", "<a href='$sponsor_url' target=_new>$sponsor_url</a>", $template);	
		$template = eregi_replace("<% sponsordesc %>", "$sponsor_description", $template);	
		$template = eregi_replace("<% sponsorimage %>", "<a href='index.php?page=sponsors&ChooseSponsor=$sponsor_id'>$image</a>", $template);		
		$template = eregi_replace("<% details %>", "<a href='index.php?page=sponsors&ChooseSponsor=$sponsor_id'>view</a>", $template);
		
			echo $template;  // display sponsors
		$rowmult++;
	}
	
}

//**************************************************************************//

function DisplaySponsorsDetails($ChooseSponsor)
{
	global $cm_dir;
	
	$result = connection("SELECT * FROM sponsors WHERE sponsor_id='$ChooseSponsor'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT sponsor_detail FROM templates");  // get sponsors template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $sponsor_detail;
	
	if ( $sponsor_image )
		$image = "<img src='$cm_dir/files/sponsors/$sponsor_image' border=0>";
	else
		$image = "";
	
	$sponsor_description = nl2br($sponsor_description);			
	
	$template = eregi_replace("<% sponsorname %>", "<a href='$sponsor_url' target=_new>$sponsor_name</a>", $template);
	$template = eregi_replace("<% sponsorurl %>", "$sponsor_url", $template);	
	$template = eregi_replace("<% sponsordesc %>", "$sponsor_description", $template);	
	$template = eregi_replace("<% sponsorimage %>", "<a href='$sponsor_url' target=_new>$image</a>", $template);		

		echo $template;	

}

//**************************************************************************//

function DisplayRecentEvents($Num)
{

	$rowmult = 1;
	$everesult = connection("SELECT * FROM events ORDER BY event_start DESC LIMIT $Num");
	
	while( $row = mysql_fetch_array($everesult) )  {
		
		extract($row);
				
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$resultu = connection("SELECT event_recent FROM templates");  // get events template
		$rowu = mysql_fetch_array($resultu); extract($rowu);
		$template = $event_recent;	
		
		$event_start = ChangeDate($event_start);
		$event_end = ChangeDate($event_end);

		if ( $event_image )
			$image = "<img src='$cm_dir/files/events/$event_image' border=0>";
		else
			$image = "";
		
		$event_description = nl2br($event_description);		
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% eventname %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>$event_name</a>", $template);
		$template = eregi_replace("<% eventstart %>", "$event_start", $template);
		$template = eregi_replace("<% eventend %>", "$event_end", $template);
		$template = eregi_replace("<% eventtime %>", "$event_time", $template);
		$template = eregi_replace("<% eventprice %>", "$event_price", $template);
		$template = eregi_replace("<% eventlocation %>", "$event_location", $template);
		$template = eregi_replace("<% eventcontact %>", "$event_contact", $template);
		$template = eregi_replace("<% eventtype %>", "$event_type", $template);
		$template = eregi_replace("<% eventdesc %>", "$event_description", $template);
		$template = eregi_replace("<% eventimage %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>$image</a>", $template);		
		$template = eregi_replace("<% details %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>details</a>", $template);
		
			echo $template;  // display events
			$rowmult++;
	}	
}

//**************************************************************************//

function DisplayEventsList($sort,$scend)
{	
	global $cm_dir;
	
	if ( $sort == null )
		$result = connection("SELECT * FROM events");
	else {
		$order = "event_".$sort;
		$result = connection("SELECT * FROM events ORDER BY $order $scend");
	} 
	
	$rowmult = 1;
	
	while( $row = mysql_fetch_array($result) ) {
		
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$result2 = connection("SELECT event_list FROM templates");  // get events template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $event_list;
		
		$event_start = ChangeDate($event_start);
		$event_end = ChangeDate($event_end);
		
		if ( $event_image )
			$image = "<img src='$cm_dir/files/events/$event_image' border=0>";
		else
			$image = "";
		
		$event_description = nl2br($event_description);		
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% eventname %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>$event_name</a>", $template);
		$template = eregi_replace("<% eventstart %>", "$event_start", $template);
		$template = eregi_replace("<% eventend %>", "$event_end", $template);
		$template = eregi_replace("<% eventtime %>", "$event_time", $template);
		$template = eregi_replace("<% eventprice %>", "$event_price", $template);
		$template = eregi_replace("<% eventlocation %>", "$event_location", $template);
		$template = eregi_replace("<% eventcontact %>", "$event_contact", $template);
		$template = eregi_replace("<% eventtype %>", "$event_type", $template);
		$template = eregi_replace("<% eventdesc %>", "$event_description", $template);
		$template = eregi_replace("<% eventimage %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>$image</a>", $template);		
		$template = eregi_replace("<% details %>", "<a href='index.php?page=events&ChooseEvent=$event_id'>details</a>", $template);
		
			echo $template;  // display events
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayEventsDetails($ChooseEvent)
{
	global $cm_dir;
	
	$result = connection("SELECT * FROM events WHERE event_id='$ChooseEvent'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT event_detail FROM templates");  // get events template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $event_detail;

	$event_start = ChangeDate($event_start);
	$event_end = ChangeDate($event_end);
		
	if ( $event_image )
		$image = "<img src='$cm_dir/files/events/$event_image' border=0>";
	else
		$image = "";

	$event_description = nl2br($event_description);		
	
	$template = eregi_replace("<% eventname %>", "$event_name", $template);
	$template = eregi_replace("<% eventstart %>", "$event_start", $template);
	$template = eregi_replace("<% eventend %>", "$event_end", $template);
	$template = eregi_replace("<% eventtime %>", "$event_time", $template);
	$template = eregi_replace("<% eventprice %>", "$event_price", $template);
	$template = eregi_replace("<% eventlocation %>", "$event_location", $template);
	$template = eregi_replace("<% eventcontact %>", "$event_contact", $template);
	$template = eregi_replace("<% eventtype %>", "$event_type", $template);
	$template = eregi_replace("<% eventdesc %>", "$event_description", $template);
	$template = eregi_replace("<% eventimage %>", "$image", $template);		
	
		echo $template;  // display events
}

//**************************************************************************//

function DisplayServersList($sort,$scend)
{	
	global $cm_dir;
	
	if ( $sort == null )
		$result = connection("SELECT * FROM servers");
	else {
		$order = "event_".$sort;
		$result = connection("SELECT * FROM servers ORDER BY $order $scend");
	} 	
	
	$rowmult = 1;
	
	while( $row = mysql_fetch_array($result) ) {
		extract($row);

		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$result2 = connection("SELECT server_list FROM templates");  // get server template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $server_list;
	
		$filename = "$cm_dir/files/servers/$server_maplist";
		$fp = fopen($filename, "r");
		$server_maplist = fread($fp, filesize($filename));
		fclose($fp);
						
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% servername %>", "<a href='index.php?page=servers&ChooseServer=$server_ip'>$server_name</a>", $template);
		$template = eregi_replace("<% serverip %>", "$server_ip", $template);	
		$template = eregi_replace("<% servertype %>", "$server_type", $template);			
		$template = eregi_replace("<% servermaplist %>", "$server_maplist", $template);			
		$template = eregi_replace("<% details %>", "<a href='index.php?page=servers&ChooseServer=$server_ip'>details</a>", $template);
		
			echo $template;
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayServersDetails($ChooseServer)
{
	global $cm_dir;
		
	$resulty = connection("SELECT * FROM servers WHERE server_ip='$ChooseServer'");
	$rowy = mysql_fetch_array($resulty); extract($rowy);
	
	$result2 = connection("SELECT server_detail FROM templates");  // get server template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $server_detail;
	
	if ( $server_maplist ) {
		$filename = $cm_dir."/files/servers/".$server_maplist;
		$fp = @fopen($filename, "rb") or die("Couldn't open file"); 
		$data = fread($fp, filesize($fp)); 
	
		while(!feof($fp)) { 
		$data .= fgets($fp, 1024); 
		$data .= "<br>"; } 
		
		fclose($fp); 
		$values = explode("\r\n", $data); 
	}
		
	$template = eregi_replace("<% servername %>", "$server_name", $template);
	$template = eregi_replace("<% serverip %>", "$server_ip", $template);	
	$template = eregi_replace("<% servertype %>", "$server_type", $template);			
	$template = eregi_replace("<% servermaplist %>", "$data", $template);			

		echo $template;	 // display server info
}

//**************************************************************************//

function DisplayRecentDemos($Num)
{	
	$demresult = connection("SELECT * FROM demos ORDER BY count DESC LIMIT $Num");
	$rowmult = 1;
	
	while( $row = mysql_fetch_array($demresult) )  {
		
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$result2 = connection("SELECT demos_recent FROM templates");  // get records template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $demos_recent;	
		
		$demo_poster = UserName($demo_poster);
		$demo_size = (int) ($demo_size/1024)." KB";
		if ( $demo_size > 1024 )
			$demo_size = round($demo_size/1024,2)." MB";	
		
		if ( $demo_match != null )
		{
			$resul2 = connection("SELECT record_awayteam,record_awaytag,record_map FROM records WHERE record_id='$demo_match'");
			$ro2 = mysql_fetch_array($resul2); extract($ro2);
			
			$template = eregi_replace("<% demoteam %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awayteam</a>", $template);
			$template = eregi_replace("<% demotag %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awaytag</a>", $template);
			$template = eregi_replace("<% demomap %>", "$record_map", $template);
		}
		else 
		{
			$template = eregi_replace("<% demoteam %>", "$demo_awayteam", $template);
			$template = eregi_replace("<% demomap %>", "$demo_map", $template);	
		}
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% demopov %>", "$demo_pov", $template);			
		$template = eregi_replace("<% demomatch %>", "<a href='index.php?page=records&ChooseRecord=$demo_id''>$demo_match</a>", $template);
		$template = eregi_replace("<% demoevent %>", "$demo_event", $template);
		$template = eregi_replace("<% demosize %>", "$demo_size", $template);
		$template = eregi_replace("<% democomment %>", "$demo_comment", $template);
		$template = eregi_replace("<% demoposter %>", "$demo_poster", $template);
		$template = eregi_replace("<% numofdls %>", "$demo_downloads", $template);
		$template = eregi_replace("<% details %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>view</a>", $template);
		
			echo $template;  // display demos
			$rowmult++;
		}	
}

//**************************************************************************//

function DisplayDemosList($sort,$scend)
{	
	$rowmult = 1;
	
	if ( $sort == null )
		$result = connection("SELECT * FROM demos ORDER BY count DESC");
	else {
		$order = "demo_".$sort;
		$result = connection("SELECT * FROM demos ORDER BY $order $scend");
	} 	
	
	while( $row = mysql_fetch_array($result)) {
		extract($row);	
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
		
		$result2 = connection("SELECT demos_list FROM templates");
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $demos_list;
		
		$demo_poster = UserName($demo_poster);
		$demo_size = (int) ($demo_size/1024)." KB";
		if ( $demo_size > 1024 )
			$demo_size = round($demo_size/1024,2)." MB";	
		
		if ( $demo_match != null )
		{
			$resul2 = connection("SELECT record_awayteam,record_awaytag,record_map FROM records WHERE record_id='$demo_match'");
			$ro2 = mysql_fetch_array($resul2); extract($ro2);
			
			$template = eregi_replace("<% demoteam %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awayteam</a>", $template);
			$template = eregi_replace("<% demotag %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awaytag</a>", $template);
			$template = eregi_replace("<% demomap %>", "$record_map", $template);
		}
		else 
		{
			$template = eregi_replace("<% demoteam %>", "$demo_awayteam", $template);
			$template = eregi_replace("<% demomap %>", "$demo_map", $template);	
		}
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% demopov %>", "$demo_pov", $template);			
		$template = eregi_replace("<% demomatch %>", "<a href='index.php?page=records&ChooseRecord=$demo_id''>$demo_match</a>", $template);
		$template = eregi_replace("<% demoevent %>", "$demo_event", $template);
		$template = eregi_replace("<% demosize %>", "$demo_size", $template);
		$template = eregi_replace("<% democomment %>", "$demo_comment", $template);
		$template = eregi_replace("<% demoposter %>", "$demo_poster", $template);
		$template = eregi_replace("<% numofdls %>", "$demo_downloads", $template);	
		$template = eregi_replace("<% details %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>view</a>", $template);
		
			echo $template;  // display demos
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayDemosDetails($ChooseDemo)
{
	$result = connection("SELECT force_register,cm_dir FROM settings");
	$row = mysql_fetch_array($result); extract($row);
	
	$result = connection("SELECT * FROM demos WHERE demo_id='$ChooseDemo'");
	$row = mysql_fetch_array($result); extract($row);

	$result2 = connection("SELECT demos_detail FROM templates");  // get demos template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $demos_detail;
	
	// setup comments
	$sql = connection("SELECT * FROM comments WHERE news_id='$demo_id' ORDER BY counter ASC");
			
	// goes through all comments and displays them
	while( $rowc = mysql_fetch_array($sql) )  {
		extract($rowc);
		
		$user_name = UserName($userID);
		if ( $user_name == null )
		  $user_name = $userID;
		  
		$showcomments .= "<div style='CommentName'>$user_name</div>
											<div style='CommentPost'>$comment</div><br>";
	}
	
	if ( $force_register == "Y" ) 
	{
		if ( logintest($cm[0]) == TRUE ) {
		
			$showcomments .= "<form action='$cm_dir/process.php' method='post'>
				<font size=1><b>Comment:</b></font><br>
				<input type=hidden name='perform' value='AddComment'>
				<input type=hidden name='register' value='YES'>
				<input type=hidden name='ID' value='$demo_id'>
				<textarea rows='4' cols='30' name='Comment'></textarea>
				<br>
				<input type='submit' value='Submit'>
				</form>";
		}
		else
			$showcomments .= "<font size=1>please login to post comments</font>";
	}

	else if ( $force_register == "N" ) {

		$showcomments .= "<form action='$cm_dir/process.php' method='post'>
			<input type=hidden name='perform' value='AddComment'>
			<input type=hidden name='register' value='NO'>
			<input type=hidden name='ID' value='$demo_id'>";

		if ( logintest($cm[0]) == FALSE )
			$showcomments .= "Name:<br><input type='TEXT' name='comment_name' size='10' maxlength='255' value=''><br>";
			
		$showcomments .= "Comment:<br><textarea rows='4' cols='30' name='Comment' class='CommentTextarea'></textarea>
											<br><input type='submit' class='SubmitButton' value='Submit'></form>";
	}
	
	$demo_poster = UserName($demo_poster);
	$demo_size = (int) ($demo_size/1024)." KB";
	if ( $demo_size > 1024 )
		$demo_size = round($demo_size/1024,2)." MB";	
	
	if ( $demo_match != null )
	{
		$resul2 = connection("SELECT record_awayteam,record_awaytag,record_map FROM records WHERE record_id='$demo_match'");
		$ro2 = mysql_fetch_array($resul2); extract($ro2);
		
		$template = eregi_replace("<% demoteam %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awayteam</a>", $template);
		$template = eregi_replace("<% demotag %>", "<a href='index.php?page=demos&ChooseDemo=$demo_id'>$record_awaytag</a>", $template);
		$template = eregi_replace("<% demomap %>", "$record_map", $template);
	}
	else 
	{
		$template = eregi_replace("<% demoteam %>", "$demo_awayteam", $template);
		$template = eregi_replace("<% demomap %>", "$demo_map", $template);	
	}
		
	$template = eregi_replace("<% demopov %>", "$demo_pov", $template);			
	$template = eregi_replace("<% demomatch %>", "<a href='index.php?page=records&ChooseRecord=$demo_match''>view match</a>", $template);
	$template = eregi_replace("<% demoevent %>", "$demo_event", $template);
	$template = eregi_replace("<% demosize %>", "$demo_size", $template);
	$template = eregi_replace("<% democomment %>", "$demo_comment", $template);
	$template = eregi_replace("<% demoposter %>", "$demo_poster", $template);
	$template = eregi_replace("<% numofdls %>", "$demo_downloads", $template);	
	$template = eregi_replace("<% download %>", "<a href=javascript:popUp('$cm_dir/download.php?demoid=$demo_id',100,400);>download</a>", $template);	
	
	// new as of ver 3.0
	$template = eregi_replace("<% showcomments %>", "$showcomments", $template);
	
		echo $template;	 // display demos
}

//**************************************************************************//

function DisplayContacts()
{	
	$result = connection("SELECT * FROM contacts");
	
	while( $row = mysql_fetch_array($result)) {
		extract($row);

		$result2 = connection("SELECT contacts_list FROM templates");  // get contacts template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $contacts_list;
		
		$template = eregi_replace("<% webmaster %>", "<a href='index.php?page=email&id=$webmaster'>$webmaster</a>", $template);
		$template = eregi_replace("<% manager %>", "<a href='index.php?page=email&id=$manager'>$manager</a>", $template);
		$template = eregi_replace("<% scheduler %>", "<a href='index.php?page=email&id=$scheduler'>$scheduler</a>", $template);
		$template = eregi_replace("<% recruiting %>", "<a href='index.php?page=email&id=$recruiting'>$recruiting</a>", $template);
		$template = eregi_replace("<% help %>", "<a href='index.php?page=email&id=$help'>$help</a>", $template);
		$template = eregi_replace("<% marketing %>", "<a href='index.php?page=email&id=$marketing'>$marketing</a>", $template);
		
			echo $template;
	}
}

//**************************************************************************//

function DisplayInfo()
{	
	$result = connection("SELECT * FROM information");
	
	while( $row = mysql_fetch_array($result) ) {
		extract($row);

		$result2 = connection("SELECT info_list FROM templates");  // get info template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $info_list;
		
		$template = eregi_replace("<% clanname %>", "$clan_name", $template);
		$template = eregi_replace("<% clantag %>", "$clan_tag", $template);
		$template = eregi_replace("<% ircserver %>", "<a href='irc://$clan_irc_server'>$clan_irc_server</a>", $template);
		$template = eregi_replace("<% ircchannel %>", "<a href='irc://$clan_irc_server/$clan_irc'>$clan_irc</a>", $template);
		$template = eregi_replace("<% background %>", "$clan_background", $template);
			
			echo $template;
	}
}

//**************************************************************************//

function DisplayGalleryList()
{	
	global $cm_dir;
	$rowmult = 1;
	
	$result = connection("SELECT * FROM screenshots GROUP BY screen_gallery");

	while( $row = mysql_fetch_array($result)) {
		extract($row);
		
		if ( $rowmult % 2 == 0 ) $rowClass = "AlternateRow1";
		else $rowClass = "AlternateRow2";
				
		$result2 = connection("SELECT screens_list FROM templates");  // gallery template
		$row2 = mysql_fetch_array($result2); extract($row2);
		$template = $screens_list;
			
		$screen_size = (int) ($screen_size/1024)." KB";
		if ( $screen_size > 1024 )
			$screen_size = round($screen_size/1024,2)." MB";	

		$result3 = connection("SELECT * FROM screenshots WHERE screen_gallery='$screen_gallery'");
		$numofimages = mysql_num_rows($result3);
		
		$result4 = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
		$row4 = mysql_fetch_array($result4);
		extract($row4);
		
		$template = eregi_replace("<% rowClass %>", $rowClass, $template);
		$template = eregi_replace("<% gallery %>", "<a href='index.php?page=screenshots&ChooseGallery=$screen_gallery'>$gallery_name</a>", $template);		
		$template = eregi_replace("<% numofimages %>", "$numofimages", $template);
		$template = eregi_replace("<% desc %>", "$gallery_desc", $template);
		$template = eregi_replace("<% date %>", "$gallery_date", $template);
		$template = eregi_replace("<% location %>", "$gallery_location", $template);
		$template = eregi_replace("<% view %>", "<a href='index.php?page=screenshots&ChooseGallery=$screen_gallery'>view</a>", $template);
		
			echo $template;  // display images
			$rowmult++;
	}
}

//**************************************************************************//

function DisplayGalleryDetails($ChooseGallery, $Num)
{	
	global $cm_dir;
	
	$result2 = connection("SELECT screens_detail FROM templates");  // get gallery template
	$row2 = mysql_fetch_array($result2); extract($row2);
	$template = $screens_detail;
	
	$counter=1;
	$result = connection("SELECT * FROM screenshots WHERE screen_gallery='$ChooseGallery'");
	
	$display .= "<center><table cellspacing=0 cellpadding=5><tr>";
	while ( $row = mysql_fetch_array($result) )
	{
		extract($row);
		
		$screen_size = (int) ($screen_size/1024)." KB";
		if ( $screen_size > 1024 )
			$screen_size = round($screen_size/1024,2)." MB";	

		$result4 = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");
		$row4 = mysql_fetch_array($result4);
		extract($row4);
		
		$size = getimagesize( "$cm_dir/files/screenshots/$gallery_name/$screen_name" );
		
		//height
		if ( $size[1] <= 200 )
		 $size[1] = 200;
		 
		//width
		
		$size[1] += 100;
		
		$display .= "<td align=center><a href=javascript:popUp('ss.php?id=$screen_id',".$size[1].",650);><img src='".$cm_dir."/files/screenshots/".$gallery_name."/thumb-".$screen_name."' border=0 style='padding: 5;' alt='".$screen_caption."'></a><br><font size=1>".$screen_size."</font></td>";
		if ( $counter % $Num == 0 )
			$display .= "</tr><tr>";
			
			$counter++;
	}
	$display .= "</tr></table></center>";
	
	$result3 = connection("SELECT * FROM galleries WHERE gallery_id='$screen_gallery'");  // get gallery template
	$row3 = mysql_fetch_array($result3); extract($row3);
	
	$template = eregi_replace("<% display %>", "$display", $template);
	$template = eregi_replace("<% gallery %>", "$gallery_name", $template);
	$template = eregi_replace("<% desc %>", "$gallery_desc", $template);
	$template = eregi_replace("<% date %>", "$gallery_date", $template);
	$template = eregi_replace("<% location %>", "$gallery_location", $template);

		echo $template;	 // display demos
}

//**************************************************************************//

function SendEmail($id)
{	
	global $cm_dir;
	
	$result3 = connection("SELECT user_email,user_name FROM users WHERE user_id='$id'");  // get gallery template
	
	if ( $row3 = mysql_fetch_array($result3) )	
	{
		extract($row3);
		$recipient = $user_name;
		$email = $user_email;
	}
	else
	{
		$result4 = connection("SELECT roster_email,roster_alias FROM roster WHERE roster_id='$id'");  // get gallery template
		if ( $row4 = mysql_fetch_array($result4) ) 
		{
			extract($row4);
			$recipient = $roster_alias;
			$email = $roster_email;
		}
		else 
		{
			$recipient = $id;
			$email = $id;
		}
	}

	$emaildisplay .= "<form action='$cm_dir/process.php' method='post'>
		<div style='padding-top: 3; padding-bottom: 3;'><b>Recipient:</b><br>".$recipient."</div>
		<br>
		<input type=hidden name='perform' value='SendMail'>
		<input type=hidden name='recipient' value='".$email."'>
		<b>Subject</b><br>
		<input type='TEXT' name='mail_subject' size='50' maxlength='255' class=Inputt><br>
		<b>Your Email Address</b><br>
		<input type='TEXT' name='mail_youradd' size='50' maxlength='255' class=Inputt><br>
		
		<b>Content</b><br>
		<textarea rows='6' cols='50' name='mail_content'></textarea>
		<br>
		<input type='submit' value='Send' class=submitbutton>
		</form>";

	echo $emaildisplay;
}


//**** functions that display record totals  *****//

function TotalWins() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw > record_ctl + record_tl + record_otl");
	$row = mysql_num_rows($result); echo $row; 
}	

function TotalRoundsWon() {
	$result = connection("SELECT SUM(record_ctw) + SUM(record_tw) + SUM(record_otw) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}

function TotalRoundsLost() {
	$result = connection("SELECT SUM(record_ctl) + SUM(record_tl) + SUM(record_otl) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}
   
function TotalCTWins() {
	$result = connection("SELECT SUM(record_ctw) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}

function TotalTWins() {
	$result = connection("SELECT SUM(record_tw) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}

function TotalLosses() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw < record_ctl + record_tl + record_otl");
	$row = mysql_num_rows($result); echo $row;
}	

function TotalCTLosses() {
	$result = connection("SELECT SUM(record_ctl) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}

function TotalTLosses() {
	$result = connection("SELECT SUM(record_tl) FROM records");
	$row = mysql_fetch_array($result); echo $row[0];
}

function TotalTies() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw = record_ctl + record_tl + record_otl AND record_ctw > 0 AND record_ctl > 0");
	$row = mysql_num_rows($result); echo $row;
}

function TotalLANWins() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw > record_ctl + record_tl + record_otl AND record_type='LAN Tournament' OR record_type='LANParty'");
	$row = mysql_num_rows($result); echo $row;
}

function TotalNETWins() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw > record_ctl + record_tl + record_otl AND record_type='League Match' OR record_type='Online Tournament'");
	$row = mysql_num_rows($result); echo $row;
}

function TotalLANLosses() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw < record_ctl + record_tl + record_otl AND record_type='LAN Tournament' OR record_type='LANParty'");
	$row = mysql_num_rows($result); echo $row;
}

function TotalNETLosses() {
	$result = connection("SELECT * FROM records WHERE record_ctw + record_tw + record_otw < record_ctl + record_tl + record_otl AND record_type='League Match' OR record_type='Online Tournament'");
	$row = mysql_num_rows($result); echo $row;
}

?>