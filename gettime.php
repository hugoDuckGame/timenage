<?php
    $servername = "db5016032132.hosting-data.io";
    $username = "dbu1200988";
    $password = "wV9BuQ-F&t/?V\$z";
    $dbname = "dbs13060811";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `curr_time` FROM `usr_projects` WHERE `unicid`='" . $_GET['unicid'] . "';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo $row['curr_time'];
      }
    } else {
      echo "0 results";
    }
    $conn->close();
?>