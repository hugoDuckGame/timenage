<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="timer.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="main.css">
</head>

<a href="login.html">Login HTML</a>
<a href="login.php">Login PHP</a>
<a href="register.html">Reg HTML</a>
<a href="register.php">Reg PHP</a>
<a href="new.html">New HTML</a>
<a href="new.php">New PHP</a>
<a href=""></a>

<?php
$counter = 0;
$unicids = array();
$page = 0;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projects";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//First request to retrieve user info
$sql = "SELECT `f_name` FROM `users` WHERE id='" . $_COOKIE['sessionID'] . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "Bonjour, " . $row['f_name'] . ".";
  }
} else {
  echo "Error 6001 : Unable to log in, please try again";
}

//Second request to get a list of all the unicids
$sql = "SELECT `unicid` FROM `usr_projects` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY `unicid`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $unicids[] = $row['unicid'];
  }
} else {
  echo "0 results";
}

print_r($unicids);

//Third request to gather the 8 cards
$sql = "SELECT `unicid`, `proj_name`, `curr_time` FROM `usr_projects` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY `unicid`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  $count = mysqli_num_rows($result);
  while($row = $result->fetch_assoc()) {
    echo "<div class='timerBox col-sm-3'>
            <h5>". $row['proj_name'] ."</h5>
            <h6>Proj desc</h6>
            <div class='timer'>
                <div class='start " . $row['unicid'] . "'>
                    <button class='btn btn-success' onclick='counter(" . $row['curr_time'] . "," . $row['unicid'] . ")'>Start</button>
                </div>
                <div class='stop " . $row['unicid'] . "'>
                    <button class='btn btn-danger' onclick='stop(" . $row['unicid'] . ")'>Stop</button>
                </div>
                <timer-tag id='". $row['unicid'] ."'>". gmdate("H:i:s", $row['curr_time']) ."</timer-tag>
            </div>
        </div>
        <script>
            hide('stop')
        </script>
        ";
    if($count>8) {
        echo '<ul class="pagination">';
        while ($counter < $count/8) {
            echo '<li><a href="#"></a></li>';
        }
    }
  }
} else {
  echo "Error 6001 : Unable to log in, please try again";
}

echo "<a href='new.html' class='col-sm-3 newBtn btn btn-info'><span class='glyphicon glyphicon-plus'></span>Add a new task</a>";
$conn->close();


?>

