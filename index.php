<HTML>
<HEAD><TITLE>Pet Search Test</TITLE>
<LINK rel="stylesheet" href="includes/style.css" />
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/custom.js"></SCRIPT>
</HEAD>
<BODY>
<?php @ require_once ('includes/custom.php'); ?>
<?php

$DBhost = "127.0.0.1";
$DBuser = "pet_user";
$DBpass = "234rewf2";
$DBname = "petsearch";

$linkid = mysql_connect($DBhost,$DBuser,$DBpass);
if (!$linkid) {
    die("Unable to connect to database".mysql_error());
}

// Begin site
echo "<DIV class='container'>";
    echo "<DIV class='header'>"; echo "Pet Search <IMG src='' />"; echo "</DIV>";
    echo "<DIV class='intro'>";
        echo "I've lost a <A href='#male'>Male</A> / <A href='#female'>Female</A> dog. We want to be able to click male or female and have the list below change to reflect the choice. The list should initially load with everything.";
    echo "</DIV>";
    echo "<DIV class='main' id='main'>";
        print_postings($DBname, $linkid, 5);
echo "</DIV>";

mysql_close($linkid);

?>
</BODY></HTML>
