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

// print all the postings to the page
function print_postings($DBname, $linkid, $repeat) {
    mysql_select_db($DBname, $linkid);
    
    for($i = 0; $i < $repeat; $i++) {
        $result = mysql_query("SELECT * FROM postings");    
        while($row = mysql_fetch_array($result)) {
            echo "<DIV class='posting'>";
                echo "<DIV class='photo'><IMG src='' /></DIV>";
                echo $row['email'].", ".$row['dateadded'].", ".$row['refreshed'];
//              echo "<SPAN class='tags'>".$row['tags']."</SPAN>";
            echo "</DIV>";
        }
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

echo "<DIV class='container'>";
    echo "<DIV class='header'>"; echo "Pet Search <IMG src='' />"; echo "</DIV>";
    echo "<DIV class='intro'>"; echo "</DIV>";
    echo "<DIV class='main'>";
        print_postings($DBname, $linkid, 5);
    echo "</DIV>";
echo "</DIV>";





mysql_close($linkid);

?>
</BODY></HTML>
