<?php
include '../vars.php'; 

// Create connection
$conn = new mysqli($servername, $username, $password, "exo");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$project = $_GET['project'];

echo"[";
$count = 0;

$sql = "SELECT * FROM `events` WHERE project='{$project}'";
$conn->set_charset("utf8mb4");
$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
}

while($row = $result->fetch_assoc()) {
    if($count!=0) {echo",";}
    echo"[{$row['session']}, {$row['exo']}, {$row['level']}]";
    $count+=1;
}

echo"]";
$conn->close();
?>