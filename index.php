<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="static/functions.js"></script>
    <link rel="stylesheet" href="static/main.css">
    <title>Home - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="images/duck-icon.ico">

<div id="alertbox"></div>

<nav class="navbar navbar-default py-5">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">DG Timenage</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="static/new.html">Create a new task</a></li>
            <li><a href="static/login.html">Login</a></li>
            <li><a href="static/register.html">Sign Up</a></li>
        </ul>
    </div>
</nav>

</head>

<body>
</body>
<?php
include 'server/vars.php';
$counter = 0;
$unicids = array();
$page = 0;

// Create connection
if (isset($_COOKIE['sessionID'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //First request to retrieve user info
    $sql = "SELECT `f_name`, `name` FROM `users` WHERE id='" . $_COOKIE['sessionID'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class'homeInfo'><h1>Your Projects</h1><br><h2>Logged in as " . $row['f_name'] . " " . $row['name'] . ".</h2> </div>";
    }
    } else {
        echo "Error 6001 : Unable to log in, please try again";
    }

    echo"<ul class='pager'>
        <li><a href='index.php' class='active'>Timers</a></li>
        <li><a href='server/indexTodo.php'>To-Do Tasks</a></li>
        </ul>";

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

    //Third request to gather the 8 cards
    $sql = "SELECT `unicid`, `proj_name`, `curr_time` FROM `usr_projects` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY `unicid`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
        $count = mysqli_num_rows($result);
        while($row = $result->fetch_assoc()) {
            echo "<div class='timerBox col-sm-3 panel panel-default'>
                    <div class='panel-heading'>
                        <h5>". $row['proj_name'] ."</h5>
                    </div>
                    <div class='timer panel-body'>
                        <timer-tag id='". $row['unicid'] ."'>". gmdate("H:i:s", $row['curr_time']) ."</timer-tag>
                        <div class='start " . $row['unicid'] . "'>
                            <button class='btn btn-success' onclick='counter(".  $row['unicid'] . ")'>Start</button>
                        </div>
                        <div class='stop " . $row['unicid'] . "'>
                            <button class='btn btn-danger' onclick='stopCount(" . $row['unicid'] . ")'>Stop</button>
                        </div>
                    </div>
                </div>
                <script>
                    hide('stop')
                </script>
                ";
    }
    } else {
        echo "Error 6001 : Unable to log in, please try again";
    }
    echo "<a href='new.html' class='col-sm-3 newBtn btn btn-info'><span class='glyphicon glyphicon-plus'></span></a>";
    $conn->close();
}
else {
    echo "<h2>Would you like to log in?</h2><br><a href='/static/login.html'>LOG IN</a>";
}



?>

