<?php
include '../vars.php'; 

// Create connection
$conn = new mysqli($exosv, $username, $password, "exo");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$project = $_GET['project'];
$session = $_GET['session'];
$exo  = $_GET['id'];
$level = $_GET['type'];

$sql = "INSERT INTO `events` (`project`, `session`, `exo`, `level`) VALUES ('{$project}', '{$session}', '{$exo}', '{$level}')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>