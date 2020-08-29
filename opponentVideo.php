<?php
require_once("config.php");
$opponentid = $_REQUEST["opponentid"];
$matchid = $_REQUEST["matchid"];
$getFrame = $conn->query("SELECT `user1id`, `user2id`, `user1frame`, `user2frame` FROM `matches` WHERE `matchid`='$matchid'");
$getFrame->data_seek(0);
$user1id = $getFrame->fetch_assoc()["user1id"];
$getFrame->data_seek(0);
$user2id = $getFrame->fetch_assoc()["user2id"];
$opponentFrame = "";
if ($user1id == $opponentid){
    $getFrame->data_seek(0);
    $opponentFrame = $getFrame->fetch_assoc()["user1frame"];
} else if ($user2id == $opponentid){
    $getFrame->data_seek(0);
    $opponentFrame = $getFrame->fetch_assoc()["user2frame"];
}
while (strlen($opponentFrame) < 6){
    $opponentFrame = "0" . $opponentFrame;
}
$getUsername = $conn->query("SELECT `username` FROM `users` WHERE `userid` = '$opponentid'");
$getUsername->data_seek(0);
$opponentName = $getUsername->fetch_assoc()["username"];

echo "matches/match" . $matchid . "/" . $opponentName . "/frame" . $opponentFrame . ".png";

?>