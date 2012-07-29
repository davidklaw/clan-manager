<?php 
	
	require("global.php"); 
	ini_set("upload_max_filesize", "50M");
	ini_set("post_max_size", "30M");
	ini_set("memory_limit", "35M");
	
?>

<html>

<head>
	<title>Clan Manager - Version 3.0</title>
	<link rel="stylesheet" href="cm.css" type="text/css">
</head>

<body>
<DIV ID="dek"></DIV>

<SCRIPT TYPE="text/javascript">

	//Pop up information box II (Mike McGrath (mike_mcgrath@lineone.net,  http://website.lineone.net/~mike_mcgrath))
	//Permission granted to Dynamicdrive.com to include script in archive
	//For this and 100's more DHTML scripts, visit http://dynamicdrive.com
	
	Xoffset= -100;    // modify these values to ...
	Yoffset= 13;    // change the popup position.
	
	var old,skn,iex=(document.all),yyy=-1000;
	
	var ns4=document.layers
	var ns6=document.getElementById&&!document.all
	var ie4=document.all
	
	if (ns4)
	skn=document.dek
	else if (ns6)
	skn=document.getElementById("dek").style
	else if (ie4)
	skn=document.all.dek.style
	if(ns4)document.captureEvents(Event.MOUSEMOVE);
	else{
	skn.visibility="visible"
	skn.display="none"
	}
	document.onmousemove=get_mouse;
	
	function popup(msg,bak){
	var content="<TABLE  WIDTH=200 BORDER=1 BORDERCOLOR=black CELLPADDING=2 CELLSPACING=0 "+
	"BGCOLOR="+bak+"><TD ALIGN=center><FONT COLOR=black SIZE=1>"+msg+"</FONT></TD></TABLE>";
	yyy=Yoffset;
	 if(ns4){skn.document.write(content);skn.document.close();skn.visibility="visible"}
	 if(ns6){document.getElementById("dek").innerHTML=content;skn.display=''}
	 if(ie4){document.all("dek").innerHTML=content;skn.display=''}
	}
	
	function get_mouse(e){
	var x=(ns4||ns6)?e.pageX:event.x+document.body.scrollLeft;
	skn.left=x+Xoffset;
	var y=(ns4||ns6)?e.pageY:event.y+document.body.scrollTop;
	skn.top=y+yyy;
	}
	
	function kill(){
	yyy=-1000;
	if(ns4){skn.visibility="hidden";}
	else if (ns6||ie4)
	skn.display="none"
	}

</SCRIPT>

