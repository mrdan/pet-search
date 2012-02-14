<HTML>
<HEAD><TITLE>Pet Search Test</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="includes/style.css" />
</HEAD>
<BODY>
<?php require('includes/db.php'); ?>
<?php require('includes/custom.php'); ?>
<?php
//
// Begin site
?>
<DIV class='sendmessagebox'>
	<p>Click "Cancel" to close</p>
	<DIV class='smb_content'>
    	<FORM id="send_message" method="post">
    		Your email address: <INPUT type="text" title="give us your email" name="from"></INPUT><BR />
    		Your message: <TEXTAREA title="give us your message" name="content" rows="5" cols="20">Sample</TEXTAREA><BR />
			<BUTTON type="button" class="sendmessagebox_submit">Send</BUTTON>
    		<BUTTON type="button" class="sendmessagebox_cancel">Cancel</BUTTON>
    	</FORM>
    </DIV>
</DIV>
<DIV class='container'>
<DIV class='header'>Pet Search <IMG></DIV>
<DIV class='intro'>
	<DIV class='intro_text'>Show me (<A class='tag' href='#male'>male</A> / <A class='tag' href='#female'>female</A>) (neutered / non-neutered) (dog / cat / fox / giraffe / goat / pokemon)s.</DIV>
	<DIV class='tagcloud'><?php display_tagcloud_js('species'); ?></DIV>
	<DIV class='newpost'>
		<DIV id='newpostbutton'><P>or... add a pet using <SPAN id='tags_chosen'>some</SPAN> tags</P></DIV>
		<DIV id='newpostform'>
			<FORM id="pet_add" method="post">
				<DIV id='first'>First, click some tags above</DIV>
				<DIV id='second'>Second, <INPUT type="text" class='newText' id='email' title="give us your email" name="email" /></DIV>
				<DIV id='third'>Third, <button type="file" id="imageUpload"/>upload a picture</button></DIV>
				<DIV id='photobox'>
					<IMG id='thumb' src='loading.jpg' width=100 height=100/>
				</DIV>
				<INPUT type="hidden" id="sub_tags" name="sub_tags" value="" />
				<INPUT type="hidden" id="photo_name" name="photo_name" value="0" />
				<BUTTON type="button" class='pet_add_submit' name="pet_add_submit" value="Submit">Submit</BUTTON>
    		</FORM>
		</DIV>
	</DIV>
</DIV>
<DIV class='main' id='main'></DIV>
<DIV class='lastPostLoader'></DIV>
<DIV class='toTop'> Back to top </DIV>
<DIV class='footer'></DIV>
</DIV>
<?PHP DEBASER::disconnect(); ?>
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.ba-hashchange.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/ajaxupload.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/custom.js"></SCRIPT>
</BODY></HTML>
