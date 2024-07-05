
<?php


include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


$sql = "INSERT INTO `usr_todos` (`id`, `name`, `description`, `date`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $_GET['desc'] . "', '" . $_GET['date'] . "')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('indexTodo.php');</script>"
?>  