<?php
require_once("config.php");
$matchid = $_REQUEST["matchid"];
$userid = $_REQUEST["userid"];
$opponentid = $_REQUEST["opponentid"];
$checkState = $conn->query("SELECT `state` FROM `matches` WHERE `matchid` = '$matchid'");
$checkState->data_seek(0);
if ($checkState->fetch_assoc()["state"] == 3){
    $endGame = $conn->query("UPDATE `matches` SET `state`='4', `winner` = '$userid', `end` = NOW() WHERE `matchid` = '$matchid'");
    $winnerRating = $conn->query("UPDATE `users` SET `rating` = `rating` + 30 WHERE `userid` = '$userid'");
    $loserRating = $conn->query("UPDATE `users` SET `rating` = `rating` - 30 WHERE `userid` = '$opponentid'");
}
?>