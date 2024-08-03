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
    <div></div>
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
            echo "<div class='homeInfo'><h1>Your Projects</h1><br><h2>Logged in as " . $row['f_name'] . " " . $row['name'] . ".</h2> </div>";
        }
        } else {
            echo "Error 6001 : Unable to log in, please try again";
        }

        echo"<ul class='pager'>
            <li><a href='index.php'>Timers</a></li>
            <li><a href='indexTd.php' class='active'>To-Do Tasks</a></li>
            <li><a href='indexRtn.php'>Routines</a></li>
            </ul>";


        //Third request to gather the 8 cards
        $sql = "SELECT `unicid`, `name`, `isdone`, `date`, `ismult`, `times`, `planIt` FROM `usr_todos` WHERE id='" . $_COOKIE['sessionID'] . "' ORDER BY CASE WHEN `date` = '1980-01-01' THEN 0 WHEN `date` >= CURRENT_DATE THEN 1 ELSE 2 END, `date` ASC, `isdone` ASC";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // Output data of each row
            $count = mysqli_num_rows($result);
            $date = null; // Initialize $date
            while ($row = $result->fetch_assoc()) {
                if ($date !== $row['date']) {
                    if ($date !== null) {
                        echo "</div>"; // Close previous date container
                    }
                    $date = $row['date'];
                    if($date != '1980-01-01') {
                        echo "<div class='date-container'>
                                <div class='todoBox col-sm-2 panel panel-default'>
                                    <div class='panel-body'>
                                        <h2 style='color: black;' class='tft'>Tasks for the</h2>
                                        <h2 style='color: black;'>" . $row['date'] . "</h2>
                                    </div>
                                </div>";
                    }
                }
                echo "<div class='todoBox col-sm-2 panel panel-default'>
                        <div class='panel-heading'>
                            <h6>" . $row['name'] . "</h6>
                        </div>
                        <div class='panel-body'>
                            <div class='check " . $row['unicid'] . "'>";
                if ($row['ismult'] == 0) {
                    echo "<button id='check-" . $row['unicid'] . "' class='btn btn-xs' onclick='updateTodo(" . $row['unicid'] . ")'></button>";
                } else {
                    echo "<button id='add-" . $row['unicid'] . "' class='btn btn-xs btn-info btn-sm btn-block' onclick='addTodo(" . $row['unicid'] . ", 1)'><span class='glyphicon glyphicon-plus'></span></button>
                          <button id='remove-" . $row['unicid'] . "' class='btn btn-xs btn-warning btn-sm btn-block' onclick='addTodo(" . $row['unicid'] . ", 0)'><span class='glyphicon glyphicon-minus'></span></button>
                          <br>
                          <div class='panel-footer'>
                              <div class='counters'><h4 class='counters' id='counter-" . $row['unicid'] . "'>" . $row['times'] . "</h4><h4 class='counters'>/" . $row['planIt'] . "</h4></div>
                          </div>";
                }
                echo "</div>
                    </div>";
                if ($row['ismult'] == 0 && $row['date'] != "1980-01-01") {
                    echo "<h7>" . $row['date'] . "</h7>";
                }
                echo "<button class='btn btn-xs btn-danger btn-sm' onclick='del(" . $row['unicid'] . ", \"usr_todos\")'><span class='glyphicon glyphicon-trash'></span></button>
                    </div></div>";
    
                if ($row['isdone'] == 0) {
                    echo "<script>
                    document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Done'; 
                    document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-warning')
                    document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-success')
                    </script>";
                } else {
                    echo "<script>
                    document.getElementById('check-" . $row['unicid'] . "').innerHTML = 'Undo'; 
                    document.getElementById('check-" . $row['unicid'] . "').classList.remove('btn-success')
                    document.getElementById('check-" . $row['unicid'] . "').classList.add('btn-warning')
                    </script>";
                }
            }
            echo "</div>"; // Close last date container
        }

        echo "<a href='newTodo.html' class='col-sm-2 newBtnTodo btn btn-info'><span class='glyphicon glyphicon-plus'></span></a>";
        $conn->close();
    } else {
        echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
    }
    ?>

    <br>
    <br>
    <br>
    <iframe src="newTodo.html" width="300px" height="200px"></iframe>
    </body>
