<?

/********************************************************
//
//  kliptmedia Clan Manager
//  www.kliptmedia.com
//	copyright © 2002-2003 kliptmedia.com 
//
//  Instructions:
//     This files goes in your sites main directory.
//     This is where your index.php file should be.
//
//	   Once uploaded, add this line to your index.php
//     where the dynamic content area will be:
//
//          <? include("cm_menu.php"); ?>
//
/*******************************************************/

			
		if ( $_GET['page'] == "roster" ) {
			if ( $_GET['ChooseRoster'] ) {
				DisplayRosterDetails($_GET['ChooseRoster']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=roster&sort=alias&scend=$scend'>Alias</a></td>
								<td align=center><a href='index.php?page=roster&sort=age&scend=$scend'>Age</a></td>
								<td align=center><a href='index.php?page=roster&sort=location&scend=$scend'>Location</a></td>
								<td align=center>Details</td>";
				DisplayRosterList($_GET['sort'],$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "records" ) {
			if ( $_GET['ChooseRecord'] ) {
				DisplayRecordsDetails($_GET['ChooseRecord']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=records&sort=awayteam&scend=$scend'>Opponents</a></td>
								<td align=center><a href='index.php?page=records&sort=date&scend=$scend'>Date</a></td>
								<td align=center><a href='index.php?page=records&sort=map&scend=$scend'>Map</a></td>
								<td align=center>Result</td>
								<td align=center>Details</td>";
				DisplayRecordsList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "files" ) {
			if ( $_GET['ChooseFile']) {
				DisplayFileDetails($_GET['ChooseFile']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=files&sort=name&scend=$scend'>File Name</a></td>
								<td align=center><a href='index.php?page=files&sort=size&scend=$scend'>Size</a></td>
								<td align=center><a href='index.php?page=files&sort=downloads&scend=$scend'>Downloads</a></td>
								<td align=center>Details</td>";
				DisplayFileList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "links" ) {
			if ( $_GET['ChooseLink']) {
				DisplayLinksDetails($_GET['ChooseLink']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=links&sort=name&scend=$scend'>Name</a></td>
								<td align=center><a href='index.php?page=links&sort=size&scend=$scend'>Type</a></td>
								<td align=center>Details</td>";
				DisplayLinksList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "events" ) {
			if ( $_GET['ChooseEvent']) {
				DisplayEventsDetails($_GET['ChooseEvent']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=events&sort=name&scend=$scend'>Name</a></td>
								<td align=center><a href='index.php?page=events&sort=start&scend=$scend'>Date</a></td>
								<td align=center><a href='index.php?page=events&sort=location&scend=$scend'>Location</a></td>
								<td align=center>Details</td>";
				DisplayEventsList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "sponsors" ) {
			if ( $_GET['ChooseSponsor']) {
				DisplaySponsorsDetails($_GET['ChooseSponsor']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=sponsors&sort=name&scend=$scend'>Name</a></td>
								<td align=center><a href='index.php?page=sponsors&sort=image&scend=$scend'>Image</a></td>
								<td align=center>Details</td>";
				DisplaySponsorsList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "servers" ) {
			if ( $_GET['ChooseServer']) {
				DisplayServersDetails($_GET['ChooseServer']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=servers&sort=name&scend=$scend'>Name</a></td>
								<td align=center><a href='index.php?page=servers&sort=ip&scend=$scend'>IP</a></td>
								<td align=center><a href='index.php?page=servers&sort=type&scend=$scend'>Type</a></td>
								<td align=center>Details</td>";
				DisplayServersList($sort,$scend);
				echo "</tr></table>";
			}
		}
		
		else if ( $_GET['page'] == "demos" ) {
			if ( $_GET['ChooseDemo']) {
				DisplayDemosDetails($_GET['ChooseDemo']);
			}
			else {
				if ( $_GET['scend'] == "DESC" || $_GET['scend'] == null )
					$scend = "ASC";
				else $scend = "DESC";
				
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center><a href='index.php?page=demos&sort=name&scend=$scend'>Name</a></td>
								<td align=center><a href='index.php?page=demos&sort=map&scend=$scend'>Map</a></td>
								<td align=center><a href='index.php?page=demos&sort=pov&scend=$scend'>POV</a></td>
								<td align=center><a href='index.php?page=demos&sort=downloads&scend=$scend'>Downloads</a></td>
								<td align=center>Details</td>";
				DisplayDemosList($sort,$scend);
				echo "</tr></table>";
			}
		}
				
		else if ( $_GET['page'] == "contacts" ) {
			DisplayContacts();
		}	
		
		else if ( $_GET['page'] == "information" ) {
			DisplayInfo();
		}	
		
		else if ( $_GET['page'] == "screenshots" ) {
			if ( $_GET['ChooseGallery']) {
				DisplayGalleryDetails($_GET['ChooseGallery'], 2);
			}
			else {
				echo "<table cellspacing=0 cellpadding=5 width=100%><tr>
								<td align=center>Gallery</td>
								<td align=center>Location</td>
								<td align=center>Num Of Images</td>
								<td align=center>View</td>";
				DisplayGalleryList();
				echo "</tr></table>";
			}
		}	
		
		else if ( $_GET['page'] == "register" )
			include("register.php");
		
		else if ( $_GET['page'] == "resetpassword" )
			include("resetpassword.php");

		else if ( $_GET['page'] == "editprofile" )
			include("editprofile.php");
		
		else if ( $_GET['page'] == "email" )
			SendEmail($_GET['id']);
			
		else {
			if ( $_GET['newsid'] ) {
				DisplayPost($_GET['newsid']);	
			}
			else {
				// to edit the number of posts displayed
				// change 5 to a different number
				DisplayNews(5);
			}
		}
		
?>