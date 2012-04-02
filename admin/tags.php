<HTML>
<HEAD><TITLE>Pet Search Admin - Tags</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="../includes/style.css" />
</HEAD>
<BODY>
<?php define('__ROOT__', dirname(dirname(__FILE__))); ?>
<?php require(__ROOT__.'/includes/settings.php'); ?>
<?php require(__ROOT__.'/includes/db.php'); ?>
<?php require(__ROOT__.'/includes/custom.php'); ?>
<?php

//check and process $_POST
//check for tag reassignment
if(isset($_POST["chosen_tags"]) && isset($_POST["chosen_category"])) {
	$changed_tags = $_POST["chosen_tags"];
	$chosen_category = $_POST["chosen_category"];

	if ($chosen_category == "uncategorised")
        $sql = "UPDATE tags SET approved=1, category=DEFAULT WHERE ";
    else
        $sql = "UPDATE tags SET approved=1, category='$chosen_category' WHERE ";

    $chosen_tags = explode(" ", $changed_tags);
    if(count($chosen_tags) == 1)
    	$sql = $sql."tag='$chosen_tags[0]'";
    else {
    	for ($i=0; $i < count($chosen_tags); $i++) {
    		if($i == count($chosen_tags) - 1) 
    			$sql = $sql."tag='$chosen_tags[$i]'";
    		else
    			$sql = $sql."tag='$chosen_tags[$i]' OR ";
    	}
    }

	DEBASER::write($sql);
}
//check for tag approval
if(isset($_POST["chosen_tags"]) && isset($_POST["approval"])) {
	$changed_tags = $_POST["chosen_tags"];
	$sql = "UPDATE tags SET approved=1 WHERE ";
	$chosen_tags = explode(" ", $changed_tags);
    if(count($chosen_tags) == 1)
    	$sql = $sql."tag='$chosen_tags[0]'";
    else {
    	for ($i=0; $i < count($chosen_tags); $i++) {
    		if($i == count($chosen_tags) - 1) 
    			$sql = $sql."tag='$chosen_tags[$i]'";
    		else
    			$sql = $sql."tag='$chosen_tags[$i]' OR ";
    	}
    }

	DEBASER::write($sql);
}
//check for tag addition // TODO: SANITISATION!!! We should only allow [a-z,0-9,-]
if(isset($_POST['newtag']) && $_POST['chosen_category']) {
	$newtag = $_POST['newtag'];
	$newtag = strtolower($newtag); // all our tags will be lower case for consistency
	$category = $_POST['chosen_category'];

	if ($category == "uncategorised")
        $sql = "INSERT INTO tags(tag,approved) VALUES('$newtag',1)";
    else
		$sql = "INSERT INTO tags(tag,category,approved) VALUES('$newtag','$category',1)";

	DEBASER::write($sql);
}
//check for tag unapproval
if(isset($_POST["chosen_tags"]) && isset($_POST["delete"])) {
	$changed_tags = $_POST["chosen_tags"];
	//$sql = "DELETE FROM tags WHERE ";
	$sql = "UPDATE tags SET approved=0,category=DEFAULT WHERE ";
	$chosen_tags = explode(" ", $changed_tags);
    if(count($chosen_tags) == 1)
    	$sql = $sql."tag='$chosen_tags[0]'";
    else {
    	for ($i=0; $i < count($chosen_tags); $i++) {
    		if($i == count($chosen_tags) - 1) 
    			$sql = $sql."tag='$chosen_tags[$i]'";
    		else
    			$sql = $sql."tag='$chosen_tags[$i]' OR ";
    	}
    }

	DEBASER::write($sql);
}


//begin HTML
?>

<DIV class='lightbox'>
	<p>Click "Cancel" to close</p>
	<DIV class='lb_content' id="add">
		<FORM id="tag_add" action="tags.php" method="post">
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
    <DIV class='lb_content' id="recat">
    	To which category to you want to assign the tags: <SPAN id="tag_list">none</SPAN>? (This will also automatically approve the tags)
		<FORM id="tag_assign" action="tags.php" method="post">
      		<SELECT name="chosen_category">
      			<OPTION value="uncategorised">Uncategorised</OPTION>
      			<OPTION value="species">Species</OPTION>
      			<OPTION value="medical">Medical</OPTION>
      			<OPTION value="visual">Visual</OPTION>
      			<OPTION value="personality">Personality</OPTION>
      			<OPTION value="location">Location</OPTION>
      		</SELECT>
      		<INPUT type="hidden" id="chosen_tags" name="chosen_tags" value="" />
      		<INPUT type="Submit" name="tag_assign_submit" value="Submit" />
      		<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    	</FORM>
    </DIV>
    <DIV class='lb_content' id="approve">
    	Are you sure you want to approve the tags: <SPAN id="tag_list"> none </SPAN>?
    	<FORM id="tag_approve" action="tags.php" method="post">
      		<INPUT type="hidden" id="chosen_tags" name="chosen_tags" value="" />
      		<INPUT type="hidden" name="approval" value="approval" />
      		<INPUT type="Submit" name="tag_approve_submit" value="Submit" />
    		<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    	</FORM>
    </DIV>
    <DIV class='lb_content' id="delete">
    	    	Are you sure you want to unapprove the tags: <SPAN id="tag_list"> none </SPAN>?
    	<FORM id="tag_delete" action="tags.php" method="post">
      		<INPUT type="hidden" id="chosen_tags" name="chosen_tags" value="" />
      		<INPUT type="hidden" name="delete" value="delete" />
      		<INPUT type="Submit" name="tag_delete_submit" value="Submit" />
    		<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    	</FORM>
    </DIV>
    <DIV class='lb_content'  id="error">
    	You're not supposed to be here
    	<BUTTON type="button" class="lightbox_cancel">Cancel</BUTTON>
    </DIV>
</DIV>



<DIV class='category'><DIV id="title">Status</DIV><?php display_tag_category("status"); ?></DIV>
<DIV class='category'><DIV id="title">Species</DIV><?php display_tag_category("species"); ?></DIV>
<DIV class='category'><DIV id="title">Medical</DIV><?php display_tag_category("medical"); ?></DIV>
<DIV class='category'><DIV id="title">Visual</DIV><?php display_tag_category("visual"); ?></DIV>
<DIV class='category'><DIV id="title">Personality</DIV><?php display_tag_category("personality"); ?></DIV>
<DIV class='category'><DIV id="title">Location</DIV><?php display_tag_category("location"); ?></DIV>
<DIV class='category'><DIV id="title">Uncategorised</DIV><?php display_tag_category(NULL); ?></DIV>
<DIV class='category'><DIV id="title">Pending Approval</DIV><?php display_tag_pending(); ?></DIV>
<BUTTON type="button" class="lightbox_trigger" name="add">Add</BUTTON>
<BUTTON type="button" class="lightbox_trigger" name="recat">Re-categorise</BUTTON>
<BUTTON type="button" class="lightbox_trigger" name="approve">Approve</BUTTON>
<BUTTON type="button" class="lightbox_trigger" name="delete">Unapprove</BUTTON>

<?php
DEBASER::disconnect();
?>
<SCRIPT type="text/javascript" src="../includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../includes/admin.js"></SCRIPT>
</BODY>
</HTML>