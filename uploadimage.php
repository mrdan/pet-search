<?PHP
$uploaddir = '/var/www/pet-search/uploads/';
$uploadfile = $uploaddir . basename($_POST["pname"]).'.'. $_POST["pext"];
if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
  echo "uploads/".$_POST["pname"];
} else {
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired
  echo "error"; 
}
?>