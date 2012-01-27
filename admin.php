<HTML>
<HEAD><TITLE>Pet Search Test Admin</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="includes/style.css" />
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/admin.js"></SCRIPT>
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
?>

<DIV class='lightbox'>
	<p>Click "Cancel" to close</p>
    <DIV id="lb_content">
    	To which catgeory to you want to assign the tags <SPAN id="tag_list">none</SPAN>?
		<FORM id="tag_assign" action="admin.php" method="post">
      		<SELECT>
      			<OPTION>Species</OPTION>
      			<OPTION>Medical</OPTION>
      			<OPTION>Visual</OPTION>
      			<OPTION>Personality</OPTION>
      			<OPTION>Location</OPTION>
      			<OPTION>Uncategorised</OPTION>
      		</SELECT>
      		<INPUT type="hidden" id="chosen_tags" name="chosen_tags" value="" />
      		<INPUT type="Submit" name="tag_assign_submit" value="Submit" />
      		<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    	</FORM>
    </DIV>
</DIV>


<DIV class='category'><DIV id="title">Species</DIV><?php display_tag_category("species",$linkid); ?></DIV>
<DIV class='category'><DIV id="title">Medical</DIV><?php display_tag_category("medical",$linkid); ?></DIV>
<DIV class='category'><DIV id="title">Visual</DIV><?php display_tag_category("visual",$linkid); ?></DIV>
<DIV class='category'><DIV id="title">Personality</DIV><?php display_tag_category("personality",$linkid); ?></DIV>
<DIV class='category'><DIV id="title">Location</DIV><?php display_tag_category("location",$linkid); ?></DIV>
<DIV class='category'><DIV id="title">Uncategorised</DIV><?php display_tag_category(NULL,$linkid); ?></DIV>

<BUTTON type="button" class="lightbox_trigger">Click Me!</BUTTON> 

<?php
mysql_close($linkid);
?>
</BODY>
</HTML>