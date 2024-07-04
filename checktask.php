<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "UPDATE `usr_todos` SET `isdone` = NOT `isdone` WHERE unicid='" . $_GET['id'] . "'";

if ($conn->query($sql) === TRUE) {
  echo "1";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>  