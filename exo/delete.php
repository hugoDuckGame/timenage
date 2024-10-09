<?php
include '../vars.php'; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$project = $_GET['project'];
$session = $_GET['session'];
$exo  = $_GET['id'];
$level = $_GET['type'];

$sql = "DELETE FROM `events` WHERE `project`='{$project}' AND `session`='{$session}' AND `exo`='{$exo}' AND `level`='{$level}'";

if ($conn->query($sql) === TRUE) {
  echo "d";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>