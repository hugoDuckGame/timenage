<?php
    include 'vars.php';

    $headers = "From: contact@duckgame.com" . "\r\n";


    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //First request to retrieve user info
    $sql = "SELECT `email`, `name` FROM `users`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        mail($row['email'],$_GET['subject'],$_GET['mail'], $headers);
    }
    } else {
        echo "Error 6001 : Unable to log in, please try again";
    }
?>