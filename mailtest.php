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
        $mail= "THIS IS A TEST MAIL - THIS IS A TEST MAIL - THIS IS A TEST MAIL - THIS IS A TEST MAIL" . file_get_contents($_GET['file']); 
    }

    mail($_GET['testReceive'],"TEST MAIL" . $_GET['subject'],$mail, $headers);
    echo "contact@duckgame.org" . $_GET['subject'] . $mail . $headers;
    
?>