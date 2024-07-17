<head> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="slider.css">
    <title>Create new task - DG Timenage</title>
    <link rel="icon" type="image/x-icon" href="duck-icon.ico">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
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
    <div class="panel panel-default col-sm-3 center">
        <div class="panel-body">
            <div class="container">
                <h4>New project</h4>
                <label class="switch">
                    <input type="checkbox" onclick="switchRtn()">
                    <span class="slider"></span>
                </label>
                <h4>New task</h4>
            </div>
        </div>
    </div>
    <br>
    <div class="panel panel-default col-sm-3 center" id="nProj">
        <div class="panel-heading">
            <h1 style="color : black;">Create New Project</h1>
        </div>
        <div class="panel-body">
            <form action="newRtnCreate.php">
                <div class="form-group"></div>
                    <label for="name">Name of the project:</label>
                    <input type="text" id="name" name="name" maxlength="32" required>
                </div>
                <div class="form-group">
                    <label for="hours">Is this project required?:</label>
                    <input type="checkbox" id="isMand" name="isMand"> 
                    <input type="hidden" id="isProject" name="isProject" value="1">
                </div>
                <input type="submit" value="Submit" class="btn btn-default">
            </form>
        </div>
    </div>
    
    <div class="panel panel-default col-sm-3 center" id="nItem">
        <div class="panel-heading">
            <h1 style="color : black;">Create New Task</h1>
        </div>
        <div class="panel-body">
            <form action="newRtnCreate.php?action=ent">
                <div class="form-group"></div>
                    <label for="name">Name of the item:</label>
                    <input type="text" id="name" name="name" maxlength="32" required>
                </div>
                <div class="form-group">
                <input list="projects" name="project" id="project" autocomplete="off">
                    <datalist id="projects">
                        <?php 
                        include 'vars.php';
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error);}
                        $sql = "SELECT `rtnId`, `name` FROM usr_rtn WHERE `id`='" . $_COOKIE['sessionID'] . "' AND `isProject`='1'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {echo "<option value='" . $row['rtnId'] . "' label='" . $row['name'] . "'>";}
                        }
                        $conn->close();
                        ?>
                    </datalist>
                </div>
                <div class="form-group">
                    <label for="hours">Is this task required?:</label>
                    <input type="checkbox" id="isMand" name="isMand">
                    <input type="hidden" id="isProject" name="isProject" value="0"> 
                </div>
                <input type="submit" value="Submit" class="btn btn-default">
            </form>
        </div>
    </div>
    <script>
        document.getElementById("nProj").style.display = 'inline-block';
        document.getElementById("nItem").style.display = 'none';
    </script>
</body>