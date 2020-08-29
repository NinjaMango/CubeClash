<?php
require_once("config.php");
//load match info from db
$matchid = $_REQUEST["matchid"];
$getMatchInfo = $conn->query("SELECT * FROM `matches` WHERE `matchid` = '$matchid'");
$matchInfo = $getMatchInfo->fetch_row();
$matchState = $matchInfo[9];
$matchStart = strtotime($matchInfo[10]) + 21600;
$timeUntilScramble = 10 - (time() - $matchStart);
$timeUntilInspection = 40 - (time() - $matchStart);
$timeUntilSolve = 55 - (time() - $matchStart);
$timeSinceSolve = round(microtime(true)- $matchStart - 55, 4);
$winner = $matchInfo[7];
//if state is 0, either update it to 1 if pregame is over or return time until state 1 to client
if ($matchState == 0){
    if ($timeUntilScramble < 0){
        $updateState = $conn->query("UPDATE `matches` SET `state`='1' WHERE `matchid`= '$matchid'");
        echo "1|$timeUntilInspection";
    } else {
        echo "0|$timeUntilScramble";
    }
}
if ($matchState == 1){
    if ($timeUntilInspection < 0){
        $updateState = $conn->query("UPDATE `matches` SET `state`='2' WHERE `matchid`= '$matchid'");
        echo "2|$timeUntilSolve";
    } else {
        echo "1|$timeUntilInspection";
    }
}
if ($matchState == 2){
    if ($timeUntilSolve < 0){
        $updateState = $conn->query("UPDATE `matches` SET `state`='3' WHERE `matchid`= '$matchid'");
        echo "3|$timeSinceSolve";
    } else {
        echo "2|$timeUntilSolve";
    }
}
if ($matchState == 3){
    echo "3|$timeSinceSolve";
}
if ($matchState == 4){
    echo "4|$winner";
}
?>