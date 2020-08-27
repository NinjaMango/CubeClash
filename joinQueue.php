<?php
require_once("config.php");
//add user to match queue
$userid = $_REQUEST["userid"];
$isUserInQueue = $conn->query("SELECT `userid` FROM `matchqueue` WHERE `userid`='$userid'");
$isUserInMatch = $inMatch = $conn->query("SELECT `matchid` FROM `matches` WHERE `state` < 4 AND (`user1id` = '$userid' OR `user2id` = '$userid')");
if ($isUserInQueue->num_rows == 0 && $isUserInMatch->num_rows == 0){
    $conn->query("INSERT INTO `matchqueue` VALUES ('$userid', NOW())");
    echo "Succesfully joined queue.";
}

?>
