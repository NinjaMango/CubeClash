<?php

session_start();
$conn = new mysqli("localhost", "root", "", "cubeclash");
$username = "";
if (isset($_SESSION["username"])){
    $username = $_SESSION["username"];
}


$getUserId = $conn->query("SELECT `userid` FROM `users` WHERE `username`='$username'");
$getUserId->data_seek(0);
$userid = $getUserId->fetch_assoc()["userid"];
$_SESSION["userid"] = $userid;

function htmlhead($title){
    echo "<title>" . $title . " | Cube Clash</title> \n";
    echo "        <style> @import 'style.css' </style> \n";
}

function logRequest($pageid){
    $userid = "2147483647";
    if (isset($_SESSION["userid"])){
        $userid = $_SESSION["userid"];
    }
    $userip = $_SERVER["REMOTE_ADDR"];
    $conn = new mysqli("localhost", "root", "", "cubeclash");
    $logRequest = $conn->query("INSERT INTO `useractivity` VALUES ('$userid','$userip', '$pageid', NOW())");
}

function heartbeat($pageid){
    $userid = $_SESSION["userid"];
    echo "<script> \n";
    echo "          var heartbeat = new XMLHttpRequest(); \n";
    echo "          heartbeat.open('GET', 'heartbeat.php?userid=$userid&pageid=$pageid');\n";
    echo "          heartbeat.send(); \n";
    echo "        </script> \n";
    

}

?>