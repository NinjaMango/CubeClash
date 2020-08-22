<?php
    require_once("config.php");
    $userid = $_REQUEST["userid"];
    $getUsername = $conn->query("SELECT `username` FROM `users` WHERE `userid` = '$userid'");
    $getUsername->data_seek(0);
    $username = $getUsername->fetch_assoc()["username"];
    $filepath = "matches/match" . $_REQUEST["match"] . "/" . $username;
    $output1 = "";
    $output2 = "";
    exec("cd  2>&1" . $filepath, $outpu1);
    exec("ffmpeg -f image2 -i frame%06.png  2>&1" . $username . ".mpg", $output2);
    echo $output1;
    #echo $output2;
?>