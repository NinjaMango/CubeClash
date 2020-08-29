<?php
    require_once("config.php");
    //get 2nd element of exploded img info sent and decode it
    $img = explode(',', $_REQUEST["img"])[1];
    $userid = $_REQUEST["userid"];
    $getUsername = $conn->query("SELECT `username` FROM `users` WHERE `userid` = '$userid'");
    $getUsername->data_seek(0);
    $username = $getUsername->fetch_assoc()["username"];
    $matchid = $_REQUEST["matchid"];
    $filepath = "matches/match" . $matchid . "/" . $username;
    $frame = $_REQUEST["frame"];
    //update db
    $getUser = $conn->query("SELECT `user1id`, `user2id` FROM `matches` WHERE `matchid`='$matchid'");
    $getUser->data_seek(0);
    $user1id = $getUser->fetch_assoc()["user1id"];
    $getUser->data_seek(0);
    $user2id = $getUser->fetch_assoc()["user2id"];

    if ($user1id == $userid){
        $updateFrame = $conn->query("UPDATE `matches` SET `user1frame`='$frame' WHERE `matchid`='$matchid'");
    } else if ($user2id == $userid){
        $updateFrame = $conn->query("UPDATE `matches` SET `user2frame`='$frame' WHERE `matchid`='$matchid'");
    }
    while (strlen($frame) < 6){
        $frame = "0" . $frame;
    }
    //create img file and write to it
    if (!file_exists($filepath)){
        mkdir($filepath, 0777, true);
    }
    file_put_contents($filepath . "/frame" . $frame . ".png", base64_decode(str_replace(' ', '+', $img)));


?>