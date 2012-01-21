<HTML>
<HEAD><TITLE>Pet Search Test</TITLE>
<LINK rel="stylesheet" href="style.css" />
</HEAD>
<BODY>
<?php

// remove duplicate tags from an array
function array_unique_compact($a) {
  $tmparr = array_unique($a);
  $i=0;
  foreach ($tmparr as $v) {
    $newarr[$i] = $v;
    $i++;
  }
  return $newarr;
}

// print all tags from postings table to the page
function output_all_tags($DBname,$linkid) {
    mysql_select_db($DBname,$linkid);
    $result = mysql_query("SELECT * FROM postings");
    
    $tags = array();

    while($row = mysql_fetch_array($result)) {
        $tags = array_merge($tags, explode(" ", $row['tags']));
    }

    $tags = array_unique_compact($tags);

    for($i=0;$i<count($tags);$i++) {
        echo $tags[$i];
        if($i<count($tags)-1) echo ",\n";
    }
}


//
// Main
//

$DBhost = "127.0.0.1";
$DBuser = "pet_user";
$DBpass = "234rewf2";
$DBname = "petsearch";

$linkid = mysql_connect($DBhost,$DBuser,$DBpass);
if (!$linkid) {
    die("Unable to connect to database".mysql_error());
}

// Begin site

echo "<div class'container'>";
output_all_tags($DBname,$linkid);
echo "</div>";





mysql_close($linkid);

?>
</BODY></HTML>
