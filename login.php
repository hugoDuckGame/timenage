<?php
include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `hashed_pass` FROM `users` WHERE email='" . $_GET['email'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $hashed_pass = $row['hashed_pass'];
  }
} else {
    die("Could not access the account");
}
$conn->close();

if ($hashed_pass == hash('md5', $_GET['password'])) {
    echo "<script>document.cookie = 'sessionID=" . $id . "';</script>";
    echo "<script>window.location.replace('index.php');</script>";
} else {
    echo "<script>alert('Failed to log in, redirecting'); 
    window.location.replace('login.html');</script>";
}
?>