<HTML>
<HEAD><TITLE>Lost Pets Test</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="includes/style.css" />
<LINK type="text/css" rel="stylesheet" href="includes/colorbox.css" />
</HEAD>
<BODY>
<?php require('includes/db.php'); ?>
<?php require('includes/custom.php'); ?>
<?php
//
// Begin site

if(!isset($_GET['p'])) { //not a permalink

?>
<DIV class='container'>
<DIV class='header'>Lost & Found Pets</DIV>
<DIV class='intro'>
	<DIV class='tagcloud'><?php display_tag_cat('species'); display_tagcloud('species'); ?></DIV>	
</DIV>
<DIV class='newpost'>
		<DIV id='newpostbutton'><P><A class="addpetbutton" title="Add a pet" href="addpet.php">or... add a pet using <SPAN id='tags_chosen'>some</SPAN> tags</A></P></DIV>
</DIV>
<DIV class='main' id='main'></DIV>
<DIV class='lastPostLoader'></DIV>
<DIV class='toTop'> Back to top </DIV>
<DIV class='footer'></DIV>
</DIV>
<?PHP DEBASER::disconnect(); ?>
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.colorbox.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.ba-hashchange.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/ajaxupload.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/toolshed.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/custom.js"></SCRIPT>
</BODY></HTML>
<?PHP
} else { //permalink url found, TODO: apache mod_rewrite to take /[0-9]/ as /?p=[0-9]
?>
<DIV class='container'>
<DIV class='header'>Lost & Found Pets</DIV>
<DIV class='main' id='main' perma=<?PHP echo "'".$_GET['p']."'"; ?>></DIV>
<DIV class='lovebox'>
	<DIV id='sendmessagebox'>
		<FORM id="send_message" method="post">
    		<INPUT type="text" title="give us your email" name="from" value="your email address"></INPUT><br />
    		<TEXTAREA title="give us your message" name="content" size="80" maxlength="500" value="your message"></TEXTAREA>
    		<DIV id='username'>You're not supposed to see this, so leave it alone: <INPUT type="text" name="username" value="" /></DIV>
			<BUTTON type="button" class='send_submit'>Send</BUTTON>
    	</FORM>
	</DIV>
	<DIV id='delmessagebox'>
    	<FORM id="del_form" method="post">
    		Enter the email address you used to place the ad and hit delete (there is no undo): <INPUT type="text" title="Enter the email address you used to place the ad and hit delete" name="user"></INPUT><BR />
			<BUTTON type="button" class="delmessagebox_submit">Delete</BUTTON>
    	</FORM>
	</DIV>
</DIV>
</DIV>
<DIV class='footer'></DIV>
</DIV>
<?PHP DEBASER::disconnect(); ?>
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.colorbox.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/toolshed.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/permalink.js"></SCRIPT>
</BODY></HTML>

<?PHP
}
?>