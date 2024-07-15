<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$datestmp = date('Y-m-d');
$timestmp = date('H:i:s');

if($_GET['action'] == 'c'){
    $sql = "INSERT INTO `rtn_events`(`unicid`, `date`, `time`, `id`) VALUES ('" . $_GET['id'] . "' , '" . $datestmp . "' ,'" . $timestmp . "','" . $_COOKIE['sessionID'] . "')";
}
else {
    $sql = "DELETE FROM `rtn_events` WHERE `date`='" . $datestmp . "'AND `unicid`='" . $_GET['id'] . "'";
}
if ($conn->query($sql) === TRUE) {
  echo "1";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>  

