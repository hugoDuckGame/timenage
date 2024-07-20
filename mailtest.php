<meta charset="UTF-8">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    include 'vars.php';

    $headers = "From: From: Timenage Updates <contact@duckgame.org>" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    if($_GET['mail'] != "") {
        $mail = $_GET['mail'];
    }
    else {
        $mail= file_get_contents($_GET['file']); 
    }

    mail("contact@duckgame.org",$_GET['subject'],$mail, $headers);
    mail("hugoame2008@gmail.com",$_GET['subject'],$mail, $headers);
    echo "contact@duckgame.org" . $_GET['subject'] . $mail . $headers;
    
?>