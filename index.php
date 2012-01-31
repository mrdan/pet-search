<HTML>
<HEAD><TITLE>Pet Search Test</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="includes/style.css" />
</HEAD>
<BODY>
<?php @ require_once ('includes/custom.php'); ?>
<?php

// db setup
$DBhost = "127.0.0.1";
$DBuser = "pet_user";
$DBpass = "234rewf2";
$DBname = "petsearch";

$linkid = mysql_connect($DBhost,$DBuser,$DBpass);
if (!$linkid) {
    die("Unable to connect to database".mysql_error());
}
mysql_select_db($DBname,$linkid);

//
// Begin site
?>
<DIV class='container'>
<DIV class='header'>Pet Search <IMG></DIV>
<DIV class='intro'>
<DIV class='intro_text'>Show me (<A class='tag' href='#male'>male</A> / <A class='tag' href='#female'>female</A>) (neutered / non-neutered) (dog / cat / fox / giraffe / goat / pokemon)s.</DIV>
<DIV class='tagcloud'><?php display_tagcloud_js($linkid); ?></DIV>
</DIV>
<DIV class='newpostbutton'>add your pet...</DIV>
<DIV class='newpost'>
	<FORM id="ad_add" action="index.php" method="post">
			<INPUT type="text" class="newText" title="Type in your tag, it will be automatically approved..." name="newtag" />
			<SELECT name="chosen_category">
      			<OPTION value="uncategorised">Uncategorised</OPTION>
      			<OPTION value="species">Species</OPTION>
      			<OPTION value="medical">Medical</OPTION>
      			<OPTION value="visual">Visual</OPTION>
      			<OPTION value="personality">Personality</OPTION>
      			<OPTION value="location">Location</OPTION>
      		</SELECT>
			<INPUT type="Submit" name="tag_add_submit" value="Submit" />
    		<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    </FORM>
</DIV>
<DIV class='main' id='main'></DIV>
<DIV class='footer'><A href='?p=$offset'>Next 25</A></DIV>
</DIV>

<?php
// close connection
mysql_close($linkid);

?>
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.ba-hashchange.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/custom.js"></SCRIPT>
</BODY></HTML>
