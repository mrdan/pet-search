<?php
// remove duplicate tags from an array
function array_unique_compact($a) 
{
  $tmparr = array_unique($a);
  $i=0;
  foreach ($tmparr as $v) {
    $newarr[$i] = $v;
    $i++;
  }
  return $newarr;
}

// print all tags from postings table to the page
function display_tagcloud_php($linkid) 
{
    //TODO: if the url is ?tags=+black then it won't recoginise the tag as it'll be "+black" not "black"

    // add existing url tags to the links
    if(isset($_GET['tags'])) {
        $url_tags = $_GET['tags'];
        $url_tags = str_replace(" ", "+", $url_tags);
        $url_tags = $url_tags."+";
    }
    else
        $url_tags = "";

    $result = mysql_query("SELECT tags FROM postings");
    $tags = array();
    while($row = mysql_fetch_array($result)) {
        $tags = array_merge($tags, explode(" ", $row['tags']));
    }

    $tags = array_unique_compact($tags);

    for($i=0;$i<count($tags);$i++) 
    {
        if(strpos($url_tags, $tags[$i]) !== FALSE)                                                                          //tag already in url
        {
            $url_tags_clean = preg_replace("/(^".$tags[$i]."\+|\+".$tags[$i]."$|".$tags[$i]."\+)/", "", $url_tags);         //remove it from url tags list
            if($url_tags_clean == "")
                echo "<A href='?'>".$tags[$i]."</A> ";                                                                      //no more tags so remove "tags" param
            else
                echo "<A href='?tags=".substr($url_tags_clean,0,-1)."'>".$tags[$i]."</A> ";                                 //print a url without the tag and remove the uneeded "+"
        }
        else
            echo "<A href='?tags=".$url_tags.$tags[$i]."'>".$tags[$i]."</A> ";
    }
}

function display_tag_category($category,$linkid) {

    if ($category == NULL | $category == '')
        $sql = "SELECT tag FROM tags WHERE category IS NULL";
    else
        $sql = "SELECT tag FROM tags WHERE category='$category'";

    $result = mysql_query($sql);
    if(mysql_num_rows($result)==0){
        echo "No tags found for category ";
        return;
    }
    
    while($row = mysql_fetch_array($result))
        echo "<SPAN class='tag'>".$row['tag']."</SPAN> ";
}

function display_tagcloud_js($linkid) {
    $result = mysql_query("SELECT tags FROM postings");
    $tags = array();
    while($row = mysql_fetch_array($result)) {
        $tags = array_merge($tags, explode(" ", $row['tags']));
    }

    $tags = array_unique_compact($tags);

    for($i=0;$i<count($tags);$i++) {
        echo "<A class='tag' href='#".$tags[$i]."'>".$tags[$i]."</A> ";
    }
}

// print $offset postings starting from $start using the mysql connection $dbconnection, filtering by $species and $tags if needed
// returns the next offset based on $offset and $amount
function display_postings($species, $tags, $offset, $amount, $dbconnection) 
{

    $sql1 = "SELECT * FROM postings ";    
    $sql2 = "ORDER BY daterefreshed DESC LIMIT ".$offset.",".$amount;

    if(!$offset)
        $offset = 0;
    if(!$tags)
        $sql = $sql1.$sql2;
    else
    {
        $tags_array = explode(" ", $tags);
        $sql_tags1 = "WHERE ";
        for ($i=0; $i < count($tags_array); $i++) { 
            $sql_tags2 = "(tags LIKE '% ".$tags_array[$i]." %' OR tags LIKE '".$tags_array[$i] ." %' OR tags LIKE '% ".$tags_array[$i]."' OR tags = '".$tags_array[$i]."') ";
            if($i < (count($tags_array) - 1))
                $sql_tags2 = $sql_tags2."AND ";
            $sql_tags1 = $sql_tags1.$sql_tags2;
        }
        $sql = $sql1.$sql_tags1.$sql2;
    }

    $result = mysql_query($sql,$dbconnection);
    if (!$result)
        die('Error in display_postings: ' . mysql_error());
    while($row = mysql_fetch_array($result)) 
    {
        echo "<DIV class='posting'>";
            echo "<DIV class='photo'><IMG /></DIV>";
            echo "<P><A href=''>".$row['email']."</A>, ".$row['daterefreshed'].", ".$row['refreshed']."</P>";
            echo "<P>".$row['species'].": ".$row['tags']."</P>";
        echo "</DIV>";
    }

    return $offset + $amount;
}
?>