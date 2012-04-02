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

function display_tag_category($category) {

    if ($category == NULL | $category == '')
        $sql = "SELECT tag FROM tags WHERE category IS NULL AND approved=1 ORDER BY tag ASC";
    else
        $sql = "SELECT tag FROM tags WHERE category='$category' AND approved=1 ORDER BY tag ASC";

    $result = DEBASER::select($sql);
    if(!$result){
        echo "<SPAN id='greyed'>No tags found for category </SPAN>";
        return;
    }
    
    foreach ($result as $row) {
        $tag = $row['tag'];
        $sql_tagcount = "SELECT COUNT(*) FROM postings WHERE (tags LIKE '$tag' OR tags LIKE '%$tag%' OR tags LIKE '%$tag' OR tags LIKE '$tag%')";
        $result_tagcount = DEBASER::select($sql_tagcount);
        if($result_tagcount)
            $actual_tagcount = $result_tagcount[0]["COUNT(*)"];
        echo "<SPAN class='tag'>".$row['tag']." </SPAN> <SPAN id='greyed'>($actual_tagcount)</SPAN> ";
    }
}

function display_tag_pending() {
    
    $sql = "SELECT tag FROM tags WHERE approved=0";
    $result = DEBASER::select($sql);
    if(!$result){
        echo "<SPAN id='greyed'>No tags pending </SPAN>";
        return;
    }
    foreach ($result as $row)
        echo "<SPAN class='tag'>".$row['tag']."</SPAN> ";
}

// $exclude is a string of space-seperated categories you don't want the cloud to include
function display_tagcloud($exclude) {

    $baddies = explode(" ", $exclude);
    $sql_string = "SELECT tag,category FROM tags WHERE";
    $amnt = count($baddies);
    for ($x = 0; $x < $amnt; $x++) {
        $sql_string = $sql_string." category != '$baddies[$x]' ";
        if ($amnt > 1 && $x != ($amnt - 1))
            $sql_string = $sql_string."AND ";
    }
    $sql_string = $sql_string."OR category IS NULL ORDER BY category DESC, tag";

    $result = DEBASER::select($sql_string); //mysql filters NULL even if it doesn't match the query

    $prev_category = "";
    foreach ($result as $row) {
        if (strcmp($prev_category, $row['category']))
            echo "  //  ";
        echo "<A class='tag' href='#".$row['tag']."'>".$row['tag']."</A> ";
        $prev_category = $row['category'];
    }
}

// $cat is a string name of the category you want
function display_tag_cat($cat) {
    $result = DEBASER::select("SELECT tag,category FROM tags WHERE category = '$cat' ORDER BY tag"); //mysql filters NULL even if it doesn't match the query
    foreach ($result as $row) {
        echo "<A class='tag' href='#".$row['tag']."'>".$row['tag']."</A> ";
        $prev_category = $row['category'];
    }
}

function delete_posting() {
    
}
?>