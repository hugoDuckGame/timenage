<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Home - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="duck-icon.ico">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
<div id="alertbox"></div>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          
        </button>
        <a class="navbar-brand" href="#">DG Timenage</a>
      </div>
  
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="new.html">Create a new task</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Sign Up</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

</head>

<body>
</body>
<?php
include 'vars.php';
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
        <li><a href='indexTodo.php'>To-Do Tasks</a></li>
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
    echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
}



?>

