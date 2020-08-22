<?php
    require_once("config.php");
    //get 2nd element of exploded img info sent and decode it
    $img = explode(',', $_REQUEST["img"])[1];
    $userid = $_REQUEST["userid"];
    $getUsername = $conn->query("SELECT `username` FROM `users` WHERE `userid` = '$userid'");
    $getUsername->data_seek(0);
    $username = $getUsername->fetch_assoc()["username"];
    $match = $_REQUEST["matchid"];
    $filepath = "matches/match" . $match . "/" . $username;
    $frame = $_REQUEST["frame"];
    while (strlen($frame) <= 5){
        $frame = "0" . $frame;
    }
    //create img file and write to it
    if (!file_exists($filepath)){
        mkdir($filepath, 0777, true);
    }
    file_put_contents($filepath . "/frame" . $frame . ".png", base64_decode(str_replace(' ', '+', $img)));
?>