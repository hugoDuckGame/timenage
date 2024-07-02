<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projects";
    
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