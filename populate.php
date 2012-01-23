<?php @ require_once ('includes/custom.php'); ?>
<?php

// returns an array containing $count email addresses. $unique == 1 means just return unique entries
function generate_email($count, $unique) {
    $domain = Array("gmail.com","fakemail.com","hotmail.com","mail.com",
                    "netryst.org","eircom.net","aol.com","pet-search.ie",
                    "intel.com","google.com","microsoft.com","mediatemple.com",
                    "sdgsdgsd.edu");
                    
    $firstnames = Array("dan","daniel","sandra","aoife","aisling","danny","helen",
                        "des","desmond","aideen","alan","al","maeve","michael","mike",
                        "philip","phil","pip","michelle","donal","shane","david","anne");
                        
    $lastnames = Array("doyle","lyons","dowling","ryan","hilliard","murphy","white","whitely",
                       "curran","baker","gleeson");
                       
    $adjectives = Array("freaky","drunk","funny","shy","stoned","sexy","dynamite");

    $userlist = Array();
    
    for($i = 0; $i < $count; $i++) {
        $user_domain = $domain[array_rand($domain,1)];
        $user_first = $firstnames[array_rand($firstnames,1)];
        $user_last = $lastnames[array_rand($lastnames,1)];
        $user_adj = $adjectives[array_rand($adjectives,1)];

        $rand = rand(0,100);
        $rand2 = rand(0,10);
        
        if ($rand < 5) 
        {
            $username = $user_adj;                  //freaky@
        } 
        else if ($rand < 10) 
        {
            if ($rand2 < 3)
                $username = $user_adj."-".$user_first;      //freaky-dan@
            else if($rand2 < 6)
                $username = $user_adj.".".$user_first;      //freaky.dan@
            else
                $username = $user_adj.$user_first;      //freakydan@
        } 
        else if ($rand < 20) 
        {
            $username = $user_last.$user_first;     //doyledan@
        } 
        else if ($rand < 25) 
        {
            if ($rand2 < 4)
                $username = $user_last."-".$user_first; //doyle-dan@
            else
                $username = $user_last.".".$user_first; //doyle.dan@
        } 
        else if ($rand < 50) 
        {
            $username = $user_first.$user_last;      //dandoyle@
        } 
        else if ($rand < 70) 
        {
            if ($rand2 < 3)
                $username = $user_first."-".$user_last; //dan-doyle@
            else
                $username = $user_first.".".$user_last; //dan.doyle@
        } 
        else 
        {
            $username = $user_first;                //dan@
        }
        $username = $username."@".$user_domain;
        
        $userlist[$i] = $username;
    }
    
    if ($unique == 1)
        return array_unique_compact($userlist);
    else
        return $userlist;
}

// return a string containing a species
function rand_species() {
    $species = Array("dog","cat","goat","giraffe","fox","pokemon");
    $pet_species = $species[array_rand($species,1)];                    // take one species

    return $pet_species;
}

// returns an array containing $count strings containing a set of pet tags. $unique == 1 means return only unique sets (doesn't compare order of tags)
function rand_tags($count, $unique) {

    $descrip = Array("long-haired","brown","lazy","playful","short-haired","black","white", "quick", "yellow", 
                     "red", "grey", "tabby", "tortoise-shell", "orange", "green-eyed", "yellow-eyed", "nervous", "friendly"
                     );
    
    $petlist = Array();
    $descrip_size = count($descrip);
  
    for($i = 0; $i < $count; $i++) {
        $pet_descrip = Array();
        $pet_descrip_keys = Array();
        $descrip_string = "";

        $specificity = rand(1,$descrip_size);                               // decide how many tags we want this post to have (at least one, not counting species)

        if ($specificity == 1)
            $pet_descrip_keys = Array(array_rand($descrip,$specificity));   // there was a horrible bug here. it's gone now. RIP 22-01-2012.
        else
            $pet_descrip_keys = array_rand($descrip,$specificity);          // get a $specificity sized set of keys to use to grab tags

        for($x=0;$x < count($pet_descrip_keys);$x++) {
            $pet_descrip[$x] = $descrip[$pet_descrip_keys[$x]];
        }
        sort($pet_descrip);
        $descrip_string = implode(" ", $pet_descrip);
        $petlist[$i] = $descrip_string;
    }
    
    if($unique == 1)
        array_unique_compact($petlist);

    return $petlist;
}

// give us a random date string betwen $start and $end in the mySQL format YYYY-MM-DD
function rand_date($start, $end) {
    $sometime = rand( strtotime($start), strtotime($end));
    $rand_date = date("Y-m-d", $sometime);
    return $rand_date;
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

$counter = $_GET['c'];
$unique = $_GET['u'];

if($counter == NULL) {
    $userlist = generate_email(100, $unique);
    $petlist = rand_tags(100, $unique);
} else {
    $userlist = generate_email($counter, $unique);
    $petlist = rand_tags($counter, $unique);
}

$usercount = count($userlist);
$petcount = count($petlist);

// Connect our lists
if ($usercount < $petcount) {
    $petlist = array_slice($petlist, 0, $usercount);
} elseif ($usercount > $petcount) {
    $userlist = array_slice($userlist, 0, $petcount);
}
$combolist = array_combine($userlist, $petlist);

// Print stats
if($unique == 1) {
    echo "Unique users: ".$usercount."<BR />";
    echo "Unique pets: ".$petcount."<BR />";
    echo "Combined total is always the smallest number. <BR /><BR />";
}

// time to populate
mysql_select_db($DBname, $linkid);
reset($combolist);                                                          // just in case the pointer has moved
while (list($u,$t) = each($combolist)) {
    $s = rand_species();
    echo $u.": ".$t."<BR />";

    $sql = "INSERT INTO postings(species,tags,email) VALUES('$s','$t','$u')";
    if (!mysql_query($sql,$linkid))
    {
        die('Error: ' . mysql_error());
    }
}

// date && refreshed
// random date before X and after Y
// random refreshed number less than 10
// date refreshed should not be the same as dateadded if refreshed = 0



mysql_close($linkid);
?>