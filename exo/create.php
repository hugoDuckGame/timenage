<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    
    <link rel="stylesheet" href="../main.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="slider.css">
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
include '../vars.php';
if (isset($_COOKIE['sessionID'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //First request to retrieve user info
    $sql = "SELECT `f_name`, `name`, `id` FROM `users` WHERE id='" . $_COOKIE['sessionID'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $userid = $row['id'];
        }
        } else {
            echo "Error 6001 : Unable to log in, please try again";
        }
    $conn->close();
    $logged = true;
    }
else {
    echo "Please Login";
}

if($logged){
  // Create connection
  $conn = new mysqli($exosv, $exous, $exopw, $exodb);
  $conn->set_charset("utf8mb4");

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
}
?>
    <div class="panel panel-default col-sm-3 center">
        <div class="panel-heading">
            <h1 style="color : black;">Create new project</h1>
        </div>
        <div class="panel-body">
            <input type="range" id="type" name="type" min="1" max="4" value="1">
            <label for="event" id="selector">
                <label-name id="label-1" class="">Subject</label-name>
                <label-name id="label-2" class="">Theme</label-name>
                <label-name id="label-3" class="">Chapter</label-name>
                <label-name id="label-4" class="">Other</label-name>
            </label><br><br>
            <input type="text" id="value" name="name" placeholder="Name of your subject"></input><br><br>
            <select id="subject" name="subject" id="subject" class="hidden">
            <br><br>
            <option disabled selected value> -- choose a subject -- </option>
              <?php 
                $sql="SELECT `value`, `unicid` FROM `proj` WHERE `type`='1' AND `user` = $userid"; 
                $result = $conn->query($sql); 
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['unicid']}'>{$row['value']}</option>";
                  }
                }
              ?>
            </select><br><br>
            <select id="theme" name="theme" id="theme" class="hidden">
            <option disabled selected value> -- choose a theme -- </option>
              <?php 
                $sql="SELECT `value`, `unicid` FROM `proj` WHERE `type`='2' AND `user` = $userid"; 
                $result = $conn->query($sql); 
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['unicid']}'>{$row['value']}</option>";
                  }
                }
              ?>
            </select><br><br>
            <select id="chapter" name="chapter" id="chapter" class="hidden">
            <option disabled selected value> -- choose a chapter -- </option>
              <?php 
                $sql="SELECT `value`, `unicid` FROM `proj` WHERE `type`='3' AND `user` = $userid"; 
                $result = $conn->query($sql); 
                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['unicid']}'>{$row['value']}</option>";
                  }
                }
              ?>
            </select><br><br>
            <button type="button" onclick="newProj()">Create</button>
        </div>
    </div>
    <script src="create.js"></script>
</body>