
<?php
$time = $_GET['hours']*3600 + $_GET['minutes']*60 + $_GET['seconds'];


$servername = "db5016032132.hosting-data.io";
$username = "dbu1200988";
$password = "wV9BuQ-F&t/?V\$z";
$dbname = "dbs13060811";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "INSERT INTO `usr_projects` (`id`, `proj_name`, `base_time`, `curr_time`, `back_time`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['proj_name'] . "', '" . $time . "', '" . $time . "', '" . $time . "')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('index.php');</script>"
?>  