<?	
	if ( StatusCheck($cm) == "admin" || StatusCheck($cm) == "head admin"  )	{
?>

	<table width="100%" height="100%" cellspacing="10" cellpadding="0" border="0">
	
	<tr>
		<td valign="top" width="20%" class="MenuCellX">
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="CurrentHeader">Manage Clan</td>
			</tr>
			
				<td class="MenuCell">
					<div class="MenuItems">				
						<a href="index.php?option=main">Main</a><br>
						<a href="index.php?option=news">News</a><br>
						<a href="index.php?option=information">Clan Information</a><br>
						<a href="index.php?option=contacts">Contacts</a><br>
						<br>
						<a href="index.php?option=roster">Roster</a><br>
						<a href="index.php?option=records">Records</a><br>
						<a href="index.php?option=demos">Demos</a><br>
						<a href="index.php?option=servers">Servers</a><br>
						<a href="index.php?option=sponsors">Sponsors</a><br>
						<br>
						<a href="index.php?option=events">Events</a><br>
						<a href="index.php?option=links">Links</a><br>
						<a href="index.php?option=files">Files</a><br>
						<a href="index.php?option=screenshots">Screenshots</a><br>
						<br>
						<a href="index.php?option=mail">Mail Clan</a>
					</div>
				</td>
			</tr>
			
			<tr>
				<td class="MenuCellX"><br></td>
			</tr>
			
			<tr>
				<td class="CurrentHeader">Manage Page</td>
			</tr>
			
			<tr>
				<td class="MenuCell">
					<div class="MenuItems">
						<a href="index.php?option=settings">Settings</a><br>			
						<a href="index.php?option=users">Users</a>
					</div>
				</td>
			</tr>
			
			<tr>
				<td class="MenuCellX"><br></td>
			</tr>
			
			<tr>
				<td class="CurrentHeader">Templates</td>
			</tr>
			
			<tr>
				<td class="MenuCell">
				
					<div class="MenuItems">
						<a href="index.php?option=templates&type=news">News</a><br>			
						<a href="index.php?option=templates&type=information">Information</a><br>			
						<a href="index.php?option=templates&type=contacts">Contacts</a><br>
						
						<a href="index.php?option=templates&type=roster">Roster</a><br>
						<a href="index.php?option=templates&type=records">Records</a><br>
						<a href="index.php?option=templates&type=demos">Demos</a><br>
						<a href="index.php?option=templates&type=servers">Servers</a><br>
						<a href="index.php?option=templates&type=sponsors">Sponsors</a><br>
						
						<a href="index.php?option=templates&type=events">Events</a><br>
						<a href="index.php?option=templates&type=links">Links</a><br>
						<a href="index.php?option=templates&type=files">Files</a><br>
						<a href="index.php?option=templates&type=screenshots">Screenshots</a><br>
								
					</div>
				</td>
			</tr>
			</table>

		</td>
		
		<td class="MenuCellX" valign="top" width="60%">
		
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="CurrentHeader">Quick Data</td>
			</tr>
		
			<tr>
				<td class="MenuCell">

<?
				if ( $_GET['option'] ) 
					include("option_".$_GET['option'].".php");
				else 
					include("option_main.php");
?>

				</td>
			</tr>
			</table>
			
		</td>
		
		<td class="MenuCellX" valign="top" width="20%">
			
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			
			<tr>
				<td class="CurrentHeader">Version Info</td>
			</tr>
			
				<td class="MenuCell">		
						
					<div class="VersionInfo">
					<br>
					<img src="images/logo.gif"><br>
					<a href="http://www.kliptmedia.com" target="_new">KCode Clan Manager</a><br>
					Build 3.0
					</div>
					<p>
									
				</td>
			</tr>
			
			<tr>
				<td class="MenuCellX"><br></td>
			</tr>
			
			<tr>
				<td class="CurrentHeader">Quicklinks</td>
			</tr>
			
				<td class="MenuCell">		

					
					<br><br><center><font size=1>
					[ <a href="../">frontpage</a> ]
					<br><br>
					[ <a href="logout.php">logout</a> ]
					<p>
				
				</td>
			</tr>
			
			<tr>
				<td class="MenuCellX"><br></td>
			</tr>
			
			<tr>
				<td class="CurrentHeader">
<?
					if ( $_GET['option'] != "templates" )
						echo "Tips";
					else
						echo "Commands";
?>
				</td>
			</tr>
			
				<td class="MenuCell">		
					
					<br><font size=1>

<?			
				if ( $_GET['option'] == "records" ) {
?>
					<center><a class=btip href="#" onMouseover="popup('Fill in all fields such as HLTV, Scorebot, the team you are playing and then simply fill in the scores as all 0')"; onMouseout="ONMOUSEOUT=kill()">How do I do an upcoming match?</a></center>
<?	
				} 
				else if ( $_GET['option'] == "users" ) {
?>
					<center><a class=btip href="#" onMouseover="popup('Set their status to admin.  Then choose their profile again and check the news checkbox.')"; onMouseout="ONMOUSEOUT=kill()">How do I make it so someone can only post news?</a></center>
<?	
				} 
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "news" ) {
?>
					<b>All</b><br>
					&#60;% subject %><br>
					&#60;% reporter %><br>
					&#60;% date %><br>
					&#60;% time %><br>
					&#60;% comments %><br>
					&#60;% post %><p>
					<b>Posts Only</b><br>
					&#60;% image %><br>
					&#60;% caption %><p>
					<b>Single Post Only</b><br>
					&#60;% showcomments %><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "roster" ) {
?>
					<b>All</b><br>
					&#60;% alias %><br>
					&#60;% name %><br>
					&#60;% rank %><br>
					&#60;% status %><br>
					&#60;% age %><br>
					&#60;% gender %><br>
					&#60;% location %><br>
					&#60;% email %><br>
					&#60;% wonid %><br>
					&#60;% bio %><br>
					&#60;% quote %><br>
					&#60;% sogamed %><br>
					&#60;% gotfrag %><br>
					&#60;% brand %><br>
					&#60;% mobo %><br>
					&#60;% cpu %><br>
					&#60;% ram %><br>
					&#60;% video %><br>
					&#60;% sound %><br>
					&#60;% monitor %><br>
					&#60;% resolution %><br>
					&#60;% headphones %><br>
					&#60;% keyboard %><br>
					&#60;% mouse %><br>
					&#60;% sens %><br>
					&#60;% pad %><br>
					&#60;% accessories %><br>
					&#60;% photo %><br>
					&#60;% config %><br>
					&#60;% job %><br>
					&#60;% refreshrate %><br>
					&#60;% vsync %><br>
					&#60;% hdrive %><br>
					&#60;% msn %><br>
					&#60;% yahoo %><br>
					&#60;% aim %><br>
					&#60;% favfood %><br>
					&#60;% favmap %><br>
					&#60;% favweapon %><br>
					&#60;% favplayer %><br>
					&#60;% favmovie %><br>
					&#60;% favmusic %><br>
					&#60;% homepage %><br>
					&#60;% lanexp %><br>
					&#60;% prevclans %><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to their roster page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><br>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "records" ) {
?>
					<b>All</b><br>
					&#60;% opponents %><br>
					&#60;% tag %><br>
					&#60;% league %><br>
					&#60;% map %><br>
					&#60;% date %><br>
					&#60;% time %><br>
					&#60;% hltv %><br>
					&#60;% scorebot %><br>
					&#60;% roster %><br>
					&#60;% mvp %><br>
					&#60;% event %><br>
					&#60;% type %><br>
					&#60;% result %><br>
					&#60;% homescore %><br>
					&#60;% awayscore %><br>
					&#60;% comment %><br>
					&#60;% ctw %><br>
					&#60;% ctl %><br>
					&#60;% tw %><br>
					&#60;% tl %><br>
					&#60;% otw %><br>
					&#60;% otl %><br>
					&#60;% result %><br>
					&#60;% screen1 %><br>
					&#60;% screen2 %><br>
					&#60;% screen3 %><br>
					&#60;% screen4 %><p>
					<b>Upcoming</b><br>
					&#60;% opponent %><br>
					&#60;% tag %><br>
					&#60;% league %><br>
					&#60;% map %><br>
					&#60;% date %><br>
					&#60;% time %><br>
					&#60;% hltv %><br>
					&#60;% scorebot %><br>
					&#60;% roster %><br>
					&#60;% mvp %><br>
					&#60;% event %><br>
					&#60;% type %><p>			
					<b>Recent/List/Upcoming</b><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to the record page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
					<b>Listing Only</b><br>					
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><p>
					<b>Details Only</b><br>
					&#60;% showcomments %><br>
					&#60;% demos %><p>					
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "files" ) {
?>
					<b>All</b><br>
					&#60;% filename %><br>
					&#60;% filesize %><br>
					&#60;% filedesc %><br>
					&#60;% numofdls %><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to files page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
					<b>Details Only</b><br>
					<a class=btip href="#" onMouseover="popup('Will link to the download.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% download %></a><p>			
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "links" ) {
?>
					<b>All</b><br>
					&#60;% linkname %><br>
					&#60;% linkurl %><br>
					&#60;% linktype %><br>
					&#60;% linkdesc %><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to links page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "sponsors" ) {
?>
					<b>All</b><br>
					&#60;% sponsorname %><br>
					&#60;% sponsorurl %><br>
					&#60;% sponsorimage %><br>
					&#60;% sponsordesc %><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to sponsors page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "events" ) {
?>
					<b>All</b><br>
					&#60;% eventname %><br>
					&#60;% eventstart %><br>
					&#60;% eventend %><br>
					&#60;% eventtime %><br>
					&#60;% eventprice %><br>
					&#60;% eventlocation %><br>
					&#60;% eventcontact %><br>
					&#60;% eventtype %><br>
					&#60;% eventdesc %><br>
					&#60;% eventimage %><p>
					<b>Listing and Recent</b><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to events page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "servers" ) {
?>
					<b>All</b><br>
					&#60;% servername %><br>
					&#60;% serverip %><br>
					&#60;% servertype %><br>
					&#60;% servermaplist %><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to servers page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "demos" ) {
?>
					<b>All</b><br>
					<a class=btip href="#" onMouseover="popup('This first checks your records for this match, if not it uses whatever you filled in.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% demoteam %></a><br>
					<a class=btip href="#" onMouseover="popup('This first checks your records for this match, if not it uses whatever you filled in.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% demotag %></a><br>
					<a class=btip href="#" onMouseover="popup('This first checks your records for this match, if not it uses whatever you filled in.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% demomap %></a><br>
					&#60;% demopov %><br>
					&#60;% demomatch %><br>
					&#60;% demoevent %><br>
					&#60;% demosize %><br>
					&#60;% democomment %><br>
					&#60;% numofdls %><br>
					&#60;% demoposter %><p>
					<b>Recent and Listing</b><br>
					<a class=btip href="#" onMouseover="popup('This will display a link to demos page.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% details %></a><p>
					<b>Listing Only</b><br>
					<a class=btip href="#" onMouseover="popup('Used for alternating row colors.  Set a class equal to this.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% rowClass %></a><p>
					<b>Details Only</b><br>
					<a class=btip href="#" onMouseover="popup('This will link to the download.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% download %></a><br>
					&#60;% showcomments %><p>
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "information" ) {
?>
				&#60;% clanname %><br>
				&#60;% clantag %><br>
				&#60;% ircchannel %><br>
				&#60;% ircserver %><br>
				&#60;% background %><p>
					
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "contacts" ) {
?>
				&#60;% webmaster %><br>
				&#60;% manager %><br>
				&#60;% recruiting %><br>
				&#60;% scheduler %><br>
				&#60;% help %><br>
				&#60;% marketing %><p>
					
<?	
				}
				else if ( $_GET['option'] == "templates" && $_GET['type'] == "screenshots" ) {
?>
				<b>Listing Only</b><br>
				&#60;% rowClass %><br>
				&#60;% gallery %><br>
				&#60;% numofimages %><br>
				&#60;% desc %><br>
				&#60;% date %><br>
				&#60;% location %><br>
				&#60;% view %><p>

				<b>Details Only</b><br>
				<a class=btip href="#" onMouseover="popup('This command goes where the images will be displayed.')"; onMouseout="ONMOUSEOUT=kill()">&#60;% display %></a><br>
				&#60;% gallery %><br>
				&#60;% desc %><br>
				&#60;% date %><br>
				&#60;% location %><p>
				
<?	
				}
?>
				<p>			
				</td>
			</tr>
			
		</td>
	</tr>
	</table>

<?
	}

	else {	
?>

	<center>
	<br><br><br><br><br>
	<table cellspacing=0 cellpadding=0 border=0 width=400 class=MenuCell>
	<form action="login.php" method="post">
	<tr>
		<td colspan=2><a href="http://www.kliptmedia.com" target=_new><img src="images/login_logo.gif" border=0></a></td>
	</tr>
	<tr>
		<td colspan=2><br></td>
	</tr>
	<tr>
		<td align=right>
			<b>Username:</b>
		</td>
		<td>
			<input type="TEXT" name="username" size="10" maxlength="255" class=Input value="">
		</td>
	</tr>
	<tr>
	<td align=right>
		<b>Password:</b>
	</td>
	<td>
		<input type="PASSWORD" name="password" size="10" maxlength="255" class=Input value="">
	</td>
	</tr>
	<tr>
		<td colspan=2><br></td>
	</tr>
	</table>
	<p>
	<input class=SubmitButton type="submit" value="Login">
	</form>
		
	</center>
<?
	}
?>
</body>

</html>
