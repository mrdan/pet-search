<?php @ require_once ('db.php'); ?>
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

function display_tag_category($category,$db) {

    if ($category == NULL | $category == '')
        $sql = "SELECT tag FROM tags WHERE category IS NULL AND approved=1 ORDER BY tag ASC";
    else
        $sql = "SELECT tag FROM tags WHERE category='$category' AND approved=1 ORDER BY tag ASC";

    $result = $db->select($sql);
    if(mysql_num_rows($result)==0){
        echo "<SPAN id='greyed'>No tags found for category </SPAN>";
        return;
    }
    
    while($row = mysql_fetch_array($result)) {
        $tag = $row['tag'];
        $sql_tagcount = "SELECT COUNT(*) FROM postings WHERE (tags LIKE '$tag' OR tags LIKE '%$tag%' OR tags LIKE '%$tag' OR tags LIKE '$tag%')";
        $result_tagcount = $db->select($sql_tagcount);
        $actual_tagcount = mysql_fetch_array($result_tagcount);
        echo "<SPAN class='tag'>".$row['tag']." </SPAN> <SPAN id='greyed'>($actual_tagcount[0])</SPAN> ";
    }
}

function display_tag_pending($db) {
    
    $sql = "SELECT tag FROM tags WHERE approved=0";
    $result = $db->select($sql);
    if(mysql_num_rows($result)==0){
        echo "<SPAN id='greyed'>No tags pending </SPAN>";
        return;
    }
    while ($row = mysql_fetch_array($result))
            echo "<SPAN class='tag'>".$row['tag']."</SPAN> ";
}

function display_tagcloud_js($db) {
    $result = $db->select("SELECT tag FROM tags");
    while($row = mysql_fetch_array($result))
        echo "<A class='tag' href='#".$row['tag']."'>".$row['tag']."</A> ";
}

function get_postings_data($tags, $offset, $amount, $db){

    $sql1 = "SELECT * FROM postings ";    
    $sql2 = "ORDER BY daterefreshed DESC LIMIT ".$offset.",".$amount;

    if(!$offset)
        $offset = 0;
    if(!$tags)
        $sql = $sql1.$sql2;
    else
    {
        $sql_tags1 = "WHERE ";
        for ($i=0; $i < count($tags); $i++) { 
            $sql_tags2 = "(tags LIKE '% ".$tags[$i]." %' OR tags LIKE '".$tags[$i] ." %' OR tags LIKE '% ".$tags[$i]."' OR tags = '".$tags[$i]."') ";
            if($i < (count($tags) - 1))
                $sql_tags2 = $sql_tags2."AND ";
            $sql_tags1 = $sql_tags1.$sql_tags2;
        }
        $sql = $sql1.$sql_tags1.$sql2;
    }

    $result = $db->select($sql);
    // jquery error plz
    $rows = Array();
    while($r = mysql_fetch_array($result)) {
        $rows[] = $r;
    }
    echo json_encode($rows);

    return $offset + $amount;    
}
?>