<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "INSERT INTO `users` (`id`, `name`, `f_name`, `reg_date`, `hashed_pass`, `email`) VALUES (NULL, '". $_GET['lname'] ."', '". $_GET['fname'] ."', '". date("Y-m-d") ."', '". hash('md5', $_GET['password']) ."', '". $_GET['email'] ."')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
  $last_id = $conn->insert_id;
  echo "New record created successfully. Last inserted ID is: " . $last_id;
  setcookie('sessionID', $last_id, time() + (86400 * 30), "/");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('index.php');</script>"
?>

