
<?php
$time = $_GET['hours']*3600 + $_GET['minutes']*60 + $_GET['seconds'];


include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$date = date('Y-m-d');

$sql = "INSERT INTO `usr_todos` (`id`, `name`, `description`, `date`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $_GET['desc'] . "', '" . $date . "')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('indexTodo.php');</script>"
?>  