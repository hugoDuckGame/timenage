<?php
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

echo $_GET['email'];

$sql = "SELECT `id`, `hashed_pass` FROM `users` WHERE email='" . $_GET['email'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $hashed_pass = $row['hashed_pass'];
  }
} else {
  echo "0 results";
}
$conn->close();

if ($hashed_pass == hash('md5', $_GET['password'])) {
    echo "logged in";
    setcookie('sessionID', $id, time() + (86400 * 30), "/");
    echo "<script>window.location.replace('index.php');</script>";
}
else {
    echo "<script>alert('Failed to log in, redirecting'); 
                  window.location.replace('login.html');</script>";
}
?>

