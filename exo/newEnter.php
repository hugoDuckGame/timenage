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
    $event = $_GET['event'];

    if($event == "proj") {
        $value = $_GET['value'];
        $type = $_GET['type'];
        $subject = $_GET['subject'];
        $theme = $_GET['theme'];
        $chapter = $_GET['chapter'];
        $sql = "INSERT INTO `proj` (`value`, `type`, `subject`, `theme`, `chapter`, `user`) VALUES ('{$value}', '{$type}', NULLIF('{$subject}',''), NULLIF('{$theme}',''), NULLIF('{$chapter}',''), '{$userid}')";
    }
    if($event == "exo") {
        $project = $_GET['project'];
        $name = $_GET['name'];
        $sql = "INSERT INTO `exos` (`project`, `name`, `user`) VALUES ('{$project}', '{$name}', '{$userid}')";
    }
    if($event == "session") {
        $project = $_GET['project'];
        $sql = "SELECT MAX(`number`) AS max_num FROM sessions WHERE user = {$userid} AND `project` = {$project}";

        $conn = new mysqli($exosv, $exous, $exopw, $exodb);
        $conn->set_charset("utf8mb4");

        
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                $number = (int)$row['max_num'] + 1;
                if($number == '') {
                    $number  = '1';
                }
            }
        } 

        $conn->close();

        $date = date('Y-m-d');

        $sql = "INSERT INTO `sessions` (`project`, `number`, `user`, `date`) VALUES ('{$project}', '{$number}', '{$userid}', '{$date}')";
    }



    // Create connection
    $conn = new mysqli($exosv, $exous, $exopw, $exodb);
    $conn->set_charset("utf8mb4");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

}