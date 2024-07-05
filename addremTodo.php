<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if($_GET['action'] == 1){
    $sql = "UPDATE `usr_todos` SET `times` = (`times` + 1) WHERE unicid='" . $_GET['unicid'] . "'";
}
else {
    $sql = "UPDATE `usr_todos` SET `times` = (`times` - 1) WHERE unicid='" . $_GET['unicid'] . "'";
}
if ($conn->query($sql) === TRUE) {
  echo "1";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>  