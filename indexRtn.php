<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="slider.css">
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
            <li><a href="newRtn.php">Create a new task</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Sign Up</a></li>
        </ul>
        <label class="switch">
            <input type="checkbox" onclick="switchBG()">
            <span class="slider round"></span>
        </label>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

</head>

<body>
</body>
<?php
include 'vars.php';
$counter = 0;
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
        <li><a href='index.php'>Timers</a></li>
        <li><a href='indexTd.php'>To-Do Tasks</a></li>
        <li><a href='indexRtn.php' class='active'>Routines</a></li>
        </ul>";

    //Second request to get all the projects and the tasks from them
    $rtnId = 0;
    $sql = "SELECT `rtnId`, `unicid`, `id`, `name`, `isProject`, `isMand` FROM `usr_rtn` WHERE `id`='{$_COOKIE['sessionID']}' ORDER BY `rtnId` ASC, `isProject` DESC, `unicid` ASC ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            if ($rtnId != 0 && $rtnId != $row['rtnId']) {
                echo "<input type='text' name='title' id='title'>
                      <button onclick='addRtnEnt(" . $rtnId . ")'>Add</button>";
                echo "</div></div></div>"; // Fermer les divs ouvertes pour le projet précédent
            }
    
            // Si on commence un nouveau projet (isProject = 1 ou changement de rtnId)
            if ($row['isProject'] == 1 || $rtnId != $row['rtnId']) {
                // Si ce n'est pas le premier projet, fermer les divs du projet précédent
                if ($rtnId != 0) {
                    echo "</div></div></div>"; // Fermer les divs ouvertes pour le projet précédent
                }
    
                // Ouvrir les divs pour le nouveau projet
                echo "
                <div class='panel-group rtnMainBox'>
                    <div class='panel panel-default col-sm-11'>
                        <div class='panel-heading'>
                            <h4 class='panel-title'>
                                <a data-toggle='collapse' href='#project-" . $row['rtnId'] . "'><h3>#{$row['rtnId']}    " . $row['name'] . "</h3></a>
                            </h4>
                        </div>
                        <div id='project-" . $row['rtnId'] . "' class='panel-collapse collapse rtnBox'>
                        <div class='panel-body'>";
    
                // Mettre à jour le rtnId pour le nouveau projet
                $rtnId = $row['rtnId'];
            }
    
            // Afficher les éléments du projet (isProject = 0)
            if ($row['isProject'] == 0) {
                echo "
                <div class='rtnTask'>
                    <p>{$row['name']}</p>
                    <button id='check-{$row['unicid']}' onclick='updateRtn({$row['unicid']})' class='btn btn-xs'>Check</button>
                    <button class='btn btn-xs btn-danger btn-sm'><span class='glyphicon glyphicon-trash'></span></button>
                </div>
                
                <script>
                    document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Done'; 
                    document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-warning')
                    document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-success')
                </script>";
            }
        }
        
        echo "<input type='text' name='title' id='title-". $rtnId ."'>
              <button onclick='addRtnEnt(" . $rtnId . ")'>Add</button>";
        // Fermer les divs du dernier projet
        echo "</div></div></div>";
    }
    else {
        echo "0 results";
    }

    //Third request to update checked tasks
    $sql = "SELECT `unicid` FROM `rtn_events` WHERE `id`='" . $_COOKIE['sessionID'] . "' AND `date`='" . date('Y-m-d') . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "
            <script>
                document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Undo'; 
                document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-success')
                document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-warning')
            </script>
        ";
    }
    } else {
        echo "0 results";
    }

    $conn->close();
}
else {
    echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
}



?>

