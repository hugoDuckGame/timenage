<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT `rtnId` FROM usr_rtn WHERE `id`='" . $_COOKIE['sessionID'] . "' LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if($_GET['isProject'] == 1){
        $lastid = $row['rtnId'];
        $lastid = $lastid +1;
    }
    else {
        $lastid = $_GET['project'];
    }
  }
}
else {
    $lastid = 1;
}

if(isset($_GET['isMand'])) {$isMand = 1;}
else {$isMand = 0;}

$sql = "INSERT INTO `usr_rtn`(`rtnId`, `id`, `name`, `isProject`, `isMand`) VALUES ('" . $lastid . "' , '" . $_COOKIE['sessionID'] . "' , '" . $_GET['name'] . "' , '" . $_GET['isProject'] . "' , '" . $isMand . "')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('indexRtn.php');</script>"

?>