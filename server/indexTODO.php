<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="/static/functions.js"></script>
    <link rel="stylesheet" href="/static/main.css">
    <title>Home - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="/static/duck-icon.ico">

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

    echo"<ul class='pager'>
        <li><a href='index.php'>Timers</a></li>
        <li><a href='indexTodo.php' class='active'>To-Do Tasks</a></li>
        </ul>";


    //Third request to gather the 8 cards
    $sql = "SELECT `unicid`, `name`, `description`, `isdone`, `date` FROM `usr_todos` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY `date` ASC, `isdone` ASC";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
    // output data of each row
        $count = mysqli_num_rows($result);
        while($row = $result->fetch_assoc()) {
        if(isset($date)) {
            if($date != $row['date']){
                //echo "</div>";
                echo "<div class='todoBox col-sm-2 panel panel-default'>
                        <div class='panel-body'>
                            <h1 style='color: black;'>Tasks for the</h1>
                            <h1 style='color: black;'>" . $row['date'] . "</h1>
                        </div>
                    ";
                //echo "</div> <div style='border-radius: 20px; border: 2px; border-style: dotted; padding: 8px; height: 210px;' class='surrounding'>";
            }
        }
            echo "<div class='todoBox col-sm-2 panel panel-default'>
                    <div class='panel-heading'>
                        <h6>" . $row['name'] ."</h6>
                    </div>
                    <div class='panel-body'>
                        <h6>" . $row['description'] . "</h6>
                        <div class='check " . $row['unicid'] . "'>
                            <button id='check-" . $row['unicid'] . "' class='btn btn-xs' onclick='updateTodo(".  $row['unicid'] . ")'></button>
                        </div>
                    </div>
                    <div class='panel-footer'>
                        <h7>" . $row['date'] . "</h7>
                    </div>
                </div>";
            if($row['isdone'] == 0 ) {
                echo "<script>
                document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Done'; 
                document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-warning')
                document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-success')
                </script>";
            }
            else {
                echo "<script>
                document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Undo'; 
                document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-success')
                document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-warning')
                </script>";
            }
        if($count>8) {
            echo '<ul class="pagination">';
            while ($counter < $count/8) {
                echo '<li><a href="#"></a></li>';
            }
        }
    $date = $row['date'];
    }
}
    echo "<a href='newTodo.html' class='col-sm-2 newBtnTodo btn btn-info'><span class='glyphicon glyphicon-plus'></span></a>";
    $conn->close();
}
else {
    echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
}




?>

