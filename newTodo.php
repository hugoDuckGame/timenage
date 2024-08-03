
<?php


include 'vars.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

echo $servername . $username . $password . $dbname;

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if($_GET['date'] == "") {
  $date = "1980-01-01";
}
else {
  $date = $_GET['date'];
}

if(isset($_GET['ismult'])){
  $sql = "INSERT INTO `usr_todos` (`id`, `name`, `date`, `planIt`, `ismult`,`times`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $date . "', '" . $_GET['it'] . "', '1', '0')";
}
else {
  $sql = "INSERT INTO `usr_todos` (`id`, `name`, `date`,`ismult`) VALUES ('" . $_COOKIE['sessionID'] . "', '" . $_GET['name'] . "', '" . $date . "', '0')";
}
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


echo "<script>
if(window.self == window.top){
   window.location.replace('indexTd.php');
}
else {
  window.location.replace('newTodo.html');
}
</script>"
?>  