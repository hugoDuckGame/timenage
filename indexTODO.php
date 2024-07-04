<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>Home - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="duck-icon.ico">

<div id="alertbox"></div>

<nav class="navbar navbar-default py-5">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">DG Timenage</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="newTodo.html">Create a new task</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Sign Up</a></li>
        </ul>
    </div>
</nav>

</head>

<body>
</body>
<?php
$counter = 0;
$unicids = array();
$page = 0;
include 'vars.php';

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
    $sql = "SELECT `unicid`, `name`, `description`, `isdone`, `date` FROM `usr_todos` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY `date`, `isdone`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
        $count = mysqli_num_rows($result);
        while($row = $result->fetch_assoc()) {
            echo "<div class='col-sm-6 panel panel-default'>
                    <div class='panel-heading'>
                        <h5>" . $row['name'] ."</h5>
                    </div>
                    <div class='panel-body'>
                        <h6>" . $row['description'] . "</h6>
                        <input type='checkbox'></input>
                    </div>
                    <div class='panel-footer'>
                        <h6>" . $row['date'] . "</h6>
                    </div>
                </div>";
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
    echo "<a href='newTodo.html' class='col-sm-3 newBtn btn btn-info'><span class='glyphicon glyphicon-plus'></span></a>";
    $conn->close();
}
else {
    echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
}



?>

