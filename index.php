<HTML>
<HEAD><TITLE>Pet Search Test</TITLE>
<LINK rel="stylesheet" href="includes/style.css" />
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/custom.js"></SCRIPT>
</HEAD>
<BODY>
<?php @ require_once ('includes/custom.php'); ?>
<?php

// check our gets
if (isset($_GET['p']))
	$offset = $_GET['p'];
else
	$offset = 0;

if(isset($_GET['tags']))
	$tags = $_GET['tags'];
else
	$tags = "";

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
echo "<DIV class='container'>";
    echo "<DIV class='header'>"; echo "Pet Search <IMG src='' />"; echo "</DIV>";
    echo "<DIV class='intro'>";
        echo "I've lost a <A href='?tags=male'>Male</A> / <A href='?tags=female'>Female</A> <A href='#dog'>dog</A>. We want to be able to click male or female and have the list below change to reflect the choice. The list should initially load with everything. <BR /><BR />";
        display_tagcloud($linkid);
    echo ".</DIV>";
    echo "<DIV class='main' id='main'>";
    	$offset = display_postings(0, $tags, $offset, 25, $linkid);
    echo "</DIV>";
    echo "<DIV class='footer'><A href='?p=$offset'>Next 25</A></DIV>";
echo "</DIV>";

// close connection
mysql_close($linkid);

?>
</BODY></HTML>
