
<?php


include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if(isset($_GET['ismult'])){
  $sql = "INSERT INTO `usr_todos` (`id`, `name`, `date`, `planIt`, `ismult`,`times`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $_GET['date'] . "', '" . $_GET['it'] . "', '1', '0')";
}
else {
  $sql = "INSERT INTO `usr_todos` (`id`, `name`, `date`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $_GET['date'] . "')";
}
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>window.location.replace('indexTODO.php');</script>"
?>  