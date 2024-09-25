<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="../main.css">
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
            <li class="active"><a href="../index.php">Home</a></li>
            <li><a href="../new.html">Create a new task</a></li>
            <li><a href="../login.html">Login</a></li>
            <li><a href="../register.html">Sign Up</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

</head>

<body>
</body>
<?php
include '../vars.php';
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
            <li><a href='../index.php'>Timers</a></li>
            <li><a href='../indexTd.php'>To-Do Tasks</a></li>
            <li><a href='../indexRtn.php'>Routines</a></li>
            <li><a class='active' href='index.php'>Exo</a></li>
            
            </ul>";
    $conn->close();
    $logged = true;
    }
else {
    echo "<h2>Would you like to log in?</h2><br><a href='login.html'>LOG IN</a>";
}

if($logged && isset($_GET['project'])){
    echo "<table>";
    $counter = 0;
    $project = $_GET['project'];

    // Create connection
    $conn = new mysqli($exosv, $username, $exopw, "exo");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo"<tr>
    <td>X</td>";

    $exos = array();
    $sql = "SELECT * FROM `exos` WHERE project='{$_GET['project']}' ORDER BY `id`";
    $conn->set_charset("utf8mb4");
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $exos[] = $row['id'];
            echo"<td>
            {$row['name']}
            </td>";
            $counter+=1;
        }
    } else {
        echo "0 results";
    } 
    echo "</tr>";

    echo"<tr>";

    $sql = "SELECT * FROM `sessions` WHERE project='{$project}'";
    $conn->set_charset("utf8mb4");
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo"<tr>
            <td>{$row['number']}</td>";

            $ct=0;
            
            
            while($ct<$counter) {
                $id = $exos[$ct];
                echo"<td>
                        <div class='btn-group'>
                            <button onclick='addEvent({$row['project']}, {$row['number']}, {$id}, 1)' id='{$row['number']}-{$id}-1' class='btn-default btn-xs' type='button'>F</button>
                            <button onclick='addEvent({$row['project']}, {$row['number']}, {$id}, 2)' id='{$row['number']}-{$id}-2' class='btn-default btn-xs' type='button'>P</button>
                            <button onclick='addEvent({$row['project']}, {$row['number']}, {$id}, 3)' id='{$row['number']}-{$id}-3' class='btn-default btn-xs' type='button'>A</button>
                            <button onclick='addEvent({$row['project']}, {$row['number']}, {$id}, 4)' id='{$row['number']}-{$id}-4' class='btn-default btn-xs' type='button'>C</button>
                        </div>
                    </td>";
                $ct+=1;
            }

            echo "</tr>";
        }
    } else {
        echo "0 results";
    } 


    $conn->close();
}
else if ($logged) {
    echo "<form action='index.php'>
            <input type='text' name='project' id='project' placeholder='Please enter project number'>
            <input type='submit'>
          </form>";
}


?>

<script>

getEvents(<?php echo $_GET['project']; ?>);
</script>
</table>