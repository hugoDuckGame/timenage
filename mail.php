<meta charset="UTF-8">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    include 'vars.php';

    $headers = "From: Timenage Updates <contact@duckgame.org>" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    if($_GET['mail'] != "") {
        $mail = $_GET['mail'];
        
    }
    else {
        $mail= file_get_contents($_GET['file']); 
    }

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
        mail($row['email'],$_GET['subject'],$mail, $headers);
        echo $row['email'] . $_GET['subject'] . $mail . $headers;
    }
    } else {
        echo "Error 6001 : Unable to log in, please try again";
    }
?>