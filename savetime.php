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

    $sql = "UPDATE `usr_projects` SET `curr_time`= '". $_GET['time'] . "' WHERE `unicid`= '" . $_GET['unicid'] . "'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
?